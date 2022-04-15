<template>
    

    <BreezeAuthenticatedLayout>
        <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Lista De Facturas
                </h2>
        </template>
        
            <div class="flex items-center justify-between">
            
                    <div class="lg:ml-40 ml-10 space-x-8">
                        <button class="bg-indigo-600 px-4 py-2 rounded-md text-white font-semibold tracking-wide cursor-pointer">New Report</button>
                      
                    </div>
                </div>
            
       
    
  <table class="min-w-full leading-normal">
                            <thead>
                                <tr>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Referencia
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Estado
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Total
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Efectuar Pago
                                    </th>
                                     <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(invoice,index) in invoices.data" :key="index">
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <div class="flex items-center">
                                                <div class="ml-3">
                                                    <p class="text-gray-900 whitespace-no-wrap">
                                                        {{invoice.session_id}}
                                                    </p>
                                                </div>
                                        </div>
                                    </td>
                                     <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <div class="flex items-center">
                                                <div class="ml-3">
                                                    <p class="text-gray-900 whitespace-no-wrap">
                                                        {{invoice.payment_status}}
                                                    </p>
                                                </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <div class="flex items-center">
                                                <div class="ml-3">
                                                    <p class="text-gray-900 whitespace-no-wrap">
                                                        {{invoice.total}}
                                                    </p>
                                                </div>
                                        </div>
                                    </td>
                                     <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <div class="flex items-center">
                                                <div class="ml-3">
                                                    <p class="text-gray-900 whitespace-no-wrap">
                                                        
                                                    </p>
                                                     <button class="border-2 border-yellow-400 text-black px-4 py-2 rounded-md text-1xl font-medium hover:bg-yellow-400 transition duration-300">
                                                         
                                                        <a :href="invoice.url" type="button">Pagar</a> 

                                                     </button>
                                                </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <div class="flex items-center">
                                                <div class="ml-3">
                                                   
                                                    <a :href="route('webchekout.show', invoice.id)">ver factura</a>
                                                    
                                                </div>
                                        </div>
                                    </td>
                                    
                                </tr>
                                <div>
                                    <br>
                                    {{info}}
                                </div>
                            </tbody>
                        </table>
                        
      
        <!--seccion products -->
         <!-- tailwind.config.js -->




<!-- component -->


 <!--endseccion products -->
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head } from '@inertiajs/inertia-vue3';
import Pagination from '../../Components/Pagination';

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
        Pagination,
    },
    props:['invoices','info']
}
</script>
