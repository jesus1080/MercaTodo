<template>
    

    <BreezeAuthenticatedLayout>
        <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Generar Reporte
                </h2>
        </template>
            
        <div>
             <form @submit.prevent="submit" action="generate" ref="form">
                
                    <div class="bg-gray-50 h-50 m-20 p-6">
                        <div class="h-5 p-2 m-1">
                            <p>Seleccione la fecha inicial y final para generar el reporte:</p>
                        </div>
                        <div class="text-center h-20 p-10 m-5">
                            <Datepicker v-model="date" range />
                        </div>
                        <input type="hidden" name="start_date" :value="startDate">
                        <input type="hidden" name="end_date" :value="endDate">
                        <div class="text-left h-20 p-10 m-5">
                        <button type="submit" 
                        class="bg-indigo-600 px-4 py-2 rounded-md text-white font-semibold tracking-wide cursor-pointer">Generar PDF</button>
                        </div>
                    </div>
             </form>
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
    setup() {
        const date = ref([]);
        const startDate = ref(); 
        const endDate = ref();

        onMounted(() => {
            const start = new Date();
            const end = new Date(new Date().setDate(start.getDate() + 7));
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
    methods:{

        submit: function(){
            this.$refs.form.submit()

            Toast.fire({
              icon: 'success',
                title: 'Generando PDF'
              });
        }
    }
}
</script>