<template>
    <Head title="Editar aviso" />
    <AuthenticatedLayout>
    <template #header>
            Editar aviso
    </template>

    <!--Seccion para editar avisos-->
    <div class="w-full mb-5">
        <div class="w-11/12 mb-1  ">
            <label class=" uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2 mr-2" for="grid-first-name">
                Título
            </label>
        </div>
        <p v-if="mensajeTitulo==true" class="text-sm text-red-600 ">Por favor llena este campo</p>
        <input id="Nombre"
            class="  mr-56 appearance-none  w-3/6 bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none
             focus:bg-white" v-model="InfoEditar.Titulo"
        type="text" placeholder="Ingresa un titulo" required>

        <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-first-name">
            DESCRIPCIÓN
        </label>
        <p v-if="mensajeDescripcion==true" class="text-sm text-red-600 ">Por favor llena este campo</p>
        <div class="flex items-start justify-start ">
                <textarea class="appearance-none w-11/12 bg-white dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-slate-600 rounded
                px-4 mb-3 focus:bg-white h-60 content-start" placeholder="Escribe aquí..."
                v-model="InfoEditar.Descripcion" required></textarea>
        </div>
    </div>
    <!--Seccion de botones(Guardar y cancelar)-->
    <div class="flex items-center  space-x-2 rounded-b dark:border-gray-200">
        <button type="submit" @click="EditarAviso"
        class="text-white bg-[#014E82] hover:bg-[#0284c7] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Guardar cambios
        </button>
        <Link
            :href="route('Avisos.index')"
            class='w-auto bg-gray-700 hover:bg-gray-600 rounded-lg shadow-xl font-medium text-white px-4 py-2' type="button">
            Cancelar
        </Link>
    </div>
    </AuthenticatedLayout>
</template>

<script setup>

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import Pagination from '@/Components/Pagination.vue'
    import { Head } from '@inertiajs/vue3';
    import { Link } from '@inertiajs/vue3'

</script>

<script>
    import axios from 'axios';
    import Swal from 'sweetalert2'
    import { useDark,useToggle} from '@vueuse/core'
    const isDark=useDark()

    export default {
        components:{
            Link
        },
        props:{
            aviso:Array,
        },
        data() {
            return {
                mensajeTitulo:false,
                mensajeDescripcion:false,


                InfoEditar: {
                    id:this.$props.aviso.id,
                    Titulo:this.$props.aviso.Titulo,
                    Descripcion:this.$props.aviso.Descripcion,
                },
            }
        },
        methods: {
            ComprobarCampos(){

                var camposValidos=true;

                if(this.InfoEditar.Titulo==''){
                    this.mensajeTitulo=true;
                    camposValidos=false;
                }
                else{
                    this.mensajeTitulo=false;
                }

                if(this.InfoEditar.Descripcion==''){
                    this.mensajeDescripcion=true;
                    camposValidos=false;
                }
                else{
                    this.mensajeDescripcion=false;
                }

                return camposValidos;
            },
            async EditarAviso(){

                try{
                    if(this.ComprobarCampos()==true){
                        this.$inertia.put(
                            route("Avisos.update",this.$props.aviso.id),
                                this.InfoEditar
                        );
                    }
                }catch (error) {
                    console.error(error);
                }


            },
        }
    };
</script>





