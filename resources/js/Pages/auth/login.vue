<template >
    <div class="bg-white shadow-lg p-4 rounded-lg border-2">
        <Head>
            <title>Login</title>
        </Head>
        <div class="text-4xl font-extrabold my-2 inline-block text-center w-full">
            SIUP LOGIN
        </div>
        <div class="text-sm text-red-500 mb-4 text-center" v-if="errors.login">
            {{ errors.login }}
        </div>
        <form @submit.prevent="handleSubmit" method="POST">
            <div class="my-7">
                <input type="text" placeholder="Username" v-model="form.username" class="input input-bordered w-full" />
                <p class="text-red-500 text-sm mt-1" v-if="errors.username">{{ errors.username }}</p>
            </div>
            <div class="my-7">
                <input type="password" placeholder="Password" v-model="form.password" class="input input-bordered w-full" />
                <p class="text-red-500 text-sm mt-1" v-if="errors.password">{{ errors.password }}</p>
            </div>
            <div class="my-5">
                <button :disabled="form.processing" class="btn btn-block btn-primary">{{ form.processing ?
                    "Loading...." : "Masuk" }}</button>
            </div>
        </form>
        <div class="text-center text-sm text-gray-500">
            &copy; 2023 Made by Farriq Muwaffaq
        </div>
    </div>
</template>
<script>
import { Head, useForm } from '@inertiajs/vue3';
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
        };
    },
    methods: {
        handleSubmit() {
            this.form.post(this.$route("login.action"));
        }
    },
    components: { Head }
}
</script>
<style lang="">
    
</style>