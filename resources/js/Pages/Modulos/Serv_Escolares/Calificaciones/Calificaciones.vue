<template>
    <Head title="Calificaciones" />
    <AuthenticatedLayout>
        <template #header>
            Calificaciones
        </template>
        <!--Seccion para seleccionar grupo y materia-->
        <div class="w-full inline dark:text-white text-xs ">
            <div class="w-full inline text-xs">
                <!--Lista de grupos-->
                <select  v-model="grupoSeleccionado"
                    @change="BuscarAlumnos"
                    class="w-2/5 dark:bg-slate-700 dark:text-slate-200 rounded-sm text-xs">
                    <option value="0">
                        Seleccione un grupo
                    </option>

                    <option

                        v-for="grupo in grupos"
                        :key="grupo.id"
                        :value="grupo.id"
                    >
                    {{ grupo.Semestre }}-{{ grupo.Letra }}-{{ grupo.Especialidad }}
                    <span v-for="periodo in periodos">
                        <span  v-if="periodo.id==grupo.idPeriodo">
                            {{ periodo.mesInicio }} {{ periodo.AñoInicio }}-{{ periodo.mesTermino }} {{ periodo.AñoTermino }}
                        </span>
                    </span>

                    </option>
                </select>

                <div class="px-3 inline"></div>

                <!--Lista de materias-->
                <select name="periodos" v-model="materiaSelecionada"
                    v-if="grupoSeleccionado!=0"
                    @change="VerificarCalificaciones"
                    class="w-1/5 dark:bg-slate-700 dark:text-slate-200 rounded-sm text-xs">

                    <option value="0">
                        Seleccione una materia
                    </option>

                    <option
                        v-for="materia in materias"
                        :key="materia.id"
                        :value="materia"
                    >
                    {{ materia.Nombre }}

                    </option>
                </select>

                <div class="px-8 inline"></div>

                <!--Botones-->
                <div v-if="$page.props.user.roles.includes('Administrador')" class="inline">
                    <button :type="type" @click="SubirCalificaciones" class=" rounded-md bg-[#014E82] px-6 py-2  text-center text-sm text-white hover:bg-[#0284c7]  "
                    v-if="grupoSeleccionado!=0 && materiaSelecionada!=0"
                    >
                    <span v-if="Actualizar==true">Actualizar calificaciones</span>
                    <span v-if="Actualizar==false">Subir calificaciones</span>

                    <i class="fa-solid fa-arrow-up-from-bracket dark:text-white pl-2 "></i>
                    </button>
                </div>
            </div>
        </div>

        <!--Alertas de validacion-->
        <div class="w-full  mt-2
        bg-yellow-200 border border-yellow-400 text-yellow-700 px-4 py-2 rounded relative mb-1
        " v-if="mensajeValidar!=null">
        <i class="fa-solid fa-triangle-exclamation pr-2"></i>
            <strong class="block sm:inline">{{ mensajeValidar }}</strong>
        </div>

        <!--Alertas-->
        <div v-if="mensaje"
            :class="{ 'bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-3 mb-1': tipoMensaje == 'Exitoso',
            'bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-3 mb-3': tipoMensaje == 'Error' }">
            <strong class="font-bold" v-if="tipoMensaje=='Exitoso'">Éxito:</strong>
            <strong class="font-bold" v-if="tipoMensaje=='Error'">Érror:</strong>
            <span class="block sm:inline">{{ mensaje}}</span>
        </div>

        <!--TABLA DE PARA CAPTURA  DE CALIFICAIONES-->
        <div class="inline-block min-w-full overflow-hidden rounded-lg shadow mt-2 mb-6">
            <table class="w-full whitespace-no-wrap">
                    <!--Encabezados-->
                    <thead>
                        <tr class="border-b bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500" >
                            <th class="border-b-2 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200">
                                Nombre
                            </th>


                            <th v-if="$page.props.user.roles.includes('Administrador')" class="border-b-2 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200">
                                Calificación para la materia {{ materiaSelecionada.Nombre }}
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(alumno,index) in alumnos" :key="alumno.id" class="text-gray-700">

                            <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-5 py-5 text-sm">
                                <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap">
                                    {{ alumno.noControl }}-{{ alumno.Nombre }} {{ alumno.ApellidoP }} {{ alumno.ApellidoM }}
                                </p>
                            </td>

                            <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-5 py-5 text-sm"
                            >
                                <div v-if="materiaSelecionada!=0">
                                <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap">
                                    <input v-model="ListaCalificaciones[index]"
                                    type="number" class=" rounded-lg border dark:border-gray-600 dark:bg-slate-800">

                                    <span class="text-xs ml-5 text-red-600" v-if="ListaCalificaciones[index]>10 || ListaCalificaciones[index]<0">
                                        La calificación debe estar entre 0 y 10
                                    </span>

                                    <span class="text-xs ml-5 text-green-600" v-if="!ListaCalificaciones[index]">
                                        Agrega un Calificación
                                    </span>
                                </p>
                                </div>
                            </td>

                        </tr>
                    </tbody>
            </table>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/vue3';
    import { Link } from '@inertiajs/vue3'

</script>

<script>
    import axios from 'axios';

    export default {

        props:{
            materias:Array,
            grupos:Array,
            periodos:Array,
            alumnos:Array,
            mensaje:String,
            tipoMensaje:String
        },

        data() {
            return {
                materiaSelecionada:0,
                grupoSeleccionado:0,

                Actualizar:false,

                ListaIDAlumnos:[],
                ListaCalificaciones:[],

                mensajeValidar:null,
                tipoMensajeValidar:null
            }
        },

        methods: {
            BuscarAlumnos(){
                this.$page.props.mensaje=null
                this.mensajeValidar=null
                this.ListaIDAlumnos=[]
                this.ListaCalificaciones=[]


                axios.get(`/Alumnos.Grupo/${this.grupoSeleccionado}`)
                .then(response => {

                    this.resultadosBusqueda=response.data;
                    this.$page.props.alumnos=this.resultadosBusqueda;
                    this.$page.props.alumnos.forEach(alumno => {
                        this.ListaIDAlumnos.push(alumno.id)
                        this.ListaCalificaciones.push("")
                    });


                    if(this.materiaSelecionada!=0){
                        this.VerificarCalificaciones();
                    }

                })
                .catch(error => {
                    console.error('Error al hacer la busqueda:', error);
                });

            },

            validarRangoCalificaciones(calificaciones) {
                for (let i = 0; i < calificaciones.length; i++) {
                    if (calificaciones[i] < 0 || calificaciones[i] > 10) {
                    return false; // Si una calificación está fuera del rango, devuelve falso
                    }
                }
                return true; // Si todas las calificaciones están dentro del rango, devuelve verdadero
            },

            validarCalificacionesCompletas(calificaciones){
                if(calificaciones.length==0){
                    return false;
                }

                for (let i = 0; i < calificaciones.length; i++) {
                    if (calificaciones[i]=="") {
                        return false; // Si una calificación está fuera del rango, devuelve falso
                    }
                }
                return true
            },

            OcultarMensaje(){
                this.mensajeValidar=null
            },

            async VerificarCalificaciones(){
                this.$page.props.mensaje=null
                this.ListaCalificaciones=[]
                await axios.get('Calificaciones.buscar',{
                    params:{
                        Grupo:this.grupoSeleccionado,
                        Materia:this.materiaSelecionada.id
                        }
                })
                .then(response => {

                    this.resultadosBusqueda=response.data;
                    console.log('LISTA DE CALIFICACIONES',this.resultadosBusqueda)

                    if(this.resultadosBusqueda.length==0){
                        this.Actualizar=false
                    }else{
                        this.Actualizar=true
                    }

                    for(let i=0; i<this.resultadosBusqueda.length; i++){
                        console.log('Num',this.resultadosBusqueda[i].Calificacion);
                        var Calificacion=this.resultadosBusqueda[i].Calificacion
                        this.ListaCalificaciones.push(Calificacion);
                    }
                    //this.$page.props.ListaCalificaciones=this.resultadosBusqueda;
                })
                .catch(error => {
                    console.error('Error al hacer la busqueda:', error);
                });
            },

            SubirCalificaciones(){

                if(this.grupoSeleccionado==0){
                    this.mensajeValidar='No se ha seleccionado un grupo'
                }
                else{
                    if(this.materiaSelecionada==0){
                        this.mensajeValidar='No se ha seleccionado una materia'
                    }
                    else{
                        if(this.validarRangoCalificaciones(this.ListaCalificaciones)){

                            if(this.validarCalificacionesCompletas(this.ListaCalificaciones)){

                                //Enviar calificaciones

                                //Verificar si son calificaciones nuevas o hay que actualizar
                                if(this.Actualizar==false){
                                    this.$inertia.post(route('Calificaciones.subir'),{
                                        ListaCalificaciones:this.ListaCalificaciones,
                                        ListaIDAlumnos:this.ListaIDAlumnos,
                                        Materia:this.materiaSelecionada.id,
                                        grupo:this.grupoSeleccionado, //El grupo se manda para conocer el semestre
                                        profesor:this.$page.props.auth.user.id
                                    })
                                }
                                else{
                                    console.log('Actualizar')
                                    this.$inertia.post(route('Calificaciones.Actualizar'),{
                                        ListaCalificaciones:this.ListaCalificaciones,
                                        Materia:this.materiaSelecionada.id,
                                        grupo:this.grupoSeleccionado,
                                    });
                                }

                                this.mensajeValidar=null
                                this.grupoSeleccionado=0
                                this.materiaSelecionada=0;
                            }
                            else{
                                this.mensajeValidar='No se asignado calificaciones a todos los alumnos'
                            }
                        }
                        else{
                            this.mensajeValidar='Algunas calificaciones estan fuera de rango'
                            this.tipoMensajeValidar='Error'
                        }

                    }
                }
            }
        },
    }
</script>







