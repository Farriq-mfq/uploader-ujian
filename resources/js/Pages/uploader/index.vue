<template >
    <div class="grid gap-5">
        <div class="bg-white shadow-lg px-4 py-2 rounded-sm max-w-xl mx-auto w-full border grid gap-3">
            <div class="p-3 border  shadow-lg text-lg font-semibold text-gray-700 justify-self-center bg-white">
                <vue-countdown :time="time" @end="handleEnd" :interval="1000" v-slot="{ hours, minutes, seconds }"
                    v-if="!timeEnd">
                    <span v-if="hours > 0">
                        {{ hours }}&nbsp;:
                    </span>
                    <span>
                        {{ minutes }}&nbsp;:
                    </span>
                    <span>
                        {{ seconds }}
                    </span>
                </vue-countdown>
                <div v-else>
                    WAKTU HABIS
                </div>
            </div>
            <h3 class="font-bold text-gray-600 uppercase">UPLOAD HASIL UJIAN</h3>
            <form action="" @submit.prevent="handleUpload">
                <div class="my-2 w-full">
                    <input type="text" v-model="name" placeholder="Masukan nama" class="input input-bordered w-full " />
                </div>
                <div class="my-2 w-full">
                    <input type="text" v-model="nim" placeholder="NIM" class="input input-bordered w-full " />
                </div>
                <div class="my-2 w-full">
                    <input type="text" v-model="kelas" placeholder="Masukan Kode Kelas"
                        class="input input-bordered w-full " />
                </div>
                <div class="my-2 w-full">
                    <Upload v-if="form.file === null" @set-file="handleSetFile" />
                    <ul class="space-y-2" v-if="form.file">
                        <list-file :progress="form.progress" :name="form.file.name" :size="form.file.size"
                            @removeFile="handleRemoveFile"></list-file>
                    </ul>
                </div>
                <div class="my-2 w-full">
                    <button :disabled="form.processing" type="submit"
                        :class="`btn bg-blue-500 border-none font-bold leading-tight hover:bg-blue-500 btn-block text-lg disabled:bg-blue-400 disabled:text-white disabled:cursor-not-allowed ${form.processing ? `loading` : ``}`">Upload</button>
                </div>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="table w-full rounded-none">
                <tbody>
                    <!-- row 1 -->
                    <tr>
                        <th>1</th>
                        <td>Farriq Muwaffaqi</td>
                        <td>21.240.0088</td>
                        <td>
                            <div class="badge badge-accent uppercase">4p42</div>
                        </td>
                        <td>
                            <div class="bg-red">
                                _UJUA.zip
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>1</th>
                        <td>Farriq Muwaffaqi</td>
                        <td>21.240.0088</td>
                        <td>
                            <div class="badge badge-accent uppercase">4p42</div>
                        </td>
                        <td>
                            <div class="bg-red">
                                _UJUA.zip
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>1</th>
                        <td>Farriq Muwaffaqi</td>
                        <td>21.240.0088</td>
                        <td>
                            <div class="badge badge-accent uppercase">4p42</div>
                        </td>
                        <td>
                            <div class="bg-red">
                                _UJUA.zip
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>1</th>
                        <td>Farriq Muwaffaqi</td>
                        <td>21.240.0088</td>
                        <td>
                            <div class="badge badge-accent uppercase">4p42</div>
                        </td>
                        <td>
                            <div class="bg-red">
                                _UJUA.zip
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
import Upload from '../../components/Upload.vue';
import { ConvertDate } from '../../helper/convertDate';
import UploaderLayout from '../../Layouts/UploaderLayout.vue';
import { useForm } from '@inertiajs/vue3';
import ListFile from '../../components/ListFile.vue'
import Swal from 'sweetalert2';
export default {
    layout: UploaderLayout,
    components: {
        Upload,
        ListFile
    },
    data() {
        const now = new Date();
        const convertDate = ConvertDate("2023-04-01 17:00:41");
        return {
            form: useForm({
                name: null,
                nim: null,
                kelas: null,
                file: null
            }),
            time: convertDate - now,
            timeEnd: false,
        };
    },
    methods: {
        handleEnd() {
            this.timeEnd = true
        },
        handleSetFile(acceptFiles) {
            if (acceptFiles.length) {
                this.form.file = acceptFiles[0]
            }
        },

        handleUpload() {
            this.form.post(this.$route('uploader.upload', 1), { preserveScroll: true, preserveState: true })
        },
        handleRemoveFile() {
            this.form.file = null
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