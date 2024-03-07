<template>
    <Head title="Departamentos" />
    <AuthenticatedLayout>
        <template #header>
                Jefes de departamentos
        </template>

        <h3 class="text-m text-gray-900 dark:text-white py-1 ml-1">
            Buscar por:
            <input type="radio" value="Nombre" name="Campos" v-model="campoBusqueda" required > Nombre
        </h3>

        <div class="inline-flex w-full" >
            <div class="relative text-gray-700 dark:text-gray-200 focus-within:text-gray-700  dark:focus-within:text-slate-200 mb">
                <input
                    class=" border-gray-100 dark:border-gray-500 bg-white dark:bg-slate-700 h-10 px-4 pr-20 rounded-lg text-sm focus:outline-none"
                    type="text"
                    placeholder="Buscar..."
                    v-model="DepartamentoBuscar"
                    @keyup="contarTiempo"
                />
            </div>
            <button :type="type" @click="showElement" class=" ml-auto mr-9 rounded-md bg-[#014E82] px-6 py-2.5 mb-4 text-center text-sm text-white hover:bg-[#0284c7] "
            v-if="$page.props.user.roles.includes('Recursos Humanos')"
            v-tippy="{
                content:'Agregar departamento',
                placement: 'top' ,
                arrow: true,
                arrowType: 'MyArrow',
                theme: 'MiThemeBlue'
            }">
                Nuevo
            </button>
        </div>
        <!-- Capa oscura -->
        <div :class="{ hidden: !isvisibleDelete }" class="fixed inset-0 bg-black opacity-50">
        </div>
        <!-- Capa oscura -->
        <div :class="{ hidden: !isVisible }" class="fixed inset-0 bg-black opacity-50">
        </div>
        <!--Modal para registrar un nuevo departamento-->
        <div id="modalContainer">
            <!-- Main modal -->
            <div :class="{ hidden: !isVisible }">
                <div id="defaultModal" tabindex="-1" aria-hidden="true"  class="fixed inset-0 flex items-center justify-center z-50">
                    <div class="relative w-full max-w-2xl max-h-full">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
                            <!-- Modal header -->
                            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                        Agregar departamento
                                    </h3>
                                <button type="button" @click="hideElement" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>
                            <!-- Modal body -->
                            <div class="p-6 space-y-6 w-full">
                                <form @submit.prevent="crearUsuario"  class="w-full max-w-lg">
                                    <div class="flex flex-wrap -mx-3 mb-6">
                                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" f for="grid-first-name">
                                                Nombre del departamento
                                            </label>
                                            <input id="Nombre" v-model="NuevoDepartamento.Nombre"  class="appearance-none block w-full bg-gray-200 dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"  type="text" placeholder="nombre" required>
                                        </div>

                                        <div class="w-full md:w-1/2 px-3">
                                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-last-name">
                                                Jefe de departamento
                                            </label>
                                            <select name="departamentos" v-model="NuevoDepartamento.idEncargado" class="appearance-none block w-full bg-gray-200 dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white">

                                                <option
                                                    v-for="persona in personal"
                                                    :key="persona.id"
                                                    :value="persona.id"
                                                >
                                                    {{ persona.Nombre }} {{ persona.ApellidoP }} {{ persona.ApellidoM }}
                                                </option>
                                            </select>
                                        </div>

                                        <div class="w-full md:w-full px-3">
                                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-last-name">
                                                Descripcion
                                            </label>
                                            <input id="Descripcion" v-model="NuevoDepartamento.Descripcion" class="appearance-none block w-full bg-gray-200 dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"  type="text" placeholder="Ingresa una descripcion para este apartamento" required>
                                        </div>

                                        <div class="w-full md:w-1/2 px-3">
                                                <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-last-name">
                                                    Subdirección
                                                </label>

                                                <select name="departamentos" v-model="NuevoDepartamento.idSubdireccion" class="appearance-none block w-full bg-gray-200 dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white">
                                                    <option
                                                        v-for="subdireccion in subdirecciones"
                                                        :key="subdireccion.id"
                                                        :value="subdireccion.id"
                                                    >
                                                        {{ subdireccion.Nombre }}
                                                    </option>
                                                </select>
                                        </div>
                                        <!-- Modal footer -->
                                        <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                                            <button type="submit" class="text-white bg-[#014E82] hover:bg-[#0284c7] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                Agregar
                                            </button>
                                            <button @click="hideElement" data-modal-hide="defaultModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                                Cancelar
                                            </button>
                                        </div>
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
        <!--TABLA DE DEPARTAMENTOS-->
        <div class="inline-block min-w-full overflow-hidden rounded-lg shadow">
            <table class="w-full whitespace-no-wrap">
                <!--Encabezados-->
                <thead>
                    <tr class="border-b bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                        <th class="border-b-2 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200">
                            Departamento
                        </th>
                        <th class="border-b-2 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200">
                            Jefe de departamento
                        </th>
                        <th class="border-b-2 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200">
                            Subdirección
                        </th>
                        <th class="border-b-2 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200"
                        v-if="$page.props.user.roles.includes('Recursos Humanos')" >
                            Opciones
                        </th>
                    </tr>
                </thead>
                <!--FILAS-->
                <tbody>
                    <tr v-for="(departamento,index) in departamentos"  class="text-gray-700">

                        <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-5 py-5 text-sm">
                            <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap">{{ departamento.Nombre }}</p>
                        </td>

                        <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-5 py-5 text-sm">

                            <p v-if="departamento.idEncargado==null" class="dark:text-gray-200 uppercase">Sin Jefe asignado</p>
                            <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap" v-for="persona in personal" >
                                <p v-if="persona.id==departamento.idEncargado">
                                    {{ persona.Nombre }} {{ persona.ApellidoP }} {{ persona.ApellidoM }}
                                </p>
                            </p>
                        </td>

                        <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-5 py-5 text-sm">

                            <p v-if="departamento.idSubdireccion==null" class="dark:text-gray-200 uppercase">Sin subdireccion</p>
                            <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap" v-for="subdireccion in subdirecciones" >
                                <p v-if="subdireccion.id==departamento.idSubdireccion">
                                    {{ subdireccion.Nombre }}
                                </p>
                            </p>
                        </td>


                        <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-5 py-5 text-sm"
                        v-if="$page.props.user.roles.includes('Recursos Humanos')" >

                            <Link :href="route('Departamentos.edit',departamento.id)" class="p-3 rounded-md bg-[#014E82] mx-2 text-white inline-flex mb-2"
                            v-if="$page.props.user.roles.includes('Recursos Humanos')"
                            v-tippy="{
                                content:'Editar departamento',
                                placement: 'left' ,
                                arrow: true,
                                arrowType: 'MyArrow',
                                theme: 'MiThemeBlue'
                            }">
                                <strong>Cambiar Jefe<span>  <i class="fa-solid fa-user-plus pl-1"></i> </span> </strong>
                            </Link>


                            <a type="button" @click="showDelete(departamento.id,departamento.Nombre)" class="p-3 rounded-md text-white bg-[#dc2626] mx-2 inline-flex mb-2"
                            v-if="$page.props.user.roles.includes('Recursos Humanos')"
                            v-tippy="{
                                content:'Eliminar departamento',
                                placement: 'left' ,
                                arrow: true,
                                arrowType: 'MyArrow',
                                theme: 'MiThemeRed'
                            }">
                                <strong>Eliminar<span>  <i class="fa-solid fa-trash text-white pl-3"></i> </span> </strong>
                            </a>


                            <div>
                                <div :class="{ hidden: !isvisibleDelete }" v-bind:id="`Modal${departamento.id}`" tabindex="-1" class="fixed inset-0 flex items-center justify-center z-50">
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
                                                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Esta seguro de eliminar el departamento: {{ nameBorrarSeleccionado }} </h3>
                                                <Link @click="hideDelete" method="delete" :href="route('Departamentos.destroy', idBorrarSeleccionado)" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
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
        <!--Seccion de paginacion-->
        <nav aria-label="Page navigation example mt-4">
            <ul class="inline-flex -space-x-px text-sm">
                <li v-if="this.Paginator.prev_page_url!=null" >
                    <a :href="this.Paginator.prev_page_url" class="flex items-center justify-center px-3 h-8 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                    >Anterior</a>
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
                >Siguiente</a>
                </li>
            </ul>
        </nav>
    </AuthenticatedLayout>
</template>

<script setup>

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import Pagination from '@/Components/Pagination.vue'
    import { Head } from '@inertiajs/vue3';
    import { Link } from '@inertiajs/vue3';

    import 'tippy.js/themes/light.css';
    import 'tippy.js/dist/tippy.css';
    import 'tippy.js/animations/scale.css';
    import { directive } from 'vue-tippy';

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
    mounted() {
        this.hideDelete();
        if(this.Paginator.next_page_url!=null){
            this.urlPaginacion = this.Paginator.next_page_url.slice(0, -1);
        }
        else if(this.Paginator.prev_page_url!=null){
            this.urlPaginacion = this.Paginator.prev_page_url.slice(0, -1);
        }

        this.cantidadPaginas=this.Paginator.last_page
    },

    props:{
        departamentos:Array,
        personal:Array,
        Paginator:Array,
        subdirecciones:Array,
        mensaje: String,
        tipoMensaje:String,
    },

    data() {
        return {
        urlPaginacion:'',
        isVisible: false,
        isvisibleDelete:false,

        campoBusqueda:'Nombre',
        DepartamentoBuscar:'',
        setTimeoutBuscador:'',

        idBorrarSeleccionado:0,
        nameBorrarSeleccionado:"",

        NuevoDepartamento:{
            Nombre:'',
            Descripcion:'',
            idEncargado:'',
            idSubdireccion:''
        },
        ListaRoles:[],
        }
    },
    methods: {
        contarTiempo(){
            this.$page.props.mensaje=null
            clearTimeout(this.setTimeoutBuscador);
            this.setTimeoutBuscador=setTimeout(this.HacerBusqueda,360)
        },
        HacerBusqueda(){
            axios.get('Departamentos.buscar',{   params:{ departamento:this.DepartamentoBuscar,campo:this.campoBusqueda}   })
            .then(response => {

                this.resultadosBusqueda=response.data;
                this.$page.props.departamentos=this.resultadosBusqueda;
            })
            .catch(error => {
                console.error('Error al hacer la busqueda:', error);
            });
        },

        async crearUsuario(){
            await this.$inertia.post(route('Departamentos.store'),this.NuevoDepartamento)
            this.hideElement()
        },

        showElement() {
            this.$page.props.mensaje=null
            this.isVisible = true;
        },
        hideElement() {
        this.isVisible = false;
        },

        showDelete(id,name){
            this.idBorrarSeleccionado=id;
            this.nameBorrarSeleccionado=name;
            this.isvisibleDelete = true;
        },
        hideDelete(){
            this.isvisibleDelete = false;
        },
    }
};
</script>

<style>
    .tippy-box[data-theme~='MiThemeBlue'] {
        background-color: rgb(15, 24, 201);
        color: rgb(255, 255, 255);
        padding: 5px;
        border-radius: 4px;
    }
    .tippy-box[data-theme~='MiThemeYellow'] {
        background-color: rgb(184, 166, 0);
        color: rgb(255, 255, 255);
        padding: 5px;
        border-radius: 4px;
    }
    .tippy-box[data-theme~='MiThemeRed'] {
        background-color: rgb(207, 22, 65);
        color: rgb(255, 255, 255);
        padding: 5px;
        border-radius: 4px;
    }
    .tippy-box[data-theme~='MiThemeRed'][data-placement^='top'] > .tippy-arrow::before {
        border-top-color: rgb(207, 22, 65);
    }
    .tippy-box[data-theme~='MiThemeBlue'][data-placement^='top'] > .tippy-arrow::before {
        border-top-color: rgb(15, 24, 201);
    }
    .tippy-box[data-theme~='MiThemeYellow'][data-placement^='top'] > .tippy-arrow::before {
        border-top-color: rgb(184, 166, 0)
    }

    .tippy-arrow[data-theme~='MyArrow'] {
        border-color: red;
    }
</style>


