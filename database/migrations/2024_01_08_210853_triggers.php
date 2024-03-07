<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
            /* ACTUALIZAR ESTATUS DE UNA PLAZA POR EJEMPLO AL HACER UN
            CAMBIO LA PLAZA ANTERIOR QUEDA LIBRE
            Y LA ELEGIDA SE CAMBIA EL ESTATUS A ASIGNADA*/
            DB::unprepared("
            CREATE TRIGGER actualiza_estatus_plaza_update_personal
            BEFORE UPDATE ON personal
            FOR EACH ROW
            BEGIN
                IF NEW.idPlaza IS NOT NULL THEN
                UPDATE plazas SET estatus = '0' WHERE id = OLD.idPlaza;
                    UPDATE plazas SET estatus = '1' WHERE id = NEW.idPlaza;
                END IF;
            END
            ");
            /*ACTUALIZAR ESTATUS DE UNA CUENTA POR EJEMPLO AL HACER UN CAMBIO DE CUENTA
            LA ANTERIOR QUEDA LIBRE Y LA ELEGIDA SE CAMBIA EL ESTATUS A ASIGNADA */
            DB::unprepared("
            CREATE TRIGGER actualiza_estatus_cuenta_update_personal
            BEFORE UPDATE ON personal
            FOR EACH ROW
            BEGIN
                IF NEW.idUsuario IS NOT NULL THEN
                UPDATE users SET Estatus = '0' WHERE id = OLD.idUsuario;
                    UPDATE users SET Estatus = '1' WHERE id = NEW.idUsuario;
                END IF;
            END
            ");
            /*ACTUALIZAR ESTATUS DE LA PLAZA Y LA CUENTA CUANDO SE DA DE
            BAJA UN PERSONAL.
            Ademas si era jefe de departemento ese departamento se quedara sin JEFE */
            DB::unprepared("
            CREATE TRIGGER actualiza_estatus_PlazaCuenta_baja_personal
            BEFORE UPDATE ON personal
            FOR EACH ROW
            BEGIN
                DECLARE personal_id INT;
                SET personal_id = NEW.id;

                IF NEW.Estatus='B' THEN
                    UPDATE departamentos SET idEncargado=NULL WHERE id=personal_id;
                    UPDATE plazas SET estatus = '0' WHERE id = OLD.idPlaza;
                    UPDATE users SET Estatus = '0' WHERE id = OLD.idUsuario;
                    SET NEW.idPlaza=NULL;
                    SET NEW.idUsuario=NULL;
                END IF;
            END
            ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
