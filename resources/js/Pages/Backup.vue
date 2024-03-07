<template>
    <Head title="Backup" />
    <AuthenticatedLayout>
    <template #header>
            Respaldo y restauración de la base de datos
    </template>


     <!-- Capa oscura -->
    <div :class="{ hidden: !isvisibleDelete }" class="fixed inset-0  bg-black opacity-50">
    </div>


     <!-- Capa oscura -->
     <div :class="{ hidden: !isvisibleRestauracion }" class="fixed inset-0  bg-black opacity-50">
    </div>

    <div id="modalContainer" class="w-full mb-2 inline ">
        <button :type="type" @click="GenerarBackup" class="inline rounded-md bg-[#014E82] px-5 py-3 mb-2  text-sm text-white hover:bg-[#0284c7]  ">
            <i class="fa-solid fa-database text-white inline"></i> <span class="text-white pl-1">Respaldar datos</span>
        </button>
    </div>


    <div v-if="mensaje"
    :class="{ 'bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-3 mb-3': tipoMensaje == 'Exitoso', 'bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-3 mb-3': tipoMensaje == 'Error' }">
        <strong class="font-bold" v-if="tipoMensaje=='Exitoso'">Éxito:</strong>
        <strong class="font-bold" v-if="tipoMensaje=='Error'">Érror:</strong>
        <span class="block sm:inline">{{ mensaje}}</span>
    </div>

    <!--TABLA DE RESPALDOS-->
    <div class="inline-block min-w-full overflow-hidden rounded-lg shadow mb-4 mt-1">
            <table class="w-full">
                <!--Encabezados-->
                <thead>
                    <tr class="border-b bg-gray-50 text-left text-xs font-semibold uppercase  text-gray-500">

                        <th class="border-b-2 w-3/6 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200">
                            Nombre del respaldo
                        </th>

                        <th class="border-b-2 w-1/6 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200">
                            Tamaño
                        </th>


                        <th v-if="$page.props.user.roles.includes('Administrador')"
                        class="border-b-2 w-2/6 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700  py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200">
                            Opciones
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="archivo in archivos"  class="text-gray-700">

                        <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-5 py-5 text-sm">
                            <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap inline">
                                <i class="fa-solid fa-file dark:text-white"></i> <span class="pl-2">{{ archivo.filename }}</span>
                            </p>
                        </td>

                        <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-5 py-5 text-sm">
                            <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap">
                                <p class="pl-2">{{ archivo.size }} KB</p>
                            </p>
                        </td>


                        <td  class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-5 py-5 text-sm">

                            <a  v-if="$page.props.user.roles.includes('Administrador')" type="button" @click="descargarArchivo(archivo.pathname)"
                            class="p-3 rounded-md bg-[#5765fc] mx-2 inline-flex mb-1"
                            v-tippy="{
                                content:'Descargar sql',
                                placement: 'top' ,
                                arrow: true,
                                arrowType: 'round',
                                theme: 'MiTheme'
                            }"
                            >
                                <i class="fa-solid fa-download text-white"></i>
                            </a>

                            <a  v-if="$page.props.user.roles.includes('Administrador')" type="button" @click="showRestauracion(archivo.filename,archivo.pathname)"
                            class="p-3 rounded-md bg-[#dc7826] mx-2 inline-flex ">
                                 <p class="pr-2 text-white">Restaurar</p> <i class="fa-solid fa-database text-white "></i>
                            </a>


                            <a  v-if="$page.props.user.roles.includes('Administrador')" type="button" @click="showDelete(archivo.filename,archivo.pathname)"
                            class="p-3 rounded-md bg-[#dc2626] mx-2 inline-flex mb-1">
                                    <i class="fa-solid fa-trash text-white"></i>
                            </a>


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


                                                <h3  class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                                    Esta seguro de eliminar el respaldo : {{ nombreArchivoSeleccionado }}

                                                </h3>
                                                <button @click="EliminarRespaldo(rutaArchivoSeleccionado)"  type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                                    Si, estoy seguro
                                                </button>


                                                <button @click="hideDelete" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No, cancelar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div>
                                <div :class="{ hidden: !isvisibleRestauracion }"  tabindex="-1" class="fixed inset-0 flex items-center justify-center z-50">
                                    <div class="relative w-full max-w-md max-h-full">
                                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                            <button @click="hideRestauracion" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                            <div class="p-6 text-center">
                                                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                </svg>


                                                <h3  class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                                    Esta seguro de hacer la restauracion con el archivo : {{ nombreArchivoSeleccionado }}

                                                </h3>
                                                <button @click="GenerarRestauracion(rutaArchivoSeleccionado)"  type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                                    Si, estoy seguro
                                                </button>


                                                <button @click="hideRestauracion" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No, cancelar</button>
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

    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/vue3';
    import { Link } from '@inertiajs/vue3'

    import 'tippy.js/themes/light.css'

    import 'tippy.js/dist/tippy.css';
    import 'tippy.js/animations/scale.css';
    import { directive } from 'vue-tippy'

</script>

<script>

import axios from 'axios';

export default {

    components:{
        Link
    },


    directives: {
        tippy: directive,
    },


    props:{
        archivos:Array,
        mensaje:String,
        tipoMensaje:String,
    },

    data() {
    return {

        isvisibleDelete:false,
        isvisibleRestauracion:false,

        nombreArchivoSeleccionado:'',
        rutaArchivoSeleccionado:'',
    }
  },

  methods: {
    async GenerarBackup(){
        await this.$inertia.get(route('GenerarBackup'))
    },

    async GenerarRestauracion(archivo){
        //Ruta del archivo para generar la restauracion
        let archivoEnviar = { ruta: archivo };
        await this.$inertia.post(route('GenerarRestauracion'),archivoEnviar)
        this.hideRestauracion();
    },

    descargarArchivo(rutaDescargar) {
        window.location.href = `/descargar-archivo/${encodeURIComponent(rutaDescargar)}`;
    },

    async EliminarRespaldo(rutaEliminar){
        let archivoEnviar = { ruta: rutaEliminar };
        await this.$inertia.post(route('EliminarRespaldo'),archivoEnviar)
        this.hideDelete();
    },

    showRestauracion(nombre,ruta){
        this.$page.props.mensaje=null
        this.nombreArchivoSeleccionado=nombre;
        this.rutaArchivoSeleccionado=ruta;
        this.isvisibleRestauracion=true;
    },

    hideRestauracion(){
        this.isvisibleRestauracion=false;
    },

    showDelete(nombre,ruta){
        this.$page.props.mensaje=null
        this.nombreArchivoSeleccionado=nombre;
        this.rutaArchivoSeleccionado=ruta;
        this.isvisibleDelete=true;
    },

    hideDelete(){
        this.isvisibleDelete=false
    },


  }

};
</script>

<style>
    .tippy-box[data-theme~='MiTheme'] {
        background-color: rgb(46, 53, 190);
        color: rgb(255, 255, 255);
        padding: 5px;
        border-radius: 4px;
    }
    .tippy-arrow {
        border-top-color: rgb(38, 95, 230);
    }
</style>
