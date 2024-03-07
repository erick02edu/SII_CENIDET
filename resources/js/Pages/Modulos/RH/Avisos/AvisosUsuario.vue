<template>
    <Head title="Lista de avisos" />
    <AuthenticatedLayout>
        <template #header>
            Lista de avisos
        </template>
        <!--Seccion donde se visualizan los avisos-->
        <div class="dark:text-white w-full max-h-screen overflow-y-auto pt-2">
            <p class="dark:text-white uppercase py-3">
                Mis avisos
            </p>
            <p v-if="ListaAvisos.length==0" class="py-5">No hay mensajes</p>
            <div class="w-full inline mb-2">
                <div class="flex flex-wrap">
                    <!--Recorrer y mostrar avisos-->
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
        <!--Boton de volver-->
        <div class="w-full dark:text-white mt-3">
            <span class="hover:text-blue-500 underline " @click="VolverDashboard">
            Volver
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
            VolverDashboard(){
                this.$inertia.get(route('dashboard'))
            }
        },
    };
</script>
