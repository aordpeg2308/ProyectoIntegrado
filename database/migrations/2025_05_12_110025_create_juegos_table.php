<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('juegos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->enum('tipo', ['Juego de mesa', 'Manual de rol']);
            $table->string('genero');
            $table->integer('edad');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('juegos');
    }
};
