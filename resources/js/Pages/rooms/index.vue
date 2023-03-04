<template>
    <div>

        <div class="mb-3">
            <Link :href="$route('rooms.create')" class="btn btn-primary">Buat rooms</Link>
        </div>
        <div class="mb-3" v-if="rooms.data.length">
            <input v-model="keyword" type="search" placeholder="Cari nama rooms"
                class="input input-bordered w-full max-w-xs" />
        </div>
        <div class="mb-3 btn-group-horizontal space-x-2" v-if="rooms.data.length">
            <button @click="handleBatchRemove" type="button" class="btn btn-error">Hapus Semua</button>
            <button class="btn btn-accent" type="button" @click="handleActiveAll">Active Semua</button>
            <button class="btn btn-secondary" type="button" @click="handleInActiveAll">Inactive Semua</button>
        </div>
        <div class="overflow-x-auto w-full card shadow-xl p-2">
            <table class="table w-full" v-if="rooms.data.length">
                <!-- head -->
                <thead>
                    <tr>
                        <th>Rooms name</th>
                        <th>Waktu</th>
                        <th>Kelas</th>
                        <th>Mata Kuliah</th>
                        <th>Nama Folder</th>
                        <th>Extension yang di izinkan</th>
                        <th>status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="room in rooms.data" :key="room.id">

                        <td>
                            {{ room.name }}
                        </td>
                        <td>
                            {{ room.time_start }} - {{ room.time_end }}
                        </td>
                        <td>
                            {{ room.kelas }}
                        </td>
                        <td>
                            {{ room.mata_kuliah }}
                        </td>
                        <td>
                            {{ room.folder }}
                        </td>
                        <td>
                            <div class="badge badge-primary mx-1 font-bold p-3"
                                v-for="(ext, index) in room.extensions.split(',')" :key="index">
                                {{ ext }}</div>
                        </td>
                        <td>
                            <button class="btn bg-transparent border-0 hover:bg-transparent"
                                @click="handleToggleActive(room.id)" type="button">
                                <div class="badge badge-success gap-2" v-if="room.status">Active</div>
                                <div class="badge badge-error gap-2" v-if="!room.status">Inactive</div>
                            </button>
                        </td>
                        <th class="btn-group-horizontal space-x-2">
                            <Link :href="$route('rooms.edit', room.id)" as="button" class="btn btn-info">Edit</Link>
                            <button class="btn btn-error" type="button" @click="handleDelete(room.id)">Delete</button>
                            <button class="btn btn-primary" type="button"
                                @click="handleCopy($route('uploader.index', room.name))">Copy</button>
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
import { Link } from '@inertiajs/vue3';
import BaseLayout from '../../Layouts/BaseLayout.vue';
import Swal from 'sweetalert2'
import Pagintion from "../../components/Pagination.vue"
export default {
    layout: BaseLayout,
    components: { Link, Pagintion },
    props: {
        rooms: Array
    },
    data() {
        return {
            keyword: null,
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
        const toast = Swal.mixin({
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
                        }
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
            Swal.fire({
                title: 'Yakin ?',
                text: "Ingin menghapus data ini !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya hapus aja !',
                cancelButtonText: "Batalkan"
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$inertia.delete(this.$route('rooms.destroy', id), {}, {
                        preserveState: true, preserveScroll: true, onSuccess: () => {
                            Swal.fire(
                                'Berhasil!',
                                'Berhasil menghapus rooms.',
                                'success'
                            )
                        }
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
                this.toast.fire("Copy URL berhasil")
            } catch (e) {
                this.toast.fire("Copy URL gagal")
            }
        }
    }
}
</script>