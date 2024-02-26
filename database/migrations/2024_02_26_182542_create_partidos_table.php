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
        Schema::create('partidos', function (Blueprint $table) {
            $table->id();
            $table->integer("id_plantilla1");
            $table->string("usuario1");
            $table->integer("goles1");
            $table->dateTime("fecha");
            $table->integer("goles2");
            $table->string("usuario2");
            $table->integer("id_plantilla2");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partidos');
    }
};
