<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('publishers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        DB::table('publishers')->insert([
            ['name' => 'Galápagos', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Devir', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Meeple BR', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('publishers');
    }
};
