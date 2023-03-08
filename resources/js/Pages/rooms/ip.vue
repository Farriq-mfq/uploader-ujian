<template >
    <div class="bg-white shadow-lg rounded-lg border p-4">
        <div class="mb-4 space-x-2">
            <Link class="btn btn-primary" as="button" :href="$route('rooms.index')" replace>
            Kembali
            </Link>
        </div>
        <div class="mb-4">
            <form @submit.prevent="hanldeSubmit" class="space-x-2">
                <input type="text" placeholder="Masukan IP" v-model="form.ip" id="ip_add"
                    class="input input-bordered w-full max-w-xs" />
                <button class="btn btn-primary" type="submit">
                    Tambahkan
                </button>
            </form>
            <p v-if="errors.ip" class="text-red-500">{{ errors.ip }}</p>
        </div>
        <div class="mb-4 space-x-2">
            <input type="text" placeholder="Filter IP" class="input input-bordered w-full max-w-xs" v-model="keyword" />
        </div>
        <div class="text-center" v-if="!allows_ip.length">
            Silahkan&nbsp;
            <label for="ip_add" class="btn btn-primary btn-sm">Tambahkan IP</label>
        </div>
        <ul class="flex flex-col space-y-4" v-if="allows_ip.length">
            <li class="border p-2 rounded-lg flex items-center justify-between px-3" v-for="allow in allows_ip"
                :key="allow.id">
                <kbd class="kbd kbd-lg">{{ allow.ip }}</kbd>
                <button class="btn btn-primary" @click.prevent="handleDeleteIp(allow.id)">
                    <XMarkIcon class="h-5 text-white" />
                </button>
            </li>
        </ul>
    </div>
</template>
<script>
import BaseLayout from '../../Layouts/BaseLayout.vue'
import { XMarkIcon } from '@heroicons/vue/24/solid'
import { Link, useForm } from '@inertiajs/vue3';
import { useToast } from "vue-toastification";

export default {
    layout: BaseLayout,
    components: {
        XMarkIcon,
        Link
    },
    props: {
        allows: Array,
        room: Number,
        errors: Object
    },

    data() {
        return {
            keyword: null,
            allows_ip: this.allows,
            form: useForm({
                ip: null
            })
        }
    },
    setup() {
        const toast = useToast()

        return { toast }
    },
    watch: {
        keyword(old) {
            if (old === "" || old === null) {
                this.allows_ip = this.allows
            } else {
                const filter = this.allows.filter(allow => allow.ip.includes(old))
                this.allows_ip = filter
            }
        }
    },
    methods: {
        handleDeleteIp(id) {
            const app = this;
            this.$inertia.delete(this.$route('rooms.delete_ip', [this.room, id]), {
                preserveScroll: true, preserveState: true, onSuccess() {
                    app.allows_ip = app.allows
                    app.toast.success("Berhasil Hapus IP")
                },
                onError() {
                    app.toast.error("Gagal Hapus Ip")
                }
            })
        },
        hanldeSubmit() {
            const app = this;
            this.form.post(this.$route('rooms.add_ip', this.room), {
                preserveState: true, onSuccess() {
                    app.allows_ip = app.allows
                    app.toast.success("Berhasil Menambahkan IP")
                    app.form.ip = null
                },
            })
        }
    }

}
</script>
<style lang="">
    
</style>