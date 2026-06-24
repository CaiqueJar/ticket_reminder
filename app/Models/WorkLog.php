<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Validation\ValidationException;

#[Fillable(['chamado_id', 'comeco_em', 'termino_em', 'descricao', 'pausado_em', 'segundos_pausados'])]
class WorkLog extends Model
{
    protected $casts = [
        'comeco_em' => 'datetime',
        'termino_em' => 'datetime',
        'pausado_em' => 'datetime'
    ];

    protected static function booted(): void
    {
        static::saving(function (self $workLog) {
            if (filled($workLog->termino_em)) {
                return;
            }

            $query = self::query()
                ->where('chamado_id', $workLog->chamado_id)
                ->whereNull('termino_em');

            if ($workLog->exists) {
                $query->whereKeyNot($workLog->id);
            }

            if ($query->exists()) {
                throw ValidationException::withMessages([
                    'workLogs' => 'Já existe um work log em andamento.',
                ]);
            }
        });
    }

    public function isRunning(): bool
    {
        return $this->termino_em === null
            && $this->pausado_em === null;
    }

    public function isPaused(): bool
    {
        return $this->termino_em === null
            && $this->pausado_em !== null;
    }

    public function durationInSeconds(): int
    {
        $end = $this->termino_em ?? now();

        $seconds = $this->comeco_em->diffInSeconds($end);

        return max(
            0,
            $seconds - $this->segundos_pausados
        );
    }

    public function chamado(): BelongsTo
    {
        return $this->belongsTo(Chamado::class);
    }
}
