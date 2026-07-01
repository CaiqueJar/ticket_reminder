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
        Schema::create('setores', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 60);
            $table->timestamps();
        });

        Schema::create('setor_chamados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chamado_id')->constrained('chamados')->cascadeOnDelete();
            $table->foreignId('setor_id')->constrained('setores')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setor_chamados');
        Schema::dropIfExists('setores');
    }
};
