<template>
    <Head title="Editar plaza" />
        <AuthenticatedLayout>
            <template #header>
                    Editar Plaza
            </template>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white dark:bg-slate-700 overflow-hidden shadow-xl sm:rounded-lg">
                        <form @submit.prevent="EditarPlaza" class="mb-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-8 mt-5 mx-7">
                                <div class="grid grid-cols-1">
                                <label class="uppercase md:text-sm text-xs text-gray-500 dark:text-gray-200 text-light font-semibold">
                                    Categoría
                                </label>


                                <select v-model="InfoEditar.idCategoria" class="py-2 px-3 rounded-lg border-2 border-[#0285c7c6] dark:text-gray-200 dark:bg-slate-700 mt-1 focus:outline-none focus:ring-2 focus:[#014E82] focus:border-transparent">
                                    <option
                                        v-for="(categoria,index) in ListaCategorias"
                                        :key="categoria.id"
                                        :value="categoria.id"
                                        :selected="categoria.Descripcion==InfoEditar.categoriaEditar"
                                    >

                                        {{ categoria.Clave }}-{{ categoria.Descripcion }}
                                    </option>
                                </select>

                                </div>
                                <div class="grid grid-cols-1">
                                <label class="uppercase md:text-sm text-xs text-gray-500 dark:text-gray-200 text-light font-semibold">Unidad</label>

                                <select name="aplicaciones" class="md:w-2/3 py-2 px-3 rounded-lg border-2 border-[#0285c7c6] dark:text-gray-200 dark:bg-slate-700 mt-1 focus:outline-none focus:ring-2 focus:[#014E82] focus:border-transparent" v-model="InfoEditar.unidad" required>

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
                                <div class="grid grid-cols-1">
                                    <label class="uppercase md:text-sm text-xs text-gray-500 dark:text-gray-200 text-light font-semibold">Subunidad</label>

                                    <select class="md:w-1/3 py-2 px-3 rounded-lg border-2 border-[#0285c7c6] dark:text-gray-200 dark:bg-slate-700 mt-1 focus:outline-none focus:ring-2 focus:[#014E82] focus:border-transparent" name="aplicaciones" v-model="InfoEditar.subunidad" required>
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
                                <div class="grid grid-cols-1">
                                <label class="uppercase md:text-sm text-xs text-gray-500 dark:text-gray-200 text-light font-semibold">Diagonal</label>
                                <input
                                    id="diagonal"
                                    v-model="InfoEditar.diagonal"
                                    class="py-2 px-3 rounded-lg border-2 border-[#0285c7c6] dark:text-gray-200 dark:bg-slate-700 mt-1 focus:outline-none focus:ring-2 focus:[#014E82] focus:border-transparent" type="text"
                                />
                                </div>
                                <div class="grid grid-cols-1">
                                <label class="uppercase md:text-sm text-xs text-gray-500 dark:text-gray-200 text-light font-semibold">Horas/min a la semana de la plaza</label>
                                <input
                                    id="horas"
                                    v-model="InfoEditar.horas"
                                    class="py-2 px-3 rounded-lg border-2 border-[#0285c7c6] dark:text-gray-200 dark:bg-slate-700 mt-1 focus:outline-none focus:ring-2 focus:[#014E82] focus:border-transparent" type="number"
                                />
                                </div>
                                <div class="w-full md:w-1/2 px-3">
                                    <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2"  for="grid-last-name">
                                        Tipo de Movimiento
                                    </label>
                                    <select class="md:w-3/4 appearance-none block w-full bg-gray-200 dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" name="aplicaciones"
                                    v-model="InfoEditar.TipoMovimiento" required>
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
                            </div>
                            <div class='flex justify-end md:gap-8 gap-4 pt-5 pb-5 pr-5'>
                            <Link
                                :href="route('Plazas.index')"
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
        plaza:{
            type:Array,
            required:true,
        },
        categoriaEditar:Array,
        ListaCategorias:Array,
    })

    var form=useForm({
        id:props.plaza.id,
        unidad:props.plaza.unidad,
        subunidad:props.plaza.subunidad,
        idCategoria:props.plaza.idCategoria,
        diagonal:props.plaza.diagonal,
        horas:props.plaza.horas,
        TipoMovimiento:props.plaza.TipoMovimiento,
        estatus:props.plaza.estatus,
        categoriaEditar:props.categoriaEditar,
        ListaCategorias:props.ListaCategorias
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
                    idCategoria:this.$props.plaza.idCategoria,
                    unidad:this.$props.plaza.unidad,
                    subunidad:this.$props.plaza.subunidad,
                    diagonal:this.$props.plaza.diagonal,
                    horas:this.$props.plaza.horas,
                    estatus:this.$props.plaza.estatus,
                    TipoMovimiento:this.$props.plaza.TipoMovimiento
                },
            }
        },
        methods:{
            EditarPlaza(){

                console.log(this.InfoEditar);

                this.$inertia.put(
                route("Plazas.update",this.$props.plaza.id),
                    this.InfoEditar
                );
            },
        },
    };
</script>
