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
                Editar Producto
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
                         <input type="checkbox" id="status" v-model="form.status">
                         <label for="status"> Estado: </label>
                         <label for="status"> {{ form.status }} </label>
                    </label>
                </div>
                <div class="flex justify-center">
                <div class="mb-3 w-96">
                <label for="formFile" class="form-label inline-block mb-2 text-gray-700">Editar Imagen</label>
                 <div class="flex">
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
                        <div class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                <span type="hidden">
                                    <img v-bind:src=" product.image " class="img-responsive object-cover h-20 w-20 ..." >
                                </span>
                        </div>
                 </div>
                </div>
                 <h1>Categoria:</h1>
                        <div class="flex justify-center">
                            <div class="mb-3 xl:w-96">
                                <select class="form-select appearance-none
                                block
                                w-full
                                px-3
                                py-1.5
                                text-base
                                font-normal
                                text-gray-700
                                bg-white bg-clip-padding bg-no-repeat
                                border border-solid border-gray-300
                                rounded
                                transition
                                ease-in-out
                                m-0
                                focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" id="categoryId" v-model="form.categoryId">
                                   
                                <option  v-for="(category,index) in categories" :key="index" :value='category.id'>{{category.name}}</option>
                            </select>
                    </div>
                </div>
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
import BreezeValidationErrors from '@/Components/ValidationErrors.vue'
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';


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
        useForm,
    },
    props:['product','categories'],

    data(){
        return{ 
            form : useForm({
                _method: 'put',
                name: this.$props.product.name,
                price: this.$props.product.price,
                stock: this.$props.product.stock,
                description: this.$props.product.description,
                status: this.$props.product.status!=0 ? true:false,
                categoryId: this.$props.product.category_id,
                image: null,
                terms: false,

            })
        }
    },

    methods: {
        submit(){
            console.log("cualquier cosa");
            this.form.post(this.route('products.update', this.$props.product), {
                
                image: this.$props.product.image,
            })
        }
        
    }

   
  
   
}




</script>