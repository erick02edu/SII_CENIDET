<template>
    <Head title="Horarios" />
    <AuthenticatedLayout>
        <template #header>
                Lista de Horarios
        </template>

        <!--Seccion de botones y buscador-->
        <div class="flex justify-between">
            <button :type="type" @click="showElementBuscar" class=" inline-flex rounded-md bg-[#014E82] px-6 py-2.5 mb-4 text-center text-sm text-white hover:bg-[#0284c7]  "
            v-if="$page.props.user.roles.includes('Recursos Humanos')">
            <i class="fa-solid fa-magnifying-glass mr-2"></i>Buscar horario
            </button>

            <!-- Espacio entre los botones -->
            <div class="w-1/3 mr-14"></div>

            <button :type="type" @click="showElementHorConcentrado" class="inline-flex items-center  rounded-md bg-[#014E82] px-6 py-2.5 mb-4 text-center text-sm text-white hover:bg-[#0284c7]  "
            v-if="$page.props.user.roles.includes('Recursos Humanos')">
                Generar horario concentrado
            </button>

            <button :type="type" @click="showElement" class=" inline-flex items-center  ml-4 rounded-md bg-[#014E82] px-6 py-2.5 mb-4 text-center text-sm text-white hover:bg-[#0284c7]  "
            v-if="$page.props.user.roles.includes('Recursos Humanos')">
                Crear Horario
            </button>
        </div>

        <!-- Capa oscura -->
        <div :class="{ hidden: !isVisibleBuscar }" class="fixed inset-0 bg-black opacity-50">
        </div>

        <!--MODAL PARA BUSCAR UN HORARIO-->
        <div id="modalContainer" >
            <!-- Main modal -->
            <div :class="{ hidden: !isVisibleBuscar } " >

                <div id="defaultModal" tabindex="-1" aria-hidden="true"  class="fixed inset-0 flex items-center justify-center z-50">
                    <div class="relative w-full max-w-2xl max-h-full">

                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">

                            <!-- Modal header -->
                            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white uppercase">
                                    Buscar Horario
                                </h3>
                                <button type="button" @click="hideElementBuscar" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>

                            <!-- Modal body -->
                            <div class="p-6 space-y-6">
                                <form @submit.prevent="HacerBusqueda"  class="w-full max-w-lg">


                                <div class="flex flex-wrap -mx-3 mb-6">

                                        <div class="w-full md:w-full px-3 mb-2 md:mb-0">

                                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-first-name">
                                                    Departamento
                                            </label>

                                            <select class="appearance-none block w-full bg-gray-200 dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                            v-model="departamentoBuscar" @change="ObtenerPersonalPorDepartamento">

                                                <option value="0">Selecciona un departamento</option>
                                                <option
                                                    v-for="departamento in departamentos"
                                                    :key="departamento.id"
                                                    :value="departamento.id"
                                                >
                                                    {{ departamento.Nombre }}

                                                </option>
                                            </select>

                                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-first-name "
                                            >
                                                Personal
                                            </label>


                                            <div>
                                            <select  class="appearance-none block w-full bg-gray-200 dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white"
                                            v-model="PersonalBuscar">
                                                <option value="0">Selecciona un docente</option>
                                                <option
                                                    v-for="personal in PersonalPorDepartamento"
                                                    :key="personal.id"
                                                    :value="personal.id"
                                                >
                                                {{ personal.RFC }}-{{ personal.Nombre }} {{ personal.ApellidoP }} {{ personal.ApellidoM }}

                                                </option>
                                            </select>
                                            <p class=" text-xs text-red-600 mb-2" v-if="PersonalBuscar==-1">No se encontro personal para este departamento</p>
                                            </div>

                                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-first-name">
                                                    Periodo
                                            </label>

                                            <select class="appearance-none block w-full bg-gray-200 dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                            v-model="periodoBuscar">
                                                <option value="0">Selecciona un periodo</option>
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
                                        <button type="submit" target="_blank" class="text-white bg-[#014E82] hover:bg-[#0284c7] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            Buscar
                                        </button>
                                        <button @click="hideElementHorConcentrado" data-modal-hide="defaultModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Cancelar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Capa oscura -->
        <div :class="{ hidden: !isVisibleHConcentrado }" class="fixed inset-0 bg-black opacity-50">
        </div>

        <!--MODAL PARA GENERAR HORARIO CONCENTRADO-->
        <div id="modalContainer" >
            <!-- Main modal -->
            <div :class="{ hidden: !isVisibleHConcentrado } " >

                <div id="defaultModal" tabindex="-1" aria-hidden="true"  class="fixed inset-0 flex items-center justify-center z-50">
                    <div class="relative w-full max-w-2xl max-h-full">

                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">

                            <!-- Modal header -->
                            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white uppercase">
                                    Horario concentrado
                                </h3>
                                <button type="button" @click="hideElementHorConcentrado" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>

                            <!-- Modal body -->
                            <div class="p-6 space-y-6">
                                <form  class="w-full max-w-lg">
                                    <div class="flex flex-wrap -mx-3 mb-6">

                                        <div class="w-full md:w-full px-3 mb-2 md:mb-0">
                                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-4" for="grid-first-name">
                                                    Elige un periodo para generar el reporte concentrado
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
                                        <a :href="route('HorConcentrado',periodoSeleccionado)" target="_blank" class="text-white bg-[#014E82] hover:bg-[#0284c7] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            Generar
                                        </a>
                                        <button @click="hideElementHorConcentrado" data-modal-hide="defaultModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Cancelar</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Capa oscura -->
        <div :class="{ hidden: !isVisibleCorreo }" class="fixed inset-0 bg-black opacity-50">
        </div>

        <!-- Capa oscura -->
        <div :class="{ hidden: !isvisibleDelete }" class="fixed inset-0 bg-black opacity-50">
        </div>

        <!-- Capa oscura -->
        <div :class="{ hidden: !isVisible }" class="fixed inset-0 bg-black opacity-50">
        </div>

        <!--MODAL PARA CREAR UN HORARIO-->
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
                            Crear nuevo horario
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
                <form @submit.prevent="crearHorario"  class="w-full max-w-lg">
                        <div class="flex flex-wrap -mx-3 mb-6">

                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-first-name" select>
                                    Selecciona un profesor
                                </label>

                                <select class="dark:bg-slate-700 dark:text-slate-200 rounded-sm mb-2 " name="periodos" v-model="NuevoHorario.idProfesor"
                                required>


                                    <option
                                        v-for="(profesor,index) in profesores"
                                        :key="profesor.id"
                                        :value="profesor.id"
                                    >

                                        {{ profesor.Nombre }} {{ profesor.ApellidoP }}  {{ profesor.ApellidoM }}
                                    </option>
                                </select>

                                <p v-if="mensajeProfesor!=null" class="text-sm text-red-600 ">Por favor selecciona un profesor</p>

                                <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-1" for="grid-first-name" select>
                                    Selecciona el periodo del horario
                                </label>

                                <select name="periodos" v-model="NuevoHorario.idPeriodo" class="dark:bg-slate-700 dark:text-slate-200 rounded-sm "
                                required>
                                    <option
                                        v-for="periodo in periodos"
                                        :key="periodo.id"
                                        :value="periodo.id"
                                    >
                                        {{ periodo.mesInicio }} {{ periodo.AñoInicio }}-{{ periodo.mesTermino }} {{ periodo.AñoTermino }}

                                    </option>
                                </select>

                            <!-- Modal footer -->
                            <div class="flex items-center pt-5 pr-5 pb-5 space-x-2 border-t border-gray-200 rounded-b dark:border-slate-800 br-4">
                                <button type="submit" class="text-white bg-[#014E82] hover:bg-[#0284c7] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Crear</button>
                                <button @click="hideElement" data-modal-hide="defaultModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Cancelar</button>
                            </div>

                            </div>

                    </div>
                </form>
            </div>

                </div>
            </div>
            </div>
            </div>
        </div>

        <div v-if="mensaje"
        :class="{ 'bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-1 mb-3': tipoMensaje == 'Exitoso', 'bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-3 mb-3': tipoMensaje == 'Error' }">
            <strong class="font-bold" v-if="tipoMensaje=='Exitoso'">Éxito:</strong>
            <strong class="font-bold" v-if="tipoMensaje=='Error'">Érror:</strong>
            <span class="block sm:inline">{{ mensaje}}</span>
        </div>

        <!--TABLA DE HORARIOS-->
        <div class="inline-block min-w-full overflow-hidden shadow">
            <table class="w-full whitespace-no-wrap">
                <!--Encabezados-->
                <thead>
                    <tr class="border-b-10 bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 mb-10" >
                        <th class="border-b-2 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200">
                            Horario
                        </th>
                        <th class="border-b-2 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200">
                            Detalles
                        </th>
                    </tr>
                </thead>
                <!--FILAS-->
                <tbody>
                    <tr v-for="(horario,index) in horarios" class="text-gray-700">
                        <td class="border-b border-t-8 border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-2 py-2 text-sm h-64 w-2/3">
                            <iframe
                                :src="Urls[index]"
                                frameborder="0"
                                style="border:0"
                                class=" overflow-y-auto overflow-x-auto  w-full h-full "
                            ></iframe>
                        </td>

                        <td class="border-b border-t-8 border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-5 py-5 text-sm">
                            <div class="dark:text-gray-200 p-3">
                                <p class="uppercase">Información del horario:</p>
                                <div v-for="(profesor,index) in profesores">
                                    <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap" v-if="profesor.id==horario.idProfesor">
                                    <p v-for="departamento in departamentos">
                                            <p v-if="profesor.idDepAdscripcion==departamento.id">
                                            <strong>Departamentos</strong><br>{{departamento.Nombre}}
                                            </p>
                                        </p>
                                    </p>
                                </div>

                                <div v-for="(profesor,index) in profesores">
                                    <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap" v-if="profesor.id==horario.idProfesor">
                                    <strong> Profesor:</strong>{{ profesor.Nombre }} {{ profesor.ApellidoP }} {{ profesor.ApellidoM }}
                                    </p>
                                </div>

                                <div v-for="periodo in periodos">
                                    <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap"
                                    v-if="horario.idPeriodo==periodo.id"
                                    >
                                    <strong>Periodo:</strong>
                                    {{ periodo.mesInicio }}/{{ periodo.AñoInicio }}-{{ periodo.mesTermino }}/{{ periodo.AñoTermino }}
                                    </p>
                                </div>
                            </div>

                            <div class="mt-1 dark:text-gray-200">

                                <p class="mb-2 pl-3">Acciones:</p>

                                <Link :href="route('HorariosDocentes.edit',horario.id)"  class="p-3 rounded-md bg-[#b43838] mx-2 inline-flex mb-1 text-white"
                                v-if="$page.props.user.roles.includes('Recursos Humanos')"
                                v-tippy="{
                                    content:'Editar horario de docente',
                                    placement: 'left',
                                    arrow: true,
                                    arrowType: 'MyArrow',
                                    theme: 'MiThemeRed'
                                }">
                                    <i class="fa-solid fa-user-pen"></i>
                                </Link>

                                <Link :href="route('HorariosDocentes.editAdmin',horario.id)"  class="p-3 rounded-md bg-[#128201] mx-2 inline-flex mb-1 text-white"
                                v-if="$page.props.user.roles.includes('Recursos Humanos')"
                                v-tippy="{
                                    content:'Editar horario administrativo',
                                    placement: 'top',
                                    arrow: true,
                                    arrowType: 'MyArrow',
                                    theme: 'MiThemeGreen'
                                }">
                                    <i class="fa-solid fa-marker"></i>
                                </Link>


                                <a type="button"  @click="showDelete(horario.id)" class="p-3 rounded-md bg-[#dc2626] mx-2 inline-flex mb-1"
                                v-if="$page.props.user.roles.includes('Recursos Humanos')"
                                v-tippy="{
                                    content:'Eliminar horario',
                                    placement: 'top' ,
                                    arrow: true,
                                    theme: 'MiThemeRed'
                                }">
                                    <i class="fa-solid fa-trash text-white"></i>
                                </a>


                                <a :href="route('HorariosDocentes.ver',horario.id)"  target="_blank" class="p-3 rounded-md bg-[#95c73e] mx-2 inline-flex mb-1"
                                v-if="$page.props.user.roles.includes('Recursos Humanos')"
                                v-tippy="{
                                    content:'Ver Horario',
                                    placement: 'top' ,
                                    arrow: true,
                                    theme: 'MiThemeYellow'
                                }"
                                >
                                    <i class="fa-solid fa-eye text-white"></i>
                                </a>


                                <!--DESCARGAR PDF-->
                                <a v-if="$page.props.user.roles.includes('Recursos Humanos')"  :href="route('HorarioPDF',horario.id)" target="_blank" class="p-3 rounded-md bg-[#dc2626] mx-2 inline-flex mb-1"
                                v-tippy="{
                                    content:'Descargar horario',
                                    placement: 'top' ,
                                    arrow: true,
                                    theme: 'MiThemeRed'
                                }">
                                    <i class="fa-regular fa-file-pdf text-white"
                                    ></i>
                                </a>


                                <span v-for="(profesor,index) in profesores">
                                    <a type="button"  @click="showEnviar(profesor,horario.idProfesor)" class="p-3 rounded-md bg-[#dc2626] mx-2 inline-flex mb-1 mt-2"
                                    v-if="$page.props.user.roles.includes('Recursos Humanos') && profesor.id==horario.idProfesor"
                                    v-tippy="{
                                        content:'Notificar a profesor',
                                        placement: 'left' ,
                                        arrow: true,
                                        theme: 'MiThemeRed'
                                    }">
                                    <i class="fa-solid fa-envelope text-white pt-1"></i> <p class="text-white pl-1 "></p>
                                    </a>
                                </span>

                            <div>
                                <div :class="{ hidden: !isvisibleDelete }" v-bind:id="`Modal${horario.id}`" tabindex="-1" class="fixed inset-0 flex items-center justify-center z-50">
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
                                                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Esta seguro de eliminar este horario </h3>
                                                <Link @click="hideDelete" method="delete" :href="route('HorariosDocentes.destroy', idBorrarSeleccionado)" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                                    Si, estoy seguro
                                                </Link>
                                                <button @click="hideDelete" data-modal-hide="popup-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No, cancelar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <div :class="{ hidden: !isVisibleCorreo }" v-bind:id="`Modal${horario.id}`" tabindex="-1" class="fixed inset-0 flex items-center justify-center z-50">
                                    <div class="relative w-full max-w-md max-h-full">
                                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                            <button @click="hideEnviar" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                            <div class="p-6 text-center">
                                                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                </svg>
                                                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Esta seguro de enviar un correo a
                                                    {{  ProfesorCorreo.Nombre }} {{ ProfesorCorreo.ApellidoP }}  {{  ProfesorCorreo.ApellidoM }}  informando que su horario esta listo </h3>
                                                <button @click="EnviarCorreo" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                                    Si, estoy seguro
                                                </button>
                                                <button @click="hideEnviar" data-modal-hide="popup-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No, cancelar</button>
                                            </div>
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

        <div v-if="horarios==''" class=" text-xl w-full mt-14 text-center"> <i class="fa-solid fa-magnifying-glass dark:text-white "></i>
            <p class="pl-5 dark:text-white">Sin resultados</p>
        </div>

        <nav aria-label="Page navigation example mt-4" v-if="horarios!=''">
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
    import Pagination from '@/Components/Pagination.vue';
    import { Head } from '@inertiajs/vue3';
    import { Link } from '@inertiajs/vue3';
    import { useDark,useToggle} from '@vueuse/core';
    import { ref } from 'vue';

    import 'tippy.js/themes/light.css';
    import 'tippy.js/dist/tippy.css';
    import 'tippy.js/animations/scale.css';
    import { directive } from 'vue-tippy';

</script>

<script>
import axios from 'axios';
import NavLink from '@/Components/NavLink.vue';

export default {


    directives: {
        tippy: directive,
    },

    components:{
        Link,
        NavLink,
    },

    mounted() {
        this.Urls=this.$page.props.ListaUrl
        this.isVisible=false
        this.isvisibleConcentrado=false

        if(this.Paginator.next_page_url!=null){
            this.urlPaginacion = this.Paginator.next_page_url.slice(0, -1);
        }
        else if(this.Paginator.prev_page_url!=null){
            this.urlPaginacion = this.Paginator.prev_page_url.slice(0, -1);
        }

        this.cantidadPaginas=this.Paginator.last_page

    },

    props:{
        profesores:Array,
        horarios:Array,
        periodos:Array,
        ListaUrl:Array,
        Paginator:Array,
        departamentos:Array,
        mensaje: String,
        tipoMensaje:String,
    },

    data() {
    return {

        urlPaginacion:'',
        iframeSrc: '/HorariosDocentes/1/edit',
        // Urls:['/HorariosDocentes/1/edit','/HorariosDocentes/2/edit', '/HorariosDocentes/3/edit'],
        Urls:[],
        NuevoHorario:{
            idProfesor:0,
            idPeriodo:0
        },

        isVisible:'',
        isvisibleDelete:'',
        isVisibleHConcentrado:'',
        isVisibleBuscar:'',

        isVisibleCorreo:false,
        ProfesorCorreo:'',
        PeriodoHorarioCorreo:'',

        campoBusqueda:'Profesor',
        UsuarioBuscar:'',


        mensajeProfesor:null,
        idBorrarSeleccionado:0,

        MostrarFiltro:false,
        periodoSeleccionado:0,


        departamentoBuscar:0,
        PersonalBuscar:0,
        periodoBuscar:0,
        PersonalPorDepartamento:[],
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

    SeleccionarCampo(campo){
        this.campoBusqueda=campo
        this.MostrarFiltro=false
    },

    async HacerBusqueda(){
        await axios.get('HorariosDocentes.buscar',{
            params:{
                PersonalBuscar:this.PersonalBuscar,
                periodoBuscar:this.periodoBuscar,
                departamentoBuscar:this.departamentoBuscar,
            }
        })
        .then(response => {

            this.resultadosBusqueda=response.data;
            // console.log('RESULTADOS:');
            // console.log(this.$page.props.plazas);
            this.$page.props.horarios=this.resultadosBusqueda;

        })
        .catch(error => {
            console.error('Error al hacer la busqueda:', error);
        });

        this.hideElementBuscar();
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

    showElementBuscar() {
        this.$page.props.mensaje=null
        this.isVisibleBuscar = true;
    },
    hideElementBuscar() {
      this.isVisibleBuscar = false;
    },

    showElementHorConcentrado() {
        this.$page.props.mensaje=null
        this.isVisibleHConcentrado = true;
    },
    hideElementHorConcentrado() {
      this.isVisibleHConcentrado = false;
    },


    showEnviar(profesor,PeriodoCorreo){

        this.PeriodoHorarioCorreo=PeriodoCorreo;
        this.ProfesorCorreo=profesor
        this.isVisibleCorreo=true;
    },

    hideEnviar(){
        this.isVisibleCorreo=false;
    },

    async EnviarCorreo(){
        let request = { profesor:this.ProfesorCorreo.id ,periodo:this.PeriodoHorarioCorreo };

        await this.$inertia.post(route('EnviarCorreo'),request)
        this.hideEnviar();
    },


    crearHorario(){
        this.$inertia.post(route('HorariosDocentes.store'),this.NuevoHorario);
        this.hideElement()
    },


    ObtenerPersonalPorDepartamento(){
        console.log('departamento',this.departamentoBuscar)

        this.PersonalPorDepartamento=null
        this.PersonalBuscar=0;

        axios.get('Personal.Departemento',{  params:{ departamento:this.departamentoBuscar}   })
        .then(response => {
            const resultadosBusqueda=response.data.Personal;

            this.PersonalPorDepartamento=resultadosBusqueda;

            if(resultadosBusqueda.length ==0){
                this.PersonalBuscar=-1;
            }
        })
        .catch(error => {
            console.error('Error al hacer la busqueda:', error);
        });


    },

    generarPDF() {
      // Realiza una solicitud al backend para generar el PDF
      console.log('Entre')
      axios.get('/PruebaReporte',{Accept: 'application/pdf',})
        .then(response => {

            if(response.data.status=="success") {
                        const url = window.URL.createObjectURL(new Blob([response.data.data], {type: 'application/pdf'}));
                        const link = document.createElement('a');
                        console.log(link);
                        link.href = url;
                        link.setAttribute('download', 'staffs.pdf'); //or any other extension
                        document.body.appendChild(link);
                        link.click();
            } else{
                alert("Not Authenticated");
            }


        });
    }



  }
};
</script>

<style>
    .tippy-box[data-theme~='MiTheme'] {
        background-color: rgb(15, 24, 201);
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
    .tippy-box[data-theme~='MiThemeYellow'] {
        background-color: rgb(184, 166, 0);
        color: rgb(255, 255, 255);
        padding: 5px;
        border-radius: 4px;
    }
    .tippy-box[data-theme~='MiThemeGreen'] {
        background-color: rgb(54, 152, 21);
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

    .tippy-box[data-theme~='MiThemeGreen'][data-placement^='top'] > .tippy-arrow::before {
        border-top-color: rgb(54, 152, 21)
    }

    .tippy-arrow[data-theme~='MyArrow'] {
        border-color: red;
    }

</style>

