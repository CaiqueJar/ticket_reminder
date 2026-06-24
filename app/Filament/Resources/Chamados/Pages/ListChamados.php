<?php

namespace App\Filament\Resources\Chamados\Pages;

use App\Filament\Resources\Chamados\ChamadoResource;
use App\Models\Chamado;
use App\Models\Participante;
use App\Services\ImportTrelloChamado;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Storage;

class ListChamados extends ListRecords
{
    protected static string $resource = ChamadoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Action::make('importJson')
                ->label('Import JSON')
                ->icon(Heroicon::OutlinedArrowUpTray)
                ->modalHeading('Importar JSON')
                ->form([
                    FileUpload::make('json_file')
                        ->label('Arquivo JSON')
                        ->acceptedFileTypes(['application/json', '.json'])
                        ->required(),
                ])
                ->action(function (array $data) {
                    $file = $data['json_file'] ?? null;

                    if (! $file) {
                        return;
                    }

                    try {
                        $contents = Storage::disk('local')->get($file);
                    } catch (\Exception $exception) {
                        Notification::make()
                            ->title('Erro ao ler o arquivo JSON.')
                            ->danger()
                            ->send();

                        return;
                    }

                    $json = json_decode($contents, true);
                    if (! is_array($json)) {
                        Notification::make()
                            ->title('JSON inválido ou mal formado.')
                            ->danger()
                            ->send();

                        return;
                    }

                    return ImportTrelloChamado::import($json);
                })
        ];
    }
}
