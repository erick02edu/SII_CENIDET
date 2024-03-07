<template>
    <Head title="Generar Historial" />
    <!--Imagen de carga al generar historial-->
    <div class='flex items-center justify-center min-h-screen'>
        <div style="border-top-color:transparent" class="w-8 h-8 border-4 border-[#014E82] rounded-full animate-spin"></div>
        <p class="ml-2">GENERANDO HISTORIAL...</p>
    </div>
    <!--Contenido del historial-->
    <div class="hidden">
        <div id="pdfContent" class="w-full">
            <!--RECORRER ALUMNOS-->
            <div v-for="index in NumeroAlumnos" :key="index" >
                <!--Encabezado con logos-->
                <div class="w-full h-14 inline-flex align-top ">

                    <div class="w-1/3 flex justify-start align-top pl-10 ">
                        <img src="/img/LogoSEP.jpg" class="h-14">
                    </div>


                    <div class="w-1/3 flex justify-center">
                        <img src="/img/LogoTecReportes.png" class="h-14">
                    </div>

                    <div class="w-1/3 flex justify-end mr-10 ">
                        <img src="/img/CenidetLogoClaro.png" class="h-14">
                    </div>
                </div>
                <!--Informacion general-->
                <div class="w-full mb-2 mt-3 ml-12 ">
                    <strong>Informacion general del alumno</strong>
                </div>
                <div class="w-full">
                    <!--Imprimir nombre alumno-->
                    <div class='w-full'>
                        <span class="ml-12 mt-5 mb-3">
                            Nombre del alumno:{{ NombreAlumnos[index -1] }}
                        </span>

                        <span class="ml-2 mt-5 mb-3">
                            No. Control:{{ InfoAlumnos[index-1].noControl }}
                        </span>
                    </div>
                    <div class='w-full ml-12 mt-1 mb-4'>

                        <span v-if="InfoAlumnos[index-1].idCarrera==null">
                            Carrera:Sin carrera
                        </span>

                        <span v-else v-for="carrera in carreras">
                            <span v-if="carrera.id==InfoAlumnos[index-1].idCarrera">
                                Carrera:{{ carrera.Nivel }} en {{ carrera.Nombre }}
                            </span>
                        </span>



                    </div>
                </div>
                <!--Tabla de calificaciones-->
                <table class="ml-12 mr-7 text-center ">
                    <thead>
                        <tr class=" align-top border-b bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            <th class="pb-1 border-b-2 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 py-1 text-left
                            text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200 w-1/12">
                                Semestre
                            </th>
                            <th class="border-b-2 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 h-10 py-1 text-left
                            text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200">
                                Grupo
                            </th>
                            <th class="pb-1 border-b-2 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 py-1 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200">
                                Materia
                            </th>
                            <th class="border-b-2 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 h-10 py-1 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200">
                                Calificacion
                            </th>

                            <th class="border-b-2 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-2
                            h-10 pb-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600
                             dark:text-slate-200">
                                Fecha de registro
                            </th>

                        </tr>
                    </thead>

                    <!--RECORRER CALIFICACIONES DEL ALUMNO ACTUAL-->
                    <tr v-for="Calificacion in CalificacionesTotales[index -1]" class=" align-top w-full h-10 pb-1">

                        <td>
                            {{ Calificacion.NumSemestre }}
                        </td>

                        <td class="px-4">
                            <span v-if="InfoAlumnos[index-1].idGrupo==null">
                                N/A
                            </span>

                            <span v-else v-for="grupo in grupos">
                                <span v-if="grupo.id==InfoAlumnos[index-1].idGrupo">
                                    {{grupo.Letra}}
                                </span>
                            </span>
                        </td>


                        <td>
                            <span v-for="materia in materias">
                                <span v-if="materia.id==Calificacion.idMateria">
                                    {{ materia.Nombre }}
                                </span>
                            </span>
                        </td>

                        <td>
                            {{ Calificacion.Calificacion }}
                        </td>

                        <td>
                            {{ Calificacion.FechaRegistro }}
                        </td>

                    </tr>



                </table>
                <!--Mostrar promedio general-->
                <span class="ml-12 mt-1">Promedio General:{{ PromediosGenerales[index -1] }}</span>
                <!--Salto de pagina-->
                <div class="page-break"></div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { Head } from '@inertiajs/vue3';
</script>

<script>
  import html2pdf from "html2pdf.js";
    export default {
        props:{
            NombreAlumnos:Array,
            NumeroAlumnos:0,
            NumSemestres:Array,
            CalificacionesTotales:Array,
            materias:Array,
            PromediosGenerales:Array,
            InfoAlumnos:0,
            carreras:Array,
            grupos:Array,
        },

        async mounted() {
            await this.generarPDF();

            window.history.back();
        },

        methods:{

            async generarPDF() {
                var element=document.getElementById('pdfContent');//obtener elemento

                const pdfOptions = {
                margin: 0,
                filename: 'Historial.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' },//Hoja horizontal
                };

                const pdf=new html2pdf().from(element).set(pdfOptions).outputPdf();
                console.log(pdf)
                await pdf.save();

            },
        }
    }
</script>

<style>
/* Clase para el salto de pagina*/
.page-break {
  page-break-before: always;
}
</style>



