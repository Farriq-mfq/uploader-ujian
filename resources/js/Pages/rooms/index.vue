<template>
    <div>

        <div class="mb-3">
            <Link :href="$route('rooms.create')" class="btn btn-primary">Buat rooms</Link>
        </div>
        <div class="mb-3">
            <input v-model="keyword" type="search" placeholder="Cari nama rooms"
                class="input input-bordered w-full max-w-xs" />
        </div>
        <div class="mb-3 btn-group-horizontal space-x-2" v-if="rooms.data.length">
            <button @click="handleBatchRemove" type="button" class="btn btn-error">Hapus Semua</button>
            <button class="btn btn-accent" type="button" @click="handleActiveAll">Active Semua</button>
            <button class="btn btn-secondary" type="button" @click="handleInActiveAll">Inactive Semua</button>
            <button v-if="formAttch" class="btn btn-error" @click.prevent="handleCencelAttch">Batalkan Upload</button>
        </div>
        <div class="overflow-x-auto w-full card shadow-xl p-2">
            <table class="table w-full" v-if="rooms.data.length">
                <!-- head -->
                <thead>
                    <tr>
                        <th>Rooms</th>
                        <th>Waktu</th>
                        <th>Extension yang di izinkan</th>
                        <th>IP Yang di izinkan</th>
                        <th>Attchment</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="room in rooms.data" :key="room.id">

                        <td>
                    <tr>
                        <th>Nama rooms</th>
                        <td>{{ room.name }}</td>
                    </tr>
                    <tr>
                        <th>Kelas</th>
                        <td>{{ room.kelas }}</td>
                    </tr>
                    <tr>
                        <th>Mata Kuliah</th>
                        <td>{{ room.mata_kuliah }}</td>
                    </tr>
                    <tr>
                        <th>Folder</th>
                        <td>{{ room.folder }}</td>
                    </tr>
                    <tr>
                        <th>Type Field</th>
                        <td class="uppercase">{{ room.type_field ? "diaktifkan" : "tidak aktif" }}</td>
                    </tr>
                    </td>
                    <td>
                        {{ room.time_start }} - {{ room.time_end }}
                    </td>
                    <td>
                        <div class="badge badge-primary mx-1 font-bold p-3"
                            v-for="(ext, index) in room.extensions.split(',')" :key="index">
                            {{ ext }}</div>
                    </td>
                    <td>
                        <kbd class="kbd kbd-md shadow-lg">
                            {{ room.allows_i_p.length }}
                        </kbd>
                    </td>
                    <td v-if="!room.attchs.length">
                        Tidak ada file
                    </td>
                    <td v-if="room.attchs.length">
                        <ul v-for="attch in room.attchs" :key="attch.id">
                            <ListFile :name="attch.file" :size="attch.size" @removeFile="handleRemoveAttch(attch.id)" />
                        </ul>
                    </td>
                    <td>
                        <button class="btn bg-transparent border-0 hover:bg-transparent"
                            @click="handleToggleActive(room.id)" type="button">
                            <div class="badge badge-success gap-2" v-if="room.status">Active</div>
                            <div class="badge badge-error gap-2" v-if="!room.status">Inactive</div>
                        </button>
                    </td>
                    <th class="btn-group-horizontal space-x-2">
                        <Link :href="$route('rooms.edit', room.id)" as="button" class="btn btn-info btn-sm tooltip"
                            data-tip="Edit Room">
                        <PencilIcon class="h-5 text-white" />
                        </Link>
                        <button class="btn btn-error btn-sm tooltip" data-tip="Hapus Room" type="button"
                            @click="handleDelete(room.id)">
                            <TrashIcon class="h-5 text-white" />
                        </button>
                        <button class="btn btn-primary btn-sm tooltip" data-tip="Copy Link Room" type="button"
                            @click="handleCopy($route('uploader.show', room.name))">
                            <ClipboardDocumentIcon class="h-5 text-white" />
                        </button>
                        <button class="btn btn-success btn-sm tooltip relative disabled:bg-blue-500 disabled:bg-opacity-60"
                            :disabled="disableAttch" data-tip="Attach File" type="button"
                            @click="handleSelectFile($event, room.id)">
                            <input type="file" multiple class="invisible absolute" id="input_attch">
                            <LinkIcon class="h-5 text-white pointer-events-none" />
                        </button>
                        <Link :href="$route('rooms.show_ip', room.id)" as="button" class="btn btn-sm tooltip"
                            data-tip="Manage IP">
                        <ComputerDesktopIcon class="h-5 text-white" />
                        </Link>
                    </th>
                    </tr>
                </tbody>
            </table>
            <Pagintion v-if="rooms.data.length" :links="rooms.links" />
        </div>
        <p class="text-center py-4" v-if="rooms.data.length === 0">Rooms tidak ada</p>

    </div>
</template>
<script>
import { Link, useForm } from '@inertiajs/vue3';
import BaseLayout from '../../Layouts/BaseLayout.vue';
import Swal from 'sweetalert2'
import Pagintion from "../../components/Pagination.vue"
import { PencilIcon, TrashIcon, LinkIcon, ComputerDesktopIcon, ClipboardDocumentIcon } from '@heroicons/vue/24/solid';
import ListFile from '../../components/ListFile.vue'
import { useToast } from 'vue-toastification'
export default {
    layout: BaseLayout,
    components: { Link, Pagintion, PencilIcon, TrashIcon, LinkIcon, ComputerDesktopIcon, ClipboardDocumentIcon, ListFile },
    props: {
        rooms: Array
    },
    data() {
        return {
            keyword: null,
            disableAttch: false,
            formAttch: null,
            set_id_modal: null
        }
    },
    watch: {
        keyword(old) {
            if (old.length) {
                this.$inertia.get(this.$route('rooms.index'), { keyword: old }, { preserveState: true, preserveScroll: true })
            } else {
                this.$inertia.get(this.$route('rooms.index'), {}, { preserveScroll: true, preserveState: true })
            }
        }
    },
    setup() {
        const toast = useToast()
        return { toast }
    },

    methods: {
        handleBatchRemove() {
            Swal.fire({
                title: 'Yakin ?',
                text: "Ingin menghapus semua data!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya hapus aja !',
                cancelButtonText: "Batalkan"
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$inertia.post(this.$route('rooms.batch_remove'), {}, {
                        preserveState: true, onSuccess: () => {
                            Swal.fire(
                                'Berhasil!',
                                'Berhasil menghapus semua rooms.',
                                'success'
                            )
                        },

                    })
                }
            })
        },
        handleActiveAll() {
            this.$inertia.post(this.$route('rooms.batch_active'), {}, {
                preserveState: true, onSuccess: () => {
                    Swal.fire(
                        'Berhasil!',
                        'Berhasil mengaktifkan semua rooms.',
                        'success'
                    )
                }
            })
        },
        handleInActiveAll() {
            this.$inertia.post(this.$route('rooms.batch_inactive'), {}, {
                preserveState: true, onSuccess: () => {
                    Swal.fire(
                        'Berhasil!',
                        'Berhasil menonaktifkan semua rooms.',
                        'success'
                    )
                }
            })
        },

        handleDelete(id) {
            const app = this;
            Swal.fire({
                title: 'Yakin ?',
                text: "Kamu Akan menghapus Folder serta data lainnya di room ini !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya hapus aja !',
                cancelButtonText: "Batalkan"
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$inertia.delete(this.$route('rooms.destroy', id), {}, {
                        preserveState: true, preserveScroll: true,
                        onSuccess: () => {
                            Swal.fire(
                                'Berhasil!',
                                'Berhasil menghapus rooms.',
                                'success'
                            )
                        },
                        onError: (err) => {
                            console.log(err)
                            app.toast(err)
                        },
                    })
                }
            })
        },

        handleToggleActive(id) {
            this.$inertia.post(this.$route('rooms.active', id), {}, { preserveState: true, preserveScroll: true })
        },
        async handleCopy(url) {
            try {
                await navigator.clipboard.writeText(url)
                this.toast.success("Copy URL berhasil")
            } catch (e) {
                this.toast.error("Copy URL gagal")
            }
        },
        handleSelectFile(e, id) {
            const input = e.target.querySelector("#input_attch")
            const form = useForm({
                files: []
            })
            const app = this;
            if (input) {
                const _defaultHtmlinput = e.target.innerHTML
                input.click()
                input.addEventListener('change', function () {
                    form.files = input.files
                    app.formAttch = form
                    form.post(app.$route("rooms.attch", id), {
                        preserveState: true, preserveScroll: true, onProgress(progress) {
                            e.target.innerHTML = `<span class="text-white">${progress.percentage}%</span>`;
                            app.disableAttch = true
                        },
                        onSuccess() {
                            app.disableAttch = false
                            e.target.innerHTML = _defaultHtmlinput
                            app.formAttch = null
                            app.toast.success("Berhasil Upload Attch")
                        },
                        onError() {
                            app.disableAttch = false
                            app.formAttch = null
                            e.target.innerHTML = _defaultHtmlinput
                            app.toast.error("Gagal Upload Attch")
                        },
                        onCancel() {
                            app.disableAttch = false
                            e.target.innerHTML = _defaultHtmlinput
                            app.formAttch = null

                        }
                    })
                })
            }

        },
        handleCencelAttch() {
            if (this.formAttch) {
                this.formAttch.cancel();
            }
        },
        handleRemoveAttch(id) {
            const app = this;
            this.$inertia.delete(this.$route('attch.delete', id), {
                preserveScroll: true, preserveState: true, onSuccess() {
                    app.toast.success("Berhasil Hapus Attch")
                },
                onError() {
                    app.toast.error("Gagal Hapus Attch")
                },
            })
        },
    }
}
</script>