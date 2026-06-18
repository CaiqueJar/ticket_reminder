<?php

namespace App\Filament\Resources\Chamados\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;

class ChamadoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make("")
                    ->columnSpanFull()
                    ->schema([
                        Tabs\Tab::make('Dados do Chamado')
                            ->columns(2)
                            ->schema([
                                Group::make()
                                    ->columnSpan(2)
                                    ->columns(6)
                                    ->schema([
                                        Select::make('empresa')
                                            ->columnSpan(2)
                                            ->label('Empresa')
                                            ->required()
                                            ->options([
                                                'royal' => 'Royal',
                                                'tsbox' => 'TsBox',
                                            ])
                                            ->default('royal'),
                                        TextInput::make('codigo_referencia')
                                            ->label('Código de Referência')
                                            ->columnSpan(1)
                                            ->required(),
                                        TextInput::make('titulo')
                                            ->label('Título')
                                            ->columnSpan(3)
                                            ->required(),
                                    ]),
                                Select::make('participantes')
                                    ->label('Participantes')
                                    ->multiple()
                                    ->preload()
                                    ->relationship('participantes', 'name'),
                                TextInput::make('tempo_estimado_minutos')
                                    ->label('Tempo Estimado (minutos)')
                                    ->numeric(),
                                Select::make('status')
                                    ->label('Status')
                                    ->preload()
                                    ->required()
                                    ->options([
                                        'backlog sprint' => 'Backlog Sprint', 
                                        'em desenvolvimento' => 'Em desenvolvimento', 
                                        'em teste' => 'Em teste', 
                                        'parado' => 'Parado', 
                                        'concluido' => 'Concluído',
                                    ])
                                    ->default('backlog sprint')
                                    ->afterStateHydrated(function ($state, callable $set, $record) {
                                        if ($record && $record->exists) {
                                            $set('status', $record->status ?? 'backlog sprint');
                                        }
                                    }),
                                MarkdownEditor::make('descricao')
                                    ->label('Descrição')
                                    ->columnSpanFull(),
                                MarkdownEditor::make('solucao')
                                    ->label('Solução')
                                    ->columnSpanFull(),
                            ]),

                        Tabs\Tab::make('Work logs')
                            ->columns(2)
                            ->schema([
                                Repeater::make('workLogs')
                                    ->relationship('workLogs')
                                    ->addActionLabel('Adicionar novo work log')
                                    ->columns(5)
                                    ->columnSpanFull()
                                    ->defaultItems(1)
                                    ->schema([
                                        DateTimePicker::make('comeco_em')
                                            ->label('Início')
                                            ->required(),
                                        DateTimePicker::make('termino_em')
                                            ->label('Término')
                                            ->nullable(),
                                        TextInput::make('descricao')
                                            ->label('Descrição')
                                            ->columnSpan(3)
                                            ->nullable(),
                                    ]),
                            ]),
                    ])
            ]);
    }
}
