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
        Schema::create('requisitos_materias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('materia_id')->constrained('materias')->restrictOnDelete();
            $table->foreignId('requisito_id')->constrained('materias')->restrictOnDelete();
            $table->timestamps();

            $table->unique(['materia_id', 'requisito_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requisitos_materias');
    }
};