<?php

namespace App\Filament\Resources\Chamados\Pages;

use App\Filament\Resources\Chamados\ChamadoResource;
use App\Models\Chamado;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateChamado extends CreateRecord
{
    protected static string $resource = ChamadoResource::class;

    protected function handleRecordCreate(array $data): Model
    {
        $participantesChamados = $data['participantesChamados'] ?? [];

        unset($data['participantesChamados']);

        $record = Chamado::create($data);

        foreach ($participantesChamados as $participanteChamadoData) {
            $comentarioData = [
                'tipo' => $participanteChamadoData['tipo'],
                'texto' => $participanteChamadoData['texto'],
            ];

            $participanteChamado = $record->participantesChamados()->firstOrCreate([
                'participante_id' => $participanteChamadoData['participante_id'],
            ]);

            $participanteChamado->comentarios()->create($comentarioData);
        }

        return $record;
    }
}
