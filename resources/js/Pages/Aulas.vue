<template>
    <Head title="Plazas" />
    <AuthenticatedLayout>
    <template #header>
            Lista de Aulas
    </template>


    <div class="inline-flex w-full" >

        <div class="relative text-gray-700 dark:text-white focus-within:text-gray-700  dark:focus-within:text-slate-200 mb-3">
            <input
                class=" border-gray-100 dark:border-gray-500 bg-white dark:bg-slate-700 h-10 px-4 pr-20 rounded-lg text-sm focus:outline-none"
                type="text"
                :placeholder="'Buscar por ' + campoBusquedaVer"
                v-model="AulaBuscar"
                @keyup="contarTiempo"
            />
        </div>


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
                <span @click="SeleccionarCampo('NombreAula','Nombre')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-slate-500 dark:text-gray-200">Nombre</span>
                </div>

                <div class="py-1 dark:bg-slate-700 dark:hover:bg-slate-500 " role="menuitem" tabindex="-1" id="dropdown-menu-item-2" href="#">
                <span @click="SeleccionarCampo('Capacidad','Capacidad')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-slate-500 dark:text-gray-200">Capacidad</span>
                </div>

                <div class="py-1 dark:bg-slate-700 dark:hover:bg-slate-500 " role="menuitem" tabindex="-1" id="dropdown-menu-item-2" href="#">
                <span @click="SeleccionarCampo('Ubicacion','Ubicacion')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-slate-500 dark:text-gray-200">Ubicación</span>
                </div>

            </div>
        </div>


        <button :type="type" @click="showElement" class=" ml-auto mr-9 rounded-md bg-[#014E82] px-6 py-2.5 mb-4 text-center text-sm text-white hover:bg-[#0284c7]  "
        v-if="$page.props.user.roles.includes('Administrador')">
            Nuevo
        </button>

    </div>

    <div id="modalContainer">

        <!-- Main modal -->
        <div :class="{ hidden: !isVisible }">
            <div id="defaultModal" tabindex="-1" aria-hidden="true"  class="fixed inset-0 flex items-center justify-center z-50">
                <div class="relative w-full max-w-2xl max-h-full">

                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Agregar Aula
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
            <form @submit.prevent="crearAula"  class="w-full max-w-lg">
                    <div class="flex flex-wrap -mx-3 mb-6">

                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-last-name">
                                Nombre del aula
                            </label>
                            <input id="NombreAula" v-model="NuevaAula.NombreAula"
                            class="appearance-none block w-full bg-gray-200 dark:bg-slate-600 text-gray-700 dark:text-gray-200 border
                            border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                            type="text" placeholder="Aula 1" required>
                        </div>

                        <div class="w-full md:w-1/2 px-3">
                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-last-name">
                                Capacidad
                            </label>
                            <input id="Capacidad" v-model="NuevaAula.Capacidad"
                            class="appearance-none block w-full bg-gray-200 dark:bg-slate-600 text-gray-700 dark:text-gray-200 border
                            border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                            type="number" placeholder="0" required>
                            </div>
                        </div>

                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-password">
                                    Ubicación
                                </label>
                                <input id="Ubicacion" v-model="NuevaAula.Ubicacion"
                                class="appearance-none block w-full bg-gray-200 dark:bg-slate-600 text-gray-700 dark:text-gray-200 border
                                border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                type="text" placeholder="Ubicacion" required>

                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button type="submit" class="text-white bg-[#014E82] hover:bg-[#0284c7] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Agregar</button>
                        <button @click="hideElement" data-modal-hide="defaultModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Cancelar</button>
                    </div>

                </form>

            </div>

        </div>
        </div>
    </div>
    </div>

</div>


        <div v-if="mensaje"
        :class="{ 'bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-3': tipoMensaje == 'Exitoso', 'bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-3 mb-3': tipoMensaje == 'Error' }">
            <strong class="font-bold" v-if="tipoMensaje=='Exitoso'">Éxito:</strong>
            <strong class="font-bold" v-if="tipoMensaje=='Error'">Érror:</strong>
            <span class="block sm:inline">{{ mensaje}}</span>
        </div>

        <!--TABLA AULAS-->
        <div class="inline-block min-w-full overflow-hidden rounded-lg shadow">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr class="border-b bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                        <th class="border-b-2 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200">
                            ID
                        </th>
                        <th class="border-b-2 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200">
                            Nombre
                        </th>
                        <th class="border-b-2 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200">
                            Capacidad
                        </th>
                        <th class="border-b-2 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200">
                            Ubicación
                        </th>
                        <th class="border-b-2 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200"
                        v-if="$page.props.user.roles.includes('Administrador')
                        ">
                            Opciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="aula in aulas" :key="aula.id" class="text-gray-700">
                        <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-5 py-5 text-sm">
                            <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap">{{ aula.id }}</p>
                        </td>
                        <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-5 py-5 text-sm">
                            <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap">{{ aula.NombreAula }}</p>
                        </td>
                        <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-5 py-5 text-sm">
                            <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap">{{ aula.Capacidad }}</p>
                        </td>
                        <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-5 py-5 text-sm">
                            <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap">{{ aula.Ubicacion }}</p>
                        </td>

                        <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-5 py-5 text-sm"
                        v-if="$page.props.user.roles.includes('Administrador')">

                            <Link :href="route('Aulas.edit',aula.id)" class="p-3 rounded-md bg-[#014E82] mx-2 inline-flex mb-1"
                            v-if="$page.props.user.roles.includes('Administrador')">
                                <i class="fa-solid fa-pen text-white"></i>
                            </Link>

                            <a type="button" @click="showDelete(aula.id)" class="p-3 rounded-md bg-[#dc2626] mx-2 inline-flex mb-1"
                            v-if="$page.props.user.roles.includes('Administrador')">
                                <i class="fa-solid fa-trash text-white"></i>
                            </a>
                                    <div>
                                        <div :class="{ hidden: !isvisibleDelete }" v-bind:id="`Modal${aula.id}`" tabindex="-1" class="fixed inset-0 flex items-center justify-center z-50">
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
                                                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Esta seguro de eliminar esta aula </h3>
                                                        <Link @click="hideDelete" method="delete" :href="route('Aulas.destroy', idBorrarSeleccionado)" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                                            Si, estoy seguro
                                                        </Link>
                                                        <button @click="hideDelete" data-modal-hide="popup-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No, cancelar</button>
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

        <nav aria-label="Page navigation example mt-4">
                <ul class="inline-flex -space-x-px text-sm">


                    <li v-if="this.Paginator.prev_page_url!=null" >
                    <a :href="this.Paginator.prev_page_url" class="flex items-center justify-center px-3 h-8 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                    >Previous</a>
                    </li>

                    <li v-if="Paginator.current_page-2 >0">
                        <a :href="`${urlPaginacion}${Paginator.current_page-2}`"  aria-current="page" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
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
                    >Next</a>
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

export default {

    components:{
        Link
    },

    mounted() {
        this.hideDelete()
        if(this.Paginator.next_page_url!=null){
            this.urlPaginacion = this.Paginator.next_page_url.slice(0, -1);
        }
        else if(this.Paginator.prev_page_url!=null){
            this.urlPaginacion = this.Paginator.prev_page_url.slice(0, -1);
        }

        this.cantidadPaginas=this.Paginator.last_page
    },

    props:{
         aulas:Array,
         Paginator:Array,
         mensaje: String,
         tipoMensaje:String,
    },

    data() {
    return {
        urlPaginacion:'',
       infoEditar: {
          NombreAula:'',
          Capacidad:0,
          Ubicacion:''
      },


      isVisible: false,
      isvisibleDelete:false,

      idBorrarSeleccionado:0,

      MostrarFiltro:false,

      campoBusqueda:'NombreAula',
      campoBusquedaVer:'Nombre',
      AulaBuscar:'',
      setTimeoutBuscador:'',

      NuevaAula:{
          NombreAula:'',
          Capacidad:0,
          Ubicacion:''
      }

    }
  },

  methods: {


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

    contarTiempo(){
        this.$page.props.mensaje=null
        clearTimeout(this.setTimeoutBuscador);
        this.setTimeoutBuscador=setTimeout(this.HacerBusqueda,360)
    },

    HacerBusqueda(){

        console.log(this.AulaBuscar);
        this.$page.props.mensaje=null
        axios.get('Aula.buscar',{   params:{ Aula:this.AulaBuscar,campo:this.campoBusqueda}   })
        .then(response => {

            this.resultadosBusqueda=response.data;
            this.$page.props.aulas=this.resultadosBusqueda;
        })
        .catch(error => {
            console.error('Error al hacer la busqueda:', error);
        });
    },



    async crearAula(){
        await this.$inertia.post(route('Aulas.store'),this.NuevaAula)
        this.hideElement()
    },

    showElement() {
        this.$page.props.mensaje=null
        this.isVisible = true;
    },
    hideElement() {
      this.isVisible = false;
    },

    showDelete(id){
        this.$page.props.mensaje=null
        this.idBorrarSeleccionado=id;
        this.isvisibleDelete = true;
    },
    hideDelete(){
        this.isvisibleDelete = false;
    },

  }
};
</script>


