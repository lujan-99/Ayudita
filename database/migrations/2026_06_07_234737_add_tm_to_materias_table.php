<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('materias', 'tm')) {
            Schema::table('materias', function (Blueprint $table) {
                $table->string('tm', 10)->default('N')->after('nombre');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('materias', 'tm')) {
            Schema::table('materias', function (Blueprint $table) {
                $table->dropColumn('tm');
            });
        }
    }
};
