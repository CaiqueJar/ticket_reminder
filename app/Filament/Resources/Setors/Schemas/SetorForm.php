<?php

namespace App\Filament\Resources\Setors\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SetorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nome')
                    ->required()
                    ->maxLength(60)
                    ->columnSpanFull(),
            ]);
    }
}
