<template>
    <Head title="Promedios" />
    <AuthenticatedLayout>
    <template #header>
            Promedios
    </template>
    <!-- Capa oscura -->
    <div :class="{ hidden: !isVisibleImportacion }" class="fixed inset-0  bg-black opacity-50">
    </div>

    <!--Seccion de busqueda y boton para seleccionar tipo de historial-->
    <div class="inline-flex w-full" >
        <!--Barra de busqueda-->
        <div class="relative text-gray-700 focus-within:text-gray-700  dark:focus-within:text-slate-200">
            <input
            class=" border-gray-100 dark:border-gray-500 bg-white dark:bg-slate-700 dark:text-gray-200 h-10 px-4 pr-20 rounded-lg text-sm focus:outline-none"
                type="text"
                :placeholder="'Buscar por ' + campoBusquedaVer"
                v-model="AlumnoBuscar"
                @keyup="contarTiempo"
            />
        </div>
        <!--Filtro para cambio de campo de busqueda-->
        <div class="relative inline-block text-left pl-3">
            <div>
                <button type="button"  @click="MostrarOpcionesFiltro" class="inline-flex justify-center w-full rounded-md border border-gray-300 dark:border-slate-500 shadow-sm px-4 py-2 bg-white dark:bg-slate-700  text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 focus:outline-none focus:ring focus:[#014E82] active:bg-gray-200" id="dropdown-menu-button" aria-haspopup="true" aria-expanded="true">
                <span class="pr-2"> <i class="fa-solid fa-filter"></i>  </span>{{ campoBusquedaVer }}
                <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M9.293 5.293a1 1 0 011.414 0l5 5a1 1 0 01-1.414 1.414L10 7.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 010 0z" clip-rule="evenodd" />
                </svg>
                </button>
            </div>

            <div v-if="MostrarFiltro" class="origin-top-right absolute right-0 mt-2 w-32 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5" role="menu" aria-orientation="vertical" aria-labelledby="dropdown-menu-button" tabindex="-1">

                <div class="py-1 dark:bg-slate-700 dark:hover:bg-slate-500 " role="menuitem" tabindex="-1" id="dropdown-menu-item-1" href="#">
                <span @click="SeleccionarCampo('Nombre','Nombre')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-slate-500 dark:text-gray-200">Nombre</span>
                </div>

                <div class="py-1 dark:bg-slate-700 dark:hover:bg-slate-500 " role="menuitem" tabindex="-1" id="dropdown-menu-item-2" href="#">
                <span @click="SeleccionarCampo('noControl','No.Control')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-slate-500 dark:text-gray-200">No.Control</span>
                </div>

                <div class="py-1 dark:bg-slate-700 dark:hover:bg-slate-500 " role="menuitem" tabindex="-1" id="dropdown-menu-item-2" href="#">
                <span @click="SeleccionarCampo('curp','CURP')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-slate-500 dark:text-gray-200">Curp</span>
                </div>

            </div>
        </div>

        <!--Boton para abrir modal que permite seleccionar el tipo de historial-->
        <div class="justyfy-end flex w-full">
            <button :type="type" @click="showElement" class=" ml-3 mr-2 rounded-md bg-[#014E82] px-6 py-2.5 mb-4 text-center text-sm text-white hover:bg-[#0284c7] "
            v-if="$page.props.user.roles.includes('Administrador') && NuevoHistorial.AlumnosSeleccionados.length>0">
                Generar historial(s)
            </button>
        </div>

    </div>

    <!-- Capa oscura -->
    <div :class="{ hidden: !isVisible }" class="fixed inset-0 bg-black opacity-50">
    </div>

    <!--Modal para seleccionar tipo de historial-->
    <div id="modalContainer">
        <!-- Main modal -->
        <div :class="{ hidden: !isVisible }">
            <div id="defaultModal" tabindex="-1" aria-hidden="true"  class="fixed inset-0 flex items-center justify-center z-50">
                <div class="relative w-full max-w-2xl max-h-screen overflow-auto">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
                        <!-- Modal header -->
                        <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                Tipo de historial
                            </h3>
                            <button type="button" @click="hideElement" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="p-6 space-y-6">
                            <form @submit.prevent="GenerarHistorial"  class="w-full ">
                                <div class="flex flex-wrap -mx-3 mb-1 overflow-auto">
                                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                        <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-last-name">
                                            Selecciona el tipo de historial
                                        </label>

                                        <div class="my-4">

                                            <div class="my-4">
                                                <label class="inline-flex items-center">
                                                    <input type="radio" name="tipoHistorial" value="General"
                                                    v-model="NuevoHistorial.tipoHistorial" class="form-radio text-blue-500 focus:border-blue-500 focus:ring focus:ring-blue-200">
                                                    <span class="ml-2 dark:text-white text-xs">Historial general</span>
                                                </label>
                                                </div>

                                                <div class="my-4">
                                                <label class="inline-flex items-center">
                                                    <input type="radio" name="tipoHistorial" value="Especifico"
                                                    v-model="NuevoHistorial.tipoHistorial" class="form-radio text-blue-500 focus:border-blue-500  focus:ring focus:ring-blue-200">
                                                    <span class="ml-2 dark:text-white text-xs">Historial de un semestre</span>
                                                </label>
                                            </div>

                                            <div class="w-full inline" v-if="NuevoHistorial.tipoHistorial=='Especifico'">
                                                <label class="uppercase text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-last-name">
                                                    Número de semestre
                                                </label>

                                                <input id="Capacidad"  class="mt-1  bg-gray-200 dark:bg-slate-600 text-gray-700
                                                    dark:text-gray-200 border border-gray-200  dark:border-slate-600
                                                    rounded py-2 px-3  focus:outline-none focus:bg-white"
                                                    type="number" placeholder="0" required
                                                    v-model="NuevoHistorial.NumSemestre">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal footer -->
                                <div class="flex items-center px-1 py-2 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                                    <button type="submit" class="text-white bg-[#014E82] hover:bg-[#0284c7] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        Generar historial
                                    </button>
                                    <button @click="hideElement" data-modal-hide="defaultModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
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

    <!--Alerta-->
    <div v-if="mensaje"
        :class="{ 'bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-3 mb-3': tipoMensaje == 'Exitoso', 'bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-3 mb-3': tipoMensaje == 'Error' }">
            <strong class="font-bold" v-if="tipoMensaje=='Exitoso'">Éxito:</strong>
            <strong class="font-bold" v-if="tipoMensaje=='Error'">Érror:</strong>
            <span class="block sm:inline">{{ mensaje}}</span>
    </div>

    <!--TABLA DE ALUMNOS PARA VER PROMEDIOS-->
    <div class="inline-block min-w-full overflow-hidden rounded-lg shadow mt-2">
        <table class="w-full whitespace-no-wrap">
            <thead>
                <tr class="border-2 dark:border-slate-700 border-gray-300 bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">

                    <th class="border-b-2 w-5 pl-5 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200">

                    </th>

                    <th class="border-b-2 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200">
                        No.Control
                    </th>
                    <th class="border-b-2 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200">
                        Nombre
                    </th>

                    <th class="border-b-2 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200">
                        Grupo
                    </th>

                    <th class="border-b-2 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200"
                    >
                        Opciones
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(alumno,index) in alumnos" v-bind:id="`fila${alumno.id}`"  class="text-gray-700">
                    <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-5 py-5 text-sm">
                        <input type="checkbox" name="alumnosAgregar"  id="" :value="alumno"
                        v-model="NuevoHistorial.AlumnosSeleccionados">
                    </td>

                    <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-3 py-5 text-xs ">
                        <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap">
                            {{ alumno.noControl }}
                        </p>
                    </td>

                    <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-3 py-5 text-xs">
                        <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap">{{ alumno.Nombre }} {{ alumno.ApellidoP }} {{ alumno.ApellidoM }}</p>
                    </td>

                    <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-3 py-5 text-xs">
                        <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap uppercase"
                            v-if="alumno.idGrupo==null">
                                Sin grupo
                        </p>

                        <span v-for="grupo in grupos">
                            <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap"
                            v-if="grupo.id==alumno.idGrupo">
                                {{ grupo.Semestre }}-{{grupo.Letra}}-{{ grupo.Especialidad }}
                            </p>
                        </span>

                    </td>


                    <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-6 py-5 text-sm"
                    >

                        <div v-if="$page.props.user.roles.includes('Administrador')">
                            <a type="button" @click="VerGrafica(alumno)" class="p-3 rounded-md bg-[#FFD200] mx-2
                            inline-flex mb-1" >
                            <i class="fa-solid fa-chart-simple mr-1 mt-1"></i>    Rendimiento
                            </a>
                        </div>

                        <div>
                            <div :class="{ hidden: !isvisibleDelete }"  tabindex="-1" class="fixed inset-0 flex items-center justify-center z-50">
                                <div class="relative w-full max-w-md max-h-full">
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <button @click="hideDelete" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                        <div class="p-6 text-center">
                                            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                            </svg>


                                            <h3  class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Esta seguro de dar de baja a este alumno </h3>
                                            <Link @click="hideDelete" method="delete" :href="route('Alumnos.destroy', idBorrarSeleccionado)" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                                Si, estoy seguro
                                            </Link>


                                            <button @click="hideDelete" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No, cancelar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Capa oscura -->
    <div :class="{ hidden: !isVisibleRendimiento }" class="fixed inset-0  bg-black opacity-50">
    </div>

    <!--Modal para ver rendimiento de un alumno-->
    <div id="modalContainer">
        <!-- Main modal -->
        <div :class="{ hidden: !isVisibleRendimiento }">
            <div id="defaultModal" tabindex="-1" aria-hidden="true"  class="fixed inset-0 flex items-center justify-center z-50">
                <div class="relative w-full max-w-2xl max-h-screen overflow-auto">
                    <!-- Modal content -->
                    <div class="relative  bg-white rounded-lg shadow dark:bg-gray-800">
                        <!-- Modal header -->
                        <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    Rendimiento
                                </h3>
                            <button type="button" @click="OcultarGrafica" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="px-6 py-3 space-y-6 w-full  ">
                            <div  class="w-full dark:text-white ">


                                <div class="dark:text-white ">
                                    <strong>Nombre del alumno: </strong>{{ NombreAlumnoRendimiento }}<br>
                                    <strong>Número de control: </strong>{{ noControlRendimiento  }}
                                </div>

                                <div class="dark:text-white overflow-y-auto w-full h-64 my-4">
                                    <Line :data="chartData" :options="chartOptions" ref="miGrafica" />
                                </div>

                                <!-- Modal footer -->
                                <div class="flex items-center py-5  mt-4 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-200">

                                    <button @click="hideRendimiento" class="text-white bg-[#014E82] hover:bg-[#0284c7] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        Aceptar
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Seccion de paginacion-->
    <nav aria-label="Page navigation example mt-4">
        <ul class="inline-flex -space-x-px text-sm">
            <li v-if="this.Paginator.prev_page_url!=null" >
            <a :href="this.Paginator.prev_page_url" class="flex items-center justify-center px-3 h-8 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
            >Anterior</a>
            </li>

            <li v-if="Paginator.current_page-2 >0">
                <a :href="`${urlPaginacion}${Paginator.current_page-2}=`"  aria-current="page" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                {{ Paginator.current_page-2 }}</a>
            </li>

            <li v-if="Paginator.current_page-1 >0">
                <a :href="`${urlPaginacion}${Paginator.current_page-1}`" aria-current="page" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    {{ Paginator.current_page-1 }} </a>
            </li>

            <li>
                <a href="#" aria-current="page" class="flex items-center justify-center px-3 h-8 text-blue-600 border border-gray-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">
                {{ Paginator.current_page }}</a>
            </li>

            <li v-if="Paginator.current_page+1<=cantidadPaginas">
                <a :href="`${urlPaginacion}${Paginator.current_page+1}`" aria-current="page" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                >{{ Paginator.current_page+1 }}</a>
            </li>

            <li v-if="Paginator.current_page+2<=cantidadPaginas">
                <a :href="`${urlPaginacion}${Paginator.current_page+2}`" aria-current="page" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
               {{ Paginator.current_page+2 }}</a>
            </li>

            <li v-if="this.Paginator.next_page_url!=null">
                <a :href="this.Paginator.next_page_url" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                >Siguiente</a>
            </li>
        </ul>
    </nav>

    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/vue3';
    import { Link } from '@inertiajs/vue3'
</script>

<script>
    import axios from 'axios';
    import {
    ArcElement,
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend
    } from 'chart.js'
    import { Line } from 'vue-chartjs';
    import Chart from 'chart.js/auto';

    ChartJS.register(
        ArcElement,
        CategoryScale,
        LinearScale,
        PointElement,
        LineElement,
        Title,
        Tooltip,
        Legend
    )

    export default {
        name: 'Promedios',
        components:{
            Link,
            Line,
        },

        props:{
            alumnos:Array,
            Paginator:Array,
            grupos:Array,
            mensaje:String,
            tipoMensaje:String,
        },


        async mounted() {
            this.FiltroBusqueda=this.$page.props.Filtro;

            if(this.Paginator.next_page_url!=null){
                this.urlPaginacion = this.Paginator.next_page_url.slice(0, -1);
            }
            else if(this.Paginator.prev_page_url!=null){
                this.urlPaginacion = this.Paginator.prev_page_url.slice(0, -1);
            }
            this.cantidadPaginas=this.Paginator.last_page
        },

        data() {
            return {

                chartData: {
                    labels: ['Semestre 1','Semestre 2','Semestre 3','Semestre 4'],
                    datasets: [
                    {
                        label: 'Promedio por Semestre',
                        backgroundColor: 'rgba(75,192,192,0.4)',
                        borderColor: 'rgba(75,192,192,1)',
                        borderWidth: 1,
                        data: [7,6.5,9,9.4],
                    },
                    ],
                },
                chartOptions: {
                    responsive: true,
                    maintainAspectRatio: false,
                },



                urlPaginacion:'',

                isVisible: false,
                isvisibleDelete:false,
                isVisibleImportacion:false,
                isVisibleRendimiento:false,

                idBorrarSeleccionado:0,

                MostrarFiltro:false,

                AlumnoBuscar:'',
                campoBusqueda:'Nombre',
                campoBusquedaVer:'Nombre',
                setTimeoutBuscador:'',

                NuevoHistorial:{
                    AlumnosSeleccionados:[],
                    tipoHistorial:'',
                    NumSemestre:0
                },

                Activar:[],
                NombreAlumnoRendimiento:'',
                noControlRendimiento:'',
            }
        },

        methods: {
            async renderChart(Encabezados,Informacion){

                const canvas=document.getElementById("myChart");
                // const chartInstance =
                const data={
                    labels: Encabezados,
                    datasets: [
                        {
                            label: 'Promedio por Semestre',
                            backgroundColor: 'rgba(75,192,192,0.4)',
                            borderColor: 'rgba(75,192,192,1)',
                            borderWidth: 1,
                            data: Informacion
                        }
                    ]
                }
                const ctx = this.$refs.miGrafica.chart.getContext("2d");
                await new Chart(
                ctx, {
                    type: "line",
                    data: data,
                });
            },

            hideRendimiento(){
                this.isVisibleRendimiento=false
            },

            VerGrafica(alumno){

                this.isVisibleRendimiento=true

                axios.get('Calificaciones.Rendimiento',{   params:{ id:alumno.id}   })
                .then(response => {
                    console.log(response.data.Semestres);
                    console.log(response.data.Promedios);

                    console.log('Actualizando datos')

                    this.NombreAlumnoRendimiento=alumno.Nombre+' '+alumno.ApellidoP+' '+alumno.ApellidoM

                    this.noControlRendimiento=alumno.noControl;

                    this.$refs.miGrafica.chart.data.labels = response.data.Semestres;
                    this.$refs.miGrafica.chart.data.datasets[0].data = response.data.Promedios;


                    // const chartInstance = this.$refs.miGrafica.chart.data.datasets[0].data;
                    // console.log(chartInstance);
                    this.$refs.miGrafica.chart.update();

                    //this.$refs.miGrafica.load();
                    //this.renderChart(response.data.Semestres,response.data.Promedios);

                })
                .catch(error => {
                    console.error('Error al hacer la busqueda:', error);
                });
            },

            OcultarGrafica(){
                this.isVisibleRendimiento=false
            },

            MostrarOpcionesFiltro(){
                this.$page.props.mensaje=null
                if(this.MostrarFiltro==true){
                    this.MostrarFiltro=false
                }
                else{
                    this.MostrarFiltro=true
                }
            },

            SeleccionarCampo(campo,campoVer){
                this.campoBusqueda=campo
                this.campoBusquedaVer=campoVer
                this.MostrarFiltro=false
                this.HacerBusqueda();
            },

            async GenerarHistorial(){
                //await this.$inertia.post(route('Alumnos.store'),this.NuevoAlumno)
                if(this.NuevoHistorial.tipoHistorial!=''){

                    if(this.NuevoHistorial.tipoHistorial=='Especifico'){
                        if(this.NuevoHistorial.NumSemestre>0 && this.NuevoHistorial.NumSemestre<=10){
                            await this.$inertia.post(route('Calificaciones.historial'),this.NuevoHistorial)
                            this.hideElement();
                        }
                    }else{
                        await this.$inertia.post(route('Calificaciones.historial'),this.NuevoHistorial)
                        this.hideElement();
                    }
                }
            },

            contarTiempo(){
                this.$page.props.mensaje=null
                clearTimeout(this.setTimeoutBuscador);
                this.setTimeoutBuscador=setTimeout(this.HacerBusqueda,360)
            },

            HacerBusqueda(){

                console.log(this.AlumnoBuscar);

                axios.get('Alumnos.buscar',{   params:{ Alumno:this.AlumnoBuscar,campo:this.campoBusqueda}   })
                .then(response => {

                    this.resultadosBusqueda=response.data;
                    this.$page.props.alumnos=this.resultadosBusqueda;
                })
                .catch(error => {
                    console.error('Error al hacer la busqueda:', error);
                });

                this.personalSeleccionado=0;
            },


            showElement() {
            this.isVisible = true;
            this.MostrarmensajeCurp=true
            this.exitoCURP=true
            },


            hideElement() {
            this.isVisible = false;
            },
        }
    };
</script>








