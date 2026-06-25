<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nome_oficial', 'descricao'])]
class Termo extends Model
{
    public function aliases(): HasMany
    {
        return $this->hasMany(TermoAlias::class);
    }
}
