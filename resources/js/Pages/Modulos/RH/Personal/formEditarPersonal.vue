<template>
    <Head title="Modificar personal" />
    <AuthenticatedLayout>
    <template #header class="pr-2">
            Modificar Personal
    </template>
    <!--Seccion para modificar informacion del personal-->
    <div class="pl-2">
        <!--Formulario oara editar la infromacion del personal-->
        <form @submit.prevent="EditarPersonal"  class="w-full ">
            <div class="flex flex-wrap -mx-3 mb-6 overflow-auto">

                <div class="dark:text-gray-200 flex justify-between items-center ml-2 w-full mb-4 text-lg">
                    Datos Generales
                    <div>
                        <button @click="validarCURP" v-if="NuevoPersonal.CURP.length==18"  type="button"
                        class="mr-2 text-white bg-[#487c9f] hover:bg-[#0284c7] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Obtener Información por CURP
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
                    <input id="NombreAula" v-model="NuevoPersonal.FechaNacimiento"  class="appearance-none block w-full bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                    type="date" placeholder="" required>
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
                        Código postal
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
                        Telefono
                    </label>
                    <input id="Capacidad" v-model="NuevoPersonal.Telefono" class="appearance-none block w-full bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                    type="tel" placeholder="" required>
                </div>

                <div class="w-full md:w-1/2 px-3">
                    <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-last-name">
                        Correo Personal
                    </label>
                    <input id="Capacidad" v-model="NuevoPersonal.CorreoPers" class="appearance-none block w-full bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                    type="email" placeholder="">
                </div>

                <div class="dark:text-gray-200 flex justify-between items-center ml-2 w-full mb-4 text-lg">
                    Formacion academica
                </div>

                <div class="w-full md:w-1/6 px-3">
                    <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2"  for="grid-last-name">
                        Nivel de Estudios
                    </label>
                    <select class="md:w-full appearance-none block w-full bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" name="aplicaciones"
                    v-model="NuevoPersonal.NivEst1" >
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
                    type="text" placeholder="">
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
                    type="text" placeholder="Lic.">
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
                        Departamento de adscripcion
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
                        Departamento de Academico
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
                            type="number" placeholder="">

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
                        type="number" placeholder="">

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

                <div class="dark:text-gray-200 flex justify-between items-center ml-2 w-full mb-4 text-lg" v-if="NuevoPersonal.EstatusEmpleado==1">
                    Asignar cuenta
                </div>

                <div class="w-full md:w-2/5 px-3" v-if="NuevoPersonal.EstatusEmpleado==1">
                    <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2"  for="grid-last-name">
                        Cuenta de usuario
                    </label>
                    <select class="md:w-full appearance-none block w-full bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                    name="aplicaciones" v-model="NuevoPersonal.idUsuario">
                        <option :value="null">Sin cuenta</option>
                        <option :value="cuentaAsignada.id">
                            {{ cuentaAsignada.email }}
                        </option>

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
                <button type="submit" class="text-white bg-[#014E82] hover:bg-[#0284c7] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Guardar</button>
                <Link :href="route('Personal.index')"
                data-modal-hide="defaultModal" type="button"
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
    import axios from 'axios';
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
            personalEditar:Array,
            departamentos:Array,
            estatus:Array,
            usuarios:Array,
            cuentaAsignada:Array
        },

        data() {
            return {
                NuevoPersonal:{
                    //Informacion del Personal
                    ApellidoP:this.$page.props.personalEditar.ApellidoP,
                    ApellidoM:this.$page.props.personalEditar.ApellidoM,
                    Nombre:this.$page.props.personalEditar.Nombre,
                    RFC:this.$page.props.personalEditar.RFC,
                    LugarNacimiento:this.$page.props.personalEditar.LugarNacimiento,
                    FechaNacimiento:this.$page.props.personalEditar.FechaNacimiento,
                    Sexo:this.$page.props.personalEditar.Sexo,
                    EstadoCivil:this.$page.props.personalEditar.EstadoCivil,
                    Direccion:this.$page.props.personalEditar.Direccion,
                    Colonia:this.$page.props.personalEditar.Colonia,
                    CodigoPostal:this.$page.props.personalEditar.CodigoPostal,
                    Ciudad:this.$page.props.personalEditar.Ciudad,
                    EntFederativa:this.$page.props.personalEditar.EntFederativa,
                    Telefono:this.$page.props.personalEditar.Telefono,
                    CURP:this.$page.props.personalEditar.CURP,
                    CorreoPers:this.$page.props.personalEditar.CorreoPers,
                    //Inf. Academica
                    NivEst1:this.$page.props.personalEditar.NivEst1,
                    NivEst2:this.$page.props.personalEditar.NivEst2,
                    NivEst3:this.$page.props.personalEditar.NivEst3,

                    GradoMax1:this.$page.props.personalEditar.GradoMax1,
                    GradoMax2:this.$page.props.personalEditar.GradoMax2,
                    GradoMax3:this.$page.props.personalEditar.GradoMax3,

                    Estudio1:this.$page.props.personalEditar.Estudio1,
                    Estudio2:this.$page.props.personalEditar.Estudio2,
                    Estudio3:this.$page.props.personalEditar.Estudio3,
                    Titulo:this.$page.props.personalEditar.Titulo,

                    //Inf Laboral
                    Nombramiento:this.$page.props.personalEditar.Nombramiento,
                    idDepAdscripcion:this.$page.props.personalEditar.idDepAdscripcion,
                    idDepAcademico:this.$page.props.personalEditar.idDepAcademico,

                    numEmpleado:this.$page.props.personalEditar.numEmpleado,
                    EstatusEmpleado:this.$page.props.personalEditar.EstatusEmpleado,
                    Estatus:this.$page.props.personalEditar.Estatus,

                    IngAñoSNEST:this.$page.props.personalEditar.IngAñoSNEST,
                    IngQuinSNEST:this.$page.props.personalEditar.IngQuinSNEST,

                    IngAñoGob:this.$page.props.personalEditar.IngAñoGob,
                    IngQuinGob:this.$page.props.personalEditar.IngQuinGob,

                    IngAñoSEP:this.$page.props.personalEditar.IngAñoSEP,
                    IngQuinSEP:this.$page.props.personalEditar.IngQuinSEP,

                    IngAñoPlan:this.$page.props.personalEditar.IngAñoPlan,
                    IngQuinPlan:this.$page.props.personalEditar.IngQuinPlan,

                    TipoAct:this.$page.props.personalEditar.TipoAct,

                    idPlaza:this.$page.props.personalEditar.idPlaza,
                    idUsuario:this.$page.props.cuentaAsignada.id,
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
                        'Authorization': 'Bearer fd32ed13-ab6c-4918-8e52-1546288d5d6e',
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
            async EditarPersonal(){
                this.$inertia.put(route("Personal.update",this.$props.personalEditar.id),
                    this.NuevoPersonal
                );
            },
        }
    };
</script>
