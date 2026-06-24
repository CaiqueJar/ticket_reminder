<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['chamado_id', 'participante_id'])]
class ParticipantesChamado extends Model
{
    public function chamado(): BelongsTo
    {
        return $this->belongsTo(Chamado::class);
    }

    public function participante(): BelongsTo
    {
        return $this->belongsTo(Participante::class);
    }

}
