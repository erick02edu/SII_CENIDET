<script setup>

import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

defineProps({
    canResetPassword: Boolean,
    status: String,

});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};

</script>

<template>
    <Head title="Log in" />

    <div class="flex h-screen">

        <div class="w-1/2 justify-center items-center px-10 pt-10">

            <form @submit.prevent="submit" class="py-20 px-10">

                <p class="pt-10 pb-2 text-2xl uppercase">INICIAR Sesión</p>

                <div v-if="status" class=" font-medium text-xs text-red-600 ">
                Credenciales invalidas favor de revisar los datos ingresados
                </div>


                <div>
                    <i class="fa-solid fa-user pr-2"></i>
                    <InputLabel for="email" value="correo"  />
                    <TextInput
                        id="email"
                        v-model="form.email"
                        type="email"
                        class="mt-1 block w-full "
                        required
                        autofocus
                        autocomplete="username"
                    />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="mt-4">

                    <span class="">

                        <div class="w-full ">
                            <i class="fa-brands fa-expeditedssl inline pr-2 pt-1"></i>
                            <InputLabel for="password" value="Contraseña" />
                        </div>

                        <TextInput
                            id="password"
                            v-model="form.password"
                            :type="inputType"
                            class="mt-1 w-1/2"
                            required
                            autocomplete="current-password"
                        />
                        <InputError class="mt-5 mb-5" :message="form.errors.password" />

                         <Checkbox class="ml-4" v-model:checked="bandera" @change="CambiarInput"/>
                        <span class="text-sm ml-1">Mostrar contraseña </span>
                    </span>
                </div>

                <div class="block mt-4">
                    <label class="flex items-center">
                        <Checkbox v-model:checked="form.remember" name="remember" />
                        <span class="ml-2 text-sm text-gray-600">Recuerdame</span>
                    </label>
                </div>
                <br>
                <div class="flex items-center mt-4">
                    <Link v-if="canResetPassword" :href="route('password.request')" class="underline text-sm text-gray-600 hover:text-[#014E82] rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:#014E82">
                        Olvidaste tu contraseña
                    </Link>

                    <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Ingresar
                    </PrimaryButton>
                </div>
            </form>
        </div>




        <div class="w-1/2 bg-gray-300">

            <!-- <img class="h-full" src="https://i0.wp.com/bajopalabra.com.mx/wp-content/uploads/2019/06/Cenidet-2-1.jpeg?resize=1055%2C545&ssl=1" alt="Error al cargar imagen"> -->

            <!-- <img class="h-full" src="/img/CenidetLogin.jpg" alt="Error al cargar imagen"> -->
            <img class="h-full" src="/img/LoginCenidet4.jpg" alt="Error al cargar imagen">


        </div>

    </div>

</template>


<script>

    export default {

        mounted() {
            this.inputType='password',
            this.bandera=false
        },

        methods:{
            CambiarInput(){
                console.log(this.bandera)
                if(this.bandera==true){
                    this.inputType='text'
                }
                else{
                    this.inputType='password'
                }
            }
        },

        data() {
            return {

                inputType:'',
                bandera:'',
            }
        },
    }

</script>
