<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import Pagination from '@/Components/Pagination.vue'
    import { Head, useForm } from '@inertiajs/vue3';
    import { Link } from '@inertiajs/vue3'
    import Checkbox from '@/Components/Checkbox.vue';
    const props=defineProps({
        usuario:{
            type:Array,
            required:true,
        },
        RolesActuales:Array,
        ListaRolesTotal:Array,
        rolesMarcar:Array
    })
    var form=useForm({
        id:props.usuario.id,
        name:props.usuario.name,
        Email:props.usuario.email,
    })
</script>

<script>
    export default {
        mounted() {
            this.ObtenerRolesUsuario()
            this.NuevoRol.RolesSeleccionados=this.$page.props.rolesMarcar
        },
        components:{
            Link
        },
        data() {
            return {
                NuevoRol: {
                    id:this.$props.usuario.id,
                    name:this.$props.usuario.name,
                    RolesSeleccionados:[],
                },

                Activado:[],

                data:[],
                Roles:Array,
                ListaRoles:[],

                RolesUsuario:Array,
            }
        },
        methods: {
            async ObtenerRolesUsuario(){
                await axios.get( route("GetRolesUsuario",this.$props.usuario.id) ) // Ruta de la API en Laravel
                .then(response => {
                    this.RolesUsuario=response.data.ListaRolesUsuario;
                })
                .catch(error => {
                    console.error('Error al obtener datos:', error);
                });
            },
            AsignarRol(){
                this.$inertia.get(route("Roles.asignar",this.NuevoRol))

            },
        },
    };
</script>

<template>
    <Head title="Asignar tipo usuario" />
        <AuthenticatedLayout>
            <template #header>
                <p class="pl-8">Asignar un tipo de usuario</p>
            </template>
            <div class="py-6">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white dark:bg-slate-700 overflow-hidden shadow-xl sm:rounded-lg">
                        <form @submit.prevent="AsignarRol" class="mb-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-8 mt-5 mx-7">
                                <div class="grid grid-cols-1">
                                    <label class="uppercase md:text-sm text-xs text-gray-500 dark:text-gray-200 text-light font-semibold">Nombre del usuario</label>
                                    <p class="dark:text-gray-200">{{ NuevoRol.name }}</p>
                                </div>
                            </div>
                            <br>
                            <strong class="pl-8 dark:text-gray-200">Tipo de usuario actual:</strong>
                            <div class="pl-8">
                                <label v-for="(Rol, index) in RolesActuales" :key="index">
                                <span class=" pt-6 dark:text-gray-200">{{Rol}}</span><br>
                                </label>
                            </div>
                            <span v-if="RolesActuales.length==0" class="pl-8 dark:text-gray-200">Este usuario no tiene ningun tipo de usuario asignado actualmente<br></span>
                            <br>
                            <strong class="pl-8 dark:text-gray-200 uppercase">Cambiar el tipo de usuario</strong><br>
                            <p class="pl-8 dark:text-gray-200">Seleccione el nuevo tipo de usuario</p>
                            <div class="pl-8 dark:text-gray-200">
                                <select class="appearance-none block  bg-gray-200 dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" name="categorias"
                                v-model="NuevoRol.RolesSeleccionados" required>
                                    <option
                                        v-for="(rol,index) in ListaRolesTotal"
                                        :key="rol.id"
                                        :value="rol.id"
                                    >
                                        {{ rol.name }}
                                    </option>
                                </select>
                            </div>
                            <div class='flex justify-end md:gap-8 gap-4 pt-5 pb-5 pr-5'>
                                <Link
                                    :href="route('Users.index')"
                                    class='w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2' type="button">
                                    Cancelar
                                </Link>
                                <button
                                type="submit"
                                class='w-auto bg-[#014E82] hover:bg-[#0284c7] rounded-lg shadow-xl font-medium text-white px-4 py-2' >
                                Cambiar el tipo de usuario
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
</template>

