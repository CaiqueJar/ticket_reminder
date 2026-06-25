<?php

namespace App\Filament\Resources\Termos\Pages;

use App\Filament\Resources\Termos\TermoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTermo extends EditRecord
{
    protected static string $resource = TermoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
