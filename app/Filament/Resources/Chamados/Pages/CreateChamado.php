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
        $comentarios = $data['comentarios'] ?? [];

        unset($data['comentarios']);

        $record = Chamado::create($data);

        foreach ($comentarios as $comentarioData) {
            $record->participantes()->syncWithoutDetaching($comentarioData['participante_id']);

            $record->comentarios()->create([
                'participante_id' => $comentarioData['participante_id'],
                'tipo' => $comentarioData['tipo'],
                'texto' => $comentarioData['texto'],
            ]);
        }

        return $record;
    }
}
