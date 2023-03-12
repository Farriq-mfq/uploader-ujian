<template >
    <div v-if="room && startTime" class="w-full min-h-[80vh] grid place-items-center">
        <div class="max-w-xl bg-white w-full shadow-sm rounded-lg p-3 border flex items-center space-x-2 justify-center">
            <div class="font-mono text-md text-gray-600 uppercase font-bold">
                Ujian di mulai
            </div>
            <vue-countdown class="p-5" :time="UploadTimeStart" @end="handleEnd" :interval="1000"
                v-slot="{ days, hours, minutes, seconds }">
                <div class="font-mono text-3xl text-gray-600">
                    <span class="countdown" v-if="days > 0"><span :style="`--value:${days}`"></span>:</span>
                    <span class="countdown"><span :style="`--value:${hours}`"></span>:</span>
                    <span class="countdown"><span :style="`--value:${minutes}`"></span>:</span>
                    <span class="countdown"><span :style="`--value:${seconds}`"></span></span>
                </div>
            </vue-countdown>
            <div class="font-mono text-md text-gray-600 uppercase font-bold">
                Lagi
            </div>
        </div>
    </div>
    <PlayRandomImg :show="room && expired" message="WAKTU HABIS" />

    <div class="mockup-window relative bg-blue-500 bg-opacity-5 shadow z-50" v-if="room && !expired && !startTime">
        <div
            class="shadow-sm  text-4xl font-semibold text-gray-700 justify-self-center bg-blue-500/10 border-2 w-fit absolute lg:top-14 top-0 lg:right-5 right-0 grid place-items-center gap-2 rounded-lg">
            <div class="text-sm text-white bg-blue-500 font-bold leading-tight w-full h-10 grid place-items-center px-4">
                <h5>Sisa Waktu Upload</h5>
            </div>
            <vue-countdown class="p-5" :time="UploadTime" @end="handleEnd" :interval="1000"
                v-slot="{ days, hours, minutes, seconds }">
                <div class="font-mono text-4xl text-gray-600">
                    <span class="countdown" v-if="days > 0"><span :style="`--value:${days}`"></span>:</span>
                    <span class="countdown"><span :style="`--value:${hours}`"></span>:</span>
                    <span class="countdown"><span :style="`--value:${minutes}`"></span>:</span>
                    <span class="countdown"><span :style="`--value:${seconds}`"></span></span>
                </div>
            </vue-countdown>
        </div>
        <div class="grid gap-5">
            <div class="bg-white py-10">
                <div class=" px-4 py-2 rounded-sm max-w-xl mx-auto w-full grid gap-3">
                    <div class="grid gap-2" v-if="room.attchs.length">
                        <h3 class="font-bold mb-2 uppercase">Attchments</h3>
                        <Attch v-for="attch in room.attchs" :key="attch.id" :attch="attch" />
                    </div>
                    <h3 class="font-bold uppercase">
                        Room {{ room.name }}
                    </h3>
                    <form action="" @submit.prevent="handleUpload">
                        <div class="my-2 w-full">
                            <input :disabled="form.processing" type="text" v-model="form.name" placeholder="Masukan Nama"
                                class="input input-bordered w-full " />
                            <p class="text-red-500 text-sm" v-if="form.errors.name">{{ form.errors.name }}</p>
                        </div>
                        <div class="my-2 w-full">
                            <input :disabled="form.processing" type="text" v-model="form.nim" placeholder="NIM"
                                class="input input-bordered w-full " />
                            <p class="text-red-500 text-sm" v-if="form.errors.nim">{{ form.errors.nim }}</p>
                        </div>
                        <div v-if="room.type_field" class="mb-4">
                            <div class="my-2">
                                <label class="text-sm">Pilih Type Soal</label>
                            </div>
                            <select :disabled="form.processing" class="select w-full select-bordered" v-model="form.type">
                                <option value="A">A</option>
                                <option value="B">B</option>
                            </select>
                            <p class="text-red-500 text-sm" v-if="form.errors.type">{{ form.errors.type }}</p>

                        </div>
                        <div class="my-2 w-full">
                            <Upload v-if="!form.files.length" @set-file="handleSetFile" />
                            <ul class="space-y-2" v-if="form.files.length" v-for="(acc, index) in form.files" :key="index">
                                <list-file :progress="form.progress" :name="acc.name" :size="acc.size"
                                    @removeFile="handleRemoveFile(index)"></list-file>
                            </ul>
                            <div v-if="form.errors">
                                <p class="text-red-500 text-sm my-2" v-for="(acc, index) in form.files" :key="index">
                                    <span v-if="form.errors[`files.${index}`]">
                                        File ke {{ index + 1 }} : {{ form.errors[`files.${index}`] }}
                                    </span>
                                </p>
                            </div>
                            <p class="text-red-500 text-sm" v-if="form.errors.files">{{ form.errors.files }}</p>
                        </div>
                        <div class="my-2 w-full space-y-2">
                            <button :disabled="form.processing" type="submit"
                                :class="`btn bg-blue-500 border-none font-bold leading-tight hover:bg-blue-500/90 btn-block text-lg disabled:bg-blue-500/50 disabled:text-white disabled:cursor-not-allowed ${form.processing ? `loading` : ``}`">{{
                                    form.processing ? "Uploading..." : "Upload" }}</button>
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
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>File</th>
                            <th v-if="room.type_field">Type</th>
                            <th>Timestamps</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- row 1 -->
                        <tr v-for="upload in room.uploads">
                            <td>{{ upload.nim }}</td>
                            <td>{{ upload.name }}</td>
                            <td>{{ upload.file }}</td>
                            <td v-if="room.type_field">{{ upload.type }}</td>
                            <td>{{ upload.created_at }}</td>
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
import Attch from '../../components/Attch.vue';
import ListFile from '../../components/ListFile.vue';
import PlayRandomImg from '../../components/PlayRandomImg.vue';
import Upload from '../../components/Upload.vue';
import { ConvertDate } from '../../helper/convertDate';
import UploaderLayout from '../../Layouts/UploaderLayout.vue';
import { useToast } from 'vue-toastification'
export default {
    layout: UploaderLayout,
    components: {
        Upload,
        ListFile,
        FaceFrownIcon,
        PlayRandomImg,
        Attch
    },
    props: {
        room: Object | null,
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
        UploadTimeStart() {
            return this.timeStart - this.now
        },
    },
    setup(props) {
        if (props.room) {
            const now = new Date();
            const timeStart = ConvertDate(props.room.time_start);
            const timeEnd = ConvertDate(props.room.time_end);
            const expired = now > timeEnd
            const toast = useToast()
            return { timeStart, timeEnd, now, expired, toast }
        }
    },
    data() {
        return {
            form: useForm({
                name: null,
                nim: null,
                type: null,
                files: []
            }),
        };
    },
    methods: {
        handleEnd() {
            this.$inertia.visit(this.$route('uploader.show', this.room.name), { replace: true },)
        },
        handleSetFile(acceptFiles) {
            if (acceptFiles.length) {
                this.form.files = acceptFiles
            }
        },

        handleUpload() {
            const app = this;
            this.form.post(this.$route('uploader.upload', this.room.name), {
                preserveScroll: true, preserveState: true, onSuccess() {
                    app.toast.success("Berhasil Upload")
                    app.form.reset()
                }
            })
        },
        handleRemoveFile(index) {
            if (this.form.files.length) {
                this.form.files.splice(index, 1)
                this.form.errors[`files.${index}`] = null
            } else {
                this.form.files = null;
            }
        },
        handleCencel() {
            this.form.cancel()
        },
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