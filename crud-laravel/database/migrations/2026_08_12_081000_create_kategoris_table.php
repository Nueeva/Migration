<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategoris', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique();
            $table->string('icon')->default('📦');
            $table->timestamps();
        });

        // Seed default computer categories
        $defaults = [
            ['nama' => 'VGA Card', 'icon' => '🎮'],
            ['nama' => 'Processor', 'icon' => '⚡'],
            ['nama' => 'Monitor', 'icon' => '🖥️'],
            ['nama' => 'RAM', 'icon' => '💾'],
            ['nama' => 'Storage', 'icon' => '💽'],
            ['nama' => 'Peripheral', 'icon' => '⌨️'],
            ['nama' => 'Power Supply', 'icon' => '🔌'],
            ['nama' => 'Casing', 'icon' => '🖥️'],
            ['nama' => 'Komputer', 'icon' => '💻'],
        ];

        foreach ($defaults as $d) {
            DB::table('kategoris')->insertOrIgnore([
                'nama'       => $d['nama'],
                'icon'       => $d['icon'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('kategoris');
    }
};
