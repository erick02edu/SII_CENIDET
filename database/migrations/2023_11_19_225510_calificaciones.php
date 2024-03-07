<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('Calificaciones',function(Blueprint $table){
            $table->id('id');
            $table->unsignedBigInteger('idAlumno')->nullable();
            $table->unsignedBigInteger('idMateria')->nullable();
            $table->float('Calificacion');
            $table->float('NumSemestre');
            $table->date('FechaRegistro');
            $table->unsignedBigInteger('idProfesor')->nullable();
            $table->unsignedBigInteger('idGrupo')->nullable(); // Columna para la llave foránea


            //Llaves foraneas
            $table->foreign('idAlumno')->references('id')->on('alumnos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('idMateria')->references('id')->on('materias')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('idProfesor')->references('id')->on('personal')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('idGrupo')->references('id')->on('grupos')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down(): void
    {

    }

};
