<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detalle Producto
            </h2>
        </template>


<div x-data="{ cartOpen: false , isOpen: false }" class="bg-white">
    <header>
        <div class="container mx-auto px-6 py-3">
            <div class="flex items-center justify-between">
                <div class="hidden w-full text-gray-600 md:flex md:items-center">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M16.2721 10.2721C16.2721 12.4813 14.4813 14.2721 12.2721 14.2721C10.063 14.2721 8.27214 12.4813 8.27214 10.2721C8.27214 8.06298 10.063 6.27212 12.2721 6.27212C14.4813 6.27212 16.2721 8.06298 16.2721 10.2721ZM14.2721 10.2721C14.2721 11.3767 13.3767 12.2721 12.2721 12.2721C11.1676 12.2721 10.2721 11.3767 10.2721 10.2721C10.2721 9.16755 11.1676 8.27212 12.2721 8.27212C13.3767 8.27212 14.2721 9.16755 14.2721 10.2721Z" fill="currentColor" /><path fill-rule="evenodd" clip-rule="evenodd" d="M5.79417 16.5183C2.19424 13.0909 2.05438 7.39409 5.48178 3.79417C8.90918 0.194243 14.6059 0.054383 18.2059 3.48178C21.8058 6.90918 21.9457 12.6059 18.5183 16.2059L12.3124 22.7241L5.79417 16.5183ZM17.0698 14.8268L12.243 19.8965L7.17324 15.0698C4.3733 12.404 4.26452 7.97318 6.93028 5.17324C9.59603 2.3733 14.0268 2.26452 16.8268 4.93028C19.6267 7.59603 19.7355 12.0268 17.0698 14.8268Z" fill="currentColor" />
                    </svg>
                    <span class="mx-1 text-sm">NY</span>
                </div>
                <div class="w-full text-gray-700 md:text-center text-2xl font-semibold">
                    Merca Todo
                </div>
                <div class="flex items-center justify-end w-full">
                    
                    <a  :href="route('cart-content.index')" class="text-gray-600 focus:outline-none mx-4 sm:mx-0">
                        <svg class="h-7 w-7" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </a>(<div class="text-red-500"> {{countCart}}
                        </div>)

                    <div class="flex sm:hidden">
                        <button @click="isOpen = !isOpen" type="button" class="text-gray-600 hover:text-gray-500 focus:outline-none focus:text-gray-500" aria-label="toggle menu">
                            <svg viewBox="0 0 24 24" class="h-6 w-6 fill-current">
                                <path fill-rule="evenodd" d="M4 5h16a1 1 0 0 1 0 2H4a1 1 0 1 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="mt-16">
                <!-- search -->
                <form  @submit.prevent="submit">
                     <!-- <BreezeValidationErrors class="mb-4" />  -->
                    <div class="md:flex space-x-4">
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
                                focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" id="filterCategory" v-model="form.filterCategory">
                                   
                                <option  v-for="(category,index) in categories" :key="index" :value='category.id'>{{category.name}}</option>
                                </select>
                            </div>
                        </div>
                        <input id="filterName" class="w-48 border rounded-md pl-10 pr-4 py-2 focus:border-blue-500 focus:outline-none focus:shadow-outline" placeholder="nombre" v-model="form.filterName">
                        <input id="filterPriceMin" class="w-48 border rounded-md pl-10 pr-4 py-2 focus:border-blue-500 focus:outline-none focus:shadow-outline" placeholder="precio menor a" v-model="form.filterPriceMin">
                        <input id="filterPriceMax" class="w-48 border rounded-md pl-10 pr-4 py-2 focus:border-blue-500 focus:outline-none focus:shadow-outline" placeholder="precio mayor a" v-model="form.filterPriceMax">
                        <BreezeButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Buscar
                        </BreezeButton>
                    </div>
                </form>
            </div>
        </div>
    </header>
    <div :class="cartOpen ? 'translate-x-0 ease-out' : 'translate-x-full ease-in'" class="fixed right-0 top-0 max-w-xs w-full h-full px-6 py-4 transition duration-300 transform overflow-y-auto bg-white border-l-2 border-gray-300">
        <div class="flex items-center justify-between">
            <h3 class="text-2xl font-medium text-gray-700">Your cart</h3>
            <button @click="cartOpen = !cartOpen" class="text-gray-600 focus:outline-none">
                <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <hr class="my-3">
        <div class="mt-8">
            <form class="flex items-center justify-center">
                <input class="form-input w-48" type="text" placeholder="Add promocode">
                <button class="ml-3 flex items-center px-3 py-2 bg-blue-600 text-white text-sm uppercase font-medium rounded hover:bg-blue-500 focus:outline-none focus:bg-blue-500">
                    <span>Apply</span>
                </button>
            </form>
        </div>
        <a class="flex items-center justify-center mt-4 px-3 py-2 bg-blue-600 text-white text-sm uppercase font-medium rounded hover:bg-blue-500 focus:outline-none focus:bg-blue-500">
            <span>Chechout</span>
            <svg class="h-5 w-5 mx-2" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
        </a>
    </div>
    <main class="my-8">
        <div class="container mx-auto px-6">
            <h3 class="text-gray-700 text-2xl font-medium">Wrist Watch</h3>
            <span class="mt-3 text-sm text-gray-500">200+ Products</span>
            <div>
                <h1>{{info}}</h1>
            </div>

      <div class=" grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mt-6" >
            <div class="w-full max-w-sm mx-auto rounded-md shadow-md overflow-hidden" v-for="(product,index) in products.data" :key="index">
       
                             
                    <div class="w-full max-w-sm mx-auto rounded-md shadow-md overflow-hidden">
                        <div class="flex items-end justify-end h-56 w-full bg-cover" :style="{backgroundImage:'url('+product.image+')' }">
                            
                            <formp :product="product"/>
                        </div>
                        
                        <a :href="route('productsClient.show', product.id)">     
                        <div class="px-5 py-3">
                            <h3 class="text-gray-700 uppercase">{{product.name}}</h3>
                            <h3 class="text-gray-700 uppercase">{{product.category.name}}</h3>
                            <h3 class="text-gray-700 uppercase">{{product.stock}}</h3>
                            <span class="text-gray-500 mt-2">${{product.price}}</span>
                        </div>
                         </a> 
                    </div>
  
                
            </div>
            </div>
        </div>
    </main>

    <pagination class="mt-6 flex justify-center" :links="products.links" />

    <br>

    <footer class="bg-gray-200">
        <div class="container mx-auto px-6 py-3 flex justify-between items-center">
            <a href="#" class="text-xl font-bold text-gray-500 hover:text-gray-400">Brand</a>
            <p class="py-2 text-gray-500 sm:py-0">All rights reserved</p>
        </div>
    </footer>
</div>
         <!--endseccion products -->
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head, useForm } from '@inertiajs/inertia-vue3';
import Pagination from '../../Components/Pagination';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue'
import BreezeButton from '@/Components/Button.vue'
import { reactive } from 'vue'
import Formp from '../../Components/Formp';


export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
        BreezeValidationErrors,
        Pagination,
        BreezeButton,
        Formp,
    },
    props:['products','categories','filter', 'info','countCart'],
    
    data() {
        return {
            form: this.$inertia.form({
               filterName: this.$props.filter.filterName,
               filterPriceMin: this.$props.filter.filterPriceMin,
               filterPriceMax: this.$props.filter.filterPriceMax,
               filterCategory: this.$props.filter.filterCategory,
            }),
          
            formp: useForm({
                productId: null,
            })

        }
    },
    methods: {
        submit() {
            this.form.get(this.route('productsClient.index'), 
                 this.form
            )
        },
        submitCard() {
            this.formp.post(this.route('cart.store'), 
                 this.formp
            )
        }
    },
    
 
}

</script>
