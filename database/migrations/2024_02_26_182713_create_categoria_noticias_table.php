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
        Schema::create('categoria_noticias', function (Blueprint $table) {
            $table->unsignedBigInteger('id_noticia');
            $table->unsignedBigInteger('id_categoria');
            $table->foreign('id_noticia')->references('id')->on('noticias')->onDelete('cascade');
            $table->foreign('id_categoria')->references('id')->on('categorias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categoria_noticias');
    }
};
