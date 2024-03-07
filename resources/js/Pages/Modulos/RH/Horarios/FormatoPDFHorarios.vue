<template>
 <Head title="Generar PDF" />
    <!--Imagen de carga al descargar PDF-->
    <div class='flex items-center justify-center min-h-screen'>
        <div style="border-top-color:transparent" class="w-8 h-8 border-4 border-[#014E82] rounded-full animate-spin"></div>
        <p class="ml-2">GENERANDO PDF...</p>
    </div>
    <!--Seccion con el horario del docente-->
    <div v-show="false">
        <div id="pdfContent" class="w-full">
            <div class="w-full h-full overflow-y-scroll ">
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

                <!--TABLA INFORMACION DEL PERSONAL-->
                <div class="w-full inline-flex text-xxs pl-5 h-1/12 ">

                    <table class="w-full mr-4 uppercase align-top border-collapse">
                        <tr class="align-top">
                            <td class="border-t border-l border-black pb-1 border-collapse">Institucion:<strong class="pl-2">CENTRO NACIONAL DE INVESTIGACION Y DESARROLLO TECNOLOGICO</strong></td>
                            <td class="border-t border-l border-black border-collapse">C.C.T</td>
                            <td class="border-t border-l border-black border-collapse"> <strong>17IIT0001W</strong> </td>
                            <td class="border-t border-l border-black border-collapse">PERIODO ESCOLAR:</td>
                            <td class="border-t border-l border-black border-collapse"> <strong>{{ periodo.mesInicio }} {{ periodo.AñoInicio }}-{{ periodo.mesTermino }} {{ periodo.AñoTermino }}</strong></td>
                            <td class="border-t border-l border-black border-collapse">RFC:</td>
                            <td class="border-t border-l border-r border-black border-collapse "><strong>{{personal.RFC}}</strong></td>
                        </tr>

                        <tr class=" align-top ">
                            <td colspan="3" class="border-t border-l border-black pb-1 border-collapse">NOMBRE COMPLETO:<strong class="pl-10">{{ personal.Nombre }} {{ personal.ApellidoP }} {{ personal.ApellidoM }}</strong></td>
                            <td colspan="4" class="border-t border-l border-r border-black border-collapse">
                                CLAVE COMPLETO DE LA(S) PLAZA(S):
                            </td>
                        </tr>

                        <tr class=" align-top">
                            <td class="border-t border-l border-black pb-1 border-collapse">Escolaridad</td>
                            <td class="border-t border-l border-black border-collapse">PASANTE</td>
                            <td class="border-t border-l border-black border-collapse">TITULADO</td>
                            <td class="border-t border-l border-r border-black border-collapse" colspan="4">
                                <strong v-if="categoria!=null">{{  categoria.Clave }}</strong>
                                <strong v-else>Sin Plaza</strong>
                            </td>

                        </tr>

                        <tr class="align-top">
                            <td class="border-t border-l border-black pb-1 border-collapse">Licenciatura:<strong></strong></td>
                            <td class="border-t border-l border-black border-collapse "></td>
                            <td class="border-t border-l border-black border-collapse">X</td>
                            <td class="border-t border-l border-black border-collapse" colspan="2"><strong></strong></td>
                            <td class="border-t border-l border-r border-black border-collapse" colspan="2"><strong></strong></td>
                        </tr>

                        <tr class="align-top">
                            <td class="border-t border-l border-black pb-1 border-collapse">Maestria:
                                <strong v-if="personal.NivEst1=='Maestria'">
                                    {{ personal.Estudio1}}
                                </strong>
                                <strong v-if="personal.NivEst2=='Maestria'">
                                    {{ personal.Estudio2}}
                                </strong>
                                <strong v-if="personal.NivEst3=='Maestria'">
                                    {{ personal.Estudio3}}
                                </strong>
                            </td>
                            <td class="border-t border-l border-black border-collapse"></td>
                            <td class="border-t border-l border-black border-collapse text-center"></td>
                            <td class="border-t border-l border-b border-black border-collapse align-top" colspan="2" rowspan="2">
                                <strong>Tipo de nombramiento<br>
                                </strong>
                                <p class="text-center" v-if="plaza!=null">
                                        {{ plaza.TipoMovimiento }}
                                    </p>
                                    <p v-else>
                                        Sin nombramiento
                                    </p>
                            </td>
                            <td class="border border-black border-collapse align-top" colspan="2" rowspan="2"><strong>Fecha de ingreso a la S.E.P:<br>
                                <p class="text-center">{{ personal.IngAñoSEP }}/{{ personal.IngQuinSEP }}</p></strong>
                            </td>

                        </tr>

                        <tr class="align-top">
                            <td class="border-t border-l border-black pb-1 border-collapse">
                                Doctorado:
                                <strong v-if="personal.NivEst1=='Doctorado'">
                                    {{ personal.Estudio1}}
                                </strong>
                                <strong v-if="personal.NivEst2=='Doctorado'">
                                    {{ personal.Estudio2}}
                                </strong>
                                <strong v-if="personal.NivEst3=='Doctorado'">
                                    {{ personal.Estudio3}}
                                </strong>

                            </td>
                            <td class="border-t border-l border-black border-collapse"></td>
                            <td class="border-t border-l border-black border-collapse"></td>

                        </tr>


                        <tr class="align-top">
                            <td class="border-t border-l border-black pb-1 border-collapse">Otras:<strong></strong></td>
                            <td class="border-t border-l border-black border-collapse text-center"></td>
                            <td class="border-t border-l border-black border-collapse text-center"></td>
                            <td class="border-l border-b border-black border-collapse align-top" colspan="2" rowspan="2">
                                <strong>No.tarjeta de control<br>
                                    <p class="text-center">{{ personal.numEmpleado }}</p>
                                </strong></td>
                            <td class="border-b border-l border-r border-black align-top" colspan="2" rowspan="2"><strong>Fecha de ingreso a la S.N.E.S.T:<br>
                            <p class="text-center">{{ personal.IngAñoSNEST }}/{{ personal.IngQuinSNEST }}</p></strong></td>

                        </tr>

                        <tr class="">
                            <td class="border-t border-l border-b border-black pb-1 border-collapse"> UNIDAD ORGÁNICA DE ADSCRIPCION:
                                <strong v-if="DepartamentoAdscripcion!=null">{{ DepartamentoAdscripcion.Nombre }}</strong>
                                <strong v-else>Sin departamento</strong>
                            </td>
                            <td class="border-t border-l border-b border-black border-collapse text-center"></td>
                            <td class="border-t border-l border-b border-black border-collapse text-center"></td>

                        </tr>
                    </table>
                </div>

                <!--TABLA HORARIO DEL DOCENTES-->
                <div class="w-full pl-5 uppercase text-xxs mb-1">
                    <strong>I.Carga academica</strong>
                </div>

                <div class="w-full inline-flex text-xxs pl-5 h-1/12  ">

                    <table class="w-full mr-14 uppercase align-top border-collapse">

                        <tr class="bg-neutral-300 text-center w-full">
                            <td class="border-r border-l border-t border-collapse border-black  pb-1" rowspan="1">Asignatura</td>
                            <td class="border-r border-t border-collapse border-black" rowspan="1">Clave</td>
                            <td class="border-r border-t border-collapse border-black" rowspan="1">GPO </td>
                            <td class="border-r border-t border-collapse border-black" rowspan="1">Alumnos</td>
                            <td class="border-r border-t border-collapse border-black" rowspan="1">Aula</td>
                            <td class="border-r border-t border-collapse border-black" rowspan="1">Nivel</td>
                            <td class="border-r border-t border-collapse border-black" rowspan="1">Modalidad</td>
                            <td class="border-r border-t border-collapse border-black" rowspan="1">Programa</td>
                            <td class="border-r border-t border-collapse border-black align-top" colspan="6">Horario</td>
                            <td class="border-r border-t border-collapse border-black pb-1" rowspan="1">Total HRS semanales</td>
                        </tr>

                        <tr class="bg-neutral-300 align-top">
                            <td class="border-b border-r border-l border-collapse border-black px-20 py-0"></td>
                            <td class="border-b border-r border-collapse border-black px-8 py-0"></td>
                            <td class="border-b border-r border-collapse border-black px-4 py-0"></td>
                            <td class="border-b border-r border-collapse border-black px-8 py-0"></td>
                            <td class="border-b border-r border-collapse border-black px-8 py-0"></td>
                            <td class="border-b border-r border-collapse border-black px-8 py-0"></td>
                            <td class="border-b border-r border-collapse border-black px-8 py-0"></td>
                            <td class="border-b border-r border-collapse border-black px-8 py-0"></td>



                            <td class="border-t border-r border-b border-collapse border-black px-8 py-0">   L </td>
                            <td class="border-t border-r border-b border-collapse border-black px-8 pb-0.5"> M </td>
                            <td class="border-r border-t border-b border-collapse border-black px-8 pb-0.5"> M </td>
                            <td class="border-r border-t border-b border-collapse border-black px-8 pb-0.5"> J </td>
                            <td class="border-r border-t border-b border-collapse border-black px-8 pb-0.5"> V </td>
                            <td class="border-r border-t border-b border-collapse border-black px-8 pb-0.5"> S </td>
                            <td class="border-b border-r border-collapse border-black px-8 pb-5"></td>
                        </tr>

                        <tr class="">
                            <td class="border-r border-l border-collapse border-black align-top py-1"></td>
                            <td class="border-r border-collapse border-black"></td>
                            <td class="border-r border-collapse border-black"></td>
                            <td class="border-r border-collapse border-black"></td>
                            <td class="border-r border-collapse border-black"></td>
                            <td class="border-r border-collapse border-black"></td>
                            <td class="border-r border-collapse border-black"></td>
                            <td class="border-r border-collapse border-black"></td>
                            <td class="border-r border-collapse border-black"></td>
                            <td class="border-r border-collapse border-black"></td>
                            <td class="border-r border-collapse border-black"></td>
                            <td class="border-r border-collapse border-black"></td>
                            <td class="border-r border-collapse border-black"></td>
                            <td class="border-r border-collapse border-black"></td>
                            <td class="border-r border-collapse border-black"></td>

                        </tr>


                        <tr class="">
                            <td class="border-r border-t border-l border-collapse border-black py-1"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-t border-r border-collapse border-black"></td>

                        </tr>

                        <tr class="">
                            <td class="border-r border-t border-l border-collapse border-black py-1"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-t border-r border-collapse border-black"></td>

                        </tr>

                        <tr class="">
                            <td class="border-r border-t border-l border-collapse border-black py-1"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-t border-r border-collapse border-black"></td>

                        </tr>

                        <tr class="">
                            <td class="border-r border-t border-l border-collapse border-black py-1"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-t border-r border-collapse border-black"></td>

                        </tr>

                        <tr class="">
                            <td class="border-r border-t border-l border-collapse border-black py-1"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-t border-r border-collapse border-black"></td>

                        </tr>


                        <tr class="">
                            <td class="border-r border-t border-l border-collapse border-black py-1"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-t border-r border-collapse border-black"></td>

                        </tr>

                        <tr class="">
                            <td class="border-r border-t border-l border-collapse border-black py-1"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-t border-r border-collapse border-black"></td>

                        </tr>

                        <tr class="">
                            <td class="border-r border-t border-l border-collapse border-black py-1"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-t border-r border-collapse border-black"></td>

                        </tr>


                        <tr class="">
                            <td class="border-r border-t border-l border-collapse border-black py-1"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-t border-r border-collapse border-black"></td>

                        </tr>


                        <tr class="">
                            <td class="border-r border-t border-b border-l border-collapse border-black py-1"></td>
                            <td class="border-r border-t border-b border-collapse border-black"></td>
                            <td class="border-r border-t border-b border-collapse border-black"></td>
                            <td class="border-r border-t border-b border-collapse border-black"></td>
                            <td class="border-r border-t border-b border-collapse border-black"></td>
                            <td class="border-r border-t border-b border-collapse border-black"></td>
                            <td class="border-r border-t border-b border-collapse border-black"></td>
                            <td class="border-r border-t border-b border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-r border-t border-collapse border-black"></td>
                            <td class="border-t border-r border-collapse border-black"></td>

                        </tr>

                        <tr class="py-1">
                            <td class=""></td>
                            <td class=""></td>
                            <td class=""></td>
                            <td class=""></td>
                            <td class=""></td>
                            <td class=""></td>
                            <td class=""></td>
                            <td class="text-end border-r border-collapse border-black ">Subtotal</td>
                            <td class="border-r border-b border-t border-collapse border-black"></td>
                            <td class="border-r border-b border-t border-collapse border-black"></td>
                            <td class="border-r border-b border-t border-collapse border-black"></td>
                            <td class="border-r border-b border-t border-collapse border-black"></td>
                            <td class="border-r border-b border-t border-collapse border-black"></td>
                            <td class="border-r border-b border-t border-collapse border-black"></td>
                            <td class="border-t border-r border-b border-collapse border-black"></td>
                        </tr>

                    </table>
                </div>

                <!--TABLA ACTIVIDADES DE APOYO-->
                <div class="w-full pl-5 uppercase text-xxs mb-1">
                    <strong>II.- ACTIVIDADES DE APOYO A LA DOCENCIA</strong>
                </div>

                <div class="w-full inline-flex text-xxs pl-5 h-1/12 align-top">

                    <table class="w-full mr-4 uppercase">

                        <tr class="bg-neutral-300 text-center">
                            <td class="border-t border-l border-r border-black w-1/3 py-1" rowspan="1">Nombre de la actividad</td>
                            <td class="border-t border-r border-black mb-2 w-1/6" rowspan="1">Metas a atender</td>
                            <td class="border-t border-r border-b border-black mb-2 align-top" colspan="6">Horario</td>
                            <td class="border-t border-r border-black mb-2" rowspan="1">Total HRS semanales</td>
                        </tr>

                        <tr class="bg-neutral-300 align-top">

                            <td class="border-b border-l border-r border-collapse border-black px-8 mt-1"></td>
                            <td class="border-b border-r border-collapse border-black px-8 mt-1"></td>

                            <td class="border-r  border-b border-black px-8">L</td>
                            <td class="border-r  border-b border-black px-8">M</td>
                            <td class="border-r  border-b border-black px-8">M</td>
                            <td class="border-r  border-b border-black px-8">J</td>
                            <td class="border-r  border-b border-black px-8">V</td>
                            <td class="border-r  border-b border-black px-8">S</td>
                            <td class="border-b border-r border-collapse border-black px-8 mt-2 pb-5"></td>
                        </tr>

                        <tr class="">
                            <td class="border-l border-r border-b border-collapse border-black py-1"></td>
                            <td class="border-r border-b border-black"></td>
                            <td class="border-r border-b border-black"></td>
                            <td class="border-r border-b  border-black"></td>
                            <td class="border-r border-b border-black"></td>
                            <td class="border-r border-b border-black"></td>
                            <td class="border-r border-b border-black"></td>
                            <td class="border-r border-b border-black"></td>
                            <td class="border-r border-b  border-black"></td>
                        </tr>


                        <tr class="">
                            <td class="border-l  border-r border-b border-collapse border-black py-1"></td>
                            <td class="border-r  border-b border-black"></td>
                            <td class="border-r  border-b border-black"></td>
                            <td class="border-r  border-b  border-black"></td>
                            <td class="border-r  border-b border-black"></td>
                            <td class="border-r  border-b border-black"></td>
                            <td class="border-r  border-b border-black"></td>
                            <td class="border-r  border-b border-black"></td>
                            <td class="border-r  border-b border-black"></td>
                        </tr>

                        <tr class="">
                            <td class="border-l  border-r border-b border-collapse border-black py-1"></td>
                            <td class="border-r  border-b border-black"></td>
                            <td class="border-r  border-b border-black"></td>
                            <td class="border-r  border-b  border-black"></td>
                            <td class="border-r  border-b border-black"></td>
                            <td class="border-r  border-b border-black"></td>
                            <td class="border-r  border-b border-black"></td>
                            <td class="border-r  border-b border-black"></td>
                            <td class="border-r  border-b border-black"></td>
                        </tr>

                        <tr class="">
                            <td class="border-l  border-r border-b border-collapse border-black py-1"></td>
                            <td class="border-r  border-b border-black"></td>
                            <td class="border-r  border-b border-black"></td>
                            <td class="border-r  border-b  border-black"></td>
                            <td class="border-r  border-b border-black"></td>
                            <td class="border-r  border-b border-black"></td>
                            <td class="border-r  border-b border-black"></td>
                            <td class="border-r  border-b border-black"></td>
                            <td class="border-r  border-b border-black"></td>
                        </tr>

                        <tr class="">
                            <td class="border-l  border-r border-b border-collapse border-black py-1"></td>
                            <td class="border-r  border-b border-black"></td>
                            <td class="border-r  border-b border-black"></td>
                            <td class="border-r  border-b  border-black"></td>
                            <td class="border-r  border-b border-black"></td>
                            <td class="border-r  border-b border-black"></td>
                            <td class="border-r  border-b border-black"></td>
                            <td class="border-r  border-b border-black"></td>
                            <td class="border-r  border-b border-black"></td>
                        </tr>

                        <tr class="">
                            <td class="border-l border-r border-b border-collapse border-black py-1"></td>
                            <td class="border-r border-b border-black"></td>
                            <td class="border-r border-b border-black"></td>
                            <td class="border-r border-b  border-black"></td>
                            <td class="border-r border-b border-black"></td>
                            <td class="border-r border-b border-black"></td>
                            <td class="border-r border-b border-black"></td>
                            <td class="border-r border-b border-black"></td>
                            <td class="border-r border-b  border-black"></td>
                        </tr>

                        <tr class="">
                            <td class="border-l border-r border-b border-collapse border-black py-1"></td>
                            <td class="border-r border-b border-black"></td>
                            <td class="border-r border-b border-black"></td>
                            <td class="border-r border-b  border-black"></td>
                            <td class="border-r border-b border-black"></td>
                            <td class="border-r border-b border-black"></td>
                            <td class="border-r border-b border-black"></td>
                            <td class="border-r border-b border-black"></td>
                            <td class="border-r border-b  border-black"></td>
                        </tr>


                        <tr class="">
                            <td class="border-l border-r border-b border-collapse border-black py-1"></td>
                            <td class="border-r border-b border-black"></td>
                            <td class="border-r border-b border-black"></td>
                            <td class="border-r border-b  border-black"></td>
                            <td class="border-r border-b border-black"></td>
                            <td class="border-r border-b border-black"></td>
                            <td class="border-r border-b border-black"></td>
                            <td class="border-r border-b border-black"></td>
                            <td class="border-r border-b  border-black"></td>
                        </tr>



                        <tr class="">
                            <td class="py-1"></td>
                            <td class=""></td>

                            <td class="text-end border-r border-black">Subtotal</td>
                            <td class="border-r border-b  border-black"></td>
                            <td class="border-r border-b  border-black "></td>
                            <td class="border-r border-b  border-black "></td>
                            <td class="border-r border-b  border-black "></td>
                            <td class="border-r border-b  border-black "></td>
                            <td class="border-r border-b  border-black "></td>

                        </tr>


                        <tr class="">
                            <td class="py-1"></td>
                            <td class=""></td>

                            <td class="text-end border-r border-black">Total</td>
                            <td class="border-r border-b border-black"></td>
                            <td class="border-r border-b border-black"></td>
                            <td class="border-r border-b border-black"></td>
                            <td class="border-r border-b border-black"></td>
                            <td class="border-r border-b border-black"></td>
                            <td class="border-r border-b border-black"></td>

                        </tr>

                    </table>
                </div>

                <!--TABLA ACTIVIDADES DE APOYO-->

                <div class="w-full pl-5 uppercase text-xxs mb-0.5">
                    <strong>III.- ACTIVIDADES EN LA ADMINISTRACIÓN</strong>
                </div>

                <div class="w-full inline-flex text-xxs pl-5 h-1/12 align-top">

                    <table class="w-full mr-4 uppercase">

                        <tr class="bg-neutral-300 text-center">
                            <td class="border-t border-l border-r border-black w-1/4 py-1" rowspan="1">Puesto</td>
                            <td class="border-t border-r border-black mb-2 w-1/4" rowspan="1">UNIDAD ORGÁNICA DE ADSCRIPCIÓN </td>
                            <td class="border-t border-r border-b border-black mb-2 align-top" colspan="6">Horario</td>
                            <td class="border-t border-r border-black mb-2" rowspan="1">Total HRS semanales</td>
                        </tr>

                        <tr class="bg-neutral-300 align-top">

                            <td class="border-b border-l border-r border-collapse border-black px-8 mt-1"></td>
                            <td class="border-b border-r border-collapse border-black px-8 mt-1"></td>

                            <td class="border-r  border-b border-black px-8">L</td>
                            <td class="border-r  border-b border-black px-8">M</td>
                            <td class="border-r  border-b border-black px-8">M</td>
                            <td class="border-r  border-b border-black px-8">J</td>
                            <td class="border-r  border-b border-black px-8">V</td>
                            <td class="border-r  border-b border-black px-8">S</td>
                            <td class="border-b border-r border-collapse border-black px-8 mt-2 pb-5"></td>
                        </tr>

                        <tr class="">
                            <td class="border-l border-r border-b border-collapse border-black py-1 pb-1 ">
                                <span v-if="categoria!=null">
                                {{ categoria.Descripcion }}
                                </span>
                                <span v-else>
                                    Sin Puesto
                                </span>
                            </td>
                            <td class="border-r border-b border-black" v-if="DepartamentoAdscripcion!=null">
                                {{ DepartamentoAdscripcion.Nombre }}
                            </td>
                            <td class="border-r border-b border-black text-center pb-1">
                                <span v-if="DiaLunes!=null">
                                    {{ DiaLunes[0].HInicio }}-{{ DiaLunes[0].HFin }}
                                </span>
                            </td>
                            <td class="border-r border-b  border-black text-center pb-1">
                                <span v-if="DiaMartes!=null">
                                    {{ DiaMartes[0].HInicio }}-{{ DiaMartes[0].HFin }}
                                </span>
                            </td>
                            <td class="border-r border-b border-black text-center pb-1">
                                <span v-if="DiaMiercoles!=null">
                                    {{ DiaMiercoles[0].HInicio }}-{{ DiaMiercoles[0].HFin }}
                                </span>
                            </td>
                            <td class="border-r border-b border-black text-center pb-1">
                                <span v-if="DiaJueves!=null">
                                    {{ DiaJueves[0].HInicio }}-{{ DiaJueves[0].HFin }}
                                </span>
                            </td>
                            <td class="border-r border-b border-black text-center pb-1">
                                <span v-if="DiaViernes!=null">
                                    {{ DiaViernes[0].HInicio }}-{{ DiaViernes[0].HFin }}
                                </span>
                            </td>
                            <td class="border-r border-b border-black text-center pb-1">
                                <span v-if="DiaSabado!=null">
                                    {{ DiaSabado[0].HInicio }}-{{ DiaSabado[0].HFin }}
                                </span>
                            </td>
                            <td class="border-r border-b  border-black"></td>
                        </tr>


                        <tr class="">
                            <td class="border-l  border-r border-b border-collapse border-black py-1"></td>
                            <td class="border-r  border-b border-black"></td>
                            <td class="border-r  border-b border-black"></td>
                            <td class="border-r  border-b  border-black"></td>
                            <td class="border-r  border-b border-black"></td>
                            <td class="border-r  border-b border-black"></td>
                            <td class="border-r  border-b border-black"></td>
                            <td class="border-r  border-b border-black"></td>
                            <td class="border-r  border-b border-black"></td>
                        </tr>


                        <tr class="">
                            <td class="border-l border-r border-b border-collapse border-black py-1"></td>
                            <td class="border-r border-b border-black"></td>
                            <td class="border-r border-b border-black"></td>
                            <td class="border-r border-b  border-black"></td>
                            <td class="border-r border-b border-black"></td>
                            <td class="border-r border-b border-black"></td>
                            <td class="border-r border-b border-black"></td>
                            <td class="border-r border-b border-black"></td>
                            <td class="border-r border-b  border-black"></td>
                        </tr>

                        <tr class="align-top">
                            <td class="py-1"></td>


                            <td class="text-end border-r border-black">Subtotal</td>
                            <td class="border-r border-b  border-black pb-2 text-center">
                                <strong>
                                    {{ HorasTotalesLunes }}
                                </strong>
                                <strong v-if="minutosTotalesLunes!=0">
                                    .{{ minutosTotalesLunes }}
                                </strong>
                            </td>
                            <td class="border-r border-b  border-black text-center">
                                <strong>
                                    {{ HorasTotalesMartes}}
                                </strong>
                                <strong v-if="minutosTotalesMartes!=0">
                                    .{{ minutosTotalesMartes }}
                                </strong>
                            </td>
                            <td class="border-r border-b  border-black text-center ">
                                <strong>
                                    {{ HorasTotalesMiercoles}}
                                </strong>
                                <strong v-if="minutosTotalesMiercoles!=0">
                                    .{{ minutosTotalesMiercoles }}
                                </strong>
                            </td>
                            <td class="border-r border-b  border-black text-center ">
                                <strong>
                                    {{ HorasTotalesJueves}}
                                </strong>
                                <strong v-if="minutosTotalesJueves!=0">
                                    .{{ minutosTotalesJueves }}
                                </strong>
                            </td>
                            <td class="border-r border-b  border-black text-center">
                                <strong>
                                    {{ HorasTotalesViernes}}
                                </strong>
                                <strong v-if="minutosTotalesViernes!=0">
                                    .{{ minutosTotalesViernes }}
                                </strong>
                            </td>
                            <td class="border-r border-b  border-black text-center ">
                                <strong>
                                    {{ HorasTotalesSabado}}
                                </strong>
                                <strong v-if="minutosTotalesSabado!=0">
                                    .{{ minutosTotalesSabado }}
                                </strong>
                            </td>
                            <td class="border-r border-b  border-black text-center pb-1">
                                <strong>
                                    {{ HorasSemana }}
                                </strong>
                                <strong v-if="MinutosSemana!=0">
                                    .{{ MinutosSemana  }}
                                </strong>
                            </td>
                        </tr>


                        <tr class="align-top">
                            <td class="py-1"></td>

                            <td class="text-end border-r border-black">Total</td>
                            <td class="border-r border-b border-black text-center pb-1">8</td>
                            <td class="border-r border-b border-black text-center">8</td>
                            <td class="border-r border-b border-black text-center">8</td>
                            <td class="border-r border-b border-black text-center">8</td>
                            <td class="border-r border-b border-black text-center">8</td>
                            <td class="border-r border-b border-black text-center">0</td>
                            <td class="border-r border-b border-black text-center">40</td>

                        </tr>

                    </table>
                </div>

                <div class="w-full pl-10 uppercase text-xxs mb-1">
                    <p v-if="VigenciaInicio!=null" class="inline-flex">INICIO DE VIGENCIA:<strong>{{ VigenciaInicio }}</strong></p>
                    <p v-if="VigenciaInicio==null" class="inline-flex">INICIO DE VIGENCIA:<strong>Sin vigencia</strong></p>
                    <br>
                    <p v-if="VigenciaFin!=null" class="inline-flex">FIN DE VIGENCIA:<strong>{{ VigenciaFin }}</strong></p>
                    <p v-if="VigenciaFin==null" class="inline-flex">FIN DE VIGENCIA:<strong>Sin vigencia</strong></p>
                </div>

                <div class="w-10/12 ml-24 mt-5 text-xxs uppercase">
                    <div class="flex justify-between space-x-24">
                        <div class="w-1/3 text-center uppercase">
                            <div class="border-b-2 border-gray-500 mb-2"></div>
                            <strong class="text-xxs">{{personal.Titulo}}. {{ personal.Nombre }} {{personal.ApellidoP}} {{ personal.ApellidoM }}</strong><br>
                            <strong class="text-xxs">Trabajador</strong>
                        </div>

                        <div class="w-1/3 text-center">
                            <div class="border-b-2 border-gray-500 mb-2"></div>
                            <strong class="text-xxs" v-if="EncargadoDepAdscripcion!=null">
                                {{EncargadoDepAdscripcion.Titulo}}. {{EncargadoDepAdscripcion.Nombre }}
                                {{EncargadoDepAdscripcion.ApellidoP}} {{ EncargadoDepAdscripcion.ApellidoM }}
                            </strong>
                            <strong v-else>Sin encargado</strong>

                            <p class="text-xxs">{{ DepartamentoAdscripcion.Nombre }}</p>
                        </div>

                        <div class="w-1/3 text-center">
                            <div class="border-b-2 border-gray-500 mb-2 text-xss"></div>
                            <strong class="text-xxs">DR. ARTURO ERNESTO MARES GARDEA</strong>
                            <p class="text-xxs">Director</p>
                        </div>
                    </div>
                </div>


                <div class="w-full inline-flex align-top">

                    <div class="text-start pl-6 text-xxs pr-64 pb-2">
                        Original.- Trabajador, DRH<br>
                        C.c.p.- DPPyP, Archivo<br>
                        CENIDET-AC-PO-004-06
                    </div>

                    <div class="pr-28"></div>

                    <div class="pl-64 text-xxs">
                        <strong>Sello-DIR</strong>
                    </div>

                    <div class="pl-32 text-xxs align-bottom ">
                        <br>
                        <strong>Rev.O</strong>
                    </div>
                </div>
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
            personal:Array,
            periodo:Array,
            categoria:Array,
            plaza:Array,
            DepartamentoAdscripcion:Array,
            EncargadoDepAdscripcion:Array,
            DiaLunes:Array,
            DiaMartes:Array,
            DiaMiercoles:Array,
            DiaJueves:Array,
            DiaViernes:Array,
            DiaSabado:Array,

            HorasTotalesLunes:0,
            minutosTotalesLunes:0,
            HorasTotalesMartes:0,
            minutosTotalesMartes:0,
            HorasTotalesMiercoles:0,
            minutosTotalesMiercoles:0,
            HorasTotalesJueves:0,
            minutosTotalesJueves:0,
            HorasTotalesViernes:0,
            minutosTotalesViernes:0,
            HorasTotalesSabado:0,
            minutosTotalesSabado:0,
            VigenciaInicio:0,
            VigenciaFin:0,
            HorasSemana:0,
            MinutosSemana:0,
        },

        data() {
            return {
                NombreArchivo:'',
            }
        },

        async mounted() {
            this.NombreArchivo='Horario_'+this.$page.props.personal.RFC;
            await this.generarPDF();
            window.close();
        },

        methods:{
            async generarPDF() {
                var element=document.getElementById('pdfContent');//obtener elemento
                const pdfOptions = {
                margin: 0,
                filename: this.NombreArchivo,
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'landscape' },//Hoja horizontal
                };

                const pdf=new html2pdf().from(element).set(pdfOptions).outputPdf();
                console.log(pdf)
                await pdf.save();
            },
        }
    }
</script>
