<template>
    <Head title="Editar Aulas" />
    <AuthenticatedLayout>
        <template #header>
               <span class="ml-8"> Editar Departamento</span>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-slate-700 overflow-hidden shadow-xl sm:rounded-lg">
                    <form @submit.prevent="EditarDepartamento" class="mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-8 mt-5 mx-7">
                            <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 dark:text-gray-200 text-light font-semibold">Nombre</label>
                                <input
                                    id="horas"
                                    v-model="InfoEditar.Nombre"
                                    class="py-2 px-3 rounded-lg border-2 border-[#0285c7c6] dark:text-gray-200 dark:bg-slate-700 mt-1 focus:outline-none focus:ring-2 focus:[#014E82] focus:border-transparent" type="text"
                                />
                            </div>
                            <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 dark:text-gray-200 text-light font-semibold">Descripción</label>
                            <input
                                id="diagonal"
                                v-model="InfoEditar.Descripcion"
                                class="py-2 px-3 rounded-lg border-2 border-[#0285c7c6] dark:text-gray-200 dark:bg-slate-700 mt-1 focus:outline-none focus:ring-2 focus:[#014E82] focus:border-transparent" type="text"
                            />
                            </div>

                            <div class="grid grid-cols-1">
                                <label class="uppercase md:text-sm text-xs text-gray-500 dark:text-gray-200 text-light font-semibold">Elige el nuevo jefe de departamento</label>
                                <select name="departamentos" v-model="InfoEditar.idEncargado" class="py-2 px-3 rounded-lg border-2 border-[#0285c7c6] dark:text-gray-200 dark:bg-slate-700 mt-1 focus:outline-none focus:ring-2 focus:[#014E82] focus:border-transparent">

                                <option
                                    v-for="persona in personal"
                                    :key="persona.id"
                                    :value="persona.id"
                                >
                                    {{ persona.Nombre }} {{ persona.ApellidoP }} {{ persona.ApellidoM }}

                                </option>
                                </select>
                            </div>
                            <div class="grid grid-cols-1">

                                <label class="uppercase md:text-sm text-xs text-gray-500 dark:text-gray-200 text-light font-semibold">
                                    Elige una nueva subdirección</label>
                                <select name="departamentos" v-model="InfoEditar.idSubdireccion" class="py-2 px-3 rounded-lg border-2 border-[#0285c7c6] dark:text-gray-200 dark:bg-slate-700 mt-1 focus:outline-none focus:ring-2 focus:[#014E82] focus:border-transparent">

                                <option
                                    v-for="subdireccion in subdirecciones"
                                    :key="subdireccion.id"
                                    :value="subdireccion.id"
                                >
                                    {{ subdireccion.Nombre }}

                                </option>
                                </select>
                            </div>

                        </div>
                        <div class='flex justify-end md:gap-8 gap-4 pt-5 pb-5 pr-5'>
                            <Link
                                :href="route('Departamentos.index')"
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
        departamento:{
            type:Array,
            required:true,
        },
        personal:Array,
        JefeActual:Array,
        subdirecciones:Array

    })

    var form=useForm({
        id:props.departamento.id,
        unidad:props.departamento.Nombre,
        subunidad:props.departamento.Descripcion,
        idEncargado:props.JefeActual.id,
        idSubdireccion:props.departamento.idSubdireccion
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
                    idDepartamento:this.$props.departamento.id,
                    Nombre:this.$props.departamento.Nombre,
                    Descripcion:this.$props.departamento.Descripcion,
                    idEncargado:this.$props.JefeActual.id,
                    idSubdireccion:this.$props.departamento.idSubdireccion
                },
            }
        },
        methods:{
            EditarDepartamento(){

                console.log(this.InfoEditar);

                this.$inertia.put(
                route("Departamentos.update",this.$props.departamento.id),
                    this.InfoEditar
                );
            },
        },
    };
</script>
