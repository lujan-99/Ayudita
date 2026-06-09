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
        Schema::table('perfiles_estudiantes', function (Blueprint $table) {
            if (!Schema::hasColumn('perfiles_estudiantes', 'carnet_identidad')) {
                $table->string('carnet_identidad', 20)->nullable()->unique()->after('semestre_actual');
            }
            if (!Schema::hasColumn('perfiles_estudiantes', 'carnet_universitario')) {
                $table->string('carnet_universitario', 30)->nullable()->unique()->after('carnet_identidad');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perfiles_estudiantes', function (Blueprint $table) {
            $table->dropColumn(['carnet_identidad', 'carnet_universitario']);
        });
    }
};
