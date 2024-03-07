<template>
    <Head title="Editar Usuario" />
    <AuthenticatedLayout>
        <template #header>
                Editar Usuario
        </template>
        <!--Seccion para editar informacion de un usuario-->
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-slate-700 overflow-hidden shadow-xl sm:rounded-lg">
                    <form @submit.prevent="EditarUsuario" class="mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-8 mt-5 mx-7">
                            <div class="grid grid-cols-1">
                                <label class="uppercase md:text-sm text-xs text-gray-500 dark:text-gray-200 text-light font-semibold">
                                    Nombre de usuario
                                </label>
                                <input
                                    id="categoria"
                                    v-model="InfoEditar.name"
                                    class="py-2 px-3 rounded-lg border-2 border-[#0285c7c6] dark:text-gray-200 dark:bg-slate-700 mt-1 focus:outline-none focus:ring-2 focus:[#014E82] focus:border-transparent" type="text"
                                />
                            </div>
                            <div class="grid grid-cols-1">
                                <label class="uppercase md:text-sm text-xs text-gray-500 dark:text-gray-200 text-light font-semibold">
                                    Correo
                                </label>
                                <input
                                    id="unidad"
                                    v-model="InfoEditar.email"
                                    class="py-2 px-3 rounded-lg border-2 border-[#0285c7c6] dark:text-gray-200 dark:bg-slate-700 mt-1 focus:outline-none focus:ring-2 focus:[#014E82] focus:border-transparent" type="email"
                                />
                            </div>
                        </div>

                        <div class='flex justify-end md:gap-8 gap-4 pt-5 pb-5 pr-5'>
                            <Link
                                :href="route('Users.index')"
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
        usuario:{
            type:Array,
            required:true,
        }
    })
    var form=useForm({
        name:props.usuario.name,
        email:props.usuario.email,
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
                    name:this.$props.usuario.name,
                    email:this.$props.usuario.email,
                },
            }
        },
        methods:{
            EditarUsuario(){
                this.$inertia.put(
                    route("Users.update",this.$props.usuario.id),
                    this.InfoEditar
                );
            },
        },
    };
</script>
