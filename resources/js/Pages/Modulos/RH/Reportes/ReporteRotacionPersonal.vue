<template>

<div class="overflow-hidden w-full max-h-screen">
    
    <!--Imagen de carga al descargar PDF-->
    <div class='flex items-center justify-center min-h-screen
    overflow-hidden'>
        <div style="border-top-color:transparent"
        class="w-8 h-8 border-4 border-[#014E82]
        rounded-full animate-spin overflow-hidden"></div>
        <p class="ml-2">GENERANDO REPORTE...</p>
    </div>

    <!--Cantenido del reporte-->
    <div class="overflow-hidden ">
        <div id="pdfContent" class="w-full h-auto overflow-y-hidden">
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

            <!--------------------Seccion de Contrataciones----------------------------------------------------------------------------------------->
            <div class="w-full inline-flex align-top  text-xl  mt-5 ">
                <span>
                    <strong class=" ml-10 ">Contrataciones </strong>  realizadas entre las fechas {{ FechaInicio }} y {{ FechaFin }}
                </span>
            </div>
            <!-- Renderiza la gráfica en un elemento HTML -->
            <div class="w-full inline-flex align-top">

                <div class="w-1/3 align-top mr-3  flex justify-center items-center ml-28">
                    <div class="text-start align-top ">
                        <div class=" text-start text-xs">
                            <canvas id="myChart" class="w-52 max-h-50 mt-4 mr-32 ">
                            </canvas>
                            <p class="pl-7 italic" >Contrataciones entre el periodo<br> de {{ FechaInicio }} y {{ FechaFin }} </p>
                        </div>
                    </div>
                </div>

                <div class="w-2/5 text-sm ">
                    <br><br>
                    <strong>Informacion general</strong><br><br>

                    <div class="inline-flex mb-5 mt-2 w-full items-center text-xs ">
                        <div class="p-2 m-1 bg-[#41B883]"> </div>
                        <div class="pb-1">
                            <span>Porcentaje de hombres contratados:{{ porcentajeHombres }}%</span>
                        </div>
                            <span class="ml-5">Total de hombres:{{ totalHombres }}</span>
                        <br><br>
                    </div>

                    <div class="inline-flex mb-10 w-full items-center text-xs">
                        <div class="p-2 m-1 bg-[#E46651]"></div>
                        <div class="pb-1">
                            <span>Porcentaje de mujeres contratadas:{{ porcentajeMujeres }}%</span>
                        </div>
                        <span class="ml-5">Total de mujeres:{{ totalMujeres }}</span>
                        <br><br>
                    </div>
                </div>
            </div>
            <br><br>
            <!--------------------Seccion de bajas----------------------------------------------------------------------------------------->
            <div class="w-full inline-flex  text-xl mt-1">
                <span>
                    <strong class=" ml-12 ">Bajas </strong>  realizadas entre las fechas {{ FechaInicio }} y {{ FechaFin }}
                </span>
            </div>
            <!-- Renderiza la gráfica en un elemento HTML -->
            <div class="w-full inline-flex align-top">

                <div class="w-1/3 flex justify-center items-center mr-3  ml-28  ">
                    <div class="text-start align-top ">
                        <div class=" text-start text-xs">
                            <canvas id="myChart2" class="w-64   mt-4 mr-28 ">
                            </canvas>

                        </div>
                    </div>
                </div>
                <div class="w-2/5 text-sm h-auto">
                    <br><br>
                    <strong>Informacion general</strong><br><br>
                    <div class="inline-flex mb-3 mt-2 w-full h-auto items-center text-xs " v-for="(porcentaje,index) in porcentajesBajas">
                        <div class="p-2 m-1" :style="{ backgroundColor: ListaColores[index] }" >

                        </div>
                        <div class="pb-4">
                            <span>Porcentaje de bajas por {{ ListaNombreEstatus[index] }}: {{porcentaje}} %</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</template>


<script>
    import html2pdf from "html2pdf.js";


    import { Chart, ArcElement, Tooltip, Legend } from 'chart.js/auto';
    //Chart.register(PieElement, Tooltip, Legend);
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
            RegitrosContrataciones:Array,
            RegistrosBajas:0,
            ListaEstatusEmpleado:Array,
            FechaInicio:'',
            FechaFin:'',
            totalHombres:0,
            totalMujeres:0,
            porcentajeHombres:0,
            porcentajeMujeres:0,
            ListaNombreEstatus:Array,
            porcentajesBajas:Array
        },
        async mounted() {
            this.nombreArchivo="RotacionPersonal_"+this.$page.props.FechaInicio+"_"+this.$page.props.FechaFin;
            await this.renderChart();
            setTimeout(() => {
                this.generarPDF();
            }, 900); // Adjust the delay as needed
        },
        methods:{

            async renderChart() {
                //---------------------------Grafica contrataciones--------------------------------------------------------
                    const ctx = document.getElementById("myChart").getContext("2d");
                    const data={

                        labels: ['Hombres', 'Mujeres'],
                        datasets: [
                            {
                            backgroundColor: ['#41B883', '#E46651'],
                            data: [this.$page.props.totalHombres, this.$page.props.totalMujeres]
                            }
                        ]
                    }

                    await new Chart(
                    ctx, {
                        type: "pie",
                        data: data,
                    });

                //--------------------------------Grafica bajas-----------------------------------------------------------
                    const ctx2 = document.getElementById("myChart2").getContext("2d");
                    const data2={

                        labels:this.$page.props.ListaNombreEstatus,
                        datasets: [
                            {
                            backgroundColor: this.ListaColores,
                            data: this.$page.props.porcentajesBajas
                            }
                        ]
                    }
                    await new Chart(
                    ctx2, {
                        type: "pie",
                        data: data2,
                    });
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
