<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['chamado_id', 'comeco_em', 'termino_em', 'descricao'])]
class WorkLog extends Model
{
    public function chamado(): BelongsTo
    {
        return $this->belongsTo(Chamado::class);
    }
}
