<template>
    <div>

        <Head>
            <title>Buat Rooms</title>
        </Head>
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
                        <span class="label-text">IP yang di izinkan {{ form.ip.length }}</span>
                    </label>
                    <ModalIp @submit-ip="handleSumbmitIp" />
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
                    <label class="label">
                        <span class="label-text">Kelas</span>
                    </label>
                    <input type="text" v-model="form.kelas" placeholder="Masukan Nama kelas"
                        class="input input-bordered w-full" />
                    <p class="text-red-500 text-sm" v-if="form.errors.kelas">{{ form.errors.kelas }}</p>
                </div>
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Mata Kuliah</span>
                    </label>
                    <input type="text" v-model="form.mata_kuliah" placeholder="Masukan Nama Mata Kuliah"
                        class="input input-bordered w-full" />
                    <p class="text-red-500 text-sm" v-if="form.errors.mata_kuliah">{{ form.errors.mata_kuliah }}</p>
                </div>
                <div class="form-control w-full">
                    <label class="label ">
                        <span class="label-text">
                            Maksimal size upload (kb)
                        </span>
                    </label>
                    <input type="number" v-model="form.max_size" placeholder="Masukan maksimal size upload (kb)"
                        class="input input-bordered w-full" />
                    <p class="text-red-500 text-sm" v-if="form.errors.max_size">{{ form.errors.max_size }}</p>

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
                    <label class="label ">
                        <span class="label-text">Masukan FTP <kbd class="kbd">cth :
                                ftp://username:password@192.168.20.20/uploads</kbd></span>
                    </label>
                    <input type="text" v-model="form.ftp" placeholder="Masukan FTP" class="input input-bordered w-full" />
                    <p class="text-red-500 text-sm" v-if="form.errors.ftp">{{ form.errors.ftp }}</p>
                    <p v-if="form.ftp && form.processing">Connect... ke FTP</p>
                </div>
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Operator</span>
                    </label>
                    <select class="select select-bordered w-full" v-model="form.operator">
                        <option disabled selected>Pilih operator</option>
                        <option v-for="operator in operators" :value="operator.id" :key="operator.id">{{ operator.name }}
                        </option>
                    </select>
                    <p class="text-red-500 text-sm" v-if="form.errors.operator">{{ form.errors.operator }}</p>
                </div>
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Field Type Soal</span>
                    </label>
                    <input type="checkbox" v-model="form.type_field" class="toggle toggle-primary" />
                </div>
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Status</span>
                    </label>
                    <input type="checkbox" v-model="form.status" class="toggle toggle-primary" />
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
import { Head, useForm } from '@inertiajs/vue3';
import { useToast } from "vue-toastification";
import ModalIp from '../../components/ModalIp.vue';

export default {
    layout: BaseLayout,
    components: {
        VueDatePicker,
        ModalIp,
        Head
    },
    props: {
        errors: Object,
        operators: Array
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
                folder: null,
                kelas: null,
                mata_kuliah: null,
                status: false,
                type_field: false,
                extensions: null,
                ftp: null,
                max_size: null,
                operator: null,
                ip: []
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
                onSuccess: async () => {
                    const timer = setInterval(() => {
                        this.timer--;
                        if (this.timer < 1) {
                            clearInterval(timer)
                            this.copyUrl = ""
                        }
                    }, this.timer * 1000)
                    this.copyUrl = this.$route('uploader.show', this.form.name)
                    this.toast.success("Berhasil membuat rooms");
                    this.form.reset("name", "TimeRanges", "ip", "extensions", "kelas", 'mata_kuliah', "folder", "status", "ftp")
                    this.form.clearErrors()
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
        },
        handleSumbmitIp(ips) {
            this.form.ip = ips
        }
    }

}
</script>