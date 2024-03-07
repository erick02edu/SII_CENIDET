<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            Sistema Integral de Información del CENIDET
        </template>

        <div class="bg-white dark:bg-slate-700 overflow-hidden shadow-sm sm:rounded-lg ">
            <div class="p-6 border-b border-gray-200  dark:border-gray-700 dark:text-gray-200">
                Bienvenido al SII CENIDET {{ $page.props.auth.user.name }}
            </div>
        </div>

        <div class="dark:text-white w-full max-h-screen overflow-y-auto pt-2">
            <p class="dark:text-white uppercase py-3">
                Avisos pendientes:
            </p>
            <p v-if="ListaAvisos.length==0" class="py-5">No hay mensajes pendientes</p>

            <div class="w-full inline mb-2">
                <div class="flex flex-wrap">


                        <span v-for="(aviso,index) in ListaAvisos"  @click="VerAnuncio(aviso.id)"
                        class=" bg-gray-100 mr-3 mb-2 dark:bg-slate-600 dark:text-white
                        hover:bg-gray-300 dark:hover:bg-slate-500 px-5 py-4 rounded-lg ">


                                {{ aviso.Titulo }}
                                <p>
                                    <i class="fa-solid fa-calendar-days pr-1"></i>
                                    Publicado: {{ aviso.FechaPublicacion }}
                                </p>


                                <button class="mt-2 px-4 text-start py-1 bg-[#014E82] text-white hover:bg-[#0284c7] rounded-md
                                " @click="VerAnuncio(aviso.id)">
                                    Ver anuncio
                                </button>

                        </span>
                </div>
            </div>
        </div>

        <div class="w-full dark:text-white mt-3 ">
            <span class="hover:text-blue-500 underline " @click="IrAMensajesCompletos">
            Ver todos los mensajes
            <i class="fa-solid fa-arrow-right pt-2 pl-2"></i>
            </span>
        </div>

    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

    import { Head } from '@inertiajs/vue3';
</script>

<script>

    import { useDark,useToggle} from '@vueuse/core'
    const isDark=useDark()
    const toggleDark=useToggle(isDark)

    export default {
        mounted() {
            const objetoNormal = JSON.parse(JSON.stringify(this.$page.props.avisos));
            console.log(objetoNormal)
            this.ListaAvisos=objetoNormal
        },
        props:{
            avisos:0
        },
        data() {
            return {
                ListaAvisos:'Hola',
                Roles:Array,
                ListaRoles:[],
                color:'',
            }
        },
        methods: {
            VerAnuncio(idAnuncio){
                this.$inertia.get(route('Anuncio.view',{
                    id:idAnuncio
                }))
            },
            IrAMensajesCompletos(){
                this.$inertia.get(route('Anuncios'))
            }
        },
    };
</script>
