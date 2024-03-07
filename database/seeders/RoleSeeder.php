<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        //EJECUTAR php artisan migrate:fresh --seed para ejecutar todos los seeder


        Role::create(['name'=>'Comite de Calidad']);
        Role::create(['name'=>'Academicos']);
        Role::create(['name'=>'Departamento de desarrollo academico']);
        Role::create(['name'=>'Division de estudios Profesionales']);
        Role::create(['name'=>'Direccion']);
        Role::create(['name'=>'Docentes']);
        Role::create(['name'=>'Recursos Humanos']);
        Role::create(['name'=>'Escolares']);
        Role::create(['name'=>'Gestion tecnologica y vinculacion']);
        Role::create(['name'=>'Departamento de planeacion']);
        Role::create(['name'=>'Administrador']);
        Role::create(['name'=>'Secretarias CENIDET']);


        Permission::create(['name'=>'Modificación de Actas de Calificaciones']);
        Permission::create(['name'=>'Modificación de Actas de Ex. Globales o Especiales']);
        Permission::create(['name'=>'Generación de Folios']);


        Permission::create(['name'=>'Alta de Alumnos']);
        Permission::create(['name'=>'Modificación de datos de Alumnos']);
        Permission::create(['name'=>'Eliminación de Alumnos']);
        Permission::create(['name'=>'Modificación de Kardex']);
        Permission::create(['name'=>'Calcular promedios de Alumnos']);
        Permission::create(['name'=>'Solicitud de Ex. Globales o Especiales']);



        // $roleAdmin=Role::create(['name'=>'Administrador']);
        // $roleRH=Role::create(['name'=>'Usuario RH']);
        // $roleProfesor=Role::create(['name'=>'Profesor']);


        //PERIODOS DE APLICACION
        // Permission::create(['name'=>'Ver periodos de aplicacion']);
        // Permission::create(['name'=>'Agregar Periodos de aplicacion']);
        // Permission::create(['name'=>'Eliminar Periodos de Aplicacion']);
        // Permission::create(['name'=>'Actualizar fechas en los periodos de aplicacion']);

        //Usuarios
        // Permission::create(['name'=>'Agregar Usuarios']);
        // Permission::create(['name'=>'Editar Usuarios']);
        // Permission::create(['name'=>'Eliminar Usuarios']);
        // Permission::create(['name'=>'Ver usuarios']);
        // Permission::create(['name'=>'Asignar roles a los usuarios']);

        //Roles/Permisos
        // Permission::create(['name'=>'Ver Roles']);
        // Permission::create(['name'=>'Crear roles']);
        // Permission::create(['name'=>'Editar información de los roles']);
        // Permission::create(['name'=>'Eliminar roles']);

        //Personal
        // Permission::create(['name'=>'Ver informacion del personal']);
        // Permission::create(['name'=>'Agregar Personal']);
        // Permission::create(['name'=>'Asignar cuentas de usuarios al personal']);
        // Permission::create(['name'=>'Asignar Plazas al personal']);
        // Permission::create(['name'=>'Editar información del personal']);
        // Permission::create(['name'=>'Eliminar al personal']);

        //Plazas
        // Permission::create(['name'=>'Ver Plazas']);
        // Permission::create(['name'=>'Agregar Plazas']);
        // Permission::create(['name'=>'Editar Plazas']);
        // Permission::create(['name'=>'Eliminar Plazas']);

        //Profesores
        // Permission::create(['name'=>'Ver profesores']);
        // Permission::create(['name'=>'Agregar profesores']);
        // Permission::create(['name'=>'Editar Información de los profesores']);
        // Permission::create(['name'=>'Eliminar Profesores']);

        //Materias
        // Permission::create(['name'=>'Ver materias']);
        // Permission::create(['name'=>'Agregar Materias']);
        // Permission::create(['name'=>'Editar Materias']);
        // Permission::create(['name'=>'Eliminar Materias']);

        //Horarios
        // Permission::create(['name'=>'Ver horarios']);
        // Permission::create(['name'=>'Crear y Editar Horarios']);
        // Permission::create(['name'=>'Eliminar Horarios']);


        //Departamentos
        // Permission::create(['name'=>'Ver departamentos']);
        // Permission::create(['name'=>'Agregar Departamentos']);
        // Permission::create(['name'=>'Editar información de los departamentos']);
        // Permission::create(['name'=>'Eliminar departamentos']);

        //AULAS
        // Permission::create(['name'=>'Ver aulas']);
        // Permission::create(['name'=>'Agregar aulas']);
        // Permission::create(['name'=>'Editar aulas']);
        // Permission::create(['name'=>'Eliminar aulas']);

        //Categorias
        // Permission::create(['name'=>'Ver categorias de plaza']);
        // Permission::create(['name'=>'Agregar categorias de plaza']);
        // Permission::create(['name'=>'Editar informacion de categorias plaza']);
        // Permission::create(['name'=>'Eliminar categorias plaza']);

        //Respaldo
        // Permission::create(['name'=>'Hacer respaldo de la base de datos']);
        // Permission::create(['name'=>'Hacer restauración de la base de datos']);

    }

}
