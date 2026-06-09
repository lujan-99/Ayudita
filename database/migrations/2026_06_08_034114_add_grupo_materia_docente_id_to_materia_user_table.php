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
        Schema::table('materia_user', function (Blueprint $table) {
            $table->foreignId('grupo_materia_docente_id')
                ->nullable()
                ->after('estado')
                ->constrained('grupo_materia_docente')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('materia_user', function (Blueprint $table) {
            $table->dropForeign(['grupo_materia_docente_id']);
            $table->dropColumn('grupo_materia_docente_id');
        });
    }
};
