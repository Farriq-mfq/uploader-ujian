<template>
    <div class="card shadow-lg p-3 border">
        <h1 class="text-xl font-bold">Edit rooms</h1>
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
                    :disabled="form.processing">Update Rooms</button>
            </div>
        </form>
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
        room: Object
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
                kelas: null,
                mata_kuliah: null,
                extensions: null
            }),
            copyUrl: "",
            timer: 3
        };
    },
    mounted() {
        this.form.name = this.room.name,
            this.form.TimeRanges = [this.room.time_start, this.room.time_end]
        this.form.IpStart = this.room.ip_start
        this.form.IpEnd = this.room.ip_end
        this.form.folder = this.room.folder
        this.form.status = this.room.status == 1 ? true : false
        this.form.extensions = this.room.extensions
        this.form.kelas = this.room.kelas
        this.form.mata_kuliah = this.room.mata_kuliah
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