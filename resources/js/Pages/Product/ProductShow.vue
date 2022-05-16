<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detalle Del Producto {{product.name}}
            </h2>
        </template>

    <main class="flex items-center p-10 w-full h-full bg-white">
	    <div class="border-t border-b pt-16 grid grid-cols-2 gap-8">
		<div class="flex flex-col justify-start">
			<div class="flex flex-col w-full object-cover h-4/6 justify-items-start border rounded-lg overflow-hidden"
				style="min-heigth:320px">
				<img class="w-full h-full object-cover" v-bind:src=" product.image "  alt='nike shoes' >
            </div>
			</div>
			<div class="flex flex-col">
				<div class="flex flex-col gap-4">
					<h1 class="capitalize text-4xl font-extrabold">{{product.name}}</h1>
					<h2 class="text-3xl">${{product.price}}</h2>
					<p class="text-lg text-gray-500	">{{product.description}}</p>
					<h2 class="text-3xl">Cantidad:{{product.stock}}</h2>
					<div class="flex items-center gap-4 my-6 cursor-pointer ">
						<div class="bg-blue-600 px-5 py-3 text-white rounded-lg w-2/4 text-center">
							 Add to Car
						</div>
						<formp :product="product"/>
						<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-400" viewBox="0 0 20 20"
							fill="currentColor">
							<path fill-rule="evenodd"
								d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
								clip-rule="evenodd" />
						</svg>
					</div>
				</div>
			</div>
		</div>
    </main>



     </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import Formp from '../../Components/Formp';
export default{
    components:{
        BreezeAuthenticatedLayout,
		Formp,
    },
    props:['product'],
}
</script>
