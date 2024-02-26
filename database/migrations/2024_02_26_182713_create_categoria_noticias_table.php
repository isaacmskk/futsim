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
            // $table->integer("id_noticia");
            // $table->integer("id_categoria");
            $table->foreign('id_noticia')->references('id')->on('noticia');
            $table->foreign('id_categoria')->references('id')->on('categoria');

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
