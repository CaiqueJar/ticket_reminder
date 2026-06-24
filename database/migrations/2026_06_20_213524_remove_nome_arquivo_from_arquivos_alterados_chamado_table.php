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
        Schema::table('arquivos_alterados_chamado', function (Blueprint $table) {
            if (Schema::hasColumn('arquivos_alterados_chamado', 'nome_arquivo')) {
                $table->dropColumn('nome_arquivo');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('arquivos_alterados_chamado', function (Blueprint $table) {
            $table->string('nome_arquivo')->nullable();
        });
    }
};
