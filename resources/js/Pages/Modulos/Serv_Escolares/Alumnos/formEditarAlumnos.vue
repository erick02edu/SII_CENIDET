<template>
    <Head title="Editar Aulas" />
        <AuthenticatedLayout>
            <template #header>
                    <p class="w-full pl-8">Editar Alumno</p>
            </template>
            <!--Seccion para editar informacion de un alumno-->
            <div class="py-5">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white dark:bg-slate-700 overflow-hidden shadow-xl sm:rounded-lg">
                        <form @submit.prevent="EditarAlumno" class="mb-6">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-8 mt-5 mx-7">

                                <div class="grid grid-cols-1">
                                <label class="uppercase md:text-sm text-xs text-gray-500 dark:text-gray-200 text-light font-semibold">Nombre</label>
                                <input
                                    id="diagonal"
                                    v-model="InfoEditar.Nombre"
                                    class="py-2 px-3 rounded-lg border-2 border-gray-500 dark:text-gray-200 dark:bg-slate-700 mt-1 focus:outline-none focus:ring-2 focus:[#014E82] focus:border-transparent"
                                    type="text"
                                />
                                </div>

                                <div class="grid grid-cols-1">
                                <label class="uppercase md:text-sm text-xs text-gray-500 dark:text-gray-200 text-light font-semibold">Apellido Paterno</label>
                                <input
                                    id="horas"
                                    v-model="InfoEditar.ApellidoP"
                                    class="py-2 px-3 rounded-lg border-2 border-gray-500 dark:text-gray-200 dark:bg-slate-700 mt-1 focus:outline-none focus:ring-2 focus:[#014E82] focus:border-transparent"
                                    type="text"
                                />
                                </div>

                                <div class="grid grid-cols-1">
                                <label class="uppercase md:text-sm text-xs text-gray-500 dark:text-gray-200 text-light font-semibold">Apellido Materno</label>
                                <input
                                    id="horas"
                                    v-model="InfoEditar.ApellidoM"
                                    class="py-2 px-3 rounded-lg border-2 border-gray-500 dark:text-gray-200 dark:bg-slate-700 mt-1 focus:outline-none focus:ring-2 focus:[#014E82] focus:border-transparent"
                                    type="text"
                                />
                                </div>

                                <div class="grid grid-cols-1">
                                <label class="uppercase md:text-sm text-xs text-gray-500 dark:text-gray-200 text-light font-semibold">Fecha Nacimiento</label>
                                <input
                                    id="horas"
                                    v-model="InfoEditar.FechaNac"
                                    class="py-2 px-3 rounded-lg border-2 border-gray-500 dark:text-gray-200 dark:bg-slate-700 mt-1 focus:outline-none focus:ring-2 focus:[#014E82] focus:border-transparent"
                                    type="date"
                                />
                                </div>

                                <div class="grid grid-cols-1">
                                <label class="uppercase md:text-sm text-xs text-gray-500 dark:text-gray-200 text-light font-semibold">Número de Control</label>
                                <input
                                    id="horas"
                                    v-model="InfoEditar.noControl"
                                    class="py-2 px-3 rounded-lg border-2 border-gray-500 dark:text-gray-200 dark:bg-slate-700 mt-1 focus:outline-none focus:ring-2 focus:[#014E82] focus:border-transparent"
                                    type="number"
                                />
                                </div>

                                <div class="grid grid-cols-1">
                                    <label class="uppercase md:text-sm text-xs text-gray-500 dark:text-gray-200 text-light font-semibold">Grupo</label>

                                    <select v-model="InfoEditar.idGrupo" class="py-2 px-3 rounded-lg border-2 border-gray-500 dark:text-gray-200 dark:bg-slate-700 mt-1 focus:outline-none focus:ring-2 focus:[#014E82] focus:border-transparent">
                                        <option :value="null"> Sin grupo</option>
                                        <option
                                            v-for="(Grupo,index) in ListaGrupos"
                                            :key="Grupo.id"
                                            :value="Grupo.id"
                                            :selected="Grupo.id==InfoEditar.GrupoEditar"
                                        >
                                            {{ Grupo.Semestre }}-{{ Grupo.Letra }} {{ Grupo.Especialidad }}
                                        </option>
                                    </select>
                                </div>


                                <div class="grid grid-cols-1">
                                    <label class="uppercase md:text-sm text-xs text-gray-500 dark:text-gray-200 text-light font-semibold">
                                        Carrera
                                    </label>

                                    <select v-model="InfoEditar.idCarrera" class="py-2 px-3 rounded-lg border-2 border-gray-500 dark:text-gray-200 dark:bg-slate-700 mt-1 focus:outline-none focus:ring-2 focus:[#014E82] focus:border-transparent">
                                        <option :value="null"> Sin carrera</option>
                                        <option
                                            v-for="(carrera,index) in carreras"
                                            :key="carrera.id"
                                            :value="carrera.id"
                                            :selected="carrera.id==InfoEditar.idCarrera"
                                        >
                                            {{ carrera.Nivel }} en {{ carrera.Nombre }}
                                        </option>
                                    </select>
                                </div>


                                <div class="grid grid-cols-1">
                                <label class="uppercase md:text-sm text-xs text-gray-500 dark:text-gray-200 text-light font-semibold">Curp</label>
                                <input
                                    id="horas"
                                    v-model="InfoEditar.curp"
                                    class="py-2 px-3 rounded-lg border-2 border-gray-500 dark:text-gray-200 dark:bg-slate-700 mt-1 focus:outline-none focus:ring-2 focus:[#014E82] focus:border-transparent"
                                    type="text"
                                />
                                </div>

                                <div class="grid grid-cols-1">
                                <label class="uppercase md:text-sm text-xs text-gray-500 dark:text-gray-200 text-light font-semibold">Dirección</label>
                                <input
                                    id="horas"
                                    v-model="InfoEditar.Direccion"
                                    class="py-2 px-3 rounded-lg border-2 border-gray-500 dark:text-gray-200 dark:bg-slate-700 mt-1 focus:outline-none focus:ring-2 focus:[#014E82] focus:border-transparent"
                                    type="text"
                                />
                                </div>


                                <div class="grid grid-cols-1">
                                <label class="uppercase md:text-sm text-xs text-gray-500 dark:text-gray-200 text-light font-semibold">Género</label>

                                <select class="md:w-full appearance-none block w-full bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-gray-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" name="aplicaciones"
                                v-model="InfoEditar.Genero" required>
                                    <option value='Masculino'>
                                       Masculino
                                    </option>
                                    <option value='Femenino'>
                                       Femenino
                                    </option>
                                </select>
                                </div>

                                <div class="grid grid-cols-1">
                                <label class="uppercase md:text-sm text-xs text-gray-500 dark:text-gray-200 text-light font-semibold">Teléfono</label>
                                <input
                                    id="horas"
                                    v-model="InfoEditar.Telefono"
                                    class="py-2 px-3 rounded-lg border-2 border-gray-500 dark:text-gray-200 dark:bg-slate-700 mt-1 focus:outline-none focus:ring-2 focus:[#014E82] focus:border-transparent"
                                    type="text"
                                />
                                </div>
                            </div>
                            <!--Footer-->
                            <div class='flex justify-end md:gap-8 gap-4 pt-5 pb-5 pr-5'>
                                <Link
                                    :href="route('Alumnos.index')"
                                    class='w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2' type="button">
                                    Cancelar
                                </Link>
                                <button
                                    type="submit"
                                    class='w-auto bg-[#014E82] hover:bg-[#0284c7] rounded-lg shadow-xl font-medium text-white px-4 py-2'
                                >
                                    Guardar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import Pagination from '@/Components/Pagination.vue'
    import { Head, useForm } from '@inertiajs/vue3';
    import { Link } from '@inertiajs/vue3'
    const props=defineProps({
        alumno:{
            type:Array,
            required:true,
        },
        GrupoEditar:Array,
        ListaGrupos:Array,
        carreras:Array
    })
    var form=useForm({
        id:props.alumno.id,
        Nombre:props.alumno.Nombre,
        ApellidoP:props.alumno.ApellidoP,
        ApellidoM:props.alumno.ApellidoM,
        FechaNac:props.alumno.FechaNac,
        noControl:props.alumno.noControl,
        curp:props.alumno.curp,
        Direccion:props.alumno.Direccion,
        Genero:props.alumno.Genero,
        Telefono:props.alumno.Telefono,
        GrupoEditar:props.GrupoEditar,
        idCarrera:props.idCarrera,
        ListaGrupos:props.ListaGrupos,
        carreras:props.carreras
    })
</script>

<script>
    export default {
        components:{
            Link
        },
        data() {
            return {
                InfoEditar: {
                    idCarrera:this.$props.alumno.idCarrera,
                    idGrupo:this.$props.alumno.idGrupo,
                    Nombre:this.$props.alumno.Nombre,
                    ApellidoP:this.$props.alumno.ApellidoP,
                    ApellidoM:this.$props.alumno.ApellidoM,
                    FechaNac:this.$props.alumno.FechaNac,
                    noControl:this.$props.alumno.noControl,
                    curp:this.$props.alumno.curp,
                    Direccion:this.$props.alumno.Direccion,
                    Genero:this.$props.alumno.Genero,
                    Telefono:this.$props.alumno.Telefono,
                },
            }
        },
        methods:{
            EditarAlumno(){
                this.$inertia.put(
                route("Alumnos.update",this.$props.alumno.id),
                    this.InfoEditar
                );
            },
        },
    };
</script>
