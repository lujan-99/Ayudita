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
            $table->string('nickname')->nullable()->unique()->after('carnet_universitario');
            $table->integer('puntos')->default(0)->after('nickname');
        });

        // Seed existing profiles
        $profiles = \DB::table('perfiles_estudiantes')->get();
        foreach ($profiles as $profile) {
            $nickname = $this->generateUniqueNickname();
            \DB::table('perfiles_estudiantes')
                ->where('id', $profile->id)
                ->update([
                    'nickname' => $nickname,
                    'puntos' => 0
                ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perfiles_estudiantes', function (Blueprint $table) {
            $table->dropColumn(['nickname', 'puntos']);
        });
    }

    private function generateUniqueNickname(): string
    {
        $animals = ['Perro', 'Gato', 'Zorro', 'Leon', 'Oso', 'Lobo', 'Aguila', 'Halcon', 'Tigre', 'Delfin', 'Tiburon', 'Puma', 'Buho', 'Condor', 'Jaguar', 'Conejo', 'Tortuga', 'Koala', 'Panda', 'Canguro'];
        $adjectives = ['Loco', 'Feliz', 'Rapido', 'Valiente', 'Sabio', 'Astuto', 'Silencioso', 'Feroz', 'Fiel', 'Agil', 'Atento', 'Noble', 'Fuerte', 'Sereno', 'Activo', 'Curioso', 'Divertido', 'Pensativo', 'Aventurero', 'Paciente'];

        $attempts = 0;
        do {
            $animal = $animals[array_rand($animals)];
            $adjective = $adjectives[array_rand($adjectives)];
            $nickname = "El " . $animal . " " . $adjective;
            
            if ($attempts > 5) {
                $nickname .= " " . rand(100, 999);
            }
            
            $exists = \DB::table('perfiles_estudiantes')->where('nickname', $nickname)->exists();
            $attempts++;
        } while ($exists);

        return $nickname;
    }
};
