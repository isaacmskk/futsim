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
        Schema::create('plantilla_jugadores', function (Blueprint $table) {
            $table->unsignedBigInteger('id_plantilla');
            $table->foreign('id_plantilla')->references('id')->on('plantillas')->onDelete('cascade');

            
            $table->unsignedBigInteger('id_jugador');
            $table->foreign('id_jugador')->references('id')->on('jugadores')->onDelete('cascade');

            $table->integer("valoracion");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plantilla_jugadores');
    }
};
