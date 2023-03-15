<template>
    <div class="card bg-white shadow-sm border-2 p-4">
        <Head>
            <title>Tambah Operator</title>
        </Head>
        <div class="mb-4 space-x-2">
            <Link class="btn btn-primary" as="button" :href="$route('operator.index')" replace>
            Kembali
            </Link>
        </div>
        <h3 class="text-xl font-bold mb-3">Tambah Operator</h3>
        <hr>
        <form @submit.prevent="handleSubmit">
            <div class="my-2">
                <label class="inline-block mb-2">Nama</label>
                <input type="text" v-model="form.name" placeholder="Masukan Nama" class="input input-bordered w-full" />
                <p class="text-red-500 text-sm" v-if="form.errors.name">{{ form.errors.name }}</p>
            </div>
            <div class="my-2">
                <label class="inline-block mb-2">Username</label>
                <input type="text" v-model="form.username" placeholder="Masukan Username"
                    class="input input-bordered w-full" />
                <p class="text-red-500 text-sm" v-if="form.errors.username">{{ form.errors.username }}</p>
            </div>
            <div class="my-2">
                <label class="inline-block mb-2">Password</label>
                <input type="password" v-model="form.password" placeholder="Masukan password"
                    class="input input-bordered w-full" />
                <p class="text-red-500 text-sm" v-if="form.errors.password">{{ form.errors.password }}</p>
            </div>
            <div class="my-2">
                <label class="inline-block mb-2">Konfirmasi Password</label>
                <input type="password" v-model="form.confirm" placeholder="Masukan konfirmasi password"
                    class="input input-bordered w-full" />
                <p class="text-red-500 text-sm" v-if="form.errors.confirm">{{ form.errors.confirm }}</p>
            </div>
            <div class="my-2">
                <button class="btn btn-primary" type="submit" :disabled="form.processing">{{ form.processing ?
                    "Menyimpan..." : "Simpan" }}</button>
            </div>
        </form>
    </div>
</template>
<script>
import { Head, Link, useForm } from '@inertiajs/vue3';
import BaseLayout from '../../Layouts/BaseLayout.vue'
import { useToast } from 'vue-toastification'
export default {
    layout: BaseLayout,
    data() {
        return {
            form: useForm({
                name: null,
                username: null,
                password: null,
                confirm: null
            })
        };
    },
    setup() {
        const toast = useToast();
        return { toast };
    },
    methods: {
        handleSubmit() {
            const app = this;
            this.form.post(this.$route("operator.store"), {
                onSuccess() {
                    app.toast.success("berhasil menambahkan operator");
                    app.form.reset();
                    app.form.clearErrors();
                }
            });
        }
    },
    components: { Link, Head }
}
</script>
<style lang="">
    
</style>