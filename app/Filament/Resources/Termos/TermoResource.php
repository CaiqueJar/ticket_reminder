<?php

namespace App\Filament\Resources\Termos;

use App\Filament\Resources\Termos\Pages\CreateTermo;
use App\Filament\Resources\Termos\Pages\EditTermo;
use App\Filament\Resources\Termos\Pages\ListAliasesTermos;
use App\Filament\Resources\Termos\Pages\ListTermos;
use App\Filament\Resources\Termos\RelationManagers\AliasesRelationManager;
use App\Filament\Resources\Termos\Schemas\TermoForm;
use App\Filament\Resources\Termos\Tables\TermosTable;
use App\Models\Termo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TermoResource extends Resource
{
    protected static ?string $model = Termo::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nome_oficial';

    public static function form(Schema $schema): Schema
    {
        return TermoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TermosTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            AliasesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTermos::route('/'),
            'aliases' => ListAliasesTermos::route('/aliases'),
            'create' => CreateTermo::route('/create'),
            'edit' => EditTermo::route('/{record}/edit'),
        ];
    }
}
