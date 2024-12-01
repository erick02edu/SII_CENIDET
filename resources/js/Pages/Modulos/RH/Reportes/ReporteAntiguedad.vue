<template>
    <!--Imagen de carga al descargar PDF-->
    <div class='flex items-center justify-center min-h-screen'>
        <div style="border-top-color:transparent" class="w-8 h-8 border-4 border-[#014E82] rounded-full animate-spin"></div>
        <p class="ml-2">GENERANDO REPORTE...</p>
    </div>
    <!--Seccion con el reporte de antiguedad-->
    <div v-show="true">
        <div id="pdfContent" class="w-full h-auto overflow-y-auto">
            <!--Encabezado con logos-->
            <div class="w-full h-14 inline-flex align-top mb-3">
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
            <div v-for="(Rango,index) in InformacionRango">
                <div class="w-full inline-flex align-top  text-xl  mt-5 ">
                    <span>
                        <strong class=" ml-10 ">Información del rango antiguedad: </strong>{{Rango.NombreRango}}
                    </span>
                </div>
                <!-- Renderiza la gráfica en un elemento HTML -->
                <div class="w-full inline-flex align-top">

                    <div class="w-1/3 align-top mr-3  flex justify-center items-center ml-28">
                        <div class="text-start align-top ">
                            <div class=" text-start text-xs">
                                <canvas v-bind:id="`myChart${index}`"  class="w-52 max-h-50 mt-4 mr-32 ">
                                </canvas>
                                <p class="pl-7 italic" >Porcentaje de personal con antiguedad {{ Rango.NombreRango }}<br> respecto al personal total</p>
                            </div>
                        </div>
                    </div>

                    <div class="w-2/5 text-sm ">
                        <br><br>
                        <strong>Información general</strong><br><br>

                        <p class="text-xs">Personal {{ Rango.NombreRango }}:
                            Personal con
                            <span v-if="Rango.Operador=='Mas'">
                                más
                            </span>

                            <span v-if="Rango.Operador=='Menos'">
                                menos
                            </span>
                            de {{ Rango.Años }} años
                        </p>

                        <div class="inline-flex mb-5 mt-2 w-full items-center text-xs ">
                            <div class="p-2 m-1 bg-[#014E82]"></div>
                            <div class="pb-1">
                                <span>Porcentaje de personal {{ Rango.NombreRango }}:{{ Rango.PorcentajeEmpleados }}%</span>
                            </div>

                            <div class="pb-1 ml-4">
                                <span>Número de personas con esta antigüedad: {{ Rango.NumPersonas }}</span>
                            </div>
                        </div>
                    </div>

                </div>

                <div v-if="HacerEspaciado(index+1)">
                    <!--Encabezado con logos-->
                    <div class="w-full h-14 inline-flex align-top mb-3 mt-28 ">
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
                </div>
            </div>
            <br><br>
        </div>
    </div>
</template>


<script>
    import html2pdf from "html2pdf.js";
    import { Chart, ArcElement, Tooltip, Legend } from 'chart.js/auto';
    Chart.register(ArcElement, Tooltip, Legend)

    export default {

        data() {
            return {
                ListaColores:[

                "#da70d6", // Orquídea

                "#800080", // Púrpura
                "#4b0082", // Índigo
                "#da6010", // Verde
                "#800000", // Marrón
                "#000080", // Azul oscuro
                "#ff9f00", // Amarillo
                "#ff00ff", // Magenta
                "#008000", // Verde oscuro
                "#808080", // Gris
                "#c0c0c0", // Plata
                "#008080", // Verde azulado
                "#ff4500", // Naranja oscuro
                "#8b4513", // Marrón silla
                "#2e8b57", // Verde marino
                "#9932cc", // Violeta oscuro
                "#8b0000", // Rojo oscuro
                "#228b22", // Verde bosque
                "#dda0dd", // Lavanda
                "#da70d6", // Orquídea
                "#4b0082", // Índigo
                "#ff8c00", // Anaranjado oscuro
                "#00ffff", // Cian
                "#006400", // Verde oscuro
                "#ff0000", // Rojo
                ],

                nombreArchivo:''
            }
        },

        name: "PieChart",
        props:{
            InformacionRango:Array,

        },

        async mounted() {

            if(this.$page.props.InformacionRango.length>1 &&
            this.$page.props.InformacionRango.length<5){
                var tiempoRenderizar=400*this.$page.props.InformacionRango.length
            }
            else{
                var tiempoRenderizar=200*this.$page.props.InformacionRango.length
            }
            this.nombreArchivo="ReporteAntiguedad";
            await this.renderChart();
            setTimeout(() => {
                this.generarPDF();
            }, tiempoRenderizar); // Adjust the delay as needed
        },

        methods:{
            HacerEspaciado(index){
                return index % 3 === 0;
            },

            async renderChart() {
                for(let i=0; i<this.$page.props.InformacionRango.length;i++){
                    var idElement='myChart'+i;
                    var nombreRango='Personal '+this.$page.props.InformacionRango[i].NombreRango

                    const ctx = document.getElementById(idElement).getContext("2d");
                    const data={
                        labels: [nombreRango, 'Total del Personal'],
                        datasets: [
                            {
                                backgroundColor: ['#014E82', '#E2E8F0'],
                                data: [
                                    this.$page.props.InformacionRango[i].PorcentajeEmpleados,
                                    this.$page.props.InformacionRango[i].PorcentajeRestante
                                ]
                            }
                        ]
                    }
                    await new Chart(
                    ctx, {
                        type: "pie",
                        data: data,
                    });
                }
            },

            async generarPDF() {
                const element = document.getElementById("pdfContent");
                const pdfOptions = {
                margin: 5,
                filename: this.nombreArchivo,
                image: { type: "jpeg", quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: "mm", format: "a4", orientation: "portrait" },
                };

                const pdf = new html2pdf().from(element).set(pdfOptions);
                pdf.save();
                window.history.back();
            },

        }

    }
</script>
