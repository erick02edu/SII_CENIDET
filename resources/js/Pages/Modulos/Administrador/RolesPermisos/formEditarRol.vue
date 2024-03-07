<template>
    <Head title="Editar tipo de usuario" />
    <AuthenticatedLayout>
        <template #header>
                Editar tipo de usuario
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-slate-700 overflow-hidden shadow-xl sm:rounded-lg">

                    <form @submit.prevent="EditarRol" class="mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-8 mt-5 mx-7">

                            <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 dark:text-gray-200 text-light font-semibold">
                                Nombre del tipo de usuario
                            </label>
                            <input
                                id="NombreAula"
                                v-model="InfoEditar.name"
                                class="py-2 px-3 rounded-lg border-2 border-[#0285c7c6] dark:text-gray-200 dark:bg-slate-700 mt-1 focus:outline-none focus:ring-2 focus:[#014E82] focus:border-transparent" type="text"
                            />
                            </div>
                        </div>

                        <div class='flex justify-end md:gap-8 gap-4 pt-5 pb-5 pr-5'>
                        <Link
                            :href="route('Roles.index')"
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
    import { Head, useForm } from '@inertiajs/vue3';
    import { Link } from '@inertiajs/vue3'
    const props=defineProps({
        rol:{
            type:Array,
            required:true,
        }
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

        data() {
            return {
                InfoEditar: {
                    id:this.$props.rol.id,
                    name:this.$props.rol.name,
                },
            }
        },

        methods:{
            EditarRol(){
                console.log(this.InfoEditar);
                this.$inertia.put(
                route("Roles.update",this.$props.rol.id),
                    this.InfoEditar
                );
            },
        },
    };
</script>
