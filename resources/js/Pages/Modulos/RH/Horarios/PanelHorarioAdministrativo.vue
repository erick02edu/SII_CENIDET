<template>
    <Head title="Panel" />
    <!--Barra superior menu-->
    <header class="flex items-center justify-between border-b-2 border-[#014E82] dark:border-slate-500 w-screen  bg-white  dark:bg-slate-800 px-6 py-4">
        <div class="flex items-center">
            <button @click="$page.props.showingMobileMenu = !$page.props.showingMobileMenu" class="text-gray-500 dark:text-white focus:outline-none lg:hidden">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>

            <div class="dark:text-gray-200 justify-start pl-2">
                <span><button @click="GuardarCambios" class="px-4 py-2 rounded-md dark:text-gray-200 ml-2 mr-5 ">Volver</button></span>
            </div>
        </div>

        <div class="flex items-center">

            <div class="dark:text-gray-200 pr-2">
                <span> <i class="fa-solid fa-users pr-1"></i>
                    Rol: </span>
                    <span v-for="(rol,index) in Roles">
                        {{rol}}
                        <span v-if="Roles.length-1!=index">,</span>
                    </span>

                <span v-if="Roles.length==0">Sin rol</span>
            </div>

            <button @click="toggleDark()" class="relative inline overflow-hidden dark:text-slate-100 pr-3 pl-3 "
            v-tippy="{
                content: refContent,
                placement: 'top' ,
                arrow: true,
                theme: 'mediano'

            }">

                <div @click="CambiarIcono" class="hover:bg-gray-200 dark:hover:bg-slate-500  pr-2 pl-2 pt-0.5 pb-0.5 rounded-md">
                    <i :class="icono"></i>
                </div>

            </button>

            <button @click="GuardarCambios" class="px-4 py-2 bg-[#014E82] rounded-md text-gray-200 ml- relative inline-flex ">Guardar cambios</button>

        </div>
    </header>
    <!--Contenido del Panel-->
    <div class="bg-gray-200 w-screen min-h-screen dark:bg-gray-800 overflow-x-hidden overflow-y-auto">
        <main class="inset-0 h-auto w-screen bg-gray-200 dark:bg-gray-800 overflow-x-hidden overflow-y-auto pb-10 " >

            <p class="inline-flex font-roboto text-lg dark:text-gray-200 justify-start  pl-24 w-full items-center pt-7 ">
                <span class="uppercase">Horario Administrativo: {{ personal.Nombre }} {{ personal.ApellidoP }} {{ personal.ApellidoM }}</span>
                <div class="text-end  pl-64 ">
                    Total de Horas a la semana {{ HorasSemana }} h {{ MinutosSemana }} min
                </div>
            </p>

            <span class="font-roboto text-lg dark:text-gray-200 ml-24">Periodo:
                {{ periodo.mesInicio }} {{ periodo.AñoInicio }}-{{ periodo.mesTermino }} {{ periodo.AñoTermino }}
            </span>

            <!--PANEL HORARIO-->
            <div class="container mx-auto px-1 py-4 pt-5 overflow-x-hidden"   >
                <table class="w-full">
                    <thead class="bg-slate-700 text-gray-200 " >
                        <td class="py-3 w-1/6 text-center">
                            Lunes
                        </td>

                        <td  class="py-3 w-1/6 text-center">
                            Martes
                        </td>

                        <td  class="py-3 w-1/6 text-center" >
                            Miércoles
                        </td>

                        <td  class="py-3 w-1/6 text-center">
                            Jueves
                        </td>

                        <td  class="py-3 w-1/6 text-center">
                            Viernes
                        </td>

                        <td  class="py-3 w-1/6 text-center">
                            Sabado
                        </td>
                    </thead>
                    <tbody class="align-top " >

                        <td class="border-0 hover:bg-slate-300 dark:hover:bg-slate-500 hover:cursor-pointer">
                            <tr v-if="NuevoDiaLunes!=null" class=" dark:text-gray-200 " id="Lunes" v-for="Lunes in NuevoDiaLunes"
                            @click="showElement('Lunes')" >


                                <div class="py-5 pl-4 mt-1 dark:text-gray-200">

                                <i class="fa-solid fa-stopwatch  pr-2 text-green-400 pb-2"></i>H.Entrada:{{ Lunes.HInicio }}<br>
                                <i class="fa-solid fa-stopwatch  pr-2 text-red-400 pb-2"></i>H.Salida:{{  Lunes.HFin }}<br>
                                <i class="fa-solid fa-hourglass-half pr-2 pb-2"></i>Total Horas: <br>
                                    {{ HorasTotalesLunes }} h {{ minutosTotalesLunes }} min


                                </div>
                            </tr>

                            <tr v-else class="dark:text-gray-200 hover:bg-slate-300 dark:hover:bg-slate-500 hover:cursor-pointer "
                            @click="showElement('Lunes')">
                                <div class="px-1 py-5 mt-2">
                                + Agregar hora <br>
                                de entrada y salida
                                </div>
                            </tr>
                        </td>

                        <td class="border-0 hover:bg-slate-300 dark:hover:bg-slate-500 hover:cursor-pointer">

                            <tr v-if="NuevoDiaMartes!=null" class="dark:text-gray-200 " id="Lunes" v-for="Martes in NuevoDiaMartes"
                            @click="showElement('Martes')" >

                                <div class="py-5 pl-4 mt-1 dark:text-gray-200">
                                    <i class="fa-solid fa-stopwatch  pr-2 text-green-400 pb-2"></i>H.Entrada:{{ Martes.HInicio }}<br>
                                    <i class="fa-solid fa-stopwatch  pr-2 text-red-400 pb-2"></i>H.Salida:{{  Martes.HFin }}<br>
                                    <i class="fa-solid fa-hourglass-half pr-2 pb-2"></i>Total Horas:<br>
                                        {{ HorasTotalesMartes }} h {{ minutosTotalesMartes }} min

                                </div>
                            </tr>

                            <tr v-else class="dark:text-gray-200 hover:bg-slate-300 dark:hover:bg-slate-500 hover:cursor-pointer"
                            @click="showElement('Martes')">
                                <div class="px-5 py-5 mt-2">
                                + Agregar hora <br>
                                de entrada y salida
                                </div>
                            </tr>

                        </td>

                        <td class="border-0 hover:bg-slate-300 dark:hover:bg-slate-500 hover:cursor-pointer">

                            <tr v-if="NuevoDiaMiercoles!=null" class="dark:text-gray-200 " id="Lunes" v-for="Miercoles in NuevoDiaMiercoles"
                            @click="showElement('Miercoles')" >

                                <div class="py-5 pl-4 mt-1 dark:text-gray-200">
                                    <i class="fa-solid fa-stopwatch  pr-2 text-green-400 pb-2"></i>H.Entrada:{{ Miercoles.HInicio }}<br>
                                    <i class="fa-solid fa-stopwatch  pr-2 text-red-400 pb-2"></i>H.Salida:{{  Miercoles.HFin }}<br>
                                    <i class="fa-solid fa-hourglass-half pr-2 pb-2"></i>Total Horas: <br>
                                    {{ HorasTotalesMiercoles }} h {{ minutosTotalesMiercoles }} min

                                </div>
                            </tr>

                            <tr v-else class="dark:text-gray-200 hover:bg-slate-300 dark:hover:bg-slate-500 hover:cursor-pointer"
                            @click="showElement('Miercoles')">
                                <div class="px-5 py-5 mt-2">
                                + Agregar hora <br>
                                de entrada y salida
                                </div>
                            </tr>

                        </td>

                        <td class="border-0 hover:bg-slate-300 dark:hover:bg-slate-500 hover:cursor-pointer">

                            <tr v-if="NuevoDiaJueves!=null" class="dark:text-gray-200 " id="Lunes" v-for="Jueves in NuevoDiaJueves"
                            @click="showElement('Jueves')" >

                                <div class="py-5 pl-4 mt-1 dark:text-gray-200">
                                    <i class="fa-solid fa-stopwatch  pr-2 text-green-400 pb-2"></i>H.Entrada:{{ Jueves.HInicio }}<br>
                                    <i class="fa-solid fa-stopwatch  pr-2 text-red-400 pb-2"></i>H.Salida:{{  Jueves.HFin }}<br>
                                    <i class="fa-solid fa-hourglass-half pr-2 pb-2"></i>Total Horas: <br>
                                        {{ HorasTotalesJueves }} h {{ minutosTotalesJueves }} min
                                </div>
                            </tr>

                            <tr v-else class="dark:text-gray-200 hover:bg-slate-300 dark:hover:bg-slate-500 hover:cursor-pointer"
                            @click="showElement('Jueves')">
                                <div class="px-5 py-5 mt-2">
                                + Agregar hora <br>
                                de entrada y salida
                                </div>
                            </tr>
                        </td>

                        <td class="border-0 hover:bg-slate-300 dark:hover:bg-slate-500 hover:cursor-pointer">

                            <tr v-if="NuevoDiaViernes!=null" class="dark:text-gray-200 " id="Lunes" v-for="Viernes in NuevoDiaViernes"
                            @click="showElement('Viernes')" >

                                <div class="py-5 pl-4 mt-1 dark:text-gray-200">
                                    <i class="fa-solid fa-stopwatch  pr-2 text-green-400 pb-2"></i>H.Entrada:{{ Viernes.HInicio }}<br>
                                    <i class="fa-solid fa-stopwatch  pr-2 text-red-400 pb-2"></i>H.Salida:{{  Viernes.HFin }}<br>
                                    <i class="fa-solid fa-hourglass-half pr-2 pb-2"></i>Total Horas:<br>
                                        {{ HorasTotalesViernes }} h {{ minutosTotalesViernes }} min

                                </div>
                            </tr>

                            <tr v-else class="dark:text-gray-200 hover:bg-slate-300 dark:hover:bg-slate-500 hover:cursor-pointer"
                            @click="showElement('Viernes')">
                                <div class="px-5 py-5 mt-2">
                                + Agregar hora <br>
                                de entrada y salida
                                </div>
                            </tr>

                        </td>

                        <td class="border-0 hover:bg-slate-300 dark:hover:bg-slate-500 hover:cursor-pointer">

                            <tr v-if="NuevoDiaSabado!=null" class="dark:text-gray-200 " id="Lunes" v-for="Sabado in NuevoDiaSabado"
                            @click="showElement('Sabado')" >

                                <div class="py-5 pl-4 mt-1 dark:text-gray-200">
                                    <i class="fa-solid fa-stopwatch  pr-2 text-green-400 pb-2"></i>H.Entrada:{{ Sabado.HInicio }}<br>
                                    <i class="fa-solid fa-stopwatch  pr-2 text-red-400 pb-2"></i>H.Salida:{{  Sabado.HFin }}<br>
                                    <i class="fa-solid fa-hourglass-half pr-2 pb-2"></i>Total Horas:<br>
                                        {{ HorasTotalesSabado }} h {{ minutosTotalesSabado }} min

                                </div>
                            </tr>

                            <tr v-else class="dark:text-gray-200 hover:bg-slate-300 dark:hover:bg-slate-500 hover:cursor-pointer"
                            @click="showElement('Sabado')">
                                <div class="px-5 py-5 mt-2">
                                + Agregar hora <br>
                                de entrada y salida
                                </div>
                            </tr>
                        </td>
                    </tbody>
                </table>
            </div>
            <!--MODAL PARA UNA NUEVA CLASE-->
            <div id="modalContainer">
                <!-- Main modal -->
                <div :class="{ hidden: !isVisible } " >
                    <div id="defaultModal" tabindex="-1" aria-hidden="true"  class="fixed inset-0 flex items-center justify-center z-50">
                        <div class="relative w-full max-w-2xl max-h-full">
                            <!-- Modal content -->
                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
                                <!-- Modal header -->
                                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                        Definir hora de entrada y salida
                                    </h3>
                                    <button type="button"  @click="calcularHorasTotales(DiaEditar.HInicio,DiaEditar.HFin,DiaEditar.dia)" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>
                                <!-- Modal body -->
                                <div class="p-6 space-y-6">
                                    <form @submit.prevent=""  class="w-full max-w-lg">
                                        <div class="flex flex-wrap -mx-3 mb-6">
                                            <div class="w-full md:w-1/2 px-3 mb-2 md:mb-0">
                                                <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-first-name">
                                                    Hora entrada
                                                </label>
                                                <input id="Nombre" v-model="DiaEditar.HInicio"  class="appearance-none block w-full bg-gray-200 dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-1 leading-tight focus:outline-none focus:bg-white"  type="time" placeholder="" required>
                                                <div v-if="msjHoraInvalidas==true"
                                                class="text-red-400 text-xs ">
                                                    La hora de entrada debe ser menor a la hora de salida
                                                </div>
                                            </div>

                                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                                <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="grid-first-name">
                                                    Hora de salida
                                                </label>
                                                <input id="Nombre" v-model="DiaEditar.HFin"  class="appearance-none block w-full bg-gray-200 dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"  type="time" placeholder="" required>
                                            </div>

                                            <div class="w-full md:w-full px-3 mb-6 md:mb-0">
                                                <input id="Nombre" v-model="DiaEditar.dia" readonly  class="appearance-none w-full  bg-gray-200 dark:bg-slate-600 text-gray-700 dark:text-gray-200 border border-gray-200  dark:border-slate-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"  type="text" placeholder="" required>
                                            </div>

                                            <!-- Modal footer -->
                                            <div class="flex items-center mt-5 p-4 space-x-2 border-t border-gray-200 rounded-b dark:border-slate-500 ">
                                                <button @click="calcularHorasTotales(DiaEditar.HInicio,DiaEditar.HFin,DiaEditar.dia)"  class="text-white bg-[#014E82] hover:bg-[#0284c7]
                                                focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600
                                                dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                Aceptar</button>

                                                <button @click="EliminarDia(DiaEditar.dia)"
                                                data-modal-hide="defaultModal"
                                                type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200
                                                text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white
                                                dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                                    Eliminar
                                                </button>

                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <!-- Capa oscura -->
    <div :class="{ hidden: !isVisible }" class="fixed inset-0  bg-black opacity-50">
    </div>
</template>

<script setup>
    import { Head } from '@inertiajs/vue3';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
</script>

<script>
    import { useDark,useToggle} from '@vueuse/core'
    const isDark=useDark()
    const toggleDark=useToggle(isDark)
    export default {
        props:{
            infoHorario:Array,
            periodo:Array,
            idHorario:'',
            DiaLunes:Array,
            DiaMartes:Array,
            DiaMiercoles:Array,
            DiaJueves:Array,
            DiaViernes:Array,
            DiaSabado:Array,
            HorasTotalesLunes:0,
            minutosTotalesLunes:0,
            HorasTotalesMartes:0,
            minutosTotalesMartes:0,
            HorasTotalesMiercoles:0,
            minutosTotalesMiercoles:0,
            HorasTotalesJueves:0,
            minutosTotalesJueves:0,
            HorasTotalesViernes:0,
            minutosTotalesViernes:0,
            HorasTotalesSabado:0,
            minutosTotalesSabado:0,
            personal:Array,
            HorasSemana:0,
            MinutosSemana:0
        },
        mounted(){
            this.NuevoDiaLunes=this.$page.props.DiaLunes
            this.NuevoDiaMartes=this.$page.props.DiaMartes
            this.NuevoDiaMiercoles=this.$page.props.DiaMiercoles
            this.NuevoDiaJueves=this.$page.props.DiaJueves
            this.NuevoDiaViernes=this.$page.props.DiaViernes
            this.NuevoDiaSabado=this.$page.props.DiaSabado
            if(isDark.value==false){
                    this.icono='fa-solid fa-moon'
            }
            else{
                this.icono='fa-solid fa-sun'
            }
        },
        data(){
            return{

                Roles:this.$page.props.user.roles,
                icono:'',
                msjHoraInvalidas:false,

                NuevoDiaLunes:[],
                NuevoDiaMartes:[],
                NuevoDiaMiercoles:[],
                NuevoDiaJueves:[],
                NuevoDiaViernes:[],
                NuevoDiaSabado:[],

                isVisible:false,
                NuevoDia:{
                    HInicio:'12:00',
                    HoraFin:'13:00',
                    dia:'',
                },
                DiaEditar:[],
            }
        },
        methods:{
            //Calcular las horas totales semanales del horario
            async calcularHorasTotales(HInicio,HFin,dia){

                var HorasValidas=await this.validarHorasMayor(HInicio,HFin)
                if(HorasValidas==true){
                    await this.calcularHorasPorDia(HInicio,HFin,dia)
                    this.hideElement()
                    this.ObtenerHorasSemana()
                    this.msjHoraInvalidas=false
                }
                else{
                    this.msjHoraInvalidas=true;
                }
            },

            validarHorasMayor(hora1, hora2) {
                // Divide las horas y minutos en cada cadena
                const [h1, m1] = hora1.split(':').map(Number);
                const [h2, m2] = hora2.split(':').map(Number);

                // Crea objetos Date para las dos horas, estableciendo la fecha en 1970-01-01
                const date1 = new Date(1970, 0, 1, h1, m1);
                const date2 = new Date(1970, 0, 1, h2, m2);

                // Compara las fechas para determinar cuál es mayor
                if (date1 > date2) {
                    return false; //Es mayor la hora Inicio
                } else {
                    return true; //Es menor la hora inicio
                }
            },
            calcularHorasPorDia(HInicio,HFin,dia){
                const horaInicioComponents = HInicio.split(":");
                const horaFinComponents = HFin.split(":");
                // Parsea las horas y minutos en enteros
                const horaInicioHoras = parseInt(horaInicioComponents[0], 10);
                const horaInicioMinutos = parseInt(horaInicioComponents[1], 10);
                const horaFinHoras = parseInt(horaFinComponents[0], 10);
                const horaFinMinutos = parseInt(horaFinComponents[1], 10);
                // Calcula la diferencia en minutos
                const minutosInicio = horaInicioHoras * 60 + horaInicioMinutos;
                const minutosFin = horaFinHoras * 60 + horaFinMinutos;
                // Calcula la diferencia en minutos y horas
                const diferenciaMinutos = minutosFin - minutosInicio;
                const diferenciaHoras = Math.floor(diferenciaMinutos / 60);
                const diferenciaMinutosRestantes = diferenciaMinutos % 60;
                if(dia=='Lunes'){
                    this.$page.props.HorasTotalesLunes=diferenciaHoras
                    this.$page.props.minutosTotalesLunes=diferenciaMinutosRestantes
                }
                if(dia=='Martes'){
                    this.$page.props.HorasTotalesMartes=diferenciaHoras
                    this.$page.props.minutosTotalesMartes=diferenciaMinutosRestantes
                }
                if(dia=='Miercoles'){
                    this.$page.props.HorasTotalesMiercoles=diferenciaHoras
                    this.$page.props.minutosTotalesMiercoles=diferenciaMinutosRestantes
                }
                if(dia=='Jueves'){
                    this.$page.props.HorasTotalesJueves=diferenciaHoras
                    this.$page.props.minutosTotalesJueves=diferenciaMinutosRestantes
                }
                if(dia=='Viernes'){
                    this.$page.props.HorasTotalesViernes=diferenciaHoras
                    this.$page.props.minutosTotalesViernes=diferenciaMinutosRestantes
                }
                if(dia=='Sabado'){
                    this.$page.props.HorasTotalesSabado=diferenciaHoras
                    this.$page.props.minutosTotalesSabado=diferenciaMinutosRestantes
                }
            },

            ObtenerHorasSemana(){
                let totalHoras = 0;
                let totalMinutos = 0;

                var arregloHoras=[
                    this.$page.props.HorasTotalesLunes,
                    this.$page.props.HorasTotalesMartes,
                    this.$page.props.HorasTotalesMiercoles,
                    this.$page.props.HorasTotalesJueves,
                    this.$page.props.HorasTotalesViernes,
                    this.$page.props.HorasTotalesSabado,
                ]

                var arregloMinutos=[
                    this.$page.props.minutosTotalesLunes,
                    this.$page.props.minutosTotalesMartes,
                    this.$page.props.minutosTotalesMiercoles,
                    this.$page.props.minutosTotalesJueves,
                    this.$page.props.minutosTotalesViernes,
                    this.$page.props.minutosTotalesSabado
                ]

                for (let i = 0; i < 6; i++) {
                    console.log('ELEMENTO:',arregloHoras[i])
                    // Suma las horas y minutos a los totales
                    totalHoras += arregloHoras[i];
                    totalMinutos += arregloMinutos[i];
                }
                //  Si los minutos superan 59, ajusta las horas y minutos
                if (totalMinutos >= 60) {
                    totalHoras += Math.floor(totalMinutos / 60);
                    totalMinutos = totalMinutos % 60;
                }
                this.$page.props.HorasSemana=totalHoras
                this.$page.props.MinutosSemana=totalMinutos
            },
            showElement(dia) {

                if(dia=='Lunes'){
                    if(this.NuevoDiaLunes==null){
                        this.NuevoDiaLunes={
                            0:{
                                HInicio:'12:00',
                                HFin:'12:00',
                                dia:dia,
                            }
                        }
                        this.DiaEditar=this.NuevoDiaLunes[0]
                    }else{
                        this.DiaEditar=this.NuevoDiaLunes[0]
                    }
                }
                if(dia=='Martes'){
                    if(this.NuevoDiaMartes==null){
                        this.NuevoDiaMartes={
                            0:{
                                HInicio:'12:00',
                                HFin:'12:00',
                                dia:dia,
                            }
                        }
                        this.DiaEditar=this.NuevoDiaMartes[0]
                    }else{
                        this.DiaEditar=this.NuevoDiaMartes[0]
                    }
                }
                if(dia=='Miercoles'){
                    if(this.NuevoDiaMiercoles==null){
                        this.NuevoDiaMiercoles={
                            0:{
                                HInicio:'12:00',
                                HFin:'12:00',
                                dia:dia,
                            }
                        }
                        this.DiaEditar=this.NuevoDiaMiercoles[0]
                    }else{
                        this.DiaEditar=this.NuevoDiaMiercoles[0]
                    }
                }
                if(dia=='Jueves'){
                    if(this.NuevoDiaJueves==null){
                        this.NuevoDiaJueves={
                            0:{
                                HInicio:'12:00',
                                HFin:'12:00',
                                dia:dia,
                            }
                        }
                        this.DiaEditar=this.NuevoDiaJueves[0]
                    }else{
                        this.DiaEditar=this.NuevoDiaJueves[0]
                    }
                }
                if(dia=='Viernes'){
                    if(this.NuevoDiaViernes==null){
                        this.NuevoDiaViernes={
                            0:{
                                HInicio:'12:00',
                                HFin:'12:00',
                                dia:dia,
                            }
                        }
                        this.DiaEditar=this.NuevoDiaViernes[0]
                    }else{
                        this.DiaEditar=this.NuevoDiaViernes[0]
                    }
                }
                if(dia=='Sabado'){
                    if(this.NuevoDiaSabado==null){
                        this.NuevoDiaSabado={
                            0:{
                                HInicio:'12:00',
                                HFin:'12:00',
                                dia:dia,
                            }
                        }
                        this.DiaEditar=this.NuevoDiaSabado[0]
                    }else{
                        this.DiaEditar=this.NuevoDiaSabado[0]
                    }
                }

                this.isVisible = true;
            },

            async EliminarDia(dia){
                if(dia=='Lunes'){
                    await this.hideElement()
                    this.NuevoDiaLunes=null
                    this.$page.props.HorasTotalesLunes=0
                    this.$page.props.minutosTotalesLunes=0
                }
                if(dia=='Martes'){
                    await this.hideElement()
                    this.NuevoDiaMartes=null
                    this.$page.props.HorasTotalesMartes=0
                    this.$page.props.minutosTotalesMartes=0
                }
                if(dia=='Miercoles'){
                    await this.hideElement()
                    this.NuevoDiaMiercoles=null
                    this.$page.props.HorasTotalesMiercoles=0
                    this.$page.props.minutosTotalesMiercoles=0
                }
                if(dia=='Jueves'){
                    await this.hideElement()
                    this.NuevoDiaJueves=null
                    this.$page.props.HorasTotalesJueves=0
                    this.$page.props.minutosTotalesJueves=0
                }
                if(dia=='Viernes'){
                    await this.hideElement()
                    this.NuevoDiaViernes=null
                    this.$page.props.HorasTotalesViernes=0
                    this.$page.props.minutosTotalesViernes=0
                }
                if(dia=='Sabado'){
                    await this.hideElement()
                    this.NuevoDiaSabado=null
                    this.$page.props.HorasTotalesSabado=0
                    this.$page.props.minutosTotalesSabado=0
                }

                this.ObtenerHorasSemana()

            },

            hideElement() {
                this.isVisible=false
            },
            async GuardarCambios(){
                try {
                    const response = await this.$inertia.post(route('Dias.store'), {
                        NuevoDiaLunes: this.NuevoDiaLunes,
                        NuevoDiaMartes: this.NuevoDiaMartes,
                        NuevoDiaMiercoles: this.NuevoDiaMiercoles,
                        NuevoDiaJueves: this.NuevoDiaJueves,
                        NuevoDiaViernes: this.NuevoDiaViernes,
                        NuevoDiaSabado: this.NuevoDiaSabado,
                        idHorario:this.$page.props.idHorario
                    });
                } catch (error) {
                    console.error(error);
                }
            },
            CambiarIcono(){
                if(isDark.value==true){
                    this.icono='fa-solid fa-moon'
                }
                else{
                    this.icono='fa-solid fa-sun'
                }
            },

        },
    }
</script>
