<template>
    <Head title="Editar Rol" />
        <AuthenticatedLayout>
            <template #header>
                    Editar Materia
            </template>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white dark:bg-slate-700 overflow-hidden shadow-xl sm:rounded-lg">
                        <!--Formulario para editar la infromacion de la materia-->
                        <form @submit.prevent="EditarMateria" class="mb-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-8 mt-5 mx-7">

                                <div class="grid grid-cols-1">
                                <label class="uppercase md:text-sm text-xs text-gray-500 dark:text-gray-200 text-light font-semibold">Nombre</label>
                                <input
                                    id="NombreAula"
                                    v-model="InfoEditar.Nombre"
                                    class="py-2 px-3 rounded-lg border-2 border-[#0285c7c6] dark:text-gray-200 dark:bg-slate-700 mt-1 focus:outline-none focus:ring-2 focus:[#014E82] focus:border-transparent" type="text"
                                />
                                </div>

                                <div class="grid grid-cols-1">
                                <label class="uppercase md:text-sm text-xs text-gray-500 dark:text-gray-200 text-light font-semibold">Descripción</label>
                                <input
                                    id="NombreAula"
                                    v-model="InfoEditar.Descripcion"
                                    class="py-2 px-3 rounded-lg border-2 border-[#0285c7c6] dark:text-gray-200 dark:bg-slate-700 mt-1 focus:outline-none focus:ring-2 focus:[#014E82] focus:border-transparent" type="text"
                                />
                                </div>

                                <div class="grid grid-cols-1">
                                <label class="uppercase md:text-sm text-xs text-gray-500 dark:text-gray-200 text-light font-semibold">Código</label>
                                <input
                                    id="NombreAula"
                                    v-model="InfoEditar.Codigo"
                                    class="py-2 px-3 rounded-lg border-2 border-[#0285c7c6] dark:text-gray-200 dark:bg-slate-700 mt-1 focus:outline-none focus:ring-2 focus:[#014E82] focus:border-transparent"
                                    type="number"
                                />
                                </div>
                            </div>
                            <!--Seccion de botones (Guardar y cancelar)-->
                            <div class='flex justify-end md:gap-8 gap-4 pt-5 pb-5 pr-5'>
                                <Link
                                    :href="route('Materias.index')"
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
        materia:{
            type:Array,
            required:true,
        }
    })


    var form=useForm({
        id:props.materia.id,
        Nombre:props.materia.Nombre,
        Codigo:props.materia.Codigo,
        Descripcion:props.materia.Descripcion,
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
                    Nombre:this.$props.materia.Nombre,
                    Codigo:this.$props.materia.Codigo,
                    Descripcion:this.$props.materia.Descripcion,

                },
            }
        },

        methods:{
            EditarMateria(){
                console.log(this.InfoEditar);
                this.$inertia.put(
                route("Materias.update",this.$props.materia.id),
                    this.InfoEditar
                );
            },
        },


    };

</script>
