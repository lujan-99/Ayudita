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
        Schema::create('grupo_materia_docente', function (Blueprint $table) {
            $table->id();
            $table->foreignId('materia_id')->constrained('materias')->restrictOnDelete();
            $table->foreignId('docente_id')->constrained('docentes')->restrictOnDelete();
            $table->string('grupo_codigo');
            $table->timestamps();

            $table->unique(['materia_id', 'docente_id', 'grupo_codigo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grupo_materia_docente');
    }
};