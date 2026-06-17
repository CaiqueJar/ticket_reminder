<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['titulo', 'codigo_referencia', 'descricao', 'tempo_estimado_minutos', 'solucao'])]
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
}
