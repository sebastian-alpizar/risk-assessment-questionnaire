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
        Schema::create('pregunta', function (Blueprint $table) {
            $table->bigIncrements('id_pregunta');
            $table->unsignedBigInteger('id_tarea');
            $table->text('texto');
            $table->enum('tipo_cia', ['Confidencialidad', 'Integridad', 'Disponibilidad']);
            $table->decimal('peso', 5, 2)->default(1.0);
            $table->timestamps();

            $table->foreign('id_tarea')
                ->references('id_tarea')
                ->on('tarea')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pregunta');
    }
};
