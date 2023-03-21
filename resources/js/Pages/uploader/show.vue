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

    <Head>
        <title>{{ room.name }}</title>
    </Head>
    <div class="mockup-window relative bg-base z-50 border shadow-md" v-if="room && !expired && !startTime">
        <div
            class="shadow-sm text-4xl font-semibold text-gray-700 justify-self-center bg-primary/10 border-2 w-fit absolute lg:top-14 top-0 lg:right-5 right-0 grid place-items-center gap-2 rounded-lg overflow-hidden">
            <div
                class="text-sm text-white bg-primary font-bold leading-tight w-full h-10 flex space-x-2 place-items-center px-4">
                <h5 class="uppercase">Sisa Waktu Upload</h5>
                <input type="checkbox" class="toggle toggle-sm" :checked="checkDark" @change="handleChangeTheme" />
            </div>
            <vue-countdown class="p-5" :time="UploadTime" @end="handleEnd" :interval="1000"
                v-slot="{ days, hours, minutes, seconds }">
                <div class="font-mono text-4xl text-gray-600 dark:text-white">
                    <span class="countdown" v-if="days > 0"><span :style="`--value:${days}`"></span>:</span>
                    <span class="countdown"><span :style="`--value:${hours}`"></span>:</span>
                    <span class="countdown"><span :style="`--value:${minutes}`"></span>:</span>
                    <span class="countdown"><span :style="`--value:${seconds}`"></span></span>
                </div>
            </vue-countdown>
        </div>
        <div class="grid gap-5">
            <div class="bg-white dark:bg-slate-800 py-10">
                <div class=" px-4 py-2 rounded-sm max-w-xl mx-auto w-full grid gap-3">
                    <div class="grid gap-2" v-if="room.attchs.length">
                        <h3 class="font-bold mb-2 uppercase">Attchments</h3>
                        <Attch v-for="attch in room.attchs" :key="attch.id" :attch="attch" />
                    </div>
                    <h3 class="font-bold uppercase dark:text-white">
                        Room {{ room.name }}
                    </h3>

                    <form @submit.prevent="handleUpload">
                        <div class="my-2 w-full">
                            <input :disabled="form.processing" type="text" v-model="form.name" placeholder="Masukan Nama"
                                class="input input-bordered w-full dark:bg-slate-700 dark:text-white" />
                            <p class="text-red-500 text-sm" v-if="form.errors.name">{{ form.errors.name }}</p>
                        </div>
                        <div class="my-2 w-full">
                            <input :disabled="form.processing" type="text" v-model="form.nim" placeholder="NIM"
                                class="input input-bordered w-full dark:bg-slate-700 dark:text-white" />
                            <p class="text-red-500 text-sm" v-if="form.errors.nim">{{ form.errors.nim }}</p>
                        </div>
                        <div v-if="room.type_field" class="mb-4">
                            <div class="my-2">
                                <label class="text-sm dark:text-white">Pilih Type Soal</label>
                            </div>
                            <select :disabled="form.processing"
                                class="select w-full select-bordered dark:bg-slate-700 dark:text-white" v-model="form.type">
                                <option disabled selected>Pilih Type Soal</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                            </select>
                            <p class="text-red-500 text-sm" v-if="form.errors.type">{{ form.errors.type }}</p>

                        </div>
                        <div class="my-2 w-full">
                            <Upload v-if="!form.files.length" @set-file="handleSetFile"
                                :message="`Extensions hanya : ${room.extensions}`" />
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
                            <button
                                :disabled="form.processing || form.name == null || form.nim == null || !form.files.length || submit_count >= 3"
                                type="submit"
                                :class="`btn btn-primary disabled:bg-primary/50 text-sm border-none font-bold leading-tight btn-block  disabled:text-white ${form.processing ? `loading` : ``}`">{{
                                    submit_count >= 3 ? "Reloading..." : form.processing ? "Uploading..." : "Upload" }}
                                <CloudArrowUpIcon class="h-5 ml-2 animate-bounce" v-if="form.processing" />
                            </button>
                            <button v-if="form.processing" type="button" @click="handleCencel"
                                :class="`btn btn-error border-none font-bold leading-tight hover:bg-red-500 btn-block text-sm disabled:bg-red-400 disabled:text-white`">Batal</button>
                        </div>
                        <div class="text-red-500 text-sm" v-if="errors.ftp">
                            {{ errors.ftp }}
                        </div>
                        <div class="text-red-500 text-sm" v-if="errors.ip">
                            {{ errors.ip }}
                        </div>
                    </form>
                </div>
            </div>
            <div class="divider uppercase text-sm text-gray-500 dark:text-white">daftar file yang di upload</div>
            <div class="overflow-x-auto px-10">
                <button type="button" @click.prevent="handleReload"
                    class="btn btn-primary btn-sm w-fit py-1 px-2 flex justify-center items-center">
                    <ArrowPathIcon class="h-5" />
                    &nbsp;Refresh
                </button>
                <table class="table w-full rounded-none dark:text-white" v-if="room.uploads.length">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>File</th>
                            <th v-if="room.type_field">Type</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- row 1 -->
                        <tr v-for="(upload, index) in room.uploads" class="text-md">
                            <td>{{ index + 1 }}</td>
                            <td>{{ upload.nim }}</td>
                            <td>{{ upload.name }}</td>
                            <td>{{ upload.file }}</td>
                            <td v-if="room.type_field">{{ upload.type }}</td>
                            <td>
                                <div class="badge badge-primary">
                                    {{ upload.created_at.split("T")[0] }}
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="grid place-items-center text-center" v-if="!room.uploads.length">
                    <InboxIcon class="h-24 text-gray-500" />
                    <p class="text-center my-4 text-gray-500 text-sm">Belum ada yang upload</p>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { InboxIcon, ArrowPathIcon, CloudArrowUpIcon } from '@heroicons/vue/24/solid';
import { Head, useForm } from '@inertiajs/vue3';
import Attch from '../../components/Attch.vue';
import ListFile from '../../components/ListFile.vue';
import PlayRandomImg from '../../components/PlayRandomImg.vue';
import Upload from '../../components/Upload.vue';
import { ConvertDate } from '../../helper/convertDate';
import UploaderLayout from '../../Layouts/UploaderLayout.vue';
import { useToast } from 'vue-toastification'
import { router } from '@inertiajs/vue3'
export default {
    layout: UploaderLayout,
    components: {
        Upload,
        ListFile,
        InboxIcon,
        PlayRandomImg,
        Attch,
        Head, ArrowPathIcon, CloudArrowUpIcon
    },
    props: {
        room: Object | null,
        errors: Object
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
        checkDark() {
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                return true
            } else {
                return false
            }
        }
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
                files: [],
            }),
            submit_count: 0,
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
            this.submit_count += 1
            if (this.submit_count >= 3) {
                this.$inertia.visit(this.$route('uploader.show', this.room.name), { replace: true })
            } else {
                const app = this;
                this.form.post(this.$route('uploader.upload', this.room.name), {
                    preserveScroll: true, preserveState: true, onSuccess(data) {
                        if (data.component === "uploader/show") {
                            app.toast.success("Berhasil Upload")
                            app.form.reset()
                        }
                    }
                })
            }
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
        handleReload() {
            router.reload({ only: ['room'] })
        },
        handleChangeTheme(e) {
            if (e.target.checked) {
                document.documentElement.classList.add('dark')
                localStorage.setItem('theme', 'dark')
                document.documentElement.setAttribute('data-theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark')
                localStorage.setItem('theme', 'light')
                document.documentElement.setAttribute('data-theme', 'light');
            }
        }
    },
    mounted() {
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
            document.documentElement.setAttribute('data-theme', 'dark');
        } else {
            document.documentElement.classList.remove('dark')
            document.documentElement.setAttribute('data-theme', 'light');
        }
    },

}
</script>
<style scoped>
table {
    border-collapse: separate;
    border-spacing: 0 1.5em;
    @apply p-2
}

table th,
td {
    @apply bg-white py-8 dark:bg-slate-800 border-y shadow-none border-gray-300 last-of-type:rounded-r-2xl first-of-type:rounded-l-2xl first-of-type:border-l last-of-type:border-r;
}
</style>