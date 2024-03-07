<template>
    <Head title="Promedios" />
    <AuthenticatedLayout>
    <template #header>
            Promedios
    </template>


    <div id="modalContainer">
        <button :type="type" @click="verSeleccionados" class="rounded-md bg-[#014E82] px-5 py-3 mb-2 text-center text-sm text-white hover:bg-[#0284c7]  ">
            Obtener promedio de {{ AlumnosSeleccionados.length }} alumno(s)
        </button>
    </div>

      <!--TABLA DE PLAZAS-->
      <div class="inline-block min-w-full overflow-hidden rounded-lg shadow">
            <table class="w-full whitespace-no-wrap">
                <!--Encabezados-->
                <thead>
                    <tr class="border-b bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">

                        <th class="border-b-2 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200">

                        </th>

                        <th class="border-b-2 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200">
                            noControl
                        </th>
                        <th class="border-b-2 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200">
                            Materia
                        </th>
                        <th class="border-b-2 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200">
                            Calificacion
                        </th>
                        <th class="border-b-2 border-gray-300 dark:border-slate-700 bg-gray-300 dark:bg-slate-700 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-200">
                            Periodo
                        </th>


                    </tr>
                </thead>
                <!--FILAS-->
                <tbody>
                    <tr v-for="calificacion in calificaciones" :key="calificacion.id" class="text-gray-700">

                        <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-5 py-5 text-sm">
                            <input type="checkbox" v-model="AlumnosSeleccionados" :value="calificacion.noControl">
                        </td>

                        <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-5 py-5 text-sm">
                            <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap">{{ calificacion.noControl }}</p>
                        </td>

                        <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-5 py-5 text-sm">
                            <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap">{{ calificacion.Materia }}</p>
                        </td>

                        <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-5 py-5 text-sm">
                            <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap">{{ calificacion.Calificacion }}</p>
                        </td>


                        <td class="border-b border-gray-200 dark:border-slate-700  bg-white dark:bg-slate-800 px-5 py-5 text-sm">
                            <p class="text-gray-900 dark:text-gray-200 whitespace-no-wrap">
                                {{ periodos[calificacion.idPeriodo-1].mesInicio}} {{ periodos[calificacion.idPeriodo-1].AñoInicio}}-{{ periodos[calificacion.idPeriodo-1].mesTermino}} {{ periodos[calificacion.idPeriodo-1].AñoTermino}}

                            </p>
                        </td>

                    </tr>
                </tbody>

            </table>

            {{ AlumnosSeleccionados.length }}
            {{ AlumnosSeleccionados }}

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

    components:{
        Link
    },
    props:{
        calificaciones:Array,
        periodos:Array
    },


    data() {
    return {
        AlumnosSeleccionados:[],
    }
  },

  methods: {
    verSeleccionados(){
        console.log('Alumnos seleccionados:', this.AlumnosSeleccionados);
    }
  }

};
</script>

