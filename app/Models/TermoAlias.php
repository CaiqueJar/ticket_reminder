<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['termo_id', 'nome'])]
class TermoAlias extends Model
{
    public function termo(): BelongsTo
    {
        return $this->belongsTo(Termo::class);
    }
}
