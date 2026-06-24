<?php

namespace App\Filament\Resources\Chamados\Schemas;

use App\Models\Participante;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
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
                                ->required()
                                ->preload()
                                ->relationship('participantes', 'nome'),
                            TextInput::make('tempo_estimado_minutos')
                                ->label('Tempo Estimado (minutos)')
                                ->required()
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
                    Tabs\Tab::make('Comentários')
                        ->schema([
                            Repeater::make('comentarios')
                                ->relationship('comentarios')
                                ->columns(1)
                                ->nullable()
                                ->defaultItems(0)
                                ->reorderable(false)
                                ->schema([
                                    Grid::make()
                                        ->columns(4)
                                        ->schema([
                                            Select::make('participante_id')
                                                ->label('Participante')
                                                ->relationship('participante', 'nome')
                                                ->searchable()
                                                ->columnOrder(1)
                                                ->required(),
                                            Select::make('tipo')
                                                ->label('Tipo')
                                                ->options([
                                                    'tecnico' => 'Técnico',
                                                    'cliente' => 'Cliente',
                                                    'geral' => 'Geral',
                                                    'impedimento' => 'Impedimento',
                                                ])
                                                ->columnOrder(2)
                                                ->default('geral')
                                                ->required(),
                                        ]),
                                    MarkdownEditor::make('texto')
                                        ->label('Comentário')
                                        ->columnSpanFull()
                                        ->required(),
                                ])
                        ]),
                    Tabs\Tab::make('Arquivos Alterados')
                        ->schema([
                            Repeater::make('arquivosAlterados')
                                ->label('Arquivos Alterados')
                                ->relationship()
                                ->columns(1)
                                ->defaultItems(0)
                                ->nullable()
                                ->simple(
                                    TextInput::make('caminho_arquivo')
                                        ->label('Caminho do Arquivo')
                                        ->columnSpanFull()
                                        ->required()
                                        ->reactive()
                                ),
                        ]),
                ])
        ]);
}
}
