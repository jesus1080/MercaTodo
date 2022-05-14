<template>
  <!-- component -->
<BreezeAuthenticatedLayout>
<section class="py-20 bg-black">
 <div class="max-w-5xl mx-auto py-16 bg-white">
  <article class="overflow-hidden">
   <div class="bg-[white] rounded-b-md">
    <div class="p-9">
     <div class="space-y-6 text-slate-700">
      <img class="object-cover h-12" src="https://pbs.twimg.com/profile_images/1513243060834123776/dL8-d7zI_400x400.png" />

      <p class="text-xl font-extrabold tracking-tight uppercase font-body">
       Unwrapped.design
      </p>
     </div>
    </div>
    <div class="p-9">
     <div class="flex w-full">
      <div class="grid grid-cols-4 gap-12">
       <div class="text-sm font-light text-slate-500">
        <p class="text-sm font-normal text-slate-700">
         Invoice Detail:
        </p>
        <p>Numero:</p>
        <p>{{invoice.session_id}}</p>
        <p>Estado:</p>
        <p>{{invoice.payment_status}}</p>
       </div>
       <div class="text-sm font-light text-slate-500">
        <p class="text-sm font-normal text-slate-700">Cliente</p>
        <p>Nombre:</p>
        <p>{{client.first_name}} {{client.last_name}}</p>
        <p>Correo:</p>
        <p>{{client.email}}</p>
        <p>Dni:</p>
        <p>{{client.dni}}</p>
       
       </div>
       <div class="text-sm font-light text-slate-500">
        <p class="text-sm font-normal text-slate-700">Invoice Number</p>
        <p>{{invoice.session_id}}</p>

        <p class="mt-2 text-sm font-normal text-slate-700">
         Date of Issue
        </p>
        <p>{{invoice.created_at}}</p>
       </div>
       <div class="text-sm font-light text-slate-500">
        <p class="text-sm font-normal text-slate-700">Terms</p>
        <p>0 Days</p>

        <p class="mt-2 text-sm font-normal text-slate-700">Due</p>
        <p>00.00.00</p>
       </div>
      </div>
     </div>
    </div>

    <div class="p-9">
     <div class="flex flex-col mx-0 mt-8">
      <table class="min-w-full divide-y divide-slate-500">
       <thead>
        <tr>
         <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-normal text-slate-700 sm:pl-6 md:pl-0">
          Descripcion
         </th>
         <th scope="col" class="hidden py-3.5 px-3 text-right text-sm font-normal text-slate-700 sm:table-cell">
          Cantidad
         </th>
         <th scope="col" class="hidden py-3.5 px-3 text-right text-sm font-normal text-slate-700 sm:table-cell">
          Precio c/u
         </th>
         <th scope="col" class="py-3.5 pl-3 pr-4 text-right text-sm font-normal text-slate-700 sm:pr-6 md:pr-0">
          Precio
         </th>
        </tr>
       </thead>
       <tbody v-for="(product,index) in products" :key="index">
  
        <tr class="border-b border-slate-200">
         <td class="py-4 pl-4 pr-3 text-sm sm:pl-6 md:pl-0">
          <div class="font-medium text-slate-700">
           {{product.name}}
          </div>
          <div class="mt-0.5 text-slate-500 sm:hidden">
           1 unit at $75.00
          </div>
         </td>
         <td class="hidden px-3 py-4 text-sm text-right text-slate-500 sm:table-cell">
          {{product.pivot.quantity}}
         </td>
         <td class="hidden px-3 py-4 text-sm text-right text-slate-500 sm:table-cell">
          ${{product.price}}
         </td>
         <td class="py-4 pl-3 pr-4 text-sm text-right text-slate-500 sm:pr-6 md:pr-0">
          ${{product.price*product.pivot.quantity}}
         </td>
        </tr>

        <!-- Here you can write more products/tasks that you want to charge for-->
       </tbody>
       <tfoot>
        <tr>
         <th scope="row" colspan="3" class="hidden pt-6 pl-6 pr-3 text-sm font-light text-right text-slate-500 sm:table-cell md:pl-0">
          Subtotal
         </th>
         <th scope="row" class="pt-6 pl-4 pr-3 text-sm font-light text-left text-slate-500 sm:hidden">
          Subtotal
         </th>
         <td class="pt-6 pl-3 pr-4 text-sm text-right text-slate-500 sm:pr-6 md:pr-0">
          $0.00
         </td>
        </tr>
        <tr>
         <th scope="row" colspan="3" class="hidden pt-6 pl-6 pr-3 text-sm font-light text-right text-slate-500 sm:table-cell md:pl-0">
          Discount
         </th>
         <th scope="row" class="pt-6 pl-4 pr-3 text-sm font-light text-left text-slate-500 sm:hidden">
          Discount
         </th>
         <td class="pt-6 pl-3 pr-4 text-sm text-right text-slate-500 sm:pr-6 md:pr-0">
          $0.00
         </td>
        </tr>
        <tr>
         <th scope="row" colspan="3" class="hidden pt-4 pl-6 pr-3 text-sm font-light text-right text-slate-500 sm:table-cell md:pl-0">
          Tax
         </th>
         <th scope="row" class="pt-4 pl-4 pr-3 text-sm font-light text-left text-slate-500 sm:hidden">
          Tax
         </th>
         <td class="pt-4 pl-3 pr-4 text-sm text-right text-slate-500 sm:pr-6 md:pr-0">
          $0.00
         </td>
        </tr>
        <tr>
         <th scope="row" colspan="3" class="hidden pt-4 pl-6 pr-3 text-sm font-normal text-right text-slate-700 sm:table-cell md:pl-0">
          Total
         </th>
         <th scope="row" class="pt-4 pl-4 pr-3 text-sm font-normal text-left text-slate-700 sm:hidden">
          Total
         </th>
         <td class="pt-4 pl-3 pr-4 text-sm font-normal text-right text-slate-700 sm:pr-6 md:pr-0">
          {{invoice.total}}
         </td>
        </tr>
       </tfoot>
      </table>
     </div>
    </div>

    <div class="mt-48 p-9">
     <div class="border-t pt-9 border-slate-200">
      <div class="text-sm font-light text-slate-700">
       <p>
        Payment terms are 14 days. Please be aware that according to the
        Late Payment of Unwrapped Debts Act 0000, freelancers are
        entitled to claim a 00.00 late fee upon non-payment of debts
        after this time, at which point a new invoice will be submitted
        with the addition of this fee. If payment of the revised invoice
        is not received within a further 14 days, additional interest
        will be charged to the overdue account and a statutory rate of
        8% plus Bank of England base of 0.5%, totalling 8.5%. Parties
        cannot contract out of the Act’s provisions.
       </p>
      </div>
     </div>
    </div>
   </div>
  </article>
 </div>
</section>

<div class="fixed inset-x-0 z-20 lg:inset-x-auto bottom-6 lg:right-8 xl:right-10 xl:bottom-8">
    <div class="lg:w-72 px-6 lg:px-0">
        <div class="p-2 bg-blue-600 rounded-lg shadow-lg sm:p-3">
            <div class="flex flex-wrap items-center justify-between">
                <a href="javascript:window.print()" class="flex items-center flex-1 w-0">
                    <span class="flex p-2 bg-blue-800 rounded-lg">
                        <svg class="h-6 w-6 text-white" viewBox="0 0 24 24" src="http://127.0.0.1:8000/storage/logo/print.svg"></svg>
                        <img src="http://127.0.0.1:8000/storage/logo/print.svg" alt="">
                    </span>
                    <p class="ml-3 font-medium tracking-wide text-white truncate">
                        Imprimir factura 
                    </p>
                </a>
            </div>
        </div>
    </div>
</div>
</BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
export default {
    components: {
        BreezeAuthenticatedLayout,
    },
    props:['invoice','client','products'],

}
</script>

<style>

</style>