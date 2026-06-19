<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(['titulo', 'empresa', 'codigo_referencia', 'descricao', 'tempo_estimado_minutos', 'solucao'])]
class Chamado extends Model
{
    public function arquivosAlterados(): HasMany
    {
        return $this->hasMany(ArquivoAlteradoChamado::class);
    }

    public function historico(): HasMany
    {
        return $this->hasMany(HistoricoStatusChamado::class);
    }

    public function participantes(): BelongsToMany
    {
        return $this->belongsToMany(Participante::class, 'participantes_chamados');
    }

    public function participantesChamados(): HasMany
    {
        return $this->hasMany(ParticipantesChamado::class);
    }

    public function workLogs(): HasMany
    {
        return $this->hasMany(WorkLog::class);
    }

    public function activeWorkLog(): HasOne
    {
        return $this->hasOne(WorkLog::class)
            ->whereNull('termino_em');
    }

    public function getStatusAttribute(): ?string
    {
        return $this->historico()->latest()->value('status_atual');
    }
}
