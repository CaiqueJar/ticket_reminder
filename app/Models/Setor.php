<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Table('setores')]
#[Fillable(['nome'])]
class Setor extends Model
{
    public function chamados(): BelongsToMany
    {
        return $this->belongsToMany(Chamado::class, 'setor_chamados');
    }
}
