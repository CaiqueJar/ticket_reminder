<?php

namespace App\Filament\Resources\Termos\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class TermoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nome_oficial')
                    ->required(),
                Textarea::make('descricao')
                    ->columnSpanFull(),
            ]);
    }
}
