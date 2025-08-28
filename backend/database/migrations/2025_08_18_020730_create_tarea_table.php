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
        Schema::create('tarea', function (Blueprint $table) {
            $table->id('id_tarea');
            $table->unsignedBigInteger('id_norma'); // Cambio recomendado
            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();
            $table->timestamps();

            // Definición explícita de la clave foránea
            $table->foreign('id_norma')
                ->references('id_norma')
                ->on('norma')
                ->onDelete('cascade'); // o 'restrict' según tu necesidad
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarea');
    }
};
