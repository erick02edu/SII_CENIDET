<template>

<Head title="Editar Aulas" />
    <AuthenticatedLayout>

            <template #header>
                    Editar Aula
            </template>
            <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-slate-700 overflow-hidden shadow-xl sm:rounded-lg">

                    <form @submit.prevent="EditarAula" class="mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-8 mt-5 mx-7">
                        <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 dark:text-gray-200 text-light font-semibold">Nombre Aula</label>


                        <input
                            id="NombreAula"
                            v-model="InfoEditar.NombreAula"
                            class="py-2 px-3 rounded-lg border-2 border-[#0285c7c6] dark:text-gray-200 dark:bg-slate-700 mt-1 focus:outline-none focus:ring-2 focus:[#014E82] focus:border-transparent" type="text"
                            required />
                        </div>
                        <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 dark:text-gray-200 text-light font-semibold">Capacidad</label>
                        <input
                            id="Capacidad"
                            v-model="InfoEditar.Capacidad"
                            class="py-2 px-3 rounded-lg border-2 border-[#0285c7c6] dark:text-gray-200 dark:bg-slate-700 mt-1 focus:outline-none focus:ring-2 focus:[#014E82] focus:border-transparent" type="number"
                            required />
                        </div>

                        <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 dark:text-gray-200 text-light font-semibold">Ubicación</label>
                        <input
                            id="Ubicacion"
                            v-model="InfoEditar.Ubicacion"
                            class="py-2 px-3 rounded-lg border-2 border-[#0285c7c6] dark:text-gray-200 dark:bg-slate-700 mt-1 focus:outline-none focus:ring-2 focus:[#014E82] focus:border-transparent" type="text"
                            required />
                        </div>



                        </div>

                        <div class='flex justify-end md:gap-8 gap-4 pt-5 pb-5 pr-5'>
                        <Link
                            :href="route('Aulas.index')"
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

    //  const props = defineProps({
    //     aula: Array
    //  });

    const props=defineProps({
        aula:{
            type:Array,
            required:true,
        }
    })

    var form=useForm({
        id:props.aula.id,
        NombreAula:props.aula.NombreAula,
        Capacidad:props.aula.Capacidad,
        Ubicacion:props.aula.Ubicacion,
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
                    NombreAula:this.$props.aula.NombreAula,
                    Capacidad:this.$props.aula.Capacidad,
                    Ubicacion:this.$props.aula.Ubicacion,
                },
            }
        },

        methods:{
            EditarAula(){
                console.log(this.InfoEditar);
                this.$inertia.put(
                route("Aulas.update",this.$props.aula.id),
                    this.InfoEditar
                );
            },
        },


    };

</script>
