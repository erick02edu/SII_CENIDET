<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import Pagination from '@/Components/Pagination.vue'
    import { Head, useForm } from '@inertiajs/vue3';
    import { Link } from '@inertiajs/vue3'
    import Checkbox from '@/Components/Checkbox.vue';

    const props=defineProps({
        rol:{
            type:Array,
            required:true,
        },

        permisosAsignados:Array,
        ListaPermisosTotal:Array,
        permisosIDAsignados:Array

    })

    var form=useForm({
        id:props.rol.id,
        name:props.rol.name,
    })
</script>


<script>
    export default {
        components:{
            Link
        },
        mounted() {
            this.NuevoPermiso.PermisosSeleccionados=this.$page.props.permisosIDAsignados;
        },
        data() {
            return {
                NuevoPermiso: {
                    id:this.$props.rol.id,
                    name:this.$props.rol.name,
                    PermisosSeleccionados:[],
                },
                Activado:[],
                isCheckad:false,
                data:[],
                ListaPermisos:[],
            }
        },
        methods: {
            AsignarPermisos(){
                this.$inertia.get(route("Permisos.asignar",this.NuevoPermiso))
            },

            MarcarTotalPermisos(){
                if (this.isCheckad==true) {
                    this.NuevoPermiso.PermisosSeleccionados=[];
                    for (var permiso of this.ListaPermisosTotal ) {
                        this.NuevoPermiso.PermisosSeleccionados.push(permiso.id);
                    }
                }
                else{
                    this.NuevoPermiso.PermisosSeleccionados=[];
                }
            }
        },
    };
</script>

<template>
    <Head title="Asignar Permisos" />
        <AuthenticatedLayout>

            <template #header>
                <div class="pl-8">Asignar permisos a {{ NuevoPermiso.name }}</div>
            </template>
            <!--Seccion para editar permisos del rol-->
            <div class="py-7">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white dark:bg-slate-700 overflow-hidden shadow-xl sm:rounded-lg">
                        <form @submit.prevent="AsignarPermisos" class="mb-6">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 -8 mt-5 mx-7">
                                <div class='flex-inline '>

                                    <label class="uppercase md:text-sm text-xs text-gray-500 dark:text-gray-200 text-light font-semibold">
                                        Nombre del Rol
                                    </label>
                                    <input readonly
                                        id="name"
                                        v-model="NuevoPermiso.name"
                                        class="rounded-lg  border-none dark:text-gray-200 dark:bg-slate-700 w-full" type="text"
                                    />
                                    <input readonly hidden
                                        id="id"
                                        v-model="NuevoPermiso.id"
                                        class="rounded-lg border-2 border-purple-300 mt-1 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" type="text"
                                    />
                                </div>
                            </div>

                            <strong class="pl-8 dark:text-gray-200">Permisos actuales de este rol</strong>
                            <div class="pl-8 dark:text-gray-200">
                                <span v-for="(permisos, index) in permisosAsignados" :key="index">
                                    <li class="">{{permisos}}</li>
                                </span>
                            </div>

                            <span v-if="permisosAsignados.length==0" class="pl-8 dark:text-gray-200">
                                Este rol no tiene permisos asignados
                            </span>

                            <br>

                            <strong class="pl-8 dark:text-gray-200">Marque los permisos que tendrá este rol</strong>
                            <div class="inline-flex justify-end items-end w-1/2">
                                <span class="dark:text-gray-200">Seleccionar todos</span>
                                <input type="checkbox" v-model="isCheckad" @change="MarcarTotalPermisos" class="ml-1 mb-1"/>
                            </div>

                            <div class="pl-8 mt-2 mb-2 dark:text-gray-200 w-full">
                                <label v-for="(permisos, index) in ListaPermisosTotal" :key="index">
                                    <div class="flex ">
                                        <input type="checkbox" class="mt-2"
                                        v-model="NuevoPermiso.PermisosSeleccionados" :value="permisos.id"/>
                                        <span class="ml-1 ">{{permisos.name}}</span>
                                    </div>
                                </label>
                            </div>

                            <div class='flex justify-end md:gap-8 gap-4 pt-5 pb-5 pr-5 w-full'>
                                <Link
                                    :href="route('Roles.index')"
                                    class='w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2' type="button">
                                    Cancelar
                                </Link>

                                <button
                                type="submit"
                                class='w-auto bg-[#014E82] hover:bg-[#0284c7] rounded-lg shadow-xl font-medium text-white px-4 py-2 '>
                                    Asignar Permisos
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
</template>
