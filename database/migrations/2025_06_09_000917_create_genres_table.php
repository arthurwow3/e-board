<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('genres', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        DB::table('genres')->insert([
            ['name' => 'Estratégia', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Party Game', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Família', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cooperativo', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('genres');
    }
};

