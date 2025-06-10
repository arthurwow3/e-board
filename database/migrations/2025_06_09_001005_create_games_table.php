<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();

            // Características
            $table->string('title');
            $table->text('description');
            $table->unsignedInteger('players_min');
            $table->unsignedInteger('players_max');
            $table->foreignId('publisher_id')->constrained()->onDelete('cascade');
            $table->foreignId('genre_id')->constrained()->onDelete('cascade');

            // Financeiro
            $table->decimal('purchase_price', 10, 2);
            $table->date('purchase_date')->nullable();
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->decimal('asset_costs', 10, 2)->nullable();

            // Outros
            $table->unsignedInteger('sleeves')->nullable();
            $table->string('sleeve_size')->nullable(); // ex: P, M, G, GG
            $table->string('icon')->nullable(); // caminho da imagem do ícone
            $table->json('images')->nullable(); // múltiplas imagens em array JSON

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};

