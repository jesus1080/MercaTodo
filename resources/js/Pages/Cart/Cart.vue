<template>
 <BreezeAuthenticatedLayout>
    <template #header>
    </template>

   <div class="container p-8 mx-auto mt-12">
      <div class="w-full overflow-x-auto">
        <div class="my-2">
          <h3 class="text-xl font-bold tracking-wider">Shopping Cart {{countCart}} item</h3>
        </div>
        <table class="w-full shadow-inner">
          <thead>
            <tr class="bg-gray-100">
              <th class="px-6 py-3 font-bold whitespace-nowrap">Imagen</th>
              <th class="px-6 py-3 font-bold whitespace-nowrap">Producto</th>
              <th class="px-6 py-3 font-bold whitespace-nowrap">Cantidad</th>
              <th class="px-6 py-3 font-bold whitespace-nowrap">Precio</th>
              <th class="px-6 py-3 font-bold whitespace-nowrap">Quitar</th>
            </tr>
          </thead>
          <tbody >
            
           
            <tr v-for="(product,index) in cartContent" :key="index">
              <td>
                <div class="flex justify-center">
                  <img
                    v-bind:src="product.options.image" 
                    class="object-cover h-28 w-28 rounded-2xl"
                    alt="image"
                  />
                </div>
              </td>
              <td class="p-4 px-6 text-center whitespace-nowrap">{{product.name}}</td>
              <td class="p-4 px-6 text-center whitespace-nowrap">
                <div>
                  <button v-on:click="decrement(product.rowId,product.qty)">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="inline-flex w-6 h-6 text-red-600"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"
                      />
                    </svg>
                  </button>
                  <input
                    type="text"
                    name="qty"
                    :value='product.qty'
                    class="w-12 text-center bg-gray-100 outline-none"
                  />
                  <button v-on:click="increment(product.rowId, product.qty)" >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="inline-flex w-6 h-6 text-green-600"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"
                      />
                    </svg>
                  </button>
                </div>
              </td>
              <td class="p-4 px-6 text-center whitespace-nowrap">${{product.price}}</td>
              <td class="p-4 px-6 text-center whitespace-nowrap">
                <Link @click="destroy(product.rowId)" >
                 <button>
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-6 h-6 text-red-400"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                    />
                  </svg>
                  </button>
                </Link>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="mt-4">
          <div class="py-4 rounded-md shadow">
            <div class="flex justify-between px-4">
              <a :href="route('productsClient.index')" type="button" class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 shadow-lg shadow-green-500/50 dark:shadow-lg dark:shadow-green-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">Seguir Comprando</a>
              <a :href="route('cart.destroy.content')" @click="empty()" type="button" class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">Eliminar Carrito</a>
            </div>
            <h3 class="text-xl font-bold text-blue-600">Order Summary</h3>
            <div class="flex justify-between px-4">
              <span class="font-bold">Subtotal</span>
              <span class="font-bold">${{cartTotal}}</span>
            </div>
            <div class="flex justify-between px-4">
              <span class="font-bold">Discount</span>
              <span class="font-bold text-red-600">- $5.00</span>
            </div>
            <div class="flex justify-between px-4">
              <span class="font-bold">Sales Tax</span>
              <span class="font-bold">$2.25</span>
            </div>
             
            <div
              class="
                flex
                items-center
                justify-between
                px-4
                py-2
                mt-3
                border-t-2
              "
            >
              <span class="text-xl font-bold">Total</span>
              <span class="text-2xl font-bold">$37.50</span>
            </div>
          </div>
        </div>
        <div class="mt-4">
          <button @click="checkout()" type="button" class="text-gray-900 bg-[#F7BE38] hover:bg-[#F7BE38]/90 focus:ring-4 focus:outline-none focus:ring-[#F7BE38]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#F7BE38]/50 mr-2 mb-2">
              <svg class="w-4 h-4 mr-2 -ml-1" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="paypal" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path fill="currentColor" d="M111.4 295.9c-3.5 19.2-17.4 108.7-21.5 134-.3 1.8-1 2.5-3 2.5H12.3c-7.6 0-13.1-6.6-12.1-13.9L58.8 46.6c1.5-9.6 10.1-16.9 20-16.9 152.3 0 165.1-3.7 204 11.4 60.1 23.3 65.6 79.5 44 140.3-21.5 62.6-72.5 89.5-140.1 90.3-43.4 .7-69.5-7-75.3 24.2zM357.1 152c-1.8-1.3-2.5-1.8-3 1.3-2 11.4-5.1 22.5-8.8 33.6-39.9 113.8-150.5 103.9-204.5 103.9-6.1 0-10.1 3.3-10.9 9.4-22.6 140.4-27.1 169.7-27.1 169.7-1 7.1 3.5 12.9 10.6 12.9h63.5c8.6 0 15.7-6.3 17.4-14.9 .7-5.4-1.1 6.1 14.4-91.3 4.6-22 14.3-19.7 29.3-19.7 71 0 126.4-28.8 142.9-112.3 6.5-34.8 4.6-71.4-23.8-92.6z"></path></svg>
              Check out with PlacetoPay
          </button>
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head, Link } from '@inertiajs/inertia-vue3';
import Pagination from '../../Components/Pagination';
import { useForm } from '@inertiajs/inertia-vue3'

export default {
     components: {
        BreezeAuthenticatedLayout,
        Head,
        Link,
        Pagination,
    },
    props:['cartContent','info', 'cartTotal','countCart'],
    data(){
      return{
        form: useForm({
          quantity: 1
        })
      }
    },
    methods:{
        destroy(id) {
              
            this.$inertia.delete(route("cart.destroy", id),);
          
            Toast.fire({
                        icon: 'success',
                        title: 'Producto Eliminado'
                        });
        },
        empty(){

            Toast.fire({
                        icon: 'success',
                        title: 'Carrito Vacio'
                        });
        },
        checkout(){
            axios.post(route("webcheckout.store")).then((response)=>{
                window.location.href=response.data.proccessUrl
                
            }).catch((exception)=>{
                
                Toast.fire({
                            icon: 'error',
                            title: 'Ocurrio un error al procesar el pago'
                            });
            })
        },
        increment(id,quantity){
                this.form.quantity = quantity + 1;
                this.form.put(route("cart.update",id))
            },
        decrement(id,quantity){
                if(quantity>1){
                    this.form.quantity = quantity-1;
                    this.form.put(route("cart.update",id))
                }
                
            },
        

    }

}
</script>

<style>

</style>