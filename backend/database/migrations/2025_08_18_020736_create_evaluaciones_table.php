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
       Schema::create('evaluaciones', function (Blueprint $table) {
            $table->id();
            $table->string('usuario_id'); // persona entrevistada
            $table->string('empresa')->nullable();
            $table->date('fecha');
            $table->decimal('integridad', 5, 2)->default(0);
            $table->decimal('confidencialidad', 5, 2)->default(0);
            $table->decimal('disponibilidad', 5, 2)->default(0);
            $table->timestamps();

            $table->foreign('usuario_id')->references('usuario_id')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluaciones');
    }
};
