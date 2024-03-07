<template>
    <Head title="Alta Personal" />
    <AuthenticatedLayout>
    <template #header class="pr-2">
            Alta del Personal
    </template>
    <div class="pl-2">
        <!--Fomrulario para dar de alta a un personal-->
        <form @submit.prevent="crearPersonal"  class="w-full ">
            <div class="flex flex-wrap -mx-3 mb-6 overflow-auto">
                <div class="dark:text-gray-200 flex justify-between items-center ml-2 w-full mb-4 text-lg">
                    Datos Generales
                    <div>
                        <button @click="validarCURP" v-if="NuevoPersonal.CURP.length==18"  type="button"
                        class="mr-2 text-white bg-[#487c9f] hover:bg-[#0284c7] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Obtener Informacion por curp
                        </button>
                    </div>
                </div>

                <div class="w-full md:w-1/2 px-3 mb-3">

                    <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-last-name">
                        CURP
                    </label>
                    <input id="Capacidad"  maxlength="18" v-model="NuevoPersonal.CURP" class="appearance-none block w-full bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white"
                    type="text" placeholder="XXXXXXXXXXXXXXXXXX" required>
                    <p v-if="MostrarmensajeCurp!=false" :class="{ 'text-sm text-green-500':exitoCURP, 'text-sm text-red-600':!exitoCURP }">{{ mensajeCurp }}</p>

                </div>

                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">

                    <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-last-name">
                        RFC
                    </label>
                    <input id="NombreAula" maxlength="13" v-model="NuevoPersonal.RFC"  class="appearance-none block w-full bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white"

                    type="text" placeholder="XXXXXXXXXXXXX" required>

                    <p v-if="MostrarmensajeRFC!=false" :class="{ 'text-sm text-green-500':exitoRFC, 'text-sm text-red-600':!exitoRFC }">{{  mensajeRFC }}</p>

                </div>

                <div class="w-full md:w-1/2 px-3 mb-3">
                    <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-last-name">
                        Nombre
                    </label>
                    <input id="Capacidad" v-model="NuevoPersonal.Nombre" class="appearance-none block w-full bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                    type="text" placeholder="0" required>
                </div>

                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-last-name">
                        Apellido Paterno
                    </label>
                    <input id="NombreAula" v-model="NuevoPersonal.ApellidoP"  class="appearance-none block w-full bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                    type="text" placeholder="" required>
                </div>

                <div class="w-full md:w-1/2 px-3 mb-3">
                    <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-last-name">
                        Apellido Materno
                    </label>
                    <input id="Capacidad" v-model="NuevoPersonal.ApellidoM" class="appearance-none block w-full bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                    type="text" placeholder="" required>
                </div>

                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-last-name">
                        Fecha de Nacimiento
                    </label>
                    <input id="FechaNacimiento" v-model="NuevoPersonal.FechaNacimiento"  class="appearance-none block w-full bg-white
                     dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4
                     mb-1 leading-tight focus:outline-none focus:bg-white"
                    type="date" placeholder="" required>
                    <div v-if="msjFechaInvalida==true"
                    class="text-red-400 text-xs mb-1">
                        La fecha ingresada no es valida
                    </div>

                </div>

                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-last-name">
                        Lugar de nacimiento
                    </label>
                    <input id="NombreAula" v-model="NuevoPersonal.LugarNacimiento"  class="appearance-none block w-full bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                    type="text" placeholder="" required>
                </div>

                <div class="w-full md:w-1/2 px-3">
                    <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2"  for="grid-last-name">
                        Sexo
                    </label>
                    <select class="md:w-1/3 appearance-none block w-full bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" name="aplicaciones"
                    v-model="NuevoPersonal.Sexo" required>
                        <option value='Masculino'>
                            Masculino
                        </option>
                        <option value='Femenino'>
                            Femenino
                        </option>
                    </select>
                </div>

                <div class="w-full md:w-1/2 px-3">
                    <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2"  for="grid-last-name">
                        Estado Civil
                    </label>
                    <select class="md:w-1/3 appearance-none block w-full bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" name="aplicaciones"
                    v-model="NuevoPersonal.EstadoCivil" required>
                        <option value='Soltero'>
                            Soltero(a)
                        </option>
                        <option value='Casado'>
                            Casado(a)
                        </option>
                        <option value='Divorciado'>
                            Divorciado(a)
                        </option>
                        <option value='Viudo'>
                            Viudo(a)
                        </option>
                        <option value='Union Libre'>
                            Union Libre
                        </option>
                        <option value='Otro'>
                            Otro
                        </option>
                    </select>
                </div>

                <div class="w-full md:w-1/2 px-3 ">
                    <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-last-name">
                        Domicilio actual(calle y número)
                    </label>
                    <input id="Capacidad" v-model="NuevoPersonal.Direccion" class="appearance-none block w-full bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                    type="text" placeholder="" required>
                </div>

                <div class="w-full md:w-1/2 px-3 ">
                    <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-last-name">
                        Colonia
                    </label>
                    <input id="Capacidad" v-model="NuevoPersonal.Colonia" class="appearance-none block w-full bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                    type="text" placeholder="" required>
                </div>

                <div class="w-full md:w-1/2 px-3 ">
                    <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-last-name">
                        Código postal (opcional)
                    </label>
                    <input id="Capacidad" maxlength="5" v-model="NuevoPersonal.CodigoPostal" class="appearance-none block w-full bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                    type="text" placeholder="">
                </div>

                <div class="w-full md:w-1/2 px-3 ">
                    <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-last-name">
                        Ciudad o Localidad
                    </label>
                    <input id="Capacidad" v-model="NuevoPersonal.Ciudad" class="appearance-none block w-full bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                    type="text" placeholder="" required>
                </div>

                <div class="w-full md:w-1/2 px-3 ">
                    <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-last-name">
                        Entidad Federativa
                    </label>
                    <input id="Capacidad" v-model="NuevoPersonal.EntFederativa" class="appearance-none block w-full bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                    type="text" placeholder="" required>
                </div>

                <div class="w-full md:w-1/2 px-3">
                    <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-last-name">
                        Teléfono
                    </label>
                    <input id="Capacidad" v-model="NuevoPersonal.Telefono" class="appearance-none block w-full bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                    type="tel"
                    placeholder="Telefono"
                    maxlength="10" required
                    >
                </div>

                <div class="w-full md:w-1/2 px-3">
                    <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-last-name">
                        Correo Personal (opcional)
                    </label>
                    <input id="Capacidad" v-model="NuevoPersonal.CorreoPers" class="appearance-none block w-full bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                    type="email" placeholder="">
                </div>

                <div class="dark:text-gray-200 flex justify-between items-center ml-2 w-full mb-4 text-lg">
                    Formación académica
                </div>

                <div class="w-full md:w-1/6 px-3">
                    <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2"  for="grid-last-name">
                        Nivel de Estudios
                    </label>
                    <select class="md:w-full appearance-none block w-full bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" name="aplicaciones"
                    v-model="NuevoPersonal.NivEst1">
                        <option value='Sin Estudio'>
                            Sin Estudio
                        </option>
                        <option value='Primaria'>
                            Primaria
                        </option>
                        <option value='Secundaria'>
                            Secundaria
                        </option>
                        <option value='Preparatoria'>
                            Preparatoria
                        </option>
                        <option value='Carrera Tecnica'>
                            Carrera Tecnica
                        </option>
                        <option value='Carrera Comercial'>
                            Carrera Comercial
                        </option>
                        <option value='Normal'>
                            Normal
                        </option>
                        <option value='Normal Superior'>
                            Normal Superior
                        </option>
                        <option value='Especializacion'>
                            Especializacion
                        </option>
                        <option value='Profesional'>
                            Profesional
                        </option>
                        <option value='Maestria'>
                            Maestria
                        </option>
                        <option value='Doctorado'>
                            Doctorado
                        </option>
                    </select>
                </div>

                <div class="w-full md:w-1/6 px-3 ">
                    <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-last-name">
                        Grado Maximo
                    </label>
                    <input id="Capacidad" v-model="NuevoPersonal.GradoMax1" class="appearance-none block w-full bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                    type="text" placeholder="" >
                </div>

                <div class="w-full md:w-4/6 px-3 ">
                    <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-last-name">
                        Estudios
                    </label>
                    <input id="Capacidad" v-model="NuevoPersonal.Estudio1" class="appearance-none block w-full bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                    type="text" placeholder="">
                </div>

                <div class="w-full md:w-1/6 px-3">
                    <select class="md:w-full appearance-none block w-full bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" name="aplicaciones"
                    v-model="NuevoPersonal.NivEst2">
                        <option value='Sin Estudio'>
                            Sin Estudio
                        </option>
                        <option value='Primaria'>
                            Primaria
                        </option>
                        <option value='Secundaria'>
                            Secundaria
                        </option>
                        <option value='Preparatoria'>
                            Preparatoria
                        </option>
                        <option value='Carrera Tecnica'>
                            Carrera Tecnica
                        </option>
                        <option value='Carrera Comercial'>
                            Carrera Comercial
                        </option>
                        <option value='Normal'>
                            Normal
                        </option>
                        <option value='Normal Superior'>
                            Normal Superior
                        </option>
                        <option value='Especializacion'>
                            Especializacion
                        </option>
                        <option value='Profesional'>
                            Profesional
                        </option>
                        <option value='Maestria'>
                            Maestria
                        </option>
                        <option value='Doctorado'>
                            Doctorado
                        </option>
                    </select>
                </div>

                <div class="w-full md:w-1/6 px-3 ">
                    <input id="Capacidad" v-model="NuevoPersonal.GradoMax2" class="appearance-none block w-full bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                    type="text" placeholder="">
                </div>

                <div class="w-full md:w-4/6 px-3 ">
                    <input id="Capacidad" v-model="NuevoPersonal.Estudio2" class="appearance-none block w-full bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                    type="text" placeholder="">
                </div>

                <div class="w-full md:w-1/6 px-3">
                    <select class="md:w-full appearance-none block w-full bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" name="aplicaciones"
                    v-model="NuevoPersonal.NivEst3">
                        <option value='Sin Estudio'>
                            Sin Estudio
                        </option>
                        <option value='Primaria'>
                            Primaria
                        </option>
                        <option value='Secundaria'>
                            Secundaria
                        </option>
                        <option value='Preparatoria'>
                            Preparatoria
                        </option>
                        <option value='Carrera Tecnica'>
                            Carrera Tecnica
                        </option>
                        <option value='Carrera Comercial'>
                            Carrera Comercial
                        </option>
                        <option value='Normal'>
                            Normal
                        </option>
                        <option value='Normal Superior'>
                            Normal Superior
                        </option>
                        <option value='Especializacion'>
                            Especializacion
                        </option>
                        <option value='Profesional'>
                            Profesional
                        </option>
                        <option value='Maestria'>
                            Maestria
                        </option>
                        <option value='Doctorado'>
                            Doctorado
                        </option>
                    </select>
                </div>

                <div class="w-full md:w-1/6 px-3 ">
                    <input id="Capacidad" v-model="NuevoPersonal.GradoMax3" class="appearance-none block w-full bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                    type="text" placeholder="">
                </div>

                <div class="w-full md:w-4/6 px-3 ">
                    <input id="Capacidad" v-model="NuevoPersonal.Estudio3" class="appearance-none block w-full bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                    type="text" placeholder="">
                </div>

                <div class="w-full md:w-1/2 px-3 ">
                    <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-last-name">
                        Título (LI., MC., Dr., Ing.)
                    </label>
                    <input id="Capacidad" v-model="NuevoPersonal.Titulo" class="appearance-none block w-full bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                    type="text" placeholder="">
                </div>

                <div class="dark:text-gray-200 flex justify-between items-center ml-2 w-full mb-4 text-lg">
                    Información Laboral
                </div>

                <div class="w-full md:w-1/5 px-3">
                    <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2"  for="grid-last-name">
                        Nombramiento
                    </label>
                    <select class="md:w-full appearance-none block w-full bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" name="aplicaciones"
                    v-model="NuevoPersonal.Nombramiento" required>
                        <option value='Docente'>
                            Docente
                        </option>
                        <option value='Administrativo'>
                            Administrativo
                        </option>
                    </select>
                </div>

                <div class="w-full md:w-2/5 px-3">
                    <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2"  for="grid-last-name">
                        Departamento de adscripción
                    </label>
                    <select class="md:w-full appearance-none block w-full bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" name="aplicaciones"
                    v-model="NuevoPersonal.idDepAdscripcion" required>
                        <option v-for="departamento in departamentos"
                        :value="departamento.id"
                        >
                            {{ departamento.Nombre }}
                        </option>
                    </select>
                </div>

                <div class="w-full md:w-2/5 px-3">
                    <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2"  for="grid-last-name">
                        Departamento académico
                    </label>
                    <select class="md:w-full appearance-none block w-full bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" name="aplicaciones"
                    v-model="NuevoPersonal.idDepAcademico" required>
                        <option v-for="departamento in departamentos"
                        :value="departamento.id"
                        >
                            {{ departamento.Nombre }}
                        </option>
                    </select>
                </div>

                <div class="w-full md:w-1/5 px-3 mb-3">
                    <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-last-name">
                        Número de empleado
                    </label>
                    <input id="Capacidad" v-model="NuevoPersonal.numEmpleado" max="9999" class="appearance-none block w-full bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                        type="number" placeholder="" required>
                </div>

                <div class="w-full md:w-2/5 px-3">
                    <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2"  for="grid-last-name">
                        Estatus empleado
                    </label>
                    <select class="md:w-full appearance-none block w-full bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" name="aplicaciones"
                    v-model="NuevoPersonal.EstatusEmpleado" required>
                        <option v-for="estatu in estatus"
                        :value="estatu.id"
                        >
                            {{ estatu.Descripcion }}
                        </option>
                    </select>
                </div>

                <div class="w-full md:w-1/2 px-3 mb-3">
                    <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-last-name">
                        Ingreso al S.N.E.S.T
                    </label>
                    <div class="inline-flex w-4/5">
                        <span class="dark:text-gray-200 pt-2 mr-2">Año:</span>
                        <input id="Capacidad" v-model="NuevoPersonal.IngAñoSNEST" class="appearance-none block w-full bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-5 mb-3 leading-tight focus:outline-none focus:bg-white"
                        type="number" placeholder="" >

                        <span class="dark:text-gray-200 pt-2 mr-2 pl-3">Quincena:</span>
                        <input id="Capacidad" v-model="NuevoPersonal.IngQuinSNEST" class="appearance-none block w-full bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-5 mb-3 leading-tight focus:outline-none focus:bg-white"
                        type="number" placeholder="">

                    </div>
                </div>

                <div class="w-full md:w-1/2 px-3 mb-3">
                    <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-last-name">
                        Ingreso a Gobierno
                    </label>
                    <div class="inline-flex w-4/5">
                        <span class="dark:text-gray-200 pt-2 mr-2">Año:</span>
                        <input id="Capacidad" v-model="NuevoPersonal.IngAñoGob" class="appearance-none block w-full bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-5 mb-3 leading-tight focus:outline-none focus:bg-white"
                        type="number" placeholder="" >

                        <span class="dark:text-gray-200 pt-2 mr-2 pl-3">Quincena:</span>
                        <input id="Capacidad" v-model="NuevoPersonal.IngQuinGob" class="appearance-none block w-full bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-5 mb-3 leading-tight focus:outline-none focus:bg-white"
                        type="number" placeholder="">

                    </div>
                </div>

                <div class="w-full md:w-1/2 px-3 mb-3">
                    <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-last-name">
                        Ingreso a SEP
                    </label>
                    <div class="inline-flex w-4/5">
                        <span class="dark:text-gray-200 pt-2 mr-2">Año:</span>
                        <input id="Capacidad" v-model="NuevoPersonal.IngAñoSEP" class="appearance-none block w-full bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-5 mb-3 leading-tight focus:outline-none focus:bg-white"
                        type="number" placeholder="">

                        <span class="dark:text-gray-200 pt-2 mr-2 pl-3">Quincena:</span>
                        <input id="Capacidad" v-model="NuevoPersonal.IngQuinSEP" class="appearance-none block w-full bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-5 mb-3 leading-tight focus:outline-none focus:bg-white"
                        type="number" placeholder="">
                    </div>
                </div>

                <div class="w-full md:w-1/2 px-3 mb-3">
                    <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-last-name">
                        Ingreso al plantel
                    </label>
                    <div class="inline-flex w-4/5">
                        <span class="dark:text-gray-200 pt-2 mr-2">Año:</span>
                        <input id="Capacidad" v-model="NuevoPersonal.IngAñoPlan" class="appearance-none block w-full bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-5 mb-3 leading-tight focus:outline-none focus:bg-white"
                        type="number" placeholder="">

                        <span class="dark:text-gray-200 pt-2 mr-2 pl-3">Quincena:</span>
                        <input id="Capacidad" v-model="NuevoPersonal.IngQuinPlan" class="appearance-none block w-full bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-5 mb-3 leading-tight focus:outline-none focus:bg-white"
                        type="number" placeholder="">

                    </div>
                </div>

                <div class="w-full md:w-1/2 px-3">
                    <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2"  for="grid-last-name">
                        Tipo de actividades
                    </label>
                    <select class="md:w-1/3 appearance-none block w-full bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" name="aplicaciones"
                    v-model="NuevoPersonal.TipoAct" required>
                        <option value='Administrativas'>
                            Administrativas
                        </option>
                        <option value='Docentes'>
                            Docentes
                        </option>
                    </select>
                </div>

                <div class="dark:text-gray-200 flex justify-between items-center ml-2 w-full mb-4 text-lg"
                v-if="NuevoPersonal.EstatusEmpleado==1">
                    Asignar cuenta
                </div>

                <div class="w-full md:w-2/5 px-3"  v-if="NuevoPersonal.EstatusEmpleado==1">
                    <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2"  for="grid-last-name" v-if="NuevoPersonal.EstatusEmpleado==1">
                        Cuenta de usuario
                    </label>
                    <select class="md:w-full appearance-none block w-full bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                    name="aplicaciones" v-model="NuevoPersonal.idUsuario">
                        <option :value="null">Sin cuenta</option>
                        <option v-for="usuario in usuarios"
                        :value="usuario.id"
                        >
                            {{ usuario.email }}
                        </option>
                    </select>
                </div>

            </div>
            <!-- Modal footer -->
            <div class="flex items-center px-1 py-2 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button type="submit" class="text-white bg-[#014E82] hover:bg-[#0284c7] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Agregar
                </button>
                <Link :href="route('Personal.index')"  data-modal-hide="defaultModal" type="button"
                class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                Cancelar
                </Link>
            </div>

        </form>
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
    computed: {
        URL_API_CURP() {
        return "https://apimarket.mx/api/renapo/grupo/valida-curp?curp=" + this.NuevoPersonal.CURP;
        },
        URL_API_RFC() {
        return "https://apimarket.mx/api/sat/grupo/obtener-rfc?curp=" + this.NuevoPersonal.CURP;
        }
    },
    props:{
        departamentos:Array,
        estatus:Array,
        usuarios:Array
    },
    data() {
        return {

        msjFechaInvalida:false,
        NuevoPersonal:{

            //Inf.Personal
            ApellidoP:'',
            ApellidoM:'',
            Nombre:'',
            RFC:'',
            LugarNacimiento:'',
            FechaNacimiento:'',
            Sexo:'',
            EstadoCivil:'',
            Direccion:'',
            Colonia:'',
            CodigoPostal:'',
            Ciudad:'',
            EntFederativa:'',
            Telefono:'',
            CURP:'',
            CorreoPers:'',
            //Inf. Academica
            NivEst1:'',
            NivEst2:'',
            NivEst3:'',

            GradoMax1:0,
            GradoMax2:0,
            GradoMax3:0,

            Estudio1:'',
            Estudio2:'',
            Estudio3:'',
            Titulo:'',

            //Inf Laboral
            Nombramiento:'',
            idDepAdscripcion:0,
            idDepAcademico:0,

            numEmpleado:0,
            EstatusEmpleado:'',
            Estatus:'',

            IngAñoSNEST:'',
            IngQuinSNEST:'',

            IngAñoGob:'',
            IngQuinGob:'',

            IngAñoSEP:'',
            IngQuinSEP:'',

            IngAñoPlan:'',
            IngQuinPlan:'',

            TipoAct:'',

            idPlaza:0,
            idUsuario:0,
        },

        }
    },
    methods: {
        //METODO PARA REALIZAR SOLICITUD A API CURP
        validarCURP(){

            this.MostrarmensajeRFC=true
            this.MostrarmensajeCurp=true

            //URLS PARA LLAMADA A LA API
            const urlCURP=this.URL_API_CURP;
            const urlRFC=this.URL_API_RFC;

            // Opciones de la solicitud
            const requestOptions = {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer fd32ed13-ab6c-4918-8e52-1546288d5d6e', //API Key
                    'Accept': 'application/json',
                },
            };
            // Realizar la solicitud para curp
            fetch(urlCURP, requestOptions)
            .then(response => response.json()) // Parsear la respuesta JSON
            .then(response => {
                if(response.message=='Exitoso'){
                    this.exitoCURP=true
                }
                else{
                    this.mensajeCurp=response.message
                }
                this.NuevoPersonal.Nombre=response.data.nombres
                this.NuevoPersonal.ApellidoP=response.data.apellidoPaterno
                this.NuevoPersonal.ApellidoM=response.data.apellidoMaterno

                //Dar formato a la fecha obtenida
                const fechaDDMMAA=response.data.fechaNacimiento
                const FechaPorPartes = fechaDDMMAA.split('/');
                const dia = FechaPorPartes[0];
                const mes = FechaPorPartes[1];
                const año = FechaPorPartes[2];
                const fechaYYMMDD = `${año}-${mes}-${dia}`;

                this.NuevoPersonal.FechaNacimiento=fechaYYMMDD;
            })
            .catch(error => {
                console.error('Error en obtener datos personales:', error);
            });
            // Realizar la solicitud para RFC
            fetch(urlRFC, requestOptions)
            .then(response => response.json()) // Parsear la respuesta JSON
            .then(response => {
                this.mensajeRFC=response.message
                this.NuevoPersonal.RFC=response.data.rfc
            })
            .catch(error => {
                console.error('Error en obtener RFC:', error);
            });
        },
        //Funcion que redirige a ruta para registrar un personal
        async crearPersonal(){
            if(this.comprobarFecha(this.NuevoPersonal.FechaNacimiento)){
                await this.$inertia.post(route('Personal.store'),this.NuevoPersonal) //Pasar datos del nuevo personal en la ruta
                this.hideElement()
                this.msjFechaInvalida=false;
            }
            else{
                document.getElementById('FechaNacimiento').focus();
                this.msjFechaInvalida=true;

            }
        },
        comprobarFecha(Fecha) {
            // Obtener la fecha actual
            var fechaActual = new Date();
            // Obtener la fecha ingresada desde el campo de entrada
            var fechaIngresada = new Date(Fecha);

            // Comparar las fechas
            if (fechaIngresada > fechaActual) {
                //La fecha ingresada es mayor que la fecha actual
                return false;
            } else {
                //La fecha ingresada es válida
                return true;
            }
        }
    }
};
</script>
