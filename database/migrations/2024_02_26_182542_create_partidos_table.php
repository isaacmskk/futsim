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
            $table->unsignedBigInteger("id_plantilla1");
            $table->foreign('id_plantilla1')->references('id')->on('plantillas')->onDelete('cascade');

            $table->unsignedBigInteger("usuario1");
            $table->foreign('usuario1')->references('id')->on('users')->onDelete('cascade');

            $table->integer("goles1");
            $table->dateTime("fecha");
            $table->integer("goles2");

            $table->unsignedBigInteger("usuario2");
            $table->foreign('usuario2')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger("id_plantilla2");
            $table->foreign('id_plantilla2')->references('id')->on('plantillas')->onDelete('cascade');
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
