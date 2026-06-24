<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table('arquivos_alterados_chamado')]
#[Fillable(['chamado_id', 'caminho_arquivo'])]
class ArquivoAlteradoChamado extends Model
{
    public function getNomeArquivoAttribute(): ?string
    {
        return $this->caminho_arquivo ? basename($this->caminho_arquivo) : null;
    }

    public function chamado(): BelongsTo
    {
        return $this->belongsTo(Chamado::class);
    }
}
