<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partidas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->foreignId('juego_id')->constrained()->onDelete('cascade');
            $table->foreignId('creador_id')->constrained('users')->onDelete('cascade');
            $table->dateTime('fecha');
            $table->integer('min_jugadores');
            $table->integer('max_jugadores');
            $table->text('descripcion');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partidas');
    }
};
