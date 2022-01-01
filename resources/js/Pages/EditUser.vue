<template>
    <Head title="Register" />

    <BreezeValidationErrors class="mb-4" />

    <form @submit.prevent="submit">
        
        <div>
            <BreezeLabel for="first_name" value="Nombre" />
            <BreezeInput id="first_name" type="text" v-model="user.first_name" class="mt-1 block w-full"  required autofocus autocomplete="first_name" />
        </div>

        <div>
            <BreezeLabel for="last_name" value="Apellido" />
            <BreezeInput id="last_name" type="text" v-model="user.last_name" class="mt-1 block w-full" required autofocus autocomplete="last_name" />
        </div>
         <div>
            <BreezeLabel for="first_name" value="Telefono" />
            <BreezeInput id="phone" type="text" v-model="user.phone" class="mt-1 block w-full" required autofocus autocomplete="phone" />
        </div>
        <div>
            <BreezeLabel for="state" value="Estado" />
            <BreezeCheckbox  :v-model="user.state" type="checkbox" class="mt-1 block" /> 
            <label>{{ user.state }}</label>
        </div>

       

        

        <div class="flex items-center justify-end mt-4">
           

            <BreezeButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Actualizar
            </BreezeButton>
        </div>
    </form>
</template>

<script>
import BreezeButton from '@/Components/Button.vue'
import BreezeGuestLayout from '@/Layouts/Guest.vue'
import BreezeInput from '@/Components/Input.vue'
import BreezeLabel from '@/Components/Label.vue'
import BreezeCheckbox from '@/Components/Checkbox.vue'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue'
import { Head, Link } from '@inertiajs/inertia-vue3';

export default {
    layout: BreezeGuestLayout,

    components: {
        BreezeButton,
        BreezeInput,
        BreezeLabel,
        BreezeValidationErrors,
        Head,
        Link,
    },

    data() {
        return {
            form: this.$inertia.form({
                first_name: '',
                last_name: '',
                email: '',
                password: '',
                password_confirmation: '',
                terms: false,
            })
        }
    },

   
    props:['user'],

    methods: {
        submit() {
            this.form.post(this.route('register'), {
                onFinish: () => this.form.reset('password', 'password_confirmation'),
            })
        }
    }
}
</script>