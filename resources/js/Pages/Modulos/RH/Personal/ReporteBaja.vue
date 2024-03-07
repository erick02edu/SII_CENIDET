<template>
    <!--Imagen de carga al descargar PDF-->
    <div class='flex items-center justify-center min-h-screen'>
        <div style="border-top-color:transparent" class="w-8 h-8 border-4 border-[#014E82] rounded-full animate-spin"></div>
        <p class="ml-2">GENERANDO REPORTE DE BAJA...</p>
    </div>
    <!--Seccion con el reporte de antiguedad-->
    <div v-show="false">
        <div id="pdfContent" class="w-full h-auto overflow-y-auto">
            <!--Encabezado con logos-->
            <div class="w-full h-14 inline-flex align-top mb-7">
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

            <!--Contenido-->
            <div>

                <strong class="ml-10 text-xl uppercase">
                        REPORTE DE BAJA DE PERSONAL
                </strong>

                <div class="w-full inline-flex align-top mt-3 mb-2">
                    <span>
                        <strong class="ml-10 text-lg">Informacion del personal dado de baja </strong>
                        <div class="w-full px-10 my-2">
                                <strong>Nombre completo:</strong>{{personal.Nombre}} {{ personal.ApellidoM }} {{ personal.ApellidoP }}
                        </div>

                        <span class="w-1/2 px-10 my-2 space-x-5 ">
                                <strong>RFC:</strong> {{ personal.RFC }}
                                <strong>CURP:</strong> {{ personal.CURP }}
                        </span>
                    </span>
                </div>

                <!--Informacion de la plaza-->
                <div class="px-10 w-full inline-flex mb-2">
                    <div class="w-1/2">

                        <strong>
                            Puesto
                        </strong>
                        <span v-if="categoria==null">Sin Puesto </span>
                        <span v-else>{{categoria.Clave}}-{{ categoria.Descripcion }} </span>
                    </div>

                    <div class="w-1/4">
                        <strong>
                            Horas a la semana:
                        </strong>
                        <span v-if="categoria==null">0</span>
                        <span v-else>{{categoria.Horas}}</span>
                    </div>

                    <div class="w-1/4">
                        <strong>
                            Fecha de ingreso:
                        </strong>
                        <span>{{ personal.FechaRegistro }}</span>
                    </div>
                </div>

                <!-- Informacion de la baja-->
                <div class="w-full inline-flex align-top ml-10">

                    <div class="w-1/2">
                                <strong>
                                    Fecha de baja:
                                </strong>
                                <span>{{ FechaBaja }}</span>
                    </div>

                    <strong>Razon de la baja: </strong>  {{ RazonBaja }}

                </div>
            </div>

            <!--Seccion de firmas-->
            <div class="w-10/12 ml-24 text-xxs uppercase mt-40 ">
                <div class="flex justify-between space-x-24">

                    <div class="w-1/3 text-center uppercase">
                        <div class="border-b-2 border-gray-500 mb-2"></div>
                        <div class=" px-10">
                                <span v-if="JefeDepartamento==null">Sin Jefe de departamento</span>
                                <span v-else>{{JefeDepartamento.Titulo }}. {{ JefeDepartamento.Nombre }} {{ JefeDepartamento.ApellidoP }} {{ JefeDepartamento.ApellidoM  }}</span>
                                <p>Jefe del departamento {{ Departamento }}</p>
                        </div>
                    </div>

                    <div class="w-1/3 text-center uppercase" v-if="RazonBaja!='Baja por defuncion'">
                        <div class="border-b-2 border-gray-500 mb-2"></div>
                        <div class=" px-10">
                            <span>{{personal.Titulo }}. {{ personal.Nombre }} {{ personal.ApellidoP }} {{ personal.ApellidoM  }}</span>
                            <p>Personal</p>
                        </div>
                    </div>
                </div>
            </div>

            <br><br>
        </div>
    </div>
</template>


<script>
    import html2pdf from "html2pdf.js";

    export default {

        props:{
            personal:Array,
            RazonBaja:Array,
            categoria:Array,
            FechaBaja:String,
            Departamento:String,
            JefeDepartamento:Array,
        },

        data() {
            return {
                NombreArchivo:'',
            }
        },

        async mounted() {
            this.NombreArchivo='ReporteBaja_'+this.$page.props.personal.RFC;
            await this.generarPDF();
            this.$inertia.get(route('Personal.index'));
        },

        methods:{
            async generarPDF() {
                var element=document.getElementById('pdfContent');//obtener elemento
                const pdfOptions = {
                    margin: 2,
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

