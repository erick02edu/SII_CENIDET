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
        Schema::create('Grupos',function(Blueprint $table){
            $table->id('id');
            $table->integer('Semestre');
            $table->string('Especialidad');
            $table->string('Letra');
            $table->unsignedBigInteger('idPeriodo')->nullable(); // Columna para la llave foránea
            //Llaves foraneas
            $table->foreign('idPeriodo')->references('id')->on('periodos')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
