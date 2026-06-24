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
        Schema::table('work_logs', function (Blueprint $table) {
            $table->timestamp('pausado_em')->nullable()->after('termino_em');

            $table->unsignedInteger('segundos_pausados')
                ->default(0)
                ->after('pausado_em');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_logs', function (Blueprint $table) {
            $table->dropColumn([
                'pausado_em',
                'segundos_pausados',
            ]);
        });
    }
};
