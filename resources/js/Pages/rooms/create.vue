<template>
    <div>
        <div class="bg-white p-3 shadow-xl rounded-lg space-x-2 grid" v-if="copyUrl.trim().length">
            <h2 class="font-semibold mb-2 ml-3 text-lg">Copy URL (AKAN DI TUTUP <b> {{ timer }}</b> detik lagi)</h2>
            <div class="flex space-x-2">
                <input type="text" class="input input-bordered flex-1" v-model="copyUrl" />
                <button class="btn btn-primary" @click="handleCopy" type="button">Copy</button>
            </div>
        </div>
        <div class="card shadow-lg p-3 border" v-if="!copyUrl.trim().length">
            <h1 class="text-xl font-bold">Buat rooms</h1>
            <div class="divider"></div>
            <form @submit.prevent="handleSubmit">
                <!-- {{ form.errors["TimeRanges1"] }} -->
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Nama Rooms</span>
                    </label>
                    <input type="text" v-model="form.name" placeholder="Masukan Nama rooms"
                        class="input input-bordered w-full" />

                    <p class="text-red-500 text-sm" v-if="form.errors.name">{{ form.errors.name }}</p>
                </div>
                <div class="form-control  w-full">
                    <label class="label">
                        <span class="label-text">Waktu</span>
                    </label>
                    <VueDatePicker v-model="form.TimeRanges" range enable-seconds model-type="yyyy-MM-dd HH:mm:ss">
                    </VueDatePicker>
                    <p class="text-red-500 text-sm" v-if="form.errors.TimeRanges">{{ form.errors.TimeRanges }}</p>
                </div>
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Range IP</span>
                    </label>
                    <div class="lg:columns-2 space-y-2 lg:space-y-0">

                        <input type="text" v-model="form.IpStart" placeholder="Masukan IP awal"
                            class="input input-bordered w-full" />
                        <p class="text-red-500 text-sm" v-if="form.errors.IpStart">{{ form.errors.IpStart }}</p>
                        <input type="text" v-model="form.IpEnd" placeholder="Masukan IP akhir"
                            class="input input-bordered w-full" />
                        <p class="text-red-500 text-sm" v-if="form.errors.IpEnd">{{ form.errors.IpEnd }}</p>
                    </div>
                </div>
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Nama Folder</span>
                    </label>
                    <input type="text" v-model="form.folder" placeholder="Masukan Nama Folder"
                        class="input input-bordered w-full" />
                    <p class="text-red-500 text-sm" v-if="form.errors.folder">{{ form.errors.folder }}</p>
                </div>
                <div class="form-control w-full">
                    <label class="label ">
                        <span class="label-text">Option Extensions note:pisahkan dengan (,)</span>
                    </label>
                    <input type="text" v-model="form.extensions"
                        placeholder="Masukan Extension yang di izinkan upload pisahkan dengan koma (,)"
                        class="input input-bordered w-full" />
                    <p class="text-red-500 text-sm" v-if="form.errors.extensions">{{ form.errors.extensions }}</p>

                </div>
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Status</span>
                    </label>
                    <input type="checkbox" v-model="form.status" class="toggle toggle-primary" checked />
                </div>
                <div class=" my-4">
                    <button type="submit" :class="`btn btn-primary ${form.processing ? 'loading' : ``}`"
                        :disabled="form.processing">Buat Rooms</button>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
import BaseLayout from '../../Layouts/BaseLayout.vue';
import VueDatePicker from '@vuepic/vue-datepicker';
import { MinusIcon, PlusIcon } from '@heroicons/vue/24/solid'
import { useForm } from '@inertiajs/vue3';
import { useToast } from "vue-toastification";
export default {
    layout: BaseLayout,
    components: {
        VueDatePicker,
        PlusIcon,
        MinusIcon,
    },
    computed: {
        toast() {
            const _Toast = Swal.mixin({
                toast: true,
                position: 'top-right',
                iconColor: 'white',
                customClass: {
                    popup: 'colored-toast'
                },
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true,
            })
            return _Toast
        }
    },
    props: {
        errors: Object,
        baseUrl: String
    },
    setup() {
        const toast = useToast()

        return { toast }
    },
    data() {
        return {
            form: useForm({
                name: null,
                TimeRanges: null,
                IpStart: null,
                IpEnd: null,
                folder: null,
                status: false,
                extensions: null
            }),
            copyUrl: "",
            timer: 3
        };
    },
    methods: {
        async handleSubmit() {
            this.form.post(this.$route('rooms.store'), {
                preserveState: true,
                preserveScroll: true,
                onSuccess: async (data) => {
                    this.copyUrl = `${this.baseUrl}/uploader/${this.form.name}`
                    this.toast.success("Berhasil membuat rooms");
                    this.form.reset("name", "TimeRanges", "IpEnd", "IpStart", "extensions", "folder", "status")
                    this.form.clearErrors()
                    const timer = setInterval(() => {
                        this.timer--;
                        if (this.timer < 1) {
                            clearInterval(timer)
                            this.copyUrl = ""
                        }
                    }, this.timer * 1000)
                },
            })
        },
        async handleCopy(e) {
            try {
                await navigator.clipboard.writeText(this.copyUrl)
                e.target.innerHTML = "Copied"
                this.toast.success("Copy url berhasil")
            } catch (e) {
                this.toast.error("Copy url gagal")
            }
        }
    }

}
</script>