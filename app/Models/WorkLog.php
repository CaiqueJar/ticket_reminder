<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Validation\ValidationException;

#[Fillable(['chamado_id', 'comeco_em', 'termino_em', 'descricao'])]
class WorkLog extends Model
{
    protected $casts = [
        'comeco_em' => 'datetime',
        'termino_em' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $workLog) {
            if (blank($workLog->termino_em)) {
                $query = self::where('chamado_id', $workLog->chamado_id)
                    ->whereNull('termino_em');

                if ($workLog->exists) {
                    $query->where('id', '!=', $workLog->id);
                }

                if ($query->exists()) {
                    throw ValidationException::withMessages([
                        'workLogs' => ['Só pode haver apenas um work log em andamento por vez.'],
                    ]);
                }
            }
        });
    }

    public function chamado(): BelongsTo
    {
        return $this->belongsTo(Chamado::class);
    }
}
