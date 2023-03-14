<template>
    <div>
        <div class="mb-3">
            <Link :href="$route('operator.create')" as="button" class="btn btn-primary">Tambahkan Operator</Link>
        </div>
        <div class="mb-3">
            <input v-model="keyword" type="search" placeholder="Cari nama rooms"
                class="input input-bordered w-full max-w-xs" />
        </div>
        <div class="overflow-x-auto w-full card shadow-xl p-2">
            <table class="table w-full">
                <!-- head -->
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="operator in operators" :key="operator.id">
                        <td>{{ operator.name }}</td>
                        <td>{{ operator.username }}</td>
                        <td class="btn-group-horizontal space-x-2">
                            <Link :href="$route('operator.edit', operator.id)" as="button"
                                class="btn btn-info btn-sm tooltip" data-tip="Edit operator">
                            <PencilIcon class="h-5 text-white" />
                            </Link>
                            <button class="btn btn-error btn-sm tooltip" data-tip="Hapus operator" type="button"
                                @click="handleDelete(operator.id)">
                                <TrashIcon class="h-5 text-white" />
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
import BaseLayout from '../../Layouts/BaseLayout.vue'
import { Link } from '@inertiajs/vue3';
import { PencilIcon, TrashIcon } from '@heroicons/vue/24/solid';
import Swal from 'sweetalert2'
export default {
    layout: BaseLayout,
    components: {
        Link,
        TrashIcon,
        PencilIcon
    },
    props: {
        operators: Array
    },
    data() {
        return {
            keyword: null
        }
    },
    watch: {
        keyword(old) {
            if (old.length) {
                this.$inertia.get(this.$route('operator.index'), { keyword: old }, { preserveState: true, preserveScroll: true })
            } else {
                this.$inertia.get(this.$route('operator.index'), {}, { preserveScroll: true, preserveState: true })
            }
        },
    },
    methods: {
        handleDelete(id) {
            Swal.fire({
                title: 'Yakin ?',
                text: "Kamu Akan menghapus operator ini !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya hapus aja !',
                cancelButtonText: "Batalkan"
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$inertia.delete(this.$route('operator.destroy', id), {}, {
                        preserveState: true, preserveScroll: true, onSuccess: () => {
                            Swal.fire(
                                'Berhasil!',
                                'Berhasil menghapus operator.',
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