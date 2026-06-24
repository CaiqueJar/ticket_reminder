<?php 

namespace App\Services;

use App\Models\Chamado;
use App\Models\Participante;
use Filament\Notifications\Notification;

class ImportTrelloChamado
{
    public static function import(array $json) {
        $mapped = [];

        if (isset($json['name'])) {
            $mapped['titulo'] = $json['name'];
        }

        if (isset($json['desc'])) {
            $mapped['descricao'] = $json['desc'];
        }

        if (isset($json['shortLink'])) {
            $mapped['codigo_referencia'] = $json['shortLink'];
        }

        if (isset($json['idShort'])) {
            $mapped['codigo_referencia'] = $json['idShort'];
        }

        [$mapped['empresa'], $mapped['codigo_referencia'], $mapped['titulo']] = explode('-', $mapped['titulo'], 3);

        $chamado = Chamado::create([
            'titulo' => trim($mapped['titulo']),
            'empresa' => trim(strtolower($mapped['empresa'])),
            'codigo_referencia' => trim($mapped['codigo_referencia']),
            'descricao' => $mapped['descricao'] ?? null,
        ]);

        $participantes = collect($json['members'])->map(fn ($participante) => ['nome' => $participante['fullName']]);
        
        foreach ($participantes as $participante) {
            $participante = Participante::firstOrCreate(
                ['nome' => $participante['nome']]
            );

            $chamado->participantesChamados()->firstOrCreate(['participante_id' => $participante->id]);
        }

        $comentarios = [];
        if (isset($json['actions']) && is_array($json['actions'])) {
            foreach ($json['actions'] as $action) {
                if (($action['type'] === 'commentCard' || $action['type'] === 'copyCommentCard') && isset($action['data']['text'])) {
                    
                    $texto = $action['data']['text'];
                    
                    $autor = $action['memberCreator']['fullName'] ?? 'Desconhecido';
                    
                    $dataComentario = $action['date'] ?? now();
                    
                    $comentarios[] = [
                        'texto' => $texto,
                        'autor' => $autor,
                        'data' => $dataComentario,
                        'tipo' => $action['type'] === 'copyCommentCard' ? 'copiado' : 'comentario',
                    ];
                }
            }
        }
        
        foreach ($comentarios as $comentario) {
            $participante = Participante::where('nome', 'LIKE', "%{$comentario['autor']}%")->first();

            if (! $participante) {
                continue;
            }

            $chamado->participantes()->syncWithoutDetaching($participante->id);

            $chamado->comentarios()->create([
                'participante_id' => $participante->id,
                'tipo' => 'geral',
                'texto' => $comentario['texto'] ?? '',
            ]);
        }

        return Notification::make()
            ->title('Campos preenchidos a partir do JSON.')
            ->success()
            ->send();
    }
}