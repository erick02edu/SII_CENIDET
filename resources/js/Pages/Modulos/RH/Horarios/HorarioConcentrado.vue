<template>
    <Head title="Horario Concentrado PDF" />
    <!--Imagen de carga al descargar PDF-->
    <div class='flex items-center justify-center min-h-screen'>
        <div style="border-top-color:transparent" class="w-8 h-8 border-4 border-[#014E82] rounded-full animate-spin"></div>
        <p class="ml-2">GENERANDO PDF ...</p>
    </div>
    <!--Seccion con los horarios de los docentes-->
    <div v-show="true">
    <div id="pdfContent" >
    <div v-for="(horario,index) in ListaHorarios" :key="index" class="overflow:hidden page-break-before:always" >
        <div class="w-full h-full overflow-y-scroll pl-2">
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

                <table class="w-full mr-2 uppercase align-top border-collapse">
                    <tr class="align-top">
                        <td class="border-t border-l border-black pb-1 border-collapse">Institucion:<strong class="pl-2">CENTRO NACIONAL DE INVESTIGACION Y DESARROLLO TECNOLOGICO</strong></td>
                        <td class="border-t border-l border-black border-collapse">C.C.T</td>
                        <td class="border-t border-l border-black border-collapse"> <strong>17IIT0001W</strong> </td>
                        <td class="border-t border-l border-black border-collapse">PERIODO ESCOLAR:</td>
                        <!--SE QUEDA IGUAL EL PERIODO-->
                        <td class="border-t border-l border-black border-collapse"> <strong>{{ periodo.mesInicio }} {{ periodo.AñoInicio }}-{{ periodo.mesTermino }} {{ periodo.AñoTermino }}</strong></td>
                        <td class="border-t border-l border-black border-collapse">RFC:</td>
                        <td class="border-t border-l border-r border-black border-collapse w-24"><strong>{{Listapersonal[index].RFC}}</strong></td>
                    </tr>


                    <tr class=" align-top ">
                        <td colspan="3" class="border-t border-l border-black pb-1 border-collapse">NOMBRE COMPLETO:<strong class="pl-10">{{ Listapersonal[index].Nombre }} {{ Listapersonal[index].ApellidoP }} {{ Listapersonal[index].ApellidoM }}</strong></td>
                        <td colspan="4" class="border-t border-l border-r border-black border-collapse">
                            CLAVE COMPLETO DE LA(S) PLAZA(S):
                        </td>
                    </tr>

                    <tr class=" align-top">
                        <td class="border-t border-l border-black pb-1 border-collapse">Escolaridad</td>
                        <td class="border-t border-l border-black border-collapse">PASANTE</td>
                        <td class="border-t border-l border-black border-collapse">TITULADO</td>
                        <td class="border-t border-l border-r border-black border-collapse" colspan="4">
                            <strong v-if="Listacategoria[index]!=null">{{ Listacategoria[index].Clave }}</strong>
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
                            <strong v-if="Listapersonal[index].NivEst1=='Maestria'">
                                {{ Listapersonal[index].Estudio1}}
                            </strong>
                            <strong v-if="Listapersonal[index].NivEst2=='Maestria'">
                                {{ Listapersonal[index].Estudio2}}
                            </strong>
                            <strong v-if="Listapersonal[index].NivEst3=='Maestria'">
                                {{ Listapersonal[index].Estudio3}}
                            </strong>
                        </td>
                        <td class="border-t border-l border-black border-collapse"></td>
                        <td class="border-t border-l border-black border-collapse text-center"></td>
                        <td class="border-t border-l border-b border-black border-collapse align-top" colspan="2" rowspan="2">
                            <strong>Tipo de nombramiento<br>
                            </strong>
                            <p class="text-center" v-if="Listaplaza[index]!=null">
                                    {{ Listaplaza[index].TipoMovimiento }}
                                </p>
                                <p v-else>
                                    Sin nombramiento
                                </p>
                        </td>
                        <td class="border border-black border-collapse align-top" colspan="2" rowspan="2"><strong>Fecha de ingreso a la S.E.P:<br>
                            <p class="text-center">{{ Listapersonal[index].IngAñoSEP }}/{{ Listapersonal[index].IngQuinSEP }}</p></strong>
                        </td>

                    </tr>

                    <tr class="align-top">
                        <td class="border-t border-l border-black pb-1 border-collapse">
                            Doctorado:
                            <strong v-if="Listapersonal[index].NivEst1=='Doctorado'">
                                {{ Listapersonal[index].Estudio1}}
                            </strong>
                            <strong v-if="Listapersonal[index].NivEst2=='Doctorado'">
                                {{ Listapersonal[index].Estudio2}}
                            </strong>
                            <strong v-if="Listapersonal[index].NivEst3=='Doctorado'">
                                {{ Listapersonal[index].Estudio3}}
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
                                <p class="text-center">{{ Listapersonal[index].numEmpleado }}</p>
                            </strong></td>
                        <td class="border-b border-l border-r border-black align-top" colspan="2" rowspan="2"><strong>Fecha de ingreso a la S.N.E.S.T:<br>
                        <p class="text-center">{{ Listapersonal[index].IngAñoSNEST }}/{{ Listapersonal[index].IngQuinSNEST }}</p></strong></td>

                    </tr>

                    <tr class="">
                        <td class="border-t border-l border-b border-black pb-1 border-collapse"> UNIDAD ORGÁNICA DE ADSCRIPCION:
                            <strong v-if="ListaDepartamentoAdscripcion[index]!=null">{{ ListaDepartamentoAdscripcion[index].Nombre }}</strong>
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

                    <tr class="bg-neutral-300 text-center">
                        <td class="border-r border-l border-t border-collapse border-black pb-1" rowspan="1">Asignatura</td>
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
                        <td class="border-b border-r border-l border-collapse border-black px-20 "></td>
                        <td class="border-b border-r border-collapse border-black px-8 py-0"></td>
                        <td class="border-b border-r border-collapse border-black px-4 py-0"></td>
                        <td class="border-b border-r border-collapse border-black px-8 py-0"></td>
                        <td class="border-b border-r border-collapse border-black px-8 py-0"></td>
                        <td class="border-b border-r border-collapse border-black px-8 py-0"></td>
                        <td class="border-b border-r border-collapse border-black px-8 py-0"></td>
                        <td class="border-b border-r border-collapse border-black px-8 py-0"></td>



                        <td class="border-t border-r border-b border-collapse border-black px-8  ">  L </td>
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

                <table class="w-full mr-2 uppercase">

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

            <div class="w-full pl-5 uppercase text-xxs mb-1">
                <strong>III.- ACTIVIDADES EN LA ADMINISTRACIÓN</strong>
            </div>

            <div class="w-full inline-flex text-xxs pl-5 h-1/12 align-top">

                <table class="w-full mr-2 uppercase">

                    <tr class="bg-neutral-300 text-center align-top">
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

                    <tr class="align-top">
                        <td class="border-l border-r border-b border-collapse border-black py-1 pb-1 ">
                            <span v-if="Listacategoria[index]!=null">
                            {{ Listacategoria[index].Descripcion }}
                            </span>
                            <span v-else>
                                Sin Puesto
                            </span>
                        </td>
                        <td class="border-r border-b border-black" v-if="ListaDepartamentoAdscripcion[index]!=null">
                            {{ ListaDepartamentoAdscripcion[index].Nombre }}
                        </td>
                        <td class="border-r border-b border-black text-center pb-1">
                            <span v-if="ListaDiaLunes[index]!=null">
                                {{ ListaDiaLunes[index][0].HInicio }}-{{ ListaDiaLunes[index][0].HFin }}
                            </span>
                        </td>
                        <td class="border-r border-b  border-black text-center pb-1">
                            <span v-if="ListaDiaMartes[index]!=null">
                                {{ ListaDiaMartes[index][0].HInicio }}-{{ ListaDiaMartes[index][0].HFin }}
                            </span>
                        </td>
                        <td class="border-r border-b border-black text-center pb-1">
                            <span v-if="ListaDiaMiercoles[index]!=null">
                                {{ ListaDiaMiercoles[index][0].HInicio }}-{{ ListaDiaMiercoles[index][0].HFin }}
                            </span>
                        </td>
                        <td class="border-r border-b border-black text-center pb-1">
                            <span v-if="ListaDiaJueves[index]!=null">
                                {{ ListaDiaJueves[index][0].HInicio }}-{{ ListaDiaJueves[index][0].HFin }}
                            </span>
                        </td>
                        <td class="border-r border-b border-black text-center pb-1">
                            <span v-if="ListaDiaViernes[index]!=null">
                                {{ ListaDiaViernes[index][0].HInicio }}-{{ ListaDiaViernes[index][0].HFin }}
                            </span>
                        </td>
                        <td class="border-r border-b border-black text-center pb-1">
                            <span v-if="ListaDiaSabado[index]!=null">
                                {{ ListaDiaSabado[index][0].HInicio }}-{{ ListaDiaSabado[index][0].HFin }}
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

                        <td class="border-r border-b pb-2 border-black  text-center">
                            <strong>
                                {{ ListaHorasTotalesLunes[index] }}
                            </strong>
                            <strong v-if="ListaminutosTotalesLunes[index]!=0">
                                .{{ ListaminutosTotalesLunes[index] }}
                            </strong>
                        </td>

                        <td class="border-r border-b  border-black text-center">
                            <strong>
                                {{ ListaHorasTotalesMartes[index]}}
                            </strong>
                            <strong v-if="ListaminutosTotalesMartes[index]!=0">
                                .{{ ListaminutosTotalesMartes[index] }}
                            </strong>
                        </td>

                        <td class="border-r border-b  border-black text-center ">
                            <strong>
                                {{ ListaHorasTotalesMiercoles[index]}}
                            </strong>
                            <strong v-if="ListaminutosTotalesMiercoles[index]!=0">
                                .{{ ListaminutosTotalesMiercoles[index] }}
                            </strong>
                        </td>

                        <td class="border-r border-b  border-black text-center ">
                            <strong>
                                {{ ListaHorasTotalesJueves[index]}}
                            </strong>
                            <strong v-if="ListaminutosTotalesJueves[index]!=0">
                                .{{ ListaminutosTotalesJueves[index] }}
                            </strong>
                        </td>

                        <td class="border-r border-b  border-black text-center">
                            <strong>
                                {{ ListaHorasTotalesViernes[index]}}
                            </strong>
                            <strong v-if="ListaminutosTotalesViernes[index]!=0">
                                .{{ ListaminutosTotalesViernes[index] }}
                            </strong>
                        </td>

                        <td class="border-r border-b  border-black text-center ">
                            <strong>
                                {{ ListaHorasTotalesSabado[index]}}
                            </strong>
                            <strong v-if="ListaminutosTotalesSabado[index]!=0">
                                .{{ ListaminutosTotalesSabado[index] }}
                            </strong>
                        </td>
                        <td class="border-r border-b  border-black text-center pb-1">
                            <strong>
                                {{ ListaHorasSemana[index] }}
                            </strong>
                            <strong v-if="ListaMinutosSemana[index]!=0">
                                .{{ ListaMinutosSemana[index]  }}
                            </strong>
                        </td>
                    </tr>


                    <tr class="align-top">
                        <td class="py-1"></td>

                        <td class="text-end border-r border-black">Total</td>
                        <td class="border-r border-b border-black text-center pb-2">8</td>
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
                <p v-if="ListaInicioVigencia[index]!=null" class="inline-flex">INICIO DE VIGENCIA:<strong>{{ ListaInicioVigencia[0] }}</strong> </p>
                <p v-if="ListaInicioVigencia[index]==null" class="inline-flex">INICIO DE VIGENCIA:<strong>Sin vigencia</strong><br> </p>

                <br>

                <p v-if="ListaFinVigencia[index]!=null" class="inline-flex">FIN DE VIGENCIA:<strong>{{ListaFinVigencia[0]}}</strong> </p>
                <p v-if="ListaFinVigencia[index]==null" class="inline-flex">FIN DE VIGENCIA:<strong>Sin vignecia</strong> </p>
            </div>

            <div class="w-10/12 ml-24 mt-5 text-xxs uppercase">
                <div class="flex justify-between space-x-24">
                    <div class="w-1/3 text-center uppercase">
                        <div class="border-b-2 border-gray-500 mb-2"></div>
                        <strong class="text-xxs">
                            {{Listapersonal[index].Titulo}}. {{ Listapersonal[index].Nombre }} {{Listapersonal[index].ApellidoP}} {{ Listapersonal[index].ApellidoM }}
                        </strong><br>
                        <strong class="text-xxs">Trabajador</strong>
                    </div>

                    <div class="w-1/3 text-center">
                        <div class="border-b-2 border-gray-500 mb-2"></div>
                        <strong class="text-xxs" v-if="ListaEncargadoDepAdscripcion[index]!=null">
                            {{ListaEncargadoDepAdscripcion[index].Titulo}}. {{ListaEncargadoDepAdscripcion[index].Nombre }}
                            {{ListaEncargadoDepAdscripcion[index].ApellidoP}} {{ ListaEncargadoDepAdscripcion[index].ApellidoM }}
                        </strong>
                        <strong v-else>Sin encargado</strong>

                        <p class="text-xxs">{{ ListaDepartamentoAdscripcion[index].Nombre }}</p>
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

            <div class="mb-2" v-if="ListaHorarios.length !== index + 1">

            </div>


        </div>


        </div>

        </div>
    </div>

    </template>


<script>
  import html2pdf from "html2pdf.js";

  export default {

        props:{
            ListaHorarios:Array,
            Listapersonal:Array,
            periodo:Array,
            Listacategoria:Array,
            Listaplaza:Array,
            ListaDepartamentoAdscripcion:Array,
            ListaEncargadoDepAdscripcion:Array,
            ListaDiaLunes:Array,
            ListaDiaMartes:Array,
            ListaDiaMiercoles:Array,
            ListaDiaJueves:Array,
            ListaDiaViernes:Array,
            ListaDiaSabado:Array,

            ListaHorasTotalesLunes:0,
            ListaminutosTotalesLunes:0,
            ListaHorasTotalesMartes:0,
            ListaminutosTotalesMartes:0,
            ListaHorasTotalesMiercoles:0,
            ListaminutosTotalesMiercoles:0,
            ListaHorasTotalesJueves:0,
            ListaminutosTotalesJueves:0,
            ListaHorasTotalesViernes:0,
            ListaminutosTotalesViernes:0,
            ListaHorasTotalesSabado:0,
            ListaminutosTotalesSabado:0,
            ListaHorasSemana:0,
            ListaMinutosSemana:0,
            ListaInicioVigencia:0,
            ListaFinVigencia:0,

            numHorarios:0

        },

        async mounted() {
            await this.generarPDF();
            window.close();
        },

        methods:{

            async generarPDF() {
                var element=document.getElementById('pdfContent');//obtener elemento

                const pdfOptions = {
                margin: 0,
                filename: 'Horario.pdf',
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

<script setup>
    import { Head } from '@inertiajs/vue3';
</script>







