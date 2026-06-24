<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table('comentarios_chamado')]
#[Fillable(['participantes_chamados_id', 'tipo', 'texto'])]
class ComentariosChamado extends Model
{
    public function participantesChamado(): BelongsTo
    {
        return $this->belongsTo(ParticipantesChamado::class, 'participantes_chamados_id');
    }
}
