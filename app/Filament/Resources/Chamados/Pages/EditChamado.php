<?php

namespace App\Filament\Resources\Chamados\Pages;

use App\Filament\Resources\Chamados\ChamadoResource;
use App\Models\HistoricoStatusChamado;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditChamado extends EditRecord
{
    protected static string $resource = ChamadoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update($data);

        if(isset($data["status"])) {
            $statusAnterior = HistoricoStatusChamado::where('chamado_id', $record->id)->latest()->value('status_atual') ?? 'backlog sprint';
            
            HistoricoStatusChamado::create([
                'chamado_id' => $record->id,
                'status_atual' => $data['status'], 
                'status_anterior' => $statusAnterior,
            ]);
        }

        return $record;
    }
}
