<template>
    <Head title="Editar Rol" />
    <AuthenticatedLayout>
        <template #header>
            <p v-if="InfoVigencia[0].id==null" class="ml-8">
                Agregar vigencia al personal
            </p>
            <p v-else class="ml-8">
                Modificar vigencia del personal
            </p>
        </template>

        <!--Seccion para agregar o dificar vigencia-->
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-slate-700 overflow-hidden shadow-xl sm:rounded-lg">

                    <form @submit.prevent="EditarVigencia" class="mb-6 mt-5">

                        <strong class="w-full dark:text-white pl-6">
                                Nombre del personal:{{ personal.Nombre }} {{ personal.ApellidoP }} {{ personal.ApellidoM }}
                        </strong>
                        <p class="dark:text-white pl-6">
                            Periodo: {{ periodo.mesInicio }} {{ periodo.AñoInicio }}-{{ periodo.mesTermino }} {{ periodo.AñoTermino }}
                        </p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-8 mt-5 mx-7">

                            <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 dark:text-gray-200 text-light font-semibold">Establece la fecha para el inicio de la Vigencia</label>
                            <input
                                id="NombreAula"
                                v-model="InfoEditar.InicioVigencia"
                                class="py-2 px-3 rounded-lg border-2  dark:text-gray-200 dark:bg-slate-700 mt-1 focus:outline-none focus:ring-2 focus:[#014E82] focus:border-transparent"
                                type="date"
                                required
                            />
                            </div>

                            <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 dark:text-gray-200 text-light font-semibold">Establece la fecha del fin de la Vigencia</label>
                            <input
                                id="NombreAula"
                                v-model="InfoEditar.FinVigencia"
                                class="py-2 px-3 rounded-lg border-2  dark:text-gray-200 dark:bg-slate-700 mt-1 focus:outline-none focus:ring-2 focus:[#014E82] focus:border-transparent"
                                type="date"
                                required
                            />
                            </div>
                        </div>

                        <div class='flex justify-end md:gap-5 gap-4 pt-5 pb-5 pr-6'>
                        <button
                            type="submit"
                            class='w-auto bg-[#014E82] hover:bg-[#0284c7] rounded-lg shadow-xl font-medium text-white px-4 py-2'
                        >
                            Cambiar vigencia
                        </button>
                        <Link
                            :href="route('Personal.index')"
                            class='w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2' type="button">
                            Cancelar
                        </Link>
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
        InfoVigencia:{
            type:Array,
            required:true,
        },
        personal:Array,
        periodo:Array,
    })
    var form=useForm({
        id:props.InfoVigencia.id,
        idPeriodo:props.InfoVigencia.idPeriodo,
        InicioVigencia:props.InfoVigencia.InicioVigencia,
        FinVigencia:props.InfoVigencia.FinVigencia,
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
                    idPersonal:this.$props.personal.id,
                    idPeriodo:this.$props.periodo.id,
                    InicioVigencia:this.$props.InfoVigencia[0].InicioVigencia,
                    FinVigencia:this.$props.InfoVigencia[0].FinVigencia,
                },
            }
        },

        methods:{
            EditarVigencia(){
                console.log(this.InfoEditar);

                if(this.$props.InfoVigencia[0].id==null){
                    console.log('REGISTRAR DE LUGAR DE ACTUALIZAR',this.InfoEditar)
                    this.$inertia.post(
                    route("VigenciaPersonal.store",this.InfoEditar),
                    );
                }
                else{
                    this.$inertia.put(
                    route("VigenciaPersonal.update",this.$props.InfoVigencia[0].id),
                        this.InfoEditar
                    );
                }
            },
        },


    };

</script>
