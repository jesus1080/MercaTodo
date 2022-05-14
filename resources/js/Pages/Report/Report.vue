<template>
    

    <BreezeAuthenticatedLayout>
        <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Generar Reporte
                </h2>
        </template>
            
        <div>
             <form @submit.prevent="submit" action="generate" ref="form">
                <div class="lg:ml-40 ml-10 space-x-8">
                 <Datepicker name="param" v-model="date" range />
                 <input type="hidden" name="start_date" :value="startDate">
                 <input type="hidden" name="end_date" :value="endDate">
                 <button type="submit" 
                 class="bg-indigo-600 px-4 py-2 rounded-md text-white font-semibold tracking-wide cursor-pointer">New Report</button>
                </div>
             </form>
             <!-- <form @submit.prevent="submit" action="generate" ref="form">
                <div class="p-5">
                    <label for="param">Enter your name:</label>
                    <input type='text' name="param" class="px-2 ml-2 rounded-lg border">
                    <button type="submit" class="px-2 py-1 ml-2 rounded-lg border bg-gray-500 text-white hover:bg-black">Generate PDF</button>
                </div>
            </form> -->
        </div>

    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head } from '@inertiajs/inertia-vue3';
import Pagination from '../../Components/Pagination';
import { ref, onMounted, watch } from 'vue';
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
    

import 'vue-date-pick/dist/vueDatePick.css';
import dayjs from 'dayjs';
export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
        Pagination,
        Datepicker,
     
    },
    
    // props:['initialDate'],
    setup() {
        const date = ref([]);
        const startDate = ref(); 
        const endDate = ref();

        // For demo purposes assign range from the current date
        onMounted(() => {
            const start = new Date();
            const end = new Date(new Date().setDate(start.getDate() + 7));
            console.log(date)
            date.value = [start, end];
            
        });
        watch(date,()=>{
            startDate.value = dayjs(date.value[0]).format('YYYY-MM-DD')
            endDate.value = dayjs(date.value[1]).format('YYYY-MM-DD')
        });
        
        return {
            date,
            startDate,
            endDate
        }
      
    },
    // data(){
    //     return{
    //         form: this.$inertia.form({
    //             date:''
    //         })
    //     }
    // },
    methods:{
        // submit(){
        //     this.form.post(this.route('products.generate'),
        //         this.form
        //     )
        // }
        submit: function(){
            this.$refs.form.submit()
        }
    }
}
</script>