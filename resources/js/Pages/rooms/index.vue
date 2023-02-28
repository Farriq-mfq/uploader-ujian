<template>
    <div class="">
        <div class="mb-3">
            <Link :href="$route('rooms.create')" class="btn btn-primary">Buat rooms</Link>
        </div>
        <div class="mb-3">
            <input v-model="keyword" type="search" placeholder="Cari nama rooms"
                class="input input-bordered w-full max-w-xs" />
        </div>
        <div class="mb-3 btn-group-horizontal space-x-2 ">
            <button @click="handleBatchRemove" type="button" class="btn btn-error">Hapus Semua</button>
            <button class="btn btn-secondary">Active Semua</button>
        </div>
        <div class="overflow-x-auto w-full card shadow-xl">
            <table class="table w-full" v-if="rooms.length">
                <!-- head -->
                <thead>
                    <tr>
                        <th>Rooms name</th>
                        <th>Waktu</th>
                        <th>Jangkauan Ip</th>
                        <th>Nama Folder</th>
                        <th>Extension yang di izinkan</th>
                        <th>status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="room in rooms" :key="room.id">

                        <td>
                            {{ room.name }}
                        </td>
                        <td>
                            {{ room.time_start }} - {{ room.time_end }}
                        </td>
                        <td>
                            {{ room.ip_start }} - {{ room.ip_end }}
                        </td>
                        <td>
                            {{ room.folder }}
                        </td>
                        <td>
                            {{ room.extensions }}
                        </td>
                        <td>
                            <button class="btn bg-transparent border-0 hover:bg-transparent">
                                <div class="badge badge-success gap-2" v-if="room.status">Active</div>
                                <div class="badge badge-error gap-2" v-if="!room.status">Inactive</div>
                            </button>
                        </td>
                        <th class="btn-group-horizontal space-x-2">
                            <button class="btn btn-info">Edit</button>
                            <button class="btn btn-error">Delete</button>
                        </th>
                    </tr>
                </tbody>
            </table>
            <p class="text-center py-4" v-if="rooms.length === 0">Rooms tidak ada</p>
        </div>
    </div>
</template>
<script>
import { Link } from '@inertiajs/vue3';
import BaseLayout from '../../Layouts/BaseLayout.vue';
import Swal from 'sweetalert2'
export default {
    layout: BaseLayout,
    components: { Link, },
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
                    this.$inertia.post(this.$route('rooms.batch_remove'), {}, { preserveState: true })
                    // Swal.fire(
                    //     'Deleted!',
                    //     'Your file has been deleted.',
                    //     'success'
                    // )
                }
            })
        }
    }
}
</script>