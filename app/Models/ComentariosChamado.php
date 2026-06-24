<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table('comentarios_chamado')]
#[Fillable(['chamado_id', 'participante_id', 'tipo', 'texto'])]
class ComentariosChamado extends Model
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
