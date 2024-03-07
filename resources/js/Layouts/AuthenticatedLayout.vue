<template>
    <div class="flex h-screen bg-gray-200 font-roboto ">
        <Navigation />

        <div class="flex flex-1 flex-col overflow-hidden">
            <Header />
            <main class="flex-1 overflow-y-auto overflow-x-auto bg-gray-200 dark:bg-gray-800" >
                <div class="container mx-auto px-6 py-8"  >
                    <!-- Cambiar texto text-gray-700 -->
                    <h3 class="mb-4 text-3xl font-medium text-gray-700 dark:text-white ">
                        <slot name="header" />
                    </h3>
                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>

<script setup>
import Header from '@/Layouts/Header.vue';
import Navigation from '@/Layouts/Navigation.vue';

</script>

<style scoped>
.max-h-64 {
  /* Establece una altura máxima */
  max-height: 16rem;
}

.overflow-y-auto::-webkit-scrollbar {
  width: 4px; /* Ancho de la barra de desplazamiento */
}

.overflow-y-auto::-webkit-scrollbar-thumb {
  background-color:#757c81a5; /* Color del pulgar de la barra de desplazamiento */
  border-radius: 2px; /* Bordes redondeados del pulgar */
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
  background-color: #3371a3; /* Color del pulgar de la barra de desplazamiento al pasar el mouse */
}

.overflow-x-auto::-webkit-scrollbar {
  width: 4px; /* Ancho de la barra de desplazamiento */
}

.overflow-x-auto::-webkit-scrollbar-thumb {
  background-color:#757c81a5; /* Color del pulgar de la barra de desplazamiento */
  border-radius: 2px; /* Bordes redondeados del pulgar */
}

.overflow-x-auto::-webkit-scrollbar-thumb:hover {
  background-color: #3371a3; /* Color del pulgar de la barra de desplazamiento al pasar el mouse */
}

</style>

