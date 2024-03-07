<template>
    <header class="flex items-center justify-between border-b-2 border-[#014E82] dark:border-slate-500    bg-white  dark:bg-slate-800 px-6 py-4">
        <div class="flex items-center w-1/2 py-0">
            <button @click="$page.props.showingMobileMenu = !$page.props.showingMobileMenu" class="text-gray-500 dark:text-white focus:outline-none lg:hidden">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
            <div class="dark:text-gray-200 justify-start pl-2">
                <span> <i class="fa-solid fa-users pr-1"></i>
                    Tipo de usuario: </span>
                    <span v-for="(rol,index) in Roles">
                        {{rol}}
                        <span v-if="Roles.length-1!=index">,</span>
                    </span>
                <span v-if="Roles.length==0">Sin rol</span>
            </div>
        </div>

        <div class="flex items-center">
            <img :src="LogoCenidetURL" alt="Descripción de la imagen" class="w-25 h-10 pl-4">
            <button @click="toggleDark()" class="relative inline overflow-hidden dark:text-slate-100 pr-3 pl-3 "
            v-tippy="{
                content: 'ModoOscuro',
                placement: 'top' ,
                arrow: true,
                theme: 'MyTheme'

            }">
                <div @click="CambiarIcono" class="hover:bg-gray-200 dark:hover:bg-slate-500  pr-2 pl-2 pt-0.5 pb-0.5 rounded-md">
                    <i :class="icono"></i>
                </div>
            </button>
            <dropdown>
                <template #trigger>
                    <button @click="dropdownOpen = ! dropdownOpen" class="relative inline overflow-hidden dark:text-slate-100 pl-5  ">
                        {{ $page.props.auth.user.name }}
                    </button>

                </template>

                <template #content>
                    <!-- <dropdown-link :href="route('profile.show')">
                        Perfil
                    </dropdown-link> -->
                    <dropdown-link class="w-full text-left" :href="route('logout')" method="post" as="button">
                        Cerrar sesión
                    </dropdown-link>
                </template>
            </dropdown>
        </div>
    </header>
</template>

<script setup>
    import Dropdown from '@/Components/Dropdown.vue';
    import DropdownLink from '@/Components/DropdownLink.vue';
</script>

<script>
    import { useDark,useToggle} from '@vueuse/core'
    import { directive } from 'vue-tippy'

    const isDark=useDark()
    const toggleDark=useToggle(isDark)

    export default {
        directives: {
            tippy: directive,
        },
        mounted() {
            if(isDark.value==false){
                this.icono='fa-solid fa-moon'
                this.LogoCenidetURL='/img/CenidetLogoClaro.png'
                this.$page.props.colorModal="#f1f5f9"
                this.$page.props.textoModal="#014E82"
            }
            else{
                this.LogoCenidetURL='/img/CenidetLogoOscuro.png'
                this.icono='fa-solid fa-sun'
                this.$page.props.colorModal="#1f2937"
                this.$page.props.textoModal="#f1f5f9"
            }
        },
        methods:{
            CambiarIcono(){
                if(isDark.value==true){
                    this.LogoCenidetURL='/img/CenidetLogoClaro.png'
                    this.icono='fa-solid fa-moon'
                    this.$page.props.colorModal="#f1f5f9"
                    this.$page.props.textoModal="#014E82"
                }
                else{
                    this.LogoCenidetURL='/img/CenidetLogoOscuro.png'
                    this.icono='fa-solid fa-sun'
                    this.$page.props.colorModal="#1f2937"
                    this.$page.props.textoModal="#f1f5f9"
                }
            }
        },
        data() {
            return {
                icono:'',
                notificaciones:['1 notificacion','2 notificacion','3 notificacion '],
                Roles:this.$page.props.user.roles,
                LogoCenidetURL:'/img/CenidetLogoClaro.png'
            }
        },
    }
</script>

<style>
    .tippy-box[data-theme~='MyTheme'] {
        background-color: rgb(51 65 85);

        color: rgb(255, 250, 250);
        box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2);
        border-radius: 6px;
        font-size: 15px;
        padding: 5px;
    }
</style>

