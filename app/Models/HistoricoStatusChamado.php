<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['chamado_id', 'status_atual', 'status_anterior'])]
class HistoricoStatusChamado extends Model
{
    protected $table = "historico_status_chamado";

    public function chamado(): BelongsTo
    {
        return $this->belongsTo(Chamado::class);
    }
}
