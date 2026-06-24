<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('comentarios_chamado', function (Blueprint $table) {
            $table->unsignedBigInteger('chamado_id')->nullable()->after('id');
            $table->unsignedBigInteger('participante_id')->nullable()->after('chamado_id');
        });

        DB::table('comentarios_chamado')
            ->join('participantes_chamados', 'comentarios_chamado.participantes_chamados_id', '=', 'participantes_chamados.id')
            ->update([
                'comentarios_chamado.chamado_id' => DB::raw('participantes_chamados.chamado_id'),
                'comentarios_chamado.participante_id' => DB::raw('participantes_chamados.participante_id'),
            ]);

        Schema::table('comentarios_chamado', function (Blueprint $table) {
            $table->foreign('chamado_id')->references('id')->on('chamados')->cascadeOnDelete();
            $table->foreign('participante_id')->references('id')->on('participantes')->cascadeOnDelete();
            $table->dropForeign(['participantes_chamados_id']);
            $table->dropColumn('participantes_chamados_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comentarios_chamado', function (Blueprint $table) {
            $table->unsignedBigInteger('participantes_chamados_id')->nullable()->after('id');
        });

        DB::table('comentarios_chamado')
            ->leftJoin('participantes_chamados', function ($join) {
                $join->on('comentarios_chamado.chamado_id', '=', 'participantes_chamados.chamado_id')
                    ->on('comentarios_chamado.participante_id', '=', 'participantes_chamados.participante_id');
            })
            ->update([
                'comentarios_chamado.participantes_chamados_id' => DB::raw('participantes_chamados.id'),
            ]);

        Schema::table('comentarios_chamado', function (Blueprint $table) {
            $table->dropForeign(['chamado_id']);
            $table->dropForeign(['participante_id']);
            $table->dropColumn(['chamado_id', 'participante_id']);
        });

        Schema::table('comentarios_chamado', function (Blueprint $table) {
            $table->foreign('participantes_chamados_id')->references('id')->on('participantes_chamados')->cascadeOnDelete();
        });
    }
};
