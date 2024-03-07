<template>
    <Head title="Reportes" />
    <AuthenticatedLayout>
    <template #header>
            Generar reportes
    </template>

    <!--Tarjetas para seleccionar reporte-->
    <div class="flex space-x-4 w-full mt-7">
        <!--Tarjeta para seleccionar reporte de rotacion-->
        <div class="max-w-md bg-white rounded-md overflow-hidden shadow-md dark:bg-slate-700 hover:border-blue-600 hover:border-2"
        @click="showElementRotacion">
            <img class="w-full h-56 object-cover object-center" src="https://img.freepik.com/vector-premium/icono-rotacion-personal-aislado-blanco_116137-5641.jpg?w=2000" alt="Imagen de la tarjeta">
            <div class="p-4 dark:bg-slate-700 ">
                <h2 class="text-xl font-bold mb-2 dark:text-white ">Reporte de rotación de personal</h2>
                <p class="text-gray-700 dark:text-white ">Descripción: Este reporte brinda información sobre el número de contrataciones y bajas del personal en determinados periodos de tiempo</p>
                <div class="mt-4 "></div>
            </div>
        </div>

        <!--Tarjeta para seleccionar reporte de antiguedad-->
        <div class="max-w-md bg-white rounded-md overflow-hidden shadow-md dark:bg-slate-700 hover:border-blue-600 hover:border-2"
        @click="showElementAntiguedad">
            <img class="w-full h-56 object-cover object-center" src="https://www.creativefabrica.com/wp-content/uploads/2021/06/15/Leader-Icon-Graphics-13435401-1-580x376.jpg" alt="Imagen de la tarjeta">
            <div class="p-4 dark:bg-slate-700 ">
                <h2 class="text-xl font-bold mb-2 dark:text-white ">Reporte de antigüedad</h2>
                <p class="text-gray-700 dark:text-white ">Descripción: Este reporte presenta información del personal más antiguo.</p>
                <div class="mt-4 "></div>
            </div>
        </div>
    </div>
    <!-- Capa oscura -->
    <div :class="{ hidden: !isVisibleRotacion }" class="fixed inset-0 bg-black opacity-50">
    </div>

    <!--Modal para definir parametros oara reporte de rotacion-->
    <div id="modalContainer">
        <!-- Main modal -->
        <div :class="{ hidden: !isVisibleRotacion }">
            <div id="defaultModal" tabindex="-1" aria-hidden="true"  class="fixed inset-0 flex items-center justify-center z-50">
                <div class="relative w-full max-w-2xl max-h-screen overflow-auto">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
                        <!-- Modal header -->
                        <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                Instrucciones para generar reporte de rotacion
                            </h3>
                            <button type="button" @click="hideElementRotacion" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="p-6 space-y-6">
                            <form @submit.prevent="GenerarReporteRotacion"  class="w-full ">
                                <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold " for="grid-last-name">
                                    Por favor define un periodo de tiempo para generar el reporte
                                </label>
                                <br>
                                <div class="inline -mx-3 mb-1 overflow-auto ">
                                    <label class=" ml-3 inline uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-last-name">
                                        Fecha inicio:
                                    </label>
                                    <input id="NombreAula" v-model="NuevoReporteRotacion.FechaInicio" class="ml-2 appearance-none inline w-1/2 bg-gray-200 dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                    type="date" placeholder="" required>
                                    <br>

                                    <label class=" inline uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-last-name">
                                        Fecha final:
                                    </label>
                                    <input id="NombreAula" v-model="NuevoReporteRotacion.FechaFin" class="ml-3 appearance-none inline w-1/2 bg-gray-200 dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                    type="date" placeholder="" required>
                                </div>

                                <div
                                    class="text-red-400 text-xs" v-if="msjHoraInvalida">
                                    La fecha de inicio tiene que ser menor a la final
                                </div>
                                <!-- Modal footer -->
                                <div class="flex mt-2 items-center px-1 py-2 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                                    <button type="submit" class="text-white bg-[#014E82] hover:bg-[#0284c7] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        Generar reporte
                                    </button>
                                    <button @click="hideElementRotacion" data-modal-hide="defaultModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                        Cancelar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Capa oscura -->
    <div :class="{ hidden: !isVisibleAntiguedad }" class="fixed inset-0 bg-black opacity-50">
    </div>

    <!--Modal para definir parametros oara reporte de antiguedad-->
    <div id="modalContainer">
        <!-- Main modal -->
        <div :class="{ hidden: !isVisibleAntiguedad }">
            <div id="defaultModal" tabindex="-1" aria-hidden="true"  class="fixed inset-0 flex items-center justify-center z-50">
                <div class="relative w-full max-w-2xl max-h-screen overflow-auto">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
                        <!-- Modal header -->
                        <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                Opciones para generar reporte de antigüedad
                            </h3>
                            <button type="button" @click="hideElementAntiguedad" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="p-6 space-y-6">
                            <form @submit.prevent="GenerarReporteAntiguedad"  class="w-full mb-3">
                                <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold ml-1 mb-3 " for="grid-last-name">
                                    Por favor define tus rangos para generar el reporte de antigüedad por ejemplo <br>
                                    <p class="pt-2 italic">1. Personal Antiguo + 10 años</p>
                                </label>

                                <div class="inline-flex mb-1 overflow-auto w-full ml-1 mt-2 dark:text-gray-200 text-xs font-bold  ">
                                    <div class="w-full inline-flex">
                                        <div class="w-1/2">
                                            Nombre del rango
                                        </div>
                                        <div class="w-2/5">
                                            Cant.años
                                        </div>
                                    </div>
                                </div>

                                <div class="inline-flex mb-1 overflow-auto w-full  mt-2 dark:text-gray-200 text-xs font-bold  "
                                v-for="(Rango,index) in RangosAntiguedad">
                                    <div class="w-full inline-flex">
                                        <div class="w-2/3">

                                            <input id="NombreAula" v-model="Rango.NombreRango" class=" appearance-none inline w-5/6
                                            bg-gray-200 dark:bg-slate-600 text-gray-700
                                            dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded
                                            py-3 px-4  leading-tight focus:outline-none focus:bg-white"
                                            type="text" placeholder="" required>

                                        </div>

                                        <select v-model="Rango.Operador" class=" appearance-none inline w-4/12
                                            bg-gray-200 dark:bg-slate-600 text-gray-700
                                            dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded
                                            py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white">

                                            <option value="Mas">mas</option>
                                            <option value="Menos">menos</option>
                                        </select>


                                        <div class="w-3/5">
                                            <input id="NombreAula" v-model="Rango.Años" class="ml-2 appearance-none inline w-2/3
                                            bg-gray-200 dark:bg-slate-600 text-gray-700
                                            dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded
                                            py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                            type="number" placeholder="" required>

                                            <span class="pb-4 text-sm">
                                            año(s)
                                            </span>

                                        </div>



                                        <div class="w-2/5 inline-flex space-x-5">

                                            <div class=" rounded-xl h-1/2 mt-2 bg-gray-200 dark:bg-slate-500 px-2 py-0" @click="AgregarRango">
                                                <i class="fa-solid fa-plus mt-2"></i>
                                            </div>


                                            <div v-if="index!=0" class=" rounded-xl h-1/2 mt-2 bg-gray-200 dark:bg-slate-500 px-2 py-0" @click="QuitarRango(index)">
                                                <i class="fa-solid fa-minus mt-2"></i>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!-- Modal footer -->
                                <div class="flex mt-2 items-center px-1 py-2 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                                    <button type="submit" class="text-white bg-[#014E82] hover:bg-[#0284c7] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        Generar reporte
                                    </button>
                                    <button @click="hideElementAntiguedad" data-modal-hide="defaultModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                        Cancelar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </AuthenticatedLayout>
</template>


<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/vue3';
    import { Link } from '@inertiajs/vue3'
</script>

<script>

export default {
    components:{
        Link
    },
    mounted() {
        this.FiltroBusqueda=this.$page.props.Filtro;
    },
    data() {
        return {
            urlPaginacion:'',
            isVisibleRotacion: false,
            isVisibleAntiguedad:false,
            NuevoReporteRotacion:{
                FechaInicio:'',
                FechaFin:''
            },
            msjHoraInvalida:false,
            Activar:[],
            RangosAntiguedad:[
                { NombreRango: '', Años:0 ,Operador:'Mas'  },
            ],
        }
    },

    methods: {
        async GenerarReporteRotacion(){

            var dateInicio = new Date(this.NuevoReporteRotacion.FechaInicio);
            var dateFin = new Date(this.NuevoReporteRotacion.FechaFin);

            // Comparar las fechas
            if (dateInicio > dateFin) {
                //alert('La fecha de inicio es mayor que la fecha de fin');
                // Retornar true si la fecha de inicio es mayor
                this.msjHoraInvalida=true;

            } else {
                //alert('La fecha de inicio no es mayor que la fecha de fin');
                // Retornar false si la fecha de inicio no es mayor
                this.msjHoraInvalida=false;
                await this.$inertia.post(route('Personal.Rotacion'),this.NuevoReporteRotacion)
            }
        },

        async GenerarReporteAntiguedad(){
            await this.$inertia.post(route('Personal.Antiguedad'),this.RangosAntiguedad)
        },

        showElementRotacion() {
            this.isVisibleRotacion = true;
        },

        hideElementRotacion() {
            this.isVisibleRotacion = false;
        },

        showElementAntiguedad() {
            this.isVisibleAntiguedad = true;
        },

        hideElementAntiguedad() {
            this.isVisibleAntiguedad = false;
        },

        AgregarRango(){
            const nuevoRango = {
                NombreRango: '',
                Años: 0,
                Operador:'Mas'
            };
            this.RangosAntiguedad.push(nuevoRango);
        },

        QuitarRango(indice){
            this.RangosAntiguedad.splice(indice,1);
        },
    }
};
</script>








