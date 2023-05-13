<template>
    <div class="card shadow-lg p-3 border">

        <Head>
            <title>Edit Rooms</title>
        </Head>
        <div>
            <Link :href="$route('rooms.index')" method="get" class="mb-3 btn btn-primary btn-sm">Kembali</Link>
            <h1 class="text-xl font-bold">Edit rooms</h1>
        </div>
        <div class="divider"></div>
        <form @submit.prevent="handleSubmit">
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
                    <option :value="null">Tidak ada Operator</option>
                    <option v-for="operator in operators" :value="operator.id" :key="operator.id">{{ operator.name }}
                    </option>
                </select>
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
                <input type="checkbox" v-model="form.status" class="toggle toggle-primary" checked />
            </div>
            <div class=" my-4">
                <button type="submit" :class="`btn btn-primary ${form.processing ? 'loading' : ``}`"
                    :disabled="form.processing">Update Rooms</button>
            </div>
        </form>
    </div>
</template>
<script>
import BaseLayout from '../../Layouts/BaseLayout.vue';
import VueDatePicker from '@vuepic/vue-datepicker';
import { MinusIcon, PlusIcon } from '@heroicons/vue/24/solid'
import { Head, useForm } from '@inertiajs/vue3';
import { useToast } from "vue-toastification";
import { Link } from '@inertiajs/vue3';

export default {
    layout: BaseLayout,
    components: {
        VueDatePicker,
        PlusIcon,
        MinusIcon,
        Head,Link
    },
    props: {
        errors: Object,
        room: Object,
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
                status: false,
                kelas: null,
                mata_kuliah: null,
                extensions: null,
                folder: null,
                type_field: false,
                max_size: null,
                ftp: null,
                operator: null
            }),
        };
    },
    mounted() {
        this.form.name = this.room.name,
            this.form.TimeRanges = [this.room.time_start, this.room.time_end]
        this.form.status = this.room.status == 1 ? true : false
        this.form.extensions = this.room.extensions
        this.form.kelas = this.room.kelas
        this.form.folder = this.room.folder
        this.form.mata_kuliah = this.room.mata_kuliah
        this.form.type_field = this.room.type_field == 1 ? true : false
        this.form.ftp = this.room.ftp
        this.form.max_size = this.room.max_size
        this.form.operator = this.room.operator_id
    },
    methods: {
        async handleSubmit() {
            this.form.put(this.$route('rooms.update', this.room.id), {
                preserveState: true,
                preserveScroll: true,
                onSuccess: async () => {
                    this.toast.success("Berhasil update rooms");
                    this.form.clearErrors()
                },

            })
        },

    }

}
</script>