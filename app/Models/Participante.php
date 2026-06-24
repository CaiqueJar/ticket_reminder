<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nome'])]
class Participante extends Model
{
    public function chamados(): BelongsToMany
    {
        return $this->belongsToMany(Chamado::class, 'participantes_chamados');
    }

    public function comentarios(): HasMany
    {
        return $this->hasMany(ComentariosChamado::class);
    }
}
