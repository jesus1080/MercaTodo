<template>
<div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" v-show="modal">
  <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
   
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

    
    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

    
    <div v-show="modal" class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
      <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
        <div class="sm:flex sm:items-start">
          <div class="mx-auto flex-shrink-0 flex items-center justify-center h-15 w-15 rounded-full sm:mx-0 sm:h-10 sm:w-10">
            <img src="http://127.0.0.1:8000/storage/logo/excel2.svg">
          </div>
          <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
            <form @submit.prevent="submit">
              <label class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Suba el archivo excel</label>
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
                    m-3
                    focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" type="file" id="file" name="file" @input="form.file = $event.target.files[0]">
                    <BreezeButton class="m-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                     Subir
                    </BreezeButton>
            </form>
        </div>
      </div>
    </div>
      <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
        <button  @click="clicke" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-400 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">Cancelar</button>        
      </div>
    </div>
    
  </div>
</div>
 

</template>
<script>
import BreezeButton from '@/Components/Button.vue'
export default{
    components:{
      BreezeButton
    },
    props:{
      modal: Boolean,  
    },
    data(){
      return{
        form: this.$inertia.form({
          file: null,
        })
      }
    },
    methods:{
      submit(){
        this.form.post(this.route('products.import'),
          this.form
          
        )
        this.$emit('clicke',false);
        Toast.fire({
              icon: 'success',
                title: 'Procesando informacion'
              });
      },
      clicke(){
        this.$emit('clicke',false);
      }
    }
    
}
</script>
