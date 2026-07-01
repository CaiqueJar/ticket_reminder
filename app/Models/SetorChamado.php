<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

#[Fillable(['chamado_id', 'setor_id'])]
class SetorChamado extends Pivot
{
    public function chamado(): BelongsTo
    {
        return $this->belongsTo(Chamado::class);
    }

    public function setor(): BelongsTo
    {
        return $this->belongsTo(Setor::class);
    }
}
