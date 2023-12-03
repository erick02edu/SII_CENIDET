<?php

namespace App\Imports;

use App\Models\Alumnos;
use App\Models\Grupos;
use App\Models\Periodos;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow; //Permitir enlazar encabezados del excel para la importacion
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Row;


class AlumnosImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */


    // private $Grupo;
    // private $periodo;

    // public function __construct() {
    //     $this->Grupo=Grupos::pluck('id','name');
    // }

    public function model(array $row)
    {

        //TRANSFORMAR LA FECHA
        $fechaNac = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['fecha_nacimiento']));

        //OBTENER ID DEL PERIODO
        $PeriodoCompleto=$row['periodo_actual'];
        // Dividir el string por el caracter "-"
        $partes = explode('-', $PeriodoCompleto);
        $i=0;
        foreach ($partes as $parte) {
            if($i==0){
                $mesInicio=$parte;
            }
            if($i==1){
                $AñoInicio=$parte;
            }
            if($i==2){
                $mesTermino=$parte;
            }
            if($i==3){
                $AñoTermino=$parte;
            }

            $i++;
        }

        $idPeriodo=Periodos::
        where('mesInicio',$mesInicio)->
        where('AñoInicio',$AñoInicio)->
        where('mesTermino',$mesTermino)->
        where('AñoTermino',$AñoTermino)->
        value('id');

        //OBTENER ID GRUPO
        $Semestre=$row['semestre'];
        $Letra=$row['grupo'];
        $Especialidad=$row['especialidad'];




        $idGrupo=Grupos::
        where('Semestre',$Semestre)->
        where('Letra',$Letra)->
        where('Especialidad',$Especialidad)->
        where('idPeriodo',$idPeriodo)->
        value('id');

        //dd($idGrupo);

        return new Alumnos([
            //Definir las columnas (mapeo)
            // Agregar la conversión de la fecha aquí
            //Colum.BD ----- Colum.Excel
            'Nombre'=>$row['nombre'],
            'ApellidoP'=>$row['apellido_paterno'],
            'ApellidoM'=>$row['apellido_materno'],
            'FechaNac'=>$fechaNac,
            'noControl'=>$row['numcontrol'],
            'curp'=>$row['curp'],
            'Direccion'=>$row['direccion'],
            'Genero'=>$row['genero'],
            'Telefono'=>$row['telefono'],
            'idGrupo'=>$idGrupo,

        ]);
    }
}
