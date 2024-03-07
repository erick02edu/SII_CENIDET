<template>
    <Head title="Alumnos" />
    <AuthenticatedLayout>
    <template #header>
            Lista de alumnos
    </template>
    <!-- Capa oscura -->
    <div :class="{ hidden: !isVisibleImportacion }" class="fixed inset-0  bg-black opacity-50">
    </div>
    <!--Modal para realizar importacion de los datos-->
    <div id="modalContainer">
        <!-- Main modal -->
        <div :class="{ hidden: !isVisibleImportacion }">
            <div id="defaultModal" tabindex="-1" aria-hidden="true"  class="fixed inset-0 flex items-center justify-center z-50">
                <div class="relative w-full max-w-2xl max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
                        <!-- Modal header -->
                        <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    Pasos para realizar la importación
                                </h3>
                            <button type="button" @click="hideImportacion" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="px-6 py-3 space-y-6 w-full">
                            <div  class="w-full">

                                <label class=" w-full block text-gray-700 dark:text-gray-200  mb-2" for="grid-first-name">
                                    <strong>Paso {{ PasoActual+1 }}</strong> <br>
                                    <p class="text-sm">
                                        {{ pasos[PasoActual] }}
                                    </p>
                                </label>

                                <div class="flex flex-wrap  mb-2 ">
                                    <div class="w-full p-3 overflow-y-auto h-64 border rounded-lg border-gray-300 dark:border-gray-500">
                                        <img :src="ImagenesPasos[PasoActual]" class="w-full h-full" v-if="PasoActual!=3">

                                        <video v-if="PasoActual==3" autoplay loop>
                                            <source :src="ImagenesPasos[PasoActual]" type="video/mp4">
                                        </video>
                                    </div>
                                </div>

                                <div class="w-full mb-1 dark:text-white"></div>
                                <!-- Modal footer -->
                                <div class="flex items-center py-5 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-200">
                                    <button @click="AnteriorPaso" data-modal-hide="defaultModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                        Anterior
                                    </button>

                                    <button type="submit" @click="siguientePaso" v-if="PasoActual<3" class="text-white bg-[#014E82] hover:bg-[#0284c7] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        Siguiente
                                    </button>

                                    <div  v-if="PasoActual==3" >
                                        <input type="file" class="hidden " id="excelFileInput" ref="fileInput"
                                        accept=".xlsx, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                        @change="handleFileChange">

                                        <label for="excelFileInput"
                                        class="cursor-pointer flex items-center justify-center w-full px-3 py-2 bg-green-600 hover:bg-green-500  text-white rounded-md">
                                            Elegir Excel<i class="fas fa-file-excel mx-1"></i>
                                        </label>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Seccion de busqueda y botones-->
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
        <!--Filtro para cambiar campo de busqueda-->
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

        <!--Boton de nuevo para abrir modal y agregar a un alumno-->
        <div class="justyfy-end flex w-full">
            <button :type="type" @click="showElement" class=" ml-3 mr-2 rounded-md bg-[#014E82] px-6 py-2.5 mb-4 text-center text-sm text-white hover:bg-[#0284c7] "
            v-if="$page.props.user.roles.includes('Administrador')">
                Nuevo
            </button>
            <!--Boton de importar-->
            <div class="relative">

                <label for="excelFileInput" @click="showImportacion"
                class="cursor-pointer flex items-center justify-center w-full px-3 py-2 bg-green-500 text-white rounded-md">
                    <i class="fas fa-file-excel mx-1"></i> Importar
                </label>
            </div>
            <!--Mostrar nombre del archivo excel seleccionado-->
            <div v-if="NombreArchivo"
            class="dark:text-white text-xs text-center flex items-center justify-center pb-4 pl-2">
                {{ NombreArchivo }}
            </div>
        </div>
        <!--Boton para cargar datos del excel-->
        <div class="inline w-1/2 pt-1">
            <div :type="type"
            @click="ImportarDatos"
            class="rounded-md bg-red-500 px-3 py-2 ml-24 text-sm text-white hover:bg-red-400 "
            v-if="$page.props.user.roles.includes('Administrador') && NombreArchivo">
                <i class="fa-solid fa-file-arrow-down text-white pr-1"></i> Cargar
            </div>
        </div>
    </div>

    <!-- Capa oscura -->
    <div :class="{ hidden: !isVisible }" class="fixed inset-0 bg-black opacity-50">
    </div>

    <!--Modal para agregar un alumno-->
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
                                Agregar alumno
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
                            <form @submit.prevent="crearAlumno"  class="w-full ">
                                <div class="flex flex-wrap -mx-3 mb-6 overflow-auto">
                                    <div class="w-full md:w-1/2 px-3">
                                        <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-last-name">
                                            CURP
                                        </label>
                                        <input id="Capacidad"  maxlength="18" v-model="NuevoAlumno.curp" class="appearance-none block w-full bg-gray-200 dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white"
                                        type="text" placeholder="XXXXXXXXXXXXXXXXXX" required>
                                        <p v-if="MostrarmensajeCurp!=false" :class="{ 'text-sm text-green-500':exitoCURP, 'text-sm text-red-600':!exitoCURP }">{{ mensajeCurp }}</p>
                                    </div>

                                    <div class="w-full md:w-1/2 px-3">
                                        <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-last-name">
                                            Nombre
                                        </label>
                                        <input id="Capacidad" v-model="NuevoAlumno.Nombre" class="appearance-none block w-full bg-gray-200 dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                        type="text" placeholder="0" required>
                                    </div>

                                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                        <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-last-name">
                                            Apellido Paterno
                                        </label>
                                        <input id="NombreAula" v-model="NuevoAlumno.ApellidoP"  class="appearance-none block w-full bg-gray-200 dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                        type="text" placeholder="" required>
                                    </div>

                                    <div class="w-full md:w-1/2 px-3">
                                        <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-last-name">
                                            Apellido Materno
                                        </label>
                                        <input id="Capacidad" v-model="NuevoAlumno.ApellidoM" class="appearance-none block w-full bg-gray-200 dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                        type="text" placeholder="" required>
                                    </div>

                                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                        <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-last-name">
                                            Fecha de Nacimiento
                                        </label>
                                        <input id="NombreAula" v-model="NuevoAlumno.FechaNacimiento"  class="appearance-none block w-full bg-gray-200 dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                        type="date" placeholder="" required>
                                    </div>

                                    <div class="w-full md:w-1/2 px-3">
                                        <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-last-name">
                                            NO.CONTROL
                                        </label>
                                        <input id="Capacidad" v-model="NuevoAlumno.numControl" class="appearance-none block w-full bg-gray-200 dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                        type="number" placeholder="0" required>
                                    </div>

                                    <div class="w-full md:w-1/2 px-3">
                                        <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-last-name">
                                            Dirección
                                        </label>
                                        <input id="Capacidad" v-model="NuevoAlumno.Direccion" class="appearance-none block w-full bg-gray-200 dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                        type="text" placeholder="" required>
                                    </div>

                                    <div class="w-full md:w-1/2 px-3">
                                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2"  for="grid-last-name">
                                                Género
                                            </label>
                                            <select class="md:w-full appearance-none block w-full bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" name="aplicaciones"
                                            v-model="NuevoAlumno.Genero" required>
                                                <option value='Masculino'>
                                                Masculino
                                                </option>
                                                <option value='Femenino'>
                                                Femenino
                                                </option>
                                            </select>
                                    </div>

                                    <div class="w-full md:w-1/2 px-3">
                                        <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-last-name">
                                            Teléfono
                                        </label>
                                        <input id="Capacidad" v-model="NuevoAlumno.Telefono" class="appearance-none block w-full bg-gray-200 dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                        type="tel" placeholder="" required>
                                    </div>

                                    <div class="w-full md:w-1/2 px-3">
                                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-last-name">
                                                Grupo
                                            </label>

                                            <select class="md:w-full appearance-none block w-full bg-gray-200 dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" name="categorias"
                                            v-model="NuevoAlumno.idGrupo" required>
                                            <option :value="null"> Sin grupo</option>

                                            <option
                                                v-for="(Grupo,index) in grupos"
                                                :key="Grupo.id"
                                                :value="Grupo.id"
                                            >

                                                {{ Grupo.Semestre }}-{{ Grupo.Letra }}-{{ Grupo.Especialidad }}
                                            </option>
                                            </select>
                                    </div>

                                    <div class="w-full md:w-full px-3">
                                        <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-last-name">
                                            Carrera
                                        </label>

                                        <select class="md:w-full appearance-none block w-full bg-gray-200 dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" name="categorias"
                                        v-model="NuevoAlumno.idCarrera" required>

                                        <option
                                            v-for="(Carrera,index) in carreras"
                                            :key="Carrera.id"
                                            :value="Carrera.id"
                                        >

                                            {{ Carrera.Nivel }} en {{ Carrera.Nombre }}
                                        </option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Modal footer -->
                                <div class="flex items-center px-6 py-2 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                                    <button type="submit" class="text-white bg-[#014E82] hover:bg-[#0284c7] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Agregar</button>
                                    <button @click="hideElement" data-modal-hide="defaultModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Cancelar</button>
                                    <button @click="validarCURP" v-if="NuevoAlumno.curp.length==18"  type="button" class="text-white bg-[#487c9f] hover:bg-[#0284c7] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Obtener Informacion</button>
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

    <!--TABLA ALUMNOS-->
    <div class="inline-block min-w-full overflow-hidden rounded-lg shadow">
        <table class="w-full whitespace-no-wrap">
            <thead>
                <tr class="border-2 dark:border-slate-700 border-gray-300 bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">

                    <th class="border-b-2 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200">
                        No.Control
                    </th>
                    <th class="border-b-2 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200">
                        Nombre
                    </th>
                    <th class="border-b-2 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200">
                        Fecha Nacimiento
                    </th>
                    <th class="border-b-2 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200">
                        Curp
                    </th>
                    <th class="border-b-2 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200">
                        Carrera
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


                <tr v-for="(alumno,index) in alumnos" v-bind:id="`fila${alumno.id}`"  class="text-gray-700"
                >
                    <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-3 py-5 text-xs ">
                        <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap">{{ alumno.noControl }}</p>
                    </td>
                    <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-3 py-5 text-xs">
                        <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap">{{ alumno.Nombre }} {{ alumno.ApellidoP }} {{ alumno.ApellidoM }}</p>
                    </td>
                    <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-3 py-5 text-xs">
                        <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap">{{ alumno.FechaNac }}</p>
                    </td>

                    <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-3 py-5 text-xs">
                        <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap">{{ alumno.curp }}</p>
                    </td>

                    <!-- <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-3 py-5 text-xs">
                        <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap">{{ alumno.Direccion }}</p>
                    </td> -->

                    <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-3 py-5 text-xs">
                        <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap uppercase"
                            v-if="alumno.idCarrera==null">
                                Sin carrera
                        </p>

                        <span v-for="carrera in carreras">
                            <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap"
                            v-if="carrera.id==alumno.idCarrera">
                                {{ carrera.Nivel }} en {{ carrera.Nombre }}
                            </p>
                        </span>
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
                                <Link :href="route('Alumnos.edit',alumno.id)"  class="p-3 rounded-md bg-[#014E82] mx-2 inline-flex mb-1" >
                                    <i class="fa-solid fa-pen text-white"></i>
                                </Link>
                        </div>

                        <div v-if="$page.props.user.roles.includes('Administrador')">
                            <a type="button" @click="showDelete(alumno.id)" class="p-3 rounded-md bg-[#dc2626] mx-2 inline-flex mb-1" >
                                    <i class="fa-solid fa-trash text-white"></i>
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


                                                    <h3  class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Está seguro de dar de baja a este alumno </h3>
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

    <!--Paginacion-->
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

    export default {
        components:{
            Link
        },
        mounted() {
            this.hideDelete()
            this.FiltroBusqueda=this.$page.props.Filtro;

            if(this.Paginator.next_page_url!=null){
                this.urlPaginacion = this.Paginator.next_page_url.slice(0, -1);
            }
            else if(this.Paginator.prev_page_url!=null){
                this.urlPaginacion = this.Paginator.prev_page_url.slice(0, -1);
            }
            this.cantidadPaginas=this.Paginator.last_page
        },
        computed: {
            URL_API_CURP() {
            return "https://apimarket.mx/api/renapo/grupo/valida-curp?curp=" + this.NuevoAlumno.curp;
            },
        },
        props:{
            alumnos:Array,
            Paginator:Array,
            grupos:Array,
            carreras:Array,
            mensaje:String,
            tipoMensaje:String
        },
        data() {
            return {

                pasos:[
                    'El archivo Excel deberá contar con los siguientes encabezados para ser valido 1. Nombre , 2. Apellido Paterno 3. Apellido Materno 4.Fecha Nacimiento 5.NumControl 6.Curp 7.Direccion 8.Genero 9.Telefono 10.Semestre 11.Grupo 12.Especialidad 13.Periodo Actual',
                    'El campo de fecha deberá ser ingresado en un formato AÑO-MES-DIA para ser válido',
                    'El campo "Periodo Actual" debe estar separado por medio de "-" de la forma en la que se muestra en la imagen',
                    'Por último selecciona un archivo Excel y carga los datos'
                ],

                ImagenesPasos:[
                    '/img/Paso1_Importacion.jpg',
                    '/img/Paso2_Importacion.jpg',
                    '/img/Paso3_Importacion.jpg',
                    '/img/PruebaImportacion.mp4'
                ],

                PasoActual:0,

                urlPaginacion:'',

                isVisible: false,
                isvisibleDelete:false,
                isVisibleImportacion:false,
                idBorrarSeleccionado:0,

                MostrarFiltro:false,

                AlumnoBuscar:'',
                campoBusqueda:'Nombre',
                campoBusquedaVer:'Nombre',
                setTimeoutBuscador:'',


                NuevoAlumno:{
                    Nombre:'',
                    ApellidoP:'',
                    ApellidoM:'',
                    FechaNacimiento:'',
                    numControl:0,
                    curp:'',
                    Direccion:'',
                    Telefono:'',
                    Genero:'',
                    idGrupo:0,
                    idCarrera:0,
                },

                contenidoModal:'',

                Activar:[],

                mensajeCurp:'',
                mensajeRFC:'',

                exitoCURP:false,
                exitoRFC:false,

                MostrarmensajeCurp:false,

                NombreArchivo:null
            }
        },
        methods: {
            siguientePaso(){
                this.PasoActual++;
            },

            AnteriorPaso(){
                if(this.PasoActual!=0){
                    this.PasoActual--;
                }
            },

            async ImportarDatos(){
                const fileInput = this.$refs.fileInput;
                const file = fileInput.files[0];
                const formData = new FormData();
                formData.append('archivo', file);

                await this.$inertia.post('/Alumnos.importar', formData);
            },

            handleFileChange(){
                const fileInput = this.$refs.fileInput;
                this.NombreArchivo = fileInput.files.length > 0 ? fileInput.files[0].name : null;
                this.hideImportacion();
            },

            //METODO PARA REALIZAR SOLICITUD A API CURP
            validarCURP(){


                this.MostrarmensajeCurp=true

                //URLS PARA LLAMADA A LA API
                const urlCURP=this.URL_API_CURP;
                const urlRFC=this.URL_API_RFC;

                // Opciones de la solicitud
                const requestOptions = {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer fd32ed13-ab6c-4918-8e52-1546288d5d6e', //Lave de autheticacion para la API
                        'Accept': 'application/json',
                    },
                };

                // Realizar la solicitud para curp
                fetch(urlCURP, requestOptions)
                .then(response => response.json()) // Parsear la respuesta JSON
                .then(response => {
                    console.log('DATOS PERSONALES:',response); // Hacer algo con la respuesta JSON
                    console.log('mensaje CURP:',response.message)
                    if(response.message=='Exitoso'){
                        this.exitoCURP=true
                    }
                    else{
                        this.mensajeCurp=response.message
                    }
                    this.NuevoAlumno.Nombre=response.data.nombres
                    this.NuevoAlumno.ApellidoP=response.data.apellidoPaterno
                    this.NuevoAlumno.ApellidoM=response.data.apellidoMaterno

                    const fechaDDMMAA=response.data.fechaNacimiento
                    const FechaPorPartes = fechaDDMMAA.split('/');
                    const dia = FechaPorPartes[0];
                    const mes = FechaPorPartes[1];
                    const año = FechaPorPartes[2];
                    const fechaYYMMDD = `${año}-${mes}-${dia}`;
                    this.NuevoAlumno.FechaNacimiento=fechaYYMMDD;

                })
                .catch(error => {
                    console.error('Error en obtener datos personales:', error);
                });
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

            async crearAlumno(){
                await this.$inertia.post(route('Alumnos.store'),this.NuevoAlumno)
                this.hideElement()
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
            this.MostrarmensajeCurp=false;
            this.MostrarmensajeRFC=false;
            },


            showDelete(id,estatus){
                this.idBorrarSeleccionado=id;
                this.EstatusActivo=estatus;
                this.isvisibleDelete = true;
            },


            hideDelete(){
                this.isvisibleDelete = false;
                this.personalSeleccionado=0;
            },

            showImportacion(){
                this.$page.props.mensaje=null
                this.PasoActual=0
                this.NombreArchivo=null
                this.isVisibleImportacion = true;
            },


            hideImportacion(){
                this.isVisibleImportacion  = false;
            },
        }
    };
</script>








