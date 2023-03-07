<template >
    <div v-if="room && startTime" class="w-full min-h-[80vh] grid place-items-center">
        <div class="max-w-xl bg-white w-full shadow-sm rounded-lg p-3 border flex items-center space-x-2">
            <FaceFrownIcon class="h-20 text-blue-500" />
            <span class="font-bold text-lg">Ujian belum mulai</span>
        </div>
    </div>

    <div class="mockup-window relative bg-primary bg-opacity-5 shadow" v-if="room && !startTime">
        <div
            class="shadow-lg text-4xl font-semibold text-gray-700 justify-self-center bg-primary bg-opacity-20 border w-fit absolute lg:top-14 top-0 lg:right-5 right-0 grid place-items-center gap-2 rounded-lg">
            <div class="text-sm text-white bg-primary font-bold leading-tight w-full h-10 grid place-items-center px-4">
                <h5>Sisa Waktu Upload</h5>
            </div>
            <vue-countdown class="p-5" :time="UploadTime" @end="handleEnd" :interval="1000"
                v-slot="{ hours, minutes, seconds }">
                <span>
                    {{ hours }}&nbsp;:
                </span>
                <span>
                    {{ minutes }}&nbsp;:
                </span>
                <span>
                    {{ seconds }}
                </span>
            </vue-countdown>
            <!-- <p class="p-4 uppercase text-red-500" v-if="timeEnd">Waktu habis</p> -->
        </div>
        <div class="grid gap-5">
            <div class="bg-white py-10">
                <div class=" px-4 py-2 rounded-sm max-w-xl mx-auto w-full grid gap-3">
                    <div>
                        File
                    </div>
                    <h3 class="font-bold text-gray-600 uppercase">
                        Rooms lab2
                    </h3>
                    <form action="" @submit.prevent="handleUpload">
                        <div class="my-2 w-full">
                            <input type="text" v-model="form.name" placeholder="Masukan Nama"
                                class="input input-bordered w-full " />
                            <p class="text-red-500 text-sm" v-if="form.errors.name">{{ form.errors.name }}</p>
                        </div>
                        <div class="my-2 w-full">
                            <input type="text" v-model="form.nim" placeholder="NIM" class="input input-bordered w-full " />
                            <p class="text-red-500 text-sm" v-if="form.errors.nim">{{ form.errors.nim }}</p>
                        </div>
                        <div class="my-2 w-full">
                            <Upload v-if="!form.files.length" @set-file="handleSetFile" />
                            <ul class="space-y-2" v-if="form.files.length" v-for="(acc, index) in form.files" :key="index">
                                <list-file :progress="form.progress" :name="acc.name" :size="acc.size"
                                    @removeFile="handleRemoveFile(index)"></list-file>
                            </ul>
                            <p class="text-red-500 text-sm" v-if="form.errors.files">{{ form.errors.files }}</p>
                        </div>
                        <div class="my-2 w-full space-y-2">
                            <button :disabled="form.processing" type="submit"
                                :class="`btn btn-primary border-none font-bold leading-tight hover:bg-primary btn-block text-lg disabled:bg-primary disabled:text-white disabled:cursor-not-allowed ${form.processing ? `loading` : ``}`">Upload</button>
                            <button v-if="form.processing" type="button" @click="handleCencel"
                                :class="`btn bg-red-400 border-none font-bold leading-tight hover:bg-red-500 btn-block text-lg disabled:bg-red-400 disabled:text-white disabled:cursor-not-allowed`">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="divider uppercase">daftar file yang di upload</div>
            <div class="overflow-x-auto px-10">
                <table class="table w-full rounded-none">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>File</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- row 1 -->
                        <tr v-for="i in 30">
                            <th>1</th>
                            <td>21.240.0088</td>
                            <td>Farriq Muwaffaqi</td>
                            <td>
                                <div class="bg-red">
                                    _UJUA.zip
                                </div>
                            </td>
                            <td>Tanggal</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
import { FaceFrownIcon } from '@heroicons/vue/24/solid';
import { useForm } from '@inertiajs/vue3';
import ListFile from '../../components/ListFile.vue';
import PlayRandomImg from '../../components/PlayRandomImg.vue';
import Upload from '../../components/Upload.vue';
import { ConvertDate } from '../../helper/convertDate';
import UploaderLayout from '../../Layouts/UploaderLayout.vue';

export default {
    layout: UploaderLayout,
    components: {
        Upload,
        ListFile, FaceFrownIcon, PlayRandomImg
    },
    props: {
        room: Object | null
    },
    computed: {
        startTime() {
            return this.timeStart > this.now;
        },
        uploadStart() {
            return this.timeStart - this.now
        },

        UploadTime() {
            return this.timeEnd - this.now
        },
    },
    setup(props) {
        if (props.room) {
            const now = new Date();
            const timeStart = ConvertDate(props.room.time_start);
            const timeEnd = ConvertDate(props.room.time_end);
            return { timeStart, timeEnd, now }
        }
    },
    data() {
        return {
            form: useForm({
                name: null,
                nim: null,
                files: []
            }),
        };
    },
    methods: {
        handleEnd() {
            // this.timeEnd = true
            // this.$inertia.replace(this.$route("rooms.index"));
        },
        handleSetFile(acceptFiles) {
            if (acceptFiles.length) {
                this.form.files = acceptFiles
            }
        },

        handleUpload() {
            this.form.post(this.$route('uploader.upload', 1), { preserveScroll: true, preserveState: true })
        },
        handleRemoveFile(index) {
            if (this.form.files.length) {
                this.form.files.splice(index, 1)
            } else {
                this.form.files = null;
            }
        },
        handleCencel() {
            this.form.cancel()
        }
    }

}
</script>
<style scoped>
table {
    border-collapse: separate;
    border-spacing: 0 1em;
    @apply p-2
}

th,
td {
    @apply bg-white shadow py-8;
}
</style>