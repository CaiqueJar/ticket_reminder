<?php

namespace App\Filament\Resources\Termos\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TermosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nome_oficial')
                    ->searchable(),
                TextColumn::make('descricao')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('associarAlias')
                    ->label('Associar alias')
                    ->icon('heroicon-o-link')
                    ->modalHeading('Associar alias a termo')
                    ->form([
                        TextInput::make('nome')
                            ->required(),
                    ])
                    ->action(function (array $data, Action $action): void {
                        $record = $action->getRecord();

                        if (! $record) {
                            return;
                        }

                        $record->aliases()->firstOrCreate([
                            'nome' => $data['nome'],
                        ]);

                        Notification::make()
                            ->title('Alias associado com sucesso.')
                            ->success()
                            ->send();
                    }),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
