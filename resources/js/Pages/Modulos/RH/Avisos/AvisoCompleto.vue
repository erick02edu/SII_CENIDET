<template>
    <Head :title=aviso.Titulo />
    <AuthenticatedLayout>
        <template #header>
            {{ aviso.Titulo }}
        </template>

        <div class="w-full inline dark:text-white ">
            <i class="fa-solid fa-calendar-days pr-1"></i>
            Fecha de publicacion: {{ aviso.FechaPublicacion }}
        </div>

        <div class="py-2 dark:text-white">
            Descripcion del aviso:<br>
            <div class="bg-white px-5 py-5 mt-4 dark:bg-slate-700 overflow-hidden shadow-xl sm:rounded-lg">
                {{ aviso.Descripcion }}
            </div>

            <div class='flex justify-start md:gap-8 gap-4 pt-5 pb-5 pr-5'>
                <Link
                    :href="route('dashboard')"
                    class='w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2' type="button">
                            Volver
                </Link>
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
        aviso:Array
    })
</script>

<script>
    export default {
        mounted() {
            this.MarcarLeido();
        },
        components:{
            Link
        },
        methods: {
            async MarcarLeido(){
                await axios.get('Avisos.Leido',{   params:{ idAviso:this.$page.props.aviso.id}   })
            }
        },
    };
</script>
