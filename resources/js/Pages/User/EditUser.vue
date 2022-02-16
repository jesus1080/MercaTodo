<template>
    <Head title="Dashboard" />
<BreezeAuthenticatedLayout>   
    <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Editar Cliente 
                </h2>
    </template>

    <!-- component -->
        <link rel="stylesheet" href="https://demos.creative-tim.com/notus-js/assets/styles/tailwind.css">
        <link rel="stylesheet" href="https://demos.creative-tim.com/notus-js/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css">
        <section class=" py-1 bg-blueGray-50">
        <div class="w-full lg:w-8/12 px-4 mx-auto mt-6">
        <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-blueGray-100 border-0">
            <div class="rounded-t bg-white mb-0 px-6 py-6">
            <div class="text-center flex justify-between">
                <h6 class="text-blueGray-700 text-xl font-bold">
                Cliente
                </h6>
            </div>
            </div>
            <div class="flex-auto px-4 lg:px-10 py-10 pt-0">
            <form @submit.prevent="submit">
                <h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase">
                Iformacion 
                </h6>

              
                <div class="w-full lg:w-6/12 px-4">
                    <div class="relative w-full mb-3">
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" htmlfor="grid-password">
                            First Name
                        </label>
                        <input id="first_name" type="text" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"  v-model="form.first_name">
                    </div>
                </div>
                <div class="w-full lg:w-6/12 px-4">
                    <div class="relative w-full mb-3">
                    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" htmlfor="grid-password">
                        Last Name
                    </label>
                    <input id="last_name" type="text" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" v-model="form.last_name">
                    </div>
                </div>
                <div class="w-full lg:w-6/12 px-4">
                    <div class="relative w-full mb-3">
                    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" htmlfor="grid-password">
                        Telefono
                    </label>
                    <input id="phone" type="text" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" v-model="form.phone">
                    </div>
                </div>
                 <div class="w-full lg:w-6/12 px-4">
                    <div class="relative w-full mb-3">
                    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" htmlfor="grid-password">
                        Dni
                    </label>
                    <input id="dni" type="text" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" v-model="form.dni">
                    </div>
                </div>

                <div class="relative w-full mb-3">
                    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" htmlfor="grid-password">
                         <input type="checkbox" id="status" v-model="form.status">
                         <label for="status"> Estado: </label>
                         <label for="status"> {{ form.status }} </label>
                    </label>
                </div>
                <button class="bg-pink-500 text-white active:bg-pink-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150" type="submit">
                    Editar
                </button>
            </form>
            </div>
        </div>
        </div>
        </section>
</BreezeAuthenticatedLayout>
</template>

<script>
import BreezeButton from '@/Components/Button.vue'
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import BreezeInput from '@/Components/Input.vue'
import BreezeLabel from '@/Components/Label.vue'
import { Head, Link } from '@inertiajs/inertia-vue3';

export default {
    
    layaut:BreezeAuthenticatedLayout,
    components: {
        BreezeButton,
        BreezeInput,
        BreezeLabel,
        BreezeAuthenticatedLayout,
        Head,
        Link,
    },
     
    props:['user'],

    data() {
        return {
            form: this.$inertia.form({
                first_name: this.$props.user.first_name,
                last_name: this.$props.user.last_name,
                status: this.$props.user.status!=0 ? true:false,
                dni: this.$props.user.dni,
                phone: this.$props.user.phone,
                //email: '',
                //password: '',
                //password_confirmation: '',
                terms: false,
            })
        }
    },
    
    methods: {
        submit() {
            this.form.put(this.route('users.update', this.$props.user.id), 
                 this.form
            )
        }
    }
}
</script>