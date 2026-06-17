<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('historico_status_chamado', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chamado_id')->constrained('chamados')->cascadeOnDelete();
            $table->enum('status_atual', ['backlog sprint', 'em desenvolvimento', 'em teste', 'parado', 'concluido'])->default('backlog sprint');
            $table->enum('status_anterior', ['backlog sprint', 'em desenvolvimento', 'em teste', 'parado', 'concluido'])->default('backlog sprint');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historico_status_chamado');
    }
};
