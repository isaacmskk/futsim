<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plantilla_jugadores', function (Blueprint $table) {
            $table->foreignId('id_plantilla')->constrained('plantillas')->onDelete('cascade');
            $table->foreignId('id_jugador')->constrained('jugadores')->onDelete('cascade');
            $table->dateTime('fichaje')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('plantilla_jugadores');
    }
};
