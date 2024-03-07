<template>
    <Head title="Personal" />
    <AuthenticatedLayout>
    <template #header>
            Lista del Personal
    </template>

    <!--Filtro estatus-->
    <h3 class="text-m text-gray-900 dark:text-white ml-1 inline-flex w-full mb-1">
        <div class="w-3/4">
            Filtrar por estatus:
            <input type="radio" class="form-radio text-[#0284c7] bg-white shadow-lg  border-[#014E82]" value="Todos" name="Campos" v-model="FiltroBusqueda" required >Todos
            <input type="radio" class="form-radio text-[#0284c7] bg-white shadow-lg  border-[#014E82]" value="Activos" name="Campos" v-model="FiltroBusqueda" required >Activos
            <input type="radio" class="form-radio text-[#0284c7] bg-white shadow-lg  border-[#014E82]" value="Bajas" name="Campos" v-model="FiltroBusqueda" required> Bajas
        </div>
    </h3>
    <!--Seccion de buscador-->
    <div class="inline-flex w-full" >
        <!--Barra de busqueda-->
        <div class="relative text-gray-700 focus-within:text-gray-700  dark:focus-within:text-slate-200">
            <input
            class=" border-gray-100 dark:border-gray-500 bg-white dark:bg-slate-700 dark:text-gray-200 h-10 px-4 pr-20 rounded-lg text-sm focus:outline-none"
                type="text"
                placeholder="Buscar..."
                v-model="PersonalBuscar"
                @keyup="contarTiempo"
            />
        </div>
        <!--Filtro para cambiar campo de busqueda-->
        <div class="relative inline-block text-left pl-3 align-top">
            <div>
                <button type="button"  @click="MostrarOpcionesFiltro" class="inline-flex justify-center w-full rounded-md border border-gray-300 dark:border-slate-500 shadow-sm px-4 py-2 bg-white dark:bg-slate-700  text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 focus:outline-none focus:ring focus:[#014E82] active:bg-gray-200" id="dropdown-menu-button" aria-haspopup="true" aria-expanded="true">
                <span class="pr-2"> <i class="fa-solid fa-filter"></i>  </span>{{ campoBusquedaVer }}
                <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M9.293 5.293a1 1 0 011.414 0l5 5a1 1 0 01-1.414 1.414L10 7.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 010 0z" clip-rule="evenodd" />
                </svg>
                </button>
            </div>

            <div v-if="MostrarFiltro" class="z-50 origin-top-right absolute right-0 mt-2 w-32 mb-6 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5" role="menu" aria-orientation="vertical" aria-labelledby="dropdown-menu-button" tabindex="-1">

                <div class="py-1 dark:bg-slate-700 dark:hover:bg-slate-500 " role="menuitem" tabindex="-1" id="dropdown-menu-item-1" href="#">
                <span @click="SeleccionarCampo('Nombre','Nombre')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-slate-500 dark:text-gray-200">Nombre</span>
                </div>

                <div class="py-1 dark:bg-slate-700 dark:hover:bg-slate-500 " role="menuitem" tabindex="-1" id="dropdown-menu-item-2" href="#">
                <span @click="SeleccionarCampo('RFC','RFC')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-slate-500 dark:text-gray-200">RFC</span>
                </div>

            </div>
        </div>

        <div class="w-full inline-flex">
            <!-- <button :type="type" @click="VerificarUsuario()" class="ml-auto  rounded-md bg-[#014E82] px-6 py-2.5 mb-4 text-center text-sm text-white hover:bg-[#0284c7]"  :class="{'ml-auto rounded-md bg-slate-500 opacity-30 px-6 py-2.5 mb-4 text-center text-sm text-gray-500 hover:bg-gray-300 cursor-not-allowed' : personalSeleccionado==0}" :disabled="personalSeleccionado==0"
            v-if="$page.props.user.permissions.includes('Asignar cuentas de usuarios al personal')">
                Asignar cuenta de usuario
            </button> -->
            <Link :href="route('Personal.create')"
             class="h-10 ml-3 rounded-md bg-[#014E82] px-6 py-2.5 mb-4 text-center text-sm text-white
             hover:bg-[#0284c7] "
            v-if="$page.props.user.roles.includes('Recursos Humanos')"
            v-tippy="{
                content:'Agregar un nuevo personal',
                placement: 'top' ,
                arrow: true,
                arrowType: 'MyArrow',
                theme: 'MiThemeBlue'
            }">
                Nuevo
            </Link>

            <button :type="type" @click="VerificarPlaza()"
            class="h-10 ml-3 rounded-md bg-[#014E82] px-6 py-2.5 mb-4 text-center text-sm text-white
             hover:bg-[#0284c7]"  :class="{'ml-3 rounded-md bg-slate-500 opacity-30 px-6 py-2.5 mb-4 text-center text-sm text-gray-500 hover:bg-gray-300 cursor-not-allowed' : personalSeleccionado==0}" :disabled="personalSeleccionado==0"
            v-if="$page.props.user.roles.includes('Recursos Humanos')"
            v-tippy="{
                content:'Agregar plaza al personal',
                placement: 'top' ,
                arrow: true,
                arrowType: 'MyArrow',
                theme: 'MiThemeBlue'
            }">
                Agregar plaza
            </button>
        </div>
    </div>

    <!-- Capa oscura -->
    <div :class="{ hidden: !isVisible }" class="fixed inset-0 bg-black opacity-50">
    </div>

    <!--MODAL PARA ELEGIR UN PERIODO PARA ASIGNAR VIGENCIA-->
    <div id="modalContainer">
        <!-- Main modal -->
        <div :class="{ hidden: !isVisible } " >
            <div id="defaultModal" tabindex="-1" aria-hidden="true"  class="fixed inset-0 flex items-center justify-center z-50">
                <div class="relative w-full max-w-2xl max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">

                        <!-- Modal header -->
                        <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                Elegir periodo
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
                            <form @submit.prevent="cambiarVigencia()"  class="w-full max-w-lg">
                                <div class="flex flex-wrap -mx-3 mb-6">

                                    <div class="w-full md:w-full px-3 mb-2 md:mb-0">
                                        <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-4" for="grid-first-name">
                                                Elige un periodo para establecer la vigencia del personal
                                        </label>

                                        <select class="dark:bg-slate-700 dark:text-slate-200 rounded-sm " v-model="periodoSeleccionado">
                                            <option
                                                v-for="periodo in periodos"
                                                :key="periodo.id"
                                                :value="periodo.id"
                                            >
                                                {{ periodo.mesInicio }} {{ periodo.AñoInicio }}-{{ periodo.mesTermino }} {{ periodo.AñoTermino }}

                                            </option>
                                        </select>

                                    </div>
                                </div>
                                <!-- Modal footer -->
                                <div class="flex items-center pt-5 pr-5 pb-5 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-500 br-4">
                                    <button type="submit" class="text-white bg-[#014E82] hover:bg-[#0284c7] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Cambiar vigencia</button>
                                    <button @click="hideElement" data-modal-hide="defaultModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Cancelar</button>
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
    :class="{ 'bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-1 mb-3': tipoMensaje == 'Exitoso', 'bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-3 mb-3': tipoMensaje == 'Error' }">
        <strong class="font-bold" v-if="tipoMensaje=='Exitoso'">Éxito:</strong>
        <strong class="font-bold" v-if="tipoMensaje=='Error'">Érror:</strong>
        <span class="block sm:inline">{{ mensaje}}</span>
    </div>
    <!--TABLA PERSONAL-->
    <div class="inline-block min-w-full overflow-hidden rounded-lg shadow">
        <table class="w-full whitespace-no-wrap">
            <thead>
                <tr class="border-2 dark:border-slate-700 border-gray-300 bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                    <th class="border-b-2 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200">

                    </th>
                    <th class="border-b-2 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200">
                        RFC
                    </th>
                    <th class="border-b-2 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200">
                        Nombre
                    </th>
                    <th class="border-b-2 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200">
                        Departamento
                    </th>
                    <th class="border-b-2 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200">
                        Cuenta <br>
                        asignada
                    </th>
                    <th class="border-b-2 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200">
                        Plaza asignada
                    </th>
                    <th class="border-b-2 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200">
                        Estatus
                    </th>
                    <th class="border-b-2 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200"
                    v-if="$page.props.user.roles.includes('Recursos Humanos')">
                        Opciones
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(persona,index) in personal" v-bind:id="`fila${persona.id}`"  class="text-gray-700"
                >
                    <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-3 py-5 text-xs ">
                        <input v-if="persona.Estatus=='A'" type="radio" name="Persona" :value="persona" v-model="personalSeleccionado" >
                    </td>

                    <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-3 py-5 text-xs ">
                        <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap">{{ persona.RFC }}</p>
                    </td>

                    <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-3 py-5 text-xs">
                        <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap">{{ persona.Nombre }} {{ persona.ApellidoP }} {{ persona.ApellidoM }}</p>
                    </td>

                    <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-3 py-5 text-xs ">
                        <span v-for="departamento in departamentos">
                            <p v-if="departamento.id==persona.idDepAdscripcion" class="text-gray-900 dark:text-gray-200 whitespace-no-wrap">
                                {{ departamento.Nombre }}
                            </p>
                        </span>
                    </td>

                    <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-3 py-5 text-xs whitespace-no-wrap">
                        <p v-if="persona.idUsuario==null" class="text-gray-900 dark:text-gray-200 whitespace-no-wrap">SIN CUENTA ASIGNADA</p>

                        <p v-for="usuario in usuarios" class="text-gray-900 dark:text-gray-200 whitespace-no-wrap" >
                            <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap"
                            v-if="usuario.id==persona.idUsuario">
                            {{ usuario.email }}
                            </p>
                        </p>
                    </td>

                    <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-3 py-5 text-xs">
                        <p v-if="persona.idPlaza==null" class="text-gray-900 dark:text-gray-200 whitespace-no-wrap">SIN PLAZA ASIGNADA</p>
                        <span v-for="plaza in plazas">
                            <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap"
                            v-if="plaza.id==persona.idPlaza">

                            <span v-for="categoria in categorias">

                                <p v-if="categoria.id==plaza.idCategoria" class="text-gray-900 dark:text-gray-200 whitespace-no-wrap">
                                    {{ categoria.Clave }}-{{ categoria.Descripcion }}
                                </p>
                            </span>

                            </p>
                        </span>
                    </td>
                    <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-5 py-5 text-xs"
                    v-if="$page.props.user.roles.includes('Recursos Humanos')">
                        <strong class="text-[#dc2626] whitespace-no-wrap" v-if="persona.Estatus=='B'">

                            <span v-for="estatusActual in EstatusEmpleado">
                                <span v-if="estatusActual.id==persona.EstatusEmpleado">
                                    {{ estatusActual.Descripcion }}
                                </span>
                            </span>

                        </strong>

                        <strong class="text-[#2f9e56] whitespace-no-wrap" v-if="persona.Estatus=='A'">
                            <span v-for="estatusActual in EstatusEmpleado">
                                <span v-if="estatusActual.id==persona.EstatusEmpleado">
                                    {{ estatusActual.Descripcion }}
                                </span>
                            </span>
                        </strong>
                    </td>


                    <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-6 py-5 text-sm"
                    v-if="$page.props.user.roles.includes('Recursos Humanos')">


                        <Link :href="route('Personal.edit',persona.id)" class="p-3 rounded-md bg-[#014E82] mx-2 inline-flex mb-2 text-white "
                        v-if="$page.props.user.roles.includes('Recursos Humanos')"
                        v-tippy="{
                            content:'Editar informacion del personal',
                            placement: 'top' ,
                            arrow: true,
                            arrowType: 'MyArrow',
                            theme: 'MiThemeBlue'
                        }">
                            <i class="fa-solid fa-pen text-white"></i>
                        </Link>

                        <button @click="showElement(persona.id)" class="p-3 rounded-md bg-[#FFD200]   mx-2 inline-flex mb-2 text-white "
                        v-if="$page.props.user.roles.includes('Recursos Humanos') && persona.Estatus=='A'"
                        v-tippy="{
                            content:'Modificar vigencia de contratacion',
                            placement: 'top' ,
                            arrow: true,
                            arrowType: 'MyArrow',
                            theme: 'MiThemeYellow'
                        }">
                            <strong class="inline-flex"> <i class="fa-solid fa-business-time pt-1 pr-1"></i>Vigencia</strong>
                        </button>
                    </td>

                </tr>
            </tbody>

        </table>
    </div>

    <div v-if="personal==''" class=" text-xl w-full mt-14 text-center">
        <p class="pl-5 dark:text-white">No hay información disponible</p>
    </div>
    <!-- Capa oscura -->
    <div :class="{ hidden: !isvisibleAsignacion }" class="fixed inset-0 bg-black opacity-50">
    </div>
    <!--Seccion de botones nuevo y agregar plaza-->
    <div id="modalContainer">
        <!-- Main modal -->
        <div :class="{ hidden: !isvisibleAsignacion }">
            <div id="defaultModal" tabindex="-1" aria-hidden="true"  class="fixed inset-0 flex items-center justify-center z-50">
                <div class="relative w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white" v-if="contenidoModal=='Plaza'">
                            Agregar Plaza a personal
                        </h3>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white" v-if="contenidoModal=='Usuario'">
                            Agregar cuenta a personal
                        </h3>
                        <button type="button" @click="hideAsignacion" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-6 space-y-6">
                        <form @submit.prevent="AsignarPersonal(contenidoModal)"  class="w-full " >
                            <div class="flex-wrap -mx-3 mb-6 overflow-auto">

                                <label class="md:w-5/6 block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2 pl-4 " for="grid-last-name">
                                        <p class="mb-2">Nombre del personal</p>
                                        <input id="Capacidad" :value="`${personalSeleccionado.Nombre} ${personalSeleccionado.ApellidoP} ${personalSeleccionado.ApellidoM}`" readonly  class=" appearance-none block w-full bg-gray-200 dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"  type="text" placeholder="0">
                                        <input id="Capacidad" v-model="InfoAsignacion.idPersonal" readonly  class=" hidden appearance-none w-full bg-gray-200 dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"  type="text" placeholder="0">
                                </label>

                                <label v-if="contenidoModal=='Plaza'" class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2 pl-4" for="grid-last-name">
                                        Plazas disponibles
                                </label>

                                <label v-if="contenidoModal=='Usuario'" class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2 pl-4" for="grid-last-name">
                                        Cuentas disponibles
                                </label>

                                <select v-if="contenidoModal=='Plaza'" class=" ml-4 md:w-5/6 appearance-none block w-full bg-gray-200 dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" name="categorias" v-model="InfoAsignacion.idPlaza" required>

                                <option :value='0'> Seleccione una plaza </option>
                                    <option
                                        v-for="(plaza,index) in plazasDisponibles"
                                        :key="plaza.id"
                                        :value="plaza.id"
                                    >
                                        <span v-for="categoria in categorias">
                                            <p v-if="categoria.id==plaza.idCategoria">
                                                {{ categoria.Clave }}-{{ categoria.Descripcion }}
                                            </p>
                                        </span>
                                    </option>
                                </select>

                                <select v-if="contenidoModal=='Usuario'" class=" ml-4 md:w-5/6 appearance-none block w-full bg-gray-200 dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" name="categorias" v-model="InfoAsignacion.idCuenta" required>
                                    <option :value='0'> Seleccione una cuenta </option>
                                    <option
                                        v-for="(usuario,index) in usuariosDisponibles"
                                        :key="usuario.id"
                                        :value="usuario.id"
                                    >
                                            <p>{{ usuario.email }}</p>
                                    </option>
                                </select>
                            </div>
                            <!-- Modal footer -->
                            <div class="flex items-center px-6 py-2 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                                <button type="submit" class="text-white bg-[#014E82] hover:bg-[#0284c7] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    Asignar
                                </button>
                                <button @click="hideAsignacion" data-modal-hide="defaultModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                    Cancelar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <!-- Capa oscura -->
        <div :class="{ hidden: !isvisiblePregunta }" class="fixed inset-0 bg-black opacity-50">
        </div>

        <div :class="{ hidden: !isvisiblePregunta}"  tabindex="-1" class="fixed inset-0 flex items-center justify-center z-50">
            <div class="relative w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <button @click="hidePregunta" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="p-6 text-center">
                        <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400" v-if="contenidoModal=='Plaza'">
                            El personal {{ personalSeleccionado.Nombre }} {{ personalSeleccionado.ApellidoP }} {{ personalSeleccionado.ApellidoM}} ya tiene asignada la plaza:

                            <span v-for="plaza in plazas">
                                <span v-if="plaza.id==personalSeleccionado.idPlaza">

                                    <span v-for="categoria in categorias">
                                        <span v-if="plaza.idCategoria==categoria.id">
                                            {{ categoria.Clave }}-{{ categoria.Descripcion }}
                                        </span>
                                    </span>

                                </span>
                            </span>

                            <p>¿Que desea realizar?</p>
                        </h3>

                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400" v-if="contenidoModal=='Usuario'">
                            El personal {{ personalSeleccionado.Nombre }} {{ personalSeleccionado.ApellidoP }} {{ personalSeleccionado.ApellidoM}} ya tiene asignada una cuenta:

                            <span v-for="usuario in usuarios">
                                <span v-if="usuario.id==personalSeleccionado.idUsuario">
                                    {{ usuario.email }}
                                </span>
                            </span>

                            <p>¿Que desea realizar?</p>
                        </h3>

                        <div v-if="contenidoModal=='Usuario'" @click="showAsignacion" type="button" class="text-white bg-[#014E82] hover:bg-[#0284c7] focus:ring-4 focus:outline-none focus:bg-[#0284c7] dark:focus:bg-[#0284c7] font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                            Asignar una nueva cuenta
                        </div>

                        <div v-if="contenidoModal=='Plaza'" @click="showAsignacion" type="button" class="text-white bg-[#014E82] hover:bg-[#0284c7] focus:ring-4 focus:outline-none focus:bg-[#0284c7] dark:focus:bg-[#0284c7] font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                            Asignar una nueva plaza
                        </div>

                        <button @click="hidePregunta" data-modal-hide="popup-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Cancelar accion</button>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <!--Seccion de paginacion-->
    <nav aria-label="Page navigation example mt-4" v-if="personal!=''">
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
            Link,
        },
        directives: {
            tippy: directive,
        },
        mounted() {

            this.seleccionado=false
            this.Activar=this.$page.props.filas
            this.Activar.push('false')
            this.FiltroBusqueda=this.$page.props.Filtro;

            if(this.Paginator.next_page_url!=null){
                this.urlPaginacion = this.Paginator.next_page_url.slice(0, -1);
            }
            else if(this.Paginator.prev_page_url!=null){
                this.urlPaginacion = this.Paginator.prev_page_url.slice(0, -1);
            }
            this.cantidadPaginas=this.Paginator.last_page
            this.registrosCompletos=this.$page.props.personal
        },
        props:{
            personal:Array,
            plazas:Array,
            plazasDisponibles:Array,
            usuarios:Array,
            usuariosDisponibles:Array,
            categorias:Array,
            filas:Array,
            Paginator:Array,
            Filtro:'',
            EstatusEmpleado:Array,
            departamentos:Array,
            periodos:Array,
            mensaje:String,
            tipoMensaje:String,
        },
        data() {
            return {
                registrosCompletos:Array,
                urlPaginacion:'',

                infoEditar: {
                    NombreAula:'',
                    Capacidad:0,
                    Ubicacion:''
                },
                isVisible: false,
                isvisibleAsignacion:false,
                isvisiblePregunta:false,

                idBorrarSeleccionado:0,

                PersonalBuscar:'',
                campoBusqueda:'Nombre',
                campoBusquedaVer:'Nombre',
                FiltroBusqueda:'',

                NuevoPersonal:{
                    RFC:'',
                    Nombre:'',
                    ApellidoP:'',
                    ApellidoM:'',
                    CURP:'',
                    FechaNacimiento:'',
                    numTarjeta:0,
                    Direccion:'',
                    Telefono:'',
                    CorreoPers:'',
                    Estatus:'',
                    Estudio1:'',
                    Estudio2:'',
                    Estudio3:'',
                    idPlaza:0,
                    idUsuario:0,
                },

                InfoAsignacion:{
                    idPersonal:'',
                    idPlaza:'0',
                    idCuenta:'0'
                },
                contenidoModal:'',
                Activar:[],
                personalSeleccionado:0,
                periodoSeleccionado:0,
                DepartamentoSeleccionado:0,
                seleccionado:false,

                MostrarFiltro:false,
                EstatusActivo:'',
                FiltroDep:Array,

                setTimeoutBuscador:'',
            }
        },
        //Escuchar cambios
        watch: {
            FiltroBusqueda: function() {
                this.filtroEstatus();
            },
        },

        methods: {
            //METODO PARA HACER FILTRO SEGUN ESTATUS
            async filtroEstatus(){

                if(this.FiltroBusqueda=='Todos' && this.$page.props.Filtro!='Todos'){
                    this.$inertia.get(route('Personal.index'))
                    this.$page.props.personal=this.registrosCompletos;
                }

                if(this.FiltroBusqueda=='Activos' && this.$page.props.Filtro!='Activos' ){
                    this.$inertia.get(route('Personal.Activos'))
                    this.$page.props.personal=this.registrosCompletos;
                }

                if(this.FiltroBusqueda=='Bajas' && this.$page.props.Filtro!='Bajas'){
                    this.$inertia.get(route('Personal.Bajas'))
                    this.$page.props.personal=this.registrosCompletos;
                }
            },
            //Metodo que redirige a ruta para crear un personal
            AltaPersonal(){
                this.$inertia.post(route('Personal.create'));
            },
            //Metodo que redirige a ruta para definir vigencia
            cambiarVigencia(){
                const idPersonal=this.personalSeleccionado
                const idPeriodo=this.periodoSeleccionado
                this.$inertia.get(route('VigenciaPersonal.edit',{idPersonal,idPeriodo}))
            },
            //Metodo que muestre el filtro para cambiar campo de busuqeda
            MostrarOpcionesFiltro(){
                if(this.MostrarFiltro==true){
                    this.MostrarFiltro=false
                }
                else{
                    this.MostrarFiltro=true
                }
            },
            //Metodo que permite cambiar el campo de busqueda
            SeleccionarCampo(campo,campoVer){
                this.campoBusqueda=campo
                this.campoBusquedaVer=campoVer
                this.MostrarFiltro=false
            },
            //Metodo que cuenta el tiempo al escribir del usuario antes de enviar peticion para hacer busqueda
            contarTiempo(){
                this.$page.props.mensaje=null
                clearTimeout(this.setTimeoutBuscador);
                this.setTimeoutBuscador=setTimeout(this.HacerBusqueda,360)
            },
            //Metodo para hacer busqueda de un personal
            async HacerBusqueda(){
                console.log(this.PersonalBuscar);
                if(this.PersonalBuscar==''){
                    this.$page.props.personal=this.registrosCompletos;
                }
                else{
                    axios.get('Personal.buscar',{   params:{ personal:this.PersonalBuscar,campo:this.campoBusqueda,Filtro:this.FiltroBusqueda,Departamento:this.DepartamentoSeleccionado}   })
                    .then(response => {
                        this.resultadosBusqueda=response.data;
                        this.$page.props.personal=this.resultadosBusqueda;
                    })
                    .catch(error => {
                        console.error('Error al hacer la busqueda:', error);
                    });
                }
                this.personalSeleccionado=0;
            },
            //Funcion que abre modal para la asignacion de una plaza
            showAsignacion() {
                this.$page.props.mensaje=null
                this.isvisiblePregunta=false;
                this.isvisibleAsignacion = true;
            },
            //Funcion que cierra la modal para la asignacion de una plaza
            hideAsignacion() {
                this.isvisibleAsignacion = false;
            },
            //Metodo para abrir modal de vigencia
            showElement(idPersonal){
                this.personalSeleccionado=idPersonal
                this.$page.props.mensaje=null;
                this.isVisible=true;
            },
            //Metodo para cerrar modal de vigencia
            hideElement(){
                this.isVisible=false;
            },
            //Metodo para abrir modal de pregunta cuando el personal seleccionado ya tenga una plaza asignada
            showPregunta(){
                this.isvisiblePregunta=true;
            },
            //Metodo para cerrar modal de pregunta cuando el personal seleccionado ya tenga una plaza asignada
            hidePregunta(){
                this.isvisiblePregunta=false;
            },

            VerificarPlaza(){
                this.contenidoModal='Plaza';
                if(this.personalSeleccionado.idPlaza!=null){
                    //Plaza asignada
                    this.InfoAsignacion.idPersonal=this.personalSeleccionado.id
                    this.showPregunta()
                }
                else{
                    //Plaza aun sin asignar
                    this.InfoAsignacion.idPersonal=this.personalSeleccionado.id
                    this.showAsignacion()
                }
            },

            VerificarUsuario(){
                this.contenidoModal='Usuario';
                if(this.personalSeleccionado.idUsuario!=null){
                    //Personal ya tiene cuenta
                    this.InfoAsignacion.idPersonal=this.personalSeleccionado.id
                    this.showPregunta()
                }
                else{
                    //Personal aun no tiene cuenta
                    this.InfoAsignacion.idPersonal=this.personalSeleccionado.id
                    this.showAsignacion()
                }
            },
            //Metodo que redirige a ruta para asignar una plaza o cuenta al personal
            async AsignarPersonal(contenido){
                if(contenido=='Plaza'){
                    await this.$inertia.post(route('Personal.asignarPlaza'),this.InfoAsignacion)
                }
                if(contenido=='Usuario'){
                    await this.$inertia.post(route('Personal.asignarCuenta'),this.InfoAsignacion)
                }
                this.hideAsignacion()
            }
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
    .tippy-arrow[data-theme~='MyArrow'] {
        border-color: red;
    }
</style>






