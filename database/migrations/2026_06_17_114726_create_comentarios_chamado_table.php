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
        Schema::create('comentarios_chamado', function (Blueprint $table) {
            $table->id();
            $table->foreignId('participantes_chamados_id')->constrained('participantes_chamados')->cascadeOnDelete();
            $table->enum('tipo', ['tecnico', 'cliente', 'geral', 'impedimento'])->default('geral');
            $table->text('texto');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comentarios_chamado');
    }
};
