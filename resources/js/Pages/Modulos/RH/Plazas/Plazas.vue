<template>
    <Head title="Plazas" />
    <AuthenticatedLayout>
        <template #header>
                Lista de Plazas
        </template>
        <!--Filtro para plazas asignadas y sin asignar-->
        <h3 class="text-m text-gray-900 dark:text-white py-1 ml-1">
                Filtrar por estatus:
                <input type="radio" value="Todos" name="Campos" v-model="FiltroBusqueda" required > Todos
                <input type="radio" value="Asignadas" name="Campos" v-model="FiltroBusqueda" required> Asignadas
                <input type="radio" value="NoAsignadas" name="Campos" v-model="FiltroBusqueda" required> Sin asignar
        </h3>
        <!--Seccion de busqueda-->
        <div class="inline-flex w-full" >
            <!--Barra de busqueda-->
            <div class="relative text-gray-700 focus-within:text-gray-700  dark:focus-within:text-slate-200 pb-4">
                <input
                class=" border-gray-100 dark:border-gray-500 bg-white dark:bg-slate-700 dark:text-gray-200 h-10 px-4 pr-20 rounded-lg text-sm focus:outline-none "
                    type="text"
                    :placeholder="'Buscar por ' + campoBusquedaVer"
                    v-model="PlazaBuscar"
                    @keyup="contarTiempo"
                />
            </div>
            <!--Filtro para seleccionar campo de busqueda-->
            <div class="relative inline-block text-left pl-3 align-top w-3/12">
                <div>
                    <button type="button" @click="MostrarOpcionesFiltro" class="inline-flex justify-center w-full rounded-md border mb-2
                     border-gray-300 dark:border-slate-500 shadow-sm px-4 py-2 bg-white dark:bg-slate-700  text-sm font-medium text-gray-700
                      dark:text-gray-200 hover:bg-gray-50 focus:outline-none focus:ring focus:[#014E82] active:bg-gray-200" id="dropdown-menu-button"
                      aria-haspopup="true" aria-expanded="true">
                    <span class="pr-2"> <i class="fa-solid fa-filter"></i>  </span>
                    <div class="w-full">
                        {{ campoBusquedaVer }}
                    </div>
                    <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M9.293 5.293a1 1 0 011.414 0l5 5a1 1 0 01-1.414 1.414L10 7.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 010 0z" clip-rule="evenodd" />
                    </svg>
                    </button>
                </div>

                <div v-if="MostrarFiltro" class="z-50 origin-top-right absolute right-0 mt-2 w-32 mb-6 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5" role="menu" aria-orientation="vertical" aria-labelledby="dropdown-menu-button" tabindex="-1">
                    <div class="py-1 dark:bg-slate-700 dark:hover:bg-slate-500 " role="menuitem" tabindex="-1" id="dropdown-menu-item-1" href="#">
                    <span @click="SeleccionarCampo('categoria','Categoria')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-slate-500 dark:text-gray-200">Categoria</span>
                    </div>

                    <div class="py-1 dark:bg-slate-700 dark:hover:bg-slate-500 " role="menuitem" tabindex="-1" id="dropdown-menu-item-2" href="#">
                    <span @click="SeleccionarCampo('diagonal','Diagonal')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-slate-500 dark:text-gray-200">Diagonal</span>
                    </div>

                    <div class="py-1 dark:bg-slate-700 dark:hover:bg-slate-500 " role="menuitem" tabindex="-1" id="dropdown-menu-item-2" href="#">
                    <span @click="SeleccionarCampo('unidad','Unidad')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-slate-500 dark:text-gray-200">Unidad</span>
                    </div>

                    <div class="py-1 dark:bg-slate-700 dark:hover:bg-slate-500 " role="menuitem" tabindex="-1" id="dropdown-menu-item-2" href="#">
                    <span @click="SeleccionarCampo('subunidad','Subunidad')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-slate-500 dark:text-gray-200">SubUnidad</span>
                    </div>

                    <div class="py-1 dark:bg-slate-700 dark:hover:bg-slate-500 " role="menuitem" tabindex="-1" id="dropdown-menu-item-2" href="#">
                    <span @click="SeleccionarCampo('horas','Horas')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-slate-500 dark:text-gray-200">Horas</span>
                    </div>

                    <div class="py-1 dark:bg-slate-700 dark:hover:bg-slate-500 " role="menuitem" tabindex="-1" id="dropdown-menu-item-2" href="#">
                    <span @click="SeleccionarCampo('TipoMovimiento','Tipo de movimiento')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-slate-500 dark:text-gray-200">Tipo de movimiento</span>
                    </div>
                </div>
            </div>
            <!--Boton de nuevo-->
            <div v-if="$page.props.user.roles.includes('Recursos Humanos')" class="w-full ">
                <button :type="type" @click="showElement"
                class="ml-20 rounded-md bg-[#014E82] px-6 py-2.5 mb-4 text-center text-sm text-white hover:bg-[#0284c7]"
                v-tippy="{
                content:'Agregar plaza',
                placement: 'top' ,
                arrow: true,
                arrowType: 'MyArrow',
                theme: 'MiThemeBlue'
                }"
                >
                    Nuevo
                </button>
            </div>
        </div>
        <!-- Capa oscura -->
        <div :class="{ hidden: !isvisibleDelete }" class="fixed inset-0 bg-black opacity-50">
        </div>
        <!-- Capa oscura -->
        <div :class="{ hidden: !isVisible }" class="fixed inset-0 bg-black opacity-50">
        </div>
        <!--Modal para crear una nueva plaza-->
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
                                    Agregar Plaza
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
                                <form @submit.prevent="crearPlaza"  class="w-full max-w-lg">
                                    <div class="flex flex-wrap -mx-3 mb-6">

                                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">

                                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-last-name">
                                                Categoría de la plaza
                                            </label>

                                            <select class="md:w-6/7 appearance-none block w-full bg-gray-200 dark:bg-slate-600 text-gray-700 dark:text-gray-200 border
                                            border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white"
                                            name="categorias" v-model="NuevaPlaza.idCategoria" required>

                                            <option :value="0"> Seleccione categoria </option>

                                            <option
                                                v-for="(categoria,index) in categorias"
                                                :key="categoria.id"
                                                :value="categoria.id"
                                            >

                                                {{ categoria.Clave }}-{{ categoria.Descripcion }}
                                            </option>
                                            </select>

                                            <p v-if="mensajeCategoria!=null" class="text-sm text-red-600 mb-1">Por favor selecciona una categoria</p>


                                        </div>

                                        <div class="w-full md:w-1/3 px-3">

                                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2"  for="grid-last-name">
                                                Unidad
                                            </label>

                                            <select name="aplicaciones" class="md:w-2/3 appearance-none block w-full bg-gray-200 dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" v-model="NuevaPlaza.unidad" @change="PonerSubunidad(NuevaPlaza.unidad)" required>

                                                <option :value="14">
                                                14
                                                </option>
                                                <option :value="18">
                                                18
                                                </option>
                                                <option :value="68">
                                                68
                                                </option>

                                            </select>

                                        </div>

                                        <div class="w-full md:w-1/2 px-3">
                                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2"  for="grid-last-name">
                                                Subunidad
                                            </label>
                                            <select class="md:w-3/4 appearance-none block w-full bg-gray-200 dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" name="aplicaciones" v-model="NuevaPlaza.subunidad" required>
                                                <option :value='1'>
                                                01
                                                </option>
                                                <option :value='2'>
                                                02
                                                </option>
                                                <option :value='14'>
                                                14
                                                </option>
                                            </select>

                                        </div>

                                        <div class="w-full md:w-1/2 px-3">
                                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2"  for="grid-last-name">
                                                Tipo de Movimiento
                                            </label>
                                            <select class="md:w-3/4 appearance-none block w-full bg-gray-200 dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" name="aplicaciones" v-model="NuevaPlaza.TipoMovimiento" required>
                                                <option :value='10'>
                                                10
                                                </option>
                                                <option :value='20'>
                                                20
                                                </option>
                                                <option :value='95'>
                                                95
                                                </option>
                                                <option :value='97'>
                                                97
                                                </option>
                                            </select>

                                        </div>

                                        <div class="w-full md:w-1/2 px-3">
                                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2"  for="grid-last-name">
                                                Diagonal
                                            </label>
                                            <input id="diagonal" v-model="NuevaPlaza.diagonal"  class="appearance-none block w-full bg-gray-200 dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"  type="text" placeholder="Diagonal" required>
                                        </div>

                                        <div class="w-full md:w-1/2 px-3">
                                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2"  for="grid-last-name">
                                                Horas a la semana
                                            </label>
                                            <input id="horas" v-model="NuevaPlaza.horas" class="appearance-none block w-full bg-gray-200 dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"  type="number" placeholder="0" required>
                                        </div>

                                        <!-- Modal footer -->
                                        <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                                            <button type="submit" class="text-white bg-[#014E82] hover:bg-[#0284c7] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Agregar</button>
                                            <button @click="hideElement" data-modal-hide="defaultModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Cancelar</button>
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
        :class="{ 'bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-1 mb-3': tipoMensaje == 'Exitoso', 'bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-3 mb-3': tipoMensaje == 'Error' }">
            <strong class="font-bold" v-if="tipoMensaje=='Exitoso'">Éxito:</strong>
            <strong class="font-bold" v-if="tipoMensaje=='Error'">Érror:</strong>
            <span class="block sm:inline">{{ mensaje}}</span>
        </div>
        <!--TABLA DE PLAZAS-->
        <div class="inline-block min-w-full overflow-hidden rounded-lg shadow">
            <table class="w-full whitespace-no-wrap">
                <!--Encabezados-->
                <thead>
                    <tr class="border-b bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500" >
                        <th class="border-b-2 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200">
                            Descripción categoría
                        </th>
                        <th class="border-b-2 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200">
                            Diagonal
                        </th>
                        <th class="border-b-2 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200">
                            Unidad
                        </th>
                        <th class="border-b-2 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200">
                            Subunidad
                        </th>
                        <th class="border-b-2 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200">
                            Horas a la semana
                        </th>
                        <th class="border-b-2 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200">
                            Tipo de movimiento
                        </th>
                        <th class="border-b-2 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200">
                            Estatus de la plaza
                        </th>
                        <th v-if="$page.props.user.roles.includes('Recursos Humanos')" class="border-b-2 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200">
                            Opciones
                        </th>
                    </tr>
                </thead>
                <!--FILAS-->
                <tbody>
                    <tr v-for="plaza in plazas" :key="plaza.id" class="text-gray-700">
                        <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-5 py-5 text-sm">
                            <div v-for="(categoria,index) in categorias">
                                <p v-if="plaza.idCategoria==categoria.id" class="text-gray-900 dark:text-gray-200 whitespace-no-wrap"> {{categoria.Clave}}-{{ categoria.Descripcion }}</p>
                            </div>
                        </td>

                        <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-5 py-5 text-sm">
                            <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap">{{ plaza.diagonal }}</p>
                        </td>

                        <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-5 py-5 text-sm">
                            <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap">{{ plaza.unidad }}</p>
                        </td>

                        <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-5 py-5 text-sm">
                            <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap">{{ plaza.subunidad }}</p>
                        </td>

                        <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-5 py-5 text-sm">
                            <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap">{{ plaza.horas }}</p>
                        </td>

                        <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-5 py-5 text-sm">
                            <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap">{{ plaza.TipoMovimiento }}</p>
                        </td>

                        <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-5 py-5 text-sm">
                            <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap" v-if="plaza.estatus==0">
                                SIN ASIGNAR
                            </p>

                            <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap" v-if="plaza.estatus==1">
                                ASIGNADA
                            </p>
                        </td>

                        <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-5 py-5 text-sm"
                        v-if="$page.props.user.roles.includes('Recursos Humanos')">

                            <div v-if="$page.props.user.roles.includes('Recursos Humanos')">
                                <Link :href="route('Plazas.edit',plaza.id)"  class="p-3 rounded-md bg-[#014E82] mx-2 inline-flex mb-1"
                                v-tippy="{
                                    content:'Editar información de la plaza',
                                    placement: 'top' ,
                                    arrow: true,
                                    arrowType: 'MyArrow',
                                    theme: 'MiThemeBlue'
                                }">
                                    <i class="fa-solid fa-pen text-white"></i>
                                </Link>
                            </div>

                            <div v-if="$page.props.user.roles.includes('Recursos Humanos')">
                                <a type="button" @click="showDelete(plaza.id)" class="p-3 rounded-md bg-[#dc2626] mx-2 inline-flex mb-1"
                                v-tippy="{
                                    content:'Eliminar plaza',
                                    placement: 'top' ,
                                    arrow: true,
                                    arrowType: 'MyArrow',
                                    theme: 'MiThemeRed'
                                }">
                                    <i class="fa-solid fa-trash text-white"></i>
                                </a>
                            </div>

                            <div>
                                <div :class="{ hidden: !isvisibleDelete }" v-bind:id="`Modal${plaza.id}`" tabindex="-1" class="fixed inset-0 flex items-center justify-center z-50">
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
                                                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Esta seguro de eliminar esta plaza </h3>
                                                <Link @click="hideDelete" method="delete" :href="route('Plazas.destroy', idBorrarSeleccionado)" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
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
        <!--Seccion de paginado-->
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
            this.FiltroBusqueda=this.$page.props.Filtro;

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
            plazas:Array,
            categorias:Array,
            Paginator:Array,
            Filtro:'',
            mensaje: String,
            tipoMensaje:String,

        },
        data() {
            return {
                urlPaginacion:'',
                links:[
                    { label: "1", url: "/page/1", active: true },
                    { label: "2", url: "/page/2", active: false },
                    { label: "3", url: "/page/3", active: false },
                    { label: "4", url: "/page/4", active: false },
                ],

                campoBusqueda:'categoria',
                campoBusquedaVer:'Categoria',
                FiltroBusqueda:'',
                MostrarFiltro:false,
                setTimeoutBuscador:'',

                //Info para poder obtener los permisos del usuario
                items: [],
                userID:this.$page.props.auth.user.id, // Obtiene el ID del usuario
                ListaRoles:[],
                Rol:"",
                Permiso:"",
                decision:"",
                resultadosBusqueda:"",

                infoEditar: {
                    categoria:'',
                    horas:0,
                    estatus:''
                },
                isVisible: false,
                isvisibleDelete:false,

                idBorrarSeleccionado:0,

                PlazaBuscar:'',
                //Mensajes
                mensajeCategoria:null,
                mensajePlazaNueva:null,
                NuevaPlaza:{
                    idCategoria:0,
                    horas:0,
                    estatus:'',
                    diagonal:'',
                    unidad:'',
                    subunidad:'',
                    TipoMovimiento:0
                }
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

                    //axios.get('Personal');
                    this.$inertia.get(route('Plazas.index'))
                    //this.$page.props.plazas=this.registrosCompletos;
                }

                if(this.FiltroBusqueda=='Asignadas' && this.$page.props.Filtro!='Asignadas' ){
                    this.$inertia.get(route('Plazas.Asignadas'))
                    //this.$page.props.plazas=this.registrosCompletos;
                }

                if(this.FiltroBusqueda=='NoAsignadas' && this.$page.props.Filtro!='NoAsignadas'){
                    this.$inertia.get(route('Plazas.SinAsignar'))
                    //this.$page.props.plazas=this.registrosCompletos;
                }
            },

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
                //this.HacerBusqueda();
            },

            contarTiempo(){
                this.$page.props.mensaje=null
                clearTimeout(this.setTimeoutBuscador);
                this.setTimeoutBuscador=setTimeout(this.HacerBusqueda,360)
            },


            HacerBusqueda(){


                console.log(this.PlazaBuscar);

                axios.get('Plazas.buscar',{   params:{ plaza:this.PlazaBuscar,campo:this.campoBusqueda,Filtro:this.FiltroBusqueda}   })
                .then(response => {

                    this.resultadosBusqueda=response.data;
                    // console.log('RESULTADOS:');
                    // console.log(this.$page.props.plazas);

                    this.$page.props.plazas=this.resultadosBusqueda;
                })
                .catch(error => {
                    console.error('Error al hacer la busqueda:', error);
                });
            },

            async crearPlaza(){

                if(this.NuevaPlaza.idCategoria==0){
                    this.mensajeCategoria="Por favor ingresa una categoria";
                }
                else{
                    await this.$inertia.post(route('Plazas.store'),this.NuevaPlaza)
                    this.hideElement()
                    this.mensajePlazaNueva='Plaza registrada correctamente'
                }
            },

            showElement() {
                this.$page.props.mensaje=null
                this.isVisible = true;
            },
            hideElement() {
                this.isVisible = false;
                this.mensajeCategoria=null;
            },

            showDelete(id){

                this.idBorrarSeleccionado=id;

                this.isvisibleDelete = true;
            },
            hideDelete(){
                this.isvisibleDelete = false;
            },

            PonerSubunidad(unidad){
                console.log(unidad);

                if(unidad=='14'){
                    this.NuevaPlaza.subunidad='1';
                }
                else if(unidad=='18'){
                    this.NuevaPlaza.subunidad='2';
                }
                else if(unidad=='68'){
                    this.NuevaPlaza.subunidad='14';
                }
            },




        }
    };
</script>

<script setup>

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/vue3';
    import { Link } from '@inertiajs/vue3';
    import  Pagination from '@/Components/Pagination.vue';
    import { ref, computed } from 'vue';
    import 'tippy.js/themes/light.css';
    import 'tippy.js/dist/tippy.css';
    import 'tippy.js/animations/scale.css';
    import { directive } from 'vue-tippy';

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
    .tippy-arrow[data-theme~='MyArrow'] {
        border-color: red;
    }
</style>


