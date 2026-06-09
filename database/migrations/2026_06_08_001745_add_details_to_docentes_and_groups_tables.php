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
        Schema::table('docentes', function (Blueprint $table) {
            $table->string('foto')->nullable()->after('nombre_completo');
            $table->text('detalles_basicos')->nullable()->after('foto');
            $table->decimal('calificacion', 3, 2)->default(0.00)->after('detalles_basicos');
        });

        Schema::table('grupo_materia_docente', function (Blueprint $table) {
            $table->decimal('calificacion', 3, 2)->default(0.00)->after('grupo_codigo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('docentes', function (Blueprint $table) {
            $table->dropColumn(['foto', 'detalles_basicos', 'calificacion']);
        });

        Schema::table('grupo_materia_docente', function (Blueprint $table) {
            $table->dropColumn('calificacion');
        });
    }
};
