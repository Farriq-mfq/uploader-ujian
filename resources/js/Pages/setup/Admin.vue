<script setup lang="ts">
import { useForm, Head } from '@inertiajs/vue3';
import { getCurrentInstance } from 'vue'
import { useToast } from 'vue-toastification'
const form = useForm<{ username: string | null, password: string | null, konfirmasi_password: string | null, name: string | null }>({
    name: null,
    username: null,
    password: null,
    konfirmasi_password: null,
})
const $route = getCurrentInstance()?.appContext.config.globalProperties.$route
const $inertia = getCurrentInstance()?.appContext.config.globalProperties.$inertia
const $toast = useToast();


function handlSubmit(): void {
    form.post($route('setup.admin'), {
        onSuccess() {
            $toast.success('Berhasil Setup Admin')
            $inertia?.visit($route('setup.index'), { replace: true })
        }
    })
}
</script>
<template>
    <div class="container  mx-auto min-h-screen grid place-items-center">

        <Head>
            <title>Admin</title>
        </Head>
        <div class="bg-white h-auto w-1/2 p-4 rounded-lg shadow">
            <h3 class="text-center font-bold text-4xl mb-3 border-b pb-5 border-black">
                ADMIN SETUP
            </h3>
            <form @submit.prevent="handlSubmit">
                <input type="text" placeholder="Masukan Nama Admin"
                    :class="`input w-full my-3 input-bordered ${form.errors.name ? `border-red-500` : ``}`" autofocus
                    v-model="form.name" />
                <div class="text-red-500 text-sm mb-4" v-if="form.errors.name">
                    {{ form.errors.name }}
                </div>
                <input type="text" placeholder="Masukan Username"
                    :class="`input w-full my-3 input-bordered ${form.errors.username ? `border-red-500` : ``}`"
                    v-model="form.username" />
                <div class="text-red-500 text-sm mb-4" v-if="form.errors.username">
                    {{ form.errors.username }}
                </div>
                <input type="password" placeholder="Masukan Password"
                    :class="`input w-full my-3 input-bordered ${form.errors.password ? `border-red-500` : ``}`"
                    v-model="form.password" />
                <div class="text-red-500 text-sm mb-4" v-if="form.errors.password">
                    {{ form.errors.password }}
                </div>
                <input type="password" placeholder="Masukan Konfirmasi Password"
                    :class="`input w-full my-3 input-bordered ${form.errors.konfirmasi_password ? `border-red-500` : ``}`"
                    v-model="form.konfirmasi_password" />
                <div class="text-red-500 text-sm mb-4" v-if="form.errors.konfirmasi_password">
                    {{ form.errors.konfirmasi_password }}
                </div>
                <button class="btn btn-primary" :disabled="form.processing">
                    {{ form.processing ? " Sedang Dibuat..." : "Buat Admin" }}</button>
            </form>
        </div>
    </div>
</template>
<style lang="">
    
</style>