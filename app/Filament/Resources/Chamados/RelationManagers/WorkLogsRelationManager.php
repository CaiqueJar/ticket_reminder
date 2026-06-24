<?php

namespace App\Filament\Resources\Chamados\RelationManagers;

use App\Filament\Resources\Chamados\ChamadoResource;
use App\Models\WorkLog;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Table;

class WorkLogsRelationManager extends RelationManager
{
    protected static string $relationship = 'workLogs';

    protected static ?string $relatedResource = ChamadoResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->poll(fn () => !$this->hasPausedWorkLog() ? '1s' : null)
            ->searchable(false)
            ->headerActions([
                Action::make('start')
                    ->label('Iniciar')
                    ->icon('heroicon-o-play')
                    ->color('success')
                    ->hidden(fn (): bool => $this->getActiveWorkLog() !== null)
                    ->action(fn () => $this->startWorkLog()),

                Action::make('pause')
                    ->label('Pausar')
                    ->icon('heroicon-o-pause')
                    ->color('warning')
                    ->hidden(fn (): bool => ! $this->hasRunningWorkLog())
                    ->action(fn () => $this->pauseWorkLog()),

                Action::make('resume')
                    ->label('Retomar')
                    ->icon('heroicon-o-play')
                    ->color('success')
                    ->hidden(fn (): bool => ! $this->hasPausedWorkLog())
                    ->action(fn () => $this->resumeWorkLog()),

                Action::make('finish')
                    ->label('Finalizar')
                    ->icon('heroicon-o-stop')
                    ->color('danger')
                    ->hidden(fn (): bool => $this->getActiveWorkLog() === null)
                    ->requiresConfirmation()
                    ->action(fn () => $this->finishWorkLog()),
            ])
            ->columns([
                TextColumn::make('comeco_em')
                    ->label('Início')
                    ->dateTime('d/m/Y H:i'),

                TextColumn::make('termino_em')
                    ->label('Fim')
                    ->dateTime('d/m/Y H:i'),

                TextInputColumn::make('descricao')
                    ->searchable(),

                TextColumn::make('duracao')
                    ->state(fn (WorkLog $record) => gmdate(
                        'H:i:s',
                        $record->durationInSeconds(),
                    )),
            ]);
    }

    protected function startWorkLog(): void
    {
        if ($this->ownerRecord->activeWorkLog) {
            return;
        }

        $this->ownerRecord
            ->workLogs()
            ->create([
                'comeco_em' => now(),
            ]);

        $this->ownerRecord->refresh();
    }

    protected function pauseWorkLog(): void
    {
        $workLog = $this->ownerRecord->activeWorkLog;

        if (! $workLog || $workLog->isPaused()) {
            return;
        }

        $workLog->update([
            'pausado_em' => now(),
        ]);

        $this->ownerRecord->refresh();
    }

    protected function resumeWorkLog(): void
    {
        $workLog = $this->ownerRecord->activeWorkLog;

        if (! $workLog || ! $workLog->isPaused()) {
            return;
        }

        $pausedSeconds =
            $workLog->segundos_pausados +
            $workLog->pausado_em->diffInSeconds(now());

        $workLog->update([
            'pausado_em' => null,
            'segundos_pausados' => $pausedSeconds,
        ]);

        $this->ownerRecord->refresh();
    }

    protected function finishWorkLog(): void
    {
        $workLog = $this->ownerRecord->activeWorkLog;

        if (! $workLog) {
            return;
        }

        $pausedSeconds = $workLog->segundos_pausados;

        if ($workLog->isPaused()) {
            $pausedSeconds +=
                $workLog->pausado_em->diffInSeconds(now());
        }

        $workLog->update([
            'termino_em' => now(),
            'pausado_em' => null,
            'segundos_pausados' => $pausedSeconds,
        ]);

        $this->ownerRecord->refresh();
    }

    protected function getActiveWorkLog(): ?WorkLog
    {
        return $this->ownerRecord->activeWorkLog;
    }

    protected function hasRunningWorkLog(): bool
    {
        $workLog = $this->getActiveWorkLog();

        return $workLog?->isRunning() ?? false;
    }

    protected function hasPausedWorkLog(): bool
    {
        $workLog = $this->getActiveWorkLog();

        return $workLog?->isPaused() ?? false;
    }
}
