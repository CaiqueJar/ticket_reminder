<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['nome'])]
class Participante extends Model
{
    public function chamados(): BelongsToMany
    {
        return $this->belongsToMany(Chamado::class, 'participantes_chamados');
    }
}
