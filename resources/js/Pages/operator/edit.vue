<template>
    <div class="card bg-white shadow-sm border-2 p-4">

        <Head>
            <title>Edit Operator</title>
        </Head>
        <div class="mb-4 space-x-2">
            <Link class="btn btn-primary" as="button" :href="$route('operator.index')" replace>
            Kembali
            </Link>
        </div>
        <h3 class="text-xl font-bold mb-3">Edit Operator</h3>
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
                    "Update..." : "Upadate" }}</button>
            </div>
        </form>
    </div>
</template>
<script>
import { Link, useForm, Head } from '@inertiajs/vue3';
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
    props: {
        operator: Object
    },
    setup(props) {
        const toast = useToast();
        return { toast };
    },
    methods: {
        handleSubmit() {
            const app = this;
            this.form.put(this.$route("operator.update", this.operator.id), {
                onSuccess() {
                    app.toast.success("berhasil update operator");
                    app.form.clearErrors();
                }
            });
        }
    },
    mounted() {
        const { name, username, password, confirm } = this.operator;
        this.form.name = name;
        this.form.username = username;
    },
    components: { Link, Head }
}
</script>
<style lang="">
    
</style>