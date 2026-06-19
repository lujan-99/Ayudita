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
        Schema::table('consejos', function (Blueprint $table) {
            $table->longText('archivo_base64')->nullable()->after('archivo_path');
            $table->string('archivo_mime')->nullable()->after('archivo_base64');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consejos', function (Blueprint $table) {
            $table->dropColumn(['archivo_base64', 'archivo_mime']);
        });
    }
};
