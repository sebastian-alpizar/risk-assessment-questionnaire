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
        Schema::create('respuestas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('evaluacion_id');
            $table->unsignedBigInteger('id_pregunta');
            $table->enum('respuesta', ['si', 'no', 'na']);
            $table->timestamps();
            $table->foreign('evaluacion_id')->references('id')->on('evaluaciones')->onDelete('cascade');
            $table->foreign('id_pregunta')->references('id_pregunta')->on('pregunta');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('respuesta');
    }
};
