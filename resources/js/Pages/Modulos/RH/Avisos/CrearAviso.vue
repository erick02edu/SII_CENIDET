<template>
    <Head title="Crear aviso" />
    <AuthenticatedLayout>
    <template #header>
            Crear nuevo aviso
    </template>
    <!--Contenido-->
    <div class="w-full mb-5">
        <div class="w-11/12 mb-1  ">
            <label class=" uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2 mr-2" for="grid-first-name">
                Título
            </label>
        </div>
        <p v-if="mensajeTitulo==true" class="text-sm text-red-600 ">Por favor llena este campo</p>

        <input id="Nombre"
            class="  mr-56 appearance-none  w-3/6 bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none
             focus:bg-white" v-model="NuevoAviso.Titulo"
        type="text" placeholder="Ingresa un titulo" required>

        <button :type="type" v-if="$page.props.user.roles.includes('Administrador')" @click="showElement"
                class="rounded-md bg-[#014E82]  px-6 py-2.5  mb-2 text-center text-sm text-white hover:bg-[#0284c7] inline  ">
                Elegir destinatarios
        </button>

        <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-first-name">
            DESCRIPCIÓN
        </label>
        <p v-if="mensajeDescripcion==true" class="text-sm text-red-600 ">Por favor llena este campo</p>
        <div class="flex items-start justify-start ">
            <textarea class="appearance-none w-11/12 bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-slate-600 rounded
            px-4 mb-3 focus:bg-white h-60 content-start" placeholder="Escribe aquí..."
            v-model="NuevoAviso.Descripcion" required></textarea>
        </div>

        <label class=" w-full block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-first-name">
            Destinatarios:
        </label>

        <div class="w-full inline mb-2">
            <div class="flex flex-wrap">
                <span v-for="(User,index) in NuevoAviso.UsuariosSeleccionados"
                class="bg-white mr-4 mb-2 dark:bg-slate-600 dark:text-white px-2 py-1 rounded-lg ">
                {{ User.name }}-{{ User.email }} <i class="fa-solid fa-xmark dark:text-white pl-1" @click="EliminarDestinatario(index)"></i>
                </span>
            </div>
        </div>

        <div class="w-full inline mb-2">
            <div class="flex flex-wrap">
                <span v-for="(rol,index) in NuevoAviso.RolesSeleccionados"
                class="bg-white mr-4 mb-2 dark:bg-slate-600 dark:text-white px-2 py-1 rounded-lg ">
                Usuarios:{{ rol.name }} <i class="fa-solid fa-xmark dark:text-white pl-1" @click="EliminarDestinatarioRol(index)"></i>
                </span>

            </div>
        </div>
    </div>
    <!--Botones agregar y volver-->
    <div class="flex items-center  space-x-2 rounded-b dark:border-gray-200">
        <button type="submit" @click="crearAviso"
        class="text-white bg-[#014E82] hover:bg-[#0284c7] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Generar
        </button>
        <Link
            :href="route('Avisos.index')"
            class='w-auto bg-gray-700 hover:bg-gray-600 rounded-lg shadow-xl font-medium text-white px-4 py-2' type="button">
            Cancelar
        </Link>
    </div>
    <!-- Capa oscura -->
    <div :class="{ hidden: !isVisible }" class="fixed inset-0  bg-black opacity-50">
    </div>
    <!--Modal para definir los destinatarios-->
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
                                Destinatarios del aviso
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
                            <div class="flex flex-wrap ">

                                <label class=" w-full block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-first-name">
                                    Seleccione los usuarios a los que se le enviará este aviso
                                </label>

                                <div class="relative dark:text-white text-gray-700 focus-within:text-gray-700  dark:focus-within:text-slate-200 pb-3"
                                v-if="campoBusqueda!='TipoRol'">
                                    <input
                                    class=" border-gray-300 dark:border-gray-500 bg-white dark:bg-slate-700 h-10 px-4 pr-20 dark:text-gray-200 rounded-lg text-sm focus:outline-none"
                                    type="text"
                                    placeholder="Buscar usuario"
                                    v-model="UsuarioBuscar"
                                    @keyup="contarTiempo"
                                    />
                                </div>

                                <div class="relative dark:text-white text-gray-700 focus-within:text-gray-700  dark:focus-within:text-slate-200 pb-3"
                                v-if="campoBusqueda=='TipoRol'">
                                    <input
                                    class=" border-gray-300 dark:border-gray-500 bg-white dark:bg-slate-700 h-10 px-4 pr-20 dark:text-gray-200 rounded-lg text-sm focus:outline-none"
                                    type="text"
                                    placeholder="Buscar tipo de rol"
                                    v-model="RolBuscar"
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
                                            <span @click="SeleccionarCampo('name','Nombre')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-slate-500 dark:text-gray-200">Nombre</span>
                                        </div>

                                        <div class="py-1 dark:bg-slate-700 dark:hover:bg-slate-500 " role="menuitem" tabindex="-1" id="dropdown-menu-item-2" href="#">
                                            <span @click="SeleccionarCampo('email','Correo')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-slate-500 dark:text-gray-200">Correo</span>
                                        </div>

                                        <div class="py-1 dark:bg-slate-700 dark:hover:bg-slate-500 " role="menuitem" tabindex="-1" id="dropdown-menu-item-2" href="#">
                                            <span @click="SeleccionarCampo('TipoRol','TipoRol')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-slate-500 dark:text-gray-200">Tipo de usuario</span>
                                        </div>
                                    </div>
                                </div>

                                <label class=" w-full block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-first-name">
                                    Destinatarios:
                                </label>

                                <div class="w-full inline mb-2">
                                    <div class="flex flex-wrap">
                                        <span v-for="(User,index) in NuevoAviso.UsuariosSeleccionados"
                                        class=" bg-gray-200 mr-4 mb-2 dark:bg-slate-600 dark:text-white px-2 py-1 rounded-lg ">
                                        {{ User.name }} <i class="fa-solid fa-xmark dark:text-white pl-1" @click="EliminarDestinatario(index)"></i>
                                        </span>

                                    </div>
                                </div>

                                <div class="w-full inline mb-2">
                                    <div class="flex flex-wrap">
                                        <span v-for="(rol,index) in NuevoAviso.RolesSeleccionados"
                                        class="bg-gray-200 mr-4 mb-2 dark:bg-slate-600 dark:text-white px-2 py-1 rounded-lg ">
                                        Usuarios:{{ rol.name }} <i class="fa-solid fa-xmark dark:text-white pl-1" @click="EliminarDestinatarioRol(index)"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="w-full p-3 overflow-y-auto h-64 border rounded-lg border-gray-300 dark:border-gray-500">
                                    <!--TABLA ASIGNAR ALUMNOS A UN GRUPO-->
                                    <div class="inline-block min-w-full overflow-hidden rounded-lg shadow mb-4">
                                        <table class="w-full">
                                            <!--Encabezados-->
                                            <thead>
                                                <tr class="border-b bg-gray-50 text-left text-xs font-semibold uppercase  text-gray-500">

                                                    <th class="border-b-2 w-5 pl-5 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200">

                                                    </th>

                                                    <th class="border-b-2 w-4/5 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200">
                                                        <!-- Alumnos sin grupo {{  NuevoGrupo.AlumnosSeleccionados }} -->
                                                        <span v-if="campoBusqueda!='TipoRol'">Usuario</span>
                                                        <span v-if="campoBusqueda=='TipoRol'">Tipo de rol</span>

                                                    </th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr v-for="usuario in usuarios" :key="usuario.id" class="text-gray-700" v-if="campoBusqueda!='TipoRol'">

                                                    <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-5 py-5 text-sm">
                                                        <input type="checkbox" name="alumnosAgregar"  id="" :value="usuario"
                                                        v-model="NuevoAviso.UsuariosSeleccionados">
                                                    </td>

                                                    <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-5 py-5 text-sm">
                                                        <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap">
                                                            <strong>{{ usuario.name }}</strong>-{{ usuario.email }}
                                                        </p>
                                                    </td>
                                                </tr>


                                                <tr v-for="rol in roles" :key="rol.id" class="text-gray-700" v-if="campoBusqueda=='TipoRol'">

                                                    <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-5 py-5 text-sm">
                                                        <input type="checkbox" name="alumnosAgregar"  id="" :value="rol"
                                                        v-model="NuevoAviso.RolesSeleccionados">
                                                    </td>

                                                    <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-5 py-5 text-sm">
                                                        <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap">
                                                            <strong>{{ rol.name }}</strong>
                                                        </p>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal footer -->
                            <div class="flex items-center py-5 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-200">
                                <button @click="hideElement" class="text-white bg-[#014E82] hover:bg-[#0284c7] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    Aceptar
                                </button>
                                <button @click="hideElement" data-modal-hide="defaultModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                    Cancelar
                                </button>
                            </div>
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
    import Pagination from '@/Components/Pagination.vue'
    import { Head } from '@inertiajs/vue3';
    import { Link } from '@inertiajs/vue3'
</script>

<script>
    import axios from 'axios';
    import Swal from 'sweetalert2'
    import { useDark,useToggle} from '@vueuse/core'
    const isDark=useDark()

    export default {
        components:{
            Link
        },
        mounted() {

        },
        props:{
            usuarios:Array,
            roles:Array,
            mensaje: String,
            tipoMensaje:String,
        },
        data() {
            return {
                mensajeTitulo:false,
                mensajeDescripcion:false,

                isVisible: false,
                isvisibleDelete:false,

                campoBusqueda:'name',
                campoBusquedaVer:'Nombre',
                MostrarFiltro:false,

                UsuarioBuscar:'',
                RolBuscar:'',

                setTimeoutBuscador:'',

                idBorrarSeleccionado:0,
                nameBorrarSeleccionado:"",

                NuevoAviso:{
                    Titulo:'',
                    Descripcion:'',
                    UsuariosSeleccionados:[],
                    RolesSeleccionados:[],
                },
            }
        },
        methods: {
            MostrarOpcionesFiltro(){
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
                this.HacerBusquedaUsuario();
            },
            contarTiempo(){
                clearTimeout(this.setTimeoutBuscador);
                if(this.campoBusqueda!='TipoRol'){
                    this.setTimeoutBuscador=setTimeout(this.HacerBusquedaUsuario,360)
                }
                if(this.campoBusqueda=='TipoRol'){
                    this.setTimeoutBuscador=setTimeout(this.HacerBusquedaRol,360)
                }
            },
            HacerBusquedaUsuario(){
                if(this.campoBusqueda!='TipoRol'){
                    axios.get('/Users.buscar',{   params:{ usuario:this.UsuarioBuscar,campo:this.campoBusqueda}   })
                    .then(response => {
                        this.resultadosBusqueda=response.data;
                        this.$page.props.usuarios=this.resultadosBusqueda;
                    })
                    .catch(error => {
                        console.error('Error al hacer la busqueda:', error);
                    });
                }
            },
            HacerBusquedaRol(){
                axios.get('/Roles.buscar',{   params:{ Rol:this.RolBuscar,campo:'name'}   })
                .then(response => {
                    this.resultadosBusqueda=response.data;
                    this.$page.props.roles=this.resultadosBusqueda;
                })
                .catch(error => {
                    console.error('Error al hacer la busqueda:', error);
                });
            },
            EliminarDestinatario(posicion){
                this.NuevoAviso.UsuariosSeleccionados.splice(posicion, 1);
            },
            EliminarDestinatarioRol(posicion){
                this.NuevoAviso.RolesSeleccionados.splice(posicion, 1);
            },
            ComprobarCampos(){
                var camposValidos=true;
                if(this.NuevoAviso.Titulo==''){
                    this.mensajeTitulo=true;
                    camposValidos=false;
                }
                else{
                    this.mensajeTitulo=false;
                }
                if(this.NuevoAviso.Descripcion==''){
                    this.mensajeDescripcion=true;
                    camposValidos=false;
                }
                else{
                    this.mensajeDescripcion=false;
                }
                return camposValidos;
            },
            //Funcion que redirige a ruta para crear aviso
            async crearAviso(){
                try{
                    if(this.ComprobarCampos()==true){
                        const response=await this.$inertia.post(route('Avisos.store'),this.NuevoAviso)
                        this.hideElement()
                    }
                }catch (error) {
                    console.error(error);
                }
            },
            showElement() {
                this.isVisible = true;
            },
            hideElement() {
            this.isVisible = false;
            },
        }
    };
</script>


