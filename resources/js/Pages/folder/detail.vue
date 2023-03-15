<template>
    <div>
        <Head>
            <title>Folder {{ roomName.name }}</title>
        </Head>
        <div class="mb-4 space-x-2">
            <Link class="btn btn-primary" as="button" :href="$route('folder.index')" replace>
            Kembali
            </Link>
        </div>
        <h2 class="text-xl uppercase font-bold mb-2">File yang telah terupload di {{ roomName.name }}</h2>
        <div class="mb-3">
            <input v-model="keyword" type="search" placeholder="Cari nama atau NIM"
                class="input input-bordered w-full max-w-xs" />
        </div>
        <Link :href="$route('folder.detail', roomName.id)" :only="['uploads']" preserve-state preserve-scroll type="button"
            class="btn btn-primary mb-3" as="button">Refresh
        </Link>
        <div class="mb-3 btn-group-horizontal space-x-2" v-if="uploads.data.length">
            <button @click.prevent="handleDeleteAll" type="button" class="btn btn-error">Hapus
                Semua</button>
        </div>
        <div class="overflow-x-auto w-full card shadow-xl p-2" v-if="uploads.data.length">
            <table class="table w-full">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>NIM</th>
                        <th>Type</th>
                        <th>File</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="upload in uploads.data" :key="upload.id">
                        <td>{{ upload.name }}</td>
                        <td>{{ upload.nim }}</td>
                        <td>{{ upload.type == null ? "Tidak diberi type soal" : upload.type }}</td>
                        <td>{{ upload.file }}</td>
                        <td>
                            <button class="btn btn-error btn-sm tooltip" data-tip="Hapus Uploader" type="button"
                                @click="handleDelete(upload.id)">
                                <TrashIcon class="h-5 text-white" />
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <Pagination v-if="uploads.data.length" :links="uploads.links" />
        </div>
        <p v-if="!uploads.data.length">Data belum ada</p>
    </div>
</template>
<script>
import { TrashIcon } from '@heroicons/vue/24/solid';
import { Head, Link } from '@inertiajs/vue3';
import Pagination from '../../components/Pagination.vue';
import BaseLayout from '../../Layouts/BaseLayout.vue';
import Swal from 'sweetalert2';
export default {
    layout: BaseLayout,
    props: {
        uploads: Array,
        roomName: Object
    },
    data() {
        return {
            keyword: null
        }
    },
    watch: {
        keyword(old) {
            if (old.length) {
                this.$inertia.get(this.$route('folder.detail', this.roomName.id), { keyword: old }, { preserveState: true, preserveScroll: true })
            } else {
                this.$inertia.get(this.$route('folder.detail', this.roomName.id), {}, { preserveScroll: true, preserveState: true })
            }
        }
    },
    components: { Link, Pagination, TrashIcon, Head },
    methods: {
        handleDelete(id) {
            Swal.fire({
                title: 'Yakin ?',
                text: "Kamu Akan menghapus data salah satu data folder ini !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya hapus aja !',
                cancelButtonText: "Batalkan"
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$inertia.delete(this.$route('folder.delete', id), {}, {
                        preserveState: true, preserveScroll: true, onSuccess: () => {
                            Swal.fire(
                                'Berhasil!',
                                'Berhasil menghapus salah satu data folder.',
                                'success'
                            )
                        }
                    })
                }
            })
        },
        handleDeleteAll() {
            Swal.fire({
                title: 'Yakin ?',
                text: "Kamu Akan menghapus semua data di folder ini !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya hapus aja !',
                cancelButtonText: "Batalkan"
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$inertia.delete(this.$route('folder.remove_all', this.roomName.id), {}, {
                        preserveState: true, preserveScroll: true, onSuccess: () => {
                            Swal.fire(
                                'Berhasil!',
                                'Berhasil menghapus semua data folder.',
                                'success'
                            )
                        }
                    })
                }
            })
        }
    }
}
</script>
<style lang="">
    
</style>