<template>
    <Head title="Dashboard" />
<BreezeAuthenticatedLayout>   
    <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                   Producto 
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
                Crear Producto
                </h6>
            </div>
            </div>
            <div class="flex-auto px-4 lg:px-10 py-10 pt-0">
            <form @submit.prevent="submit">
                <BreezeValidationErrors class="mb-4" />
                <h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase">
                Iformacion 
                </h6>

              
                <div class="w-full lg:w-6/12 px-4">
                    <div class="relative w-full mb-3">
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" htmlfor="grid-password">
                            Nombre
                        </label>
                        <input id="name" type="text" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" v-model="form.name" >
                    </div>
                </div>
                <div class="w-full lg:w-6/12 px-4">
                    <div class="relative w-full mb-3">
                    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" htmlfor="grid-password">
                        Precio
                    </label>
                    <input id="price" type="text" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" v-model="form.price" >
                    </div>
                </div>
                <div class="w-full lg:w-6/12 px-4">
                    <div class="relative w-full mb-3">
                    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" htmlfor="grid-password">
                        Stock
                    </label>
                    <input id="stock" type="text" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" v-model="form.stock" >
                    </div>
                </div>
                 <div class="w-full lg:w-6/12 px-4">
                    <div class="relative w-full mb-3">
                    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" htmlfor="grid-password">
                        Descripcion
                    </label>
                    <textarea id="description" cols="30" rows="10" placeholder="whrite here.." class="w-full font-serif  p-4 text-gray-600 bg-indigo-50 outline-none rounded-md" v-model="form.description" ></textarea>
                    </div>
                </div>

                <div class="relative w-full mb-3">
                    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" htmlfor="grid-password">
                         <input type="checkbox" id="status">
                         <label for="status"> Estado: </label>
                         <label for="status"> {{ }} </label>
                    </label>
                </div>
                <div class="flex justify-center">
                <div class="mb-3 w-96">
                <label for="formFile" class="form-label inline-block mb-2 text-gray-700">Suba la imagen de producto</label>
                <input class="form-control
                    block
                    w-full
                    px-3
                    py-1.5
                    text-base
                    font-normal
                    text-gray-700
                    bg-white bg-clip-padding
                    border border-solid border-gray-300
                    rounded
                    transition
                    ease-in-out
                    m-0
                    focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" type="file" id="image" name="image" @input="form.image = $event.target.files[0]">
                </div>
                </div>
                <BreezeButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Crear
                </BreezeButton>
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
import BreezeValidationErrors from '@/Components/ValidationErrors.vue'
import { Head, Link } from '@inertiajs/inertia-vue3';

export default {
    
    layaut:BreezeAuthenticatedLayout,
    components: {
        BreezeButton,
        BreezeInput,
        BreezeLabel,
        BreezeAuthenticatedLayout,
        BreezeValidationErrors,
        Head,
        Link,
    },

    data() {
        return {
            form: this.$inertia.form({
                name: '',
                price: '',
                stock: '',
                description: '',
                status: '',
                image: null,
            })
        }
    },

    methods: {
        submit(){
            this.form.post(this.route('products.store'), 
                this.form
            )
        }
    }
     
  
   
}
</script>