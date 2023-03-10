<template >
    <div class="bg-white shadow-lg p-3 rounded-lg">
        <div class="divider text-lg font-bold mb-4">
            UPLOADER LOGIN
        </div>
        <form @submit.prevent="handleSubmit" method="POST">
            <div class="my-5">
                <input type="text" placeholder="Username" v-model="form.username" class="input input-bordered w-full" />
                <p class="text-red-500 text-sm mt-1" v-if="errors.username">{{ errors.username }}</p>
            </div>
            <div class="my-5">
                <input type="text" placeholder="Password" v-model="form.password" class="input input-bordered w-full" />
                <p class="text-red-500 text-sm mt-1" v-if="errors.password">{{ errors.password }}</p>
            </div>
            <div class="my-5">
                <button class="btn btn-block btn-primary">Masuk</button>
            </div>
        </form>
        <div class="text-center text-sm text-gray-500">
            &copy; 2023 Made by Farriq Muwaffaq
        </div>
    </div>
</template>
<script>
import { useForm } from '@inertiajs/vue3';
import AuthLayout from '../../Layouts/AuthLayout.vue'
export default {
    layout: AuthLayout,
    props: {
        errors: Object
    },
    data() {
        return {
            form: useForm({
                username: null,
                password: null
            })
        }
    },
    methods: {
        handleSubmit() {
            this.form.post(this.$route('login.action'))
        }
    }
}
</script>
<style lang="">
    
</style>