<?php

namespace App\Filament\Resources\Termos\Pages;

use App\Filament\Resources\Termos\TermoResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;

class ListTermos extends ListRecords
{
    protected static string $resource = TermoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('ver aliases')
                ->label("Ver aliases")
                ->icon(Heroicon::OutlinedEye)
                ->link()
                ->url('termos/aliases'),
            CreateAction::make(),
        ];
    }
}
