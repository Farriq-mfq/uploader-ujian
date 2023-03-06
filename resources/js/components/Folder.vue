<template>
    <div
        class="w-full bg-white shadow-sm h-auto border flex justify-center flex-col items-center gap-3 rounded-3xl p-3 relative">
        <FolderIcon class="text-blue-500 h-48" />
        <h1 class="text-xl font-bold">{{ folder }}</h1>
        <div class="flex space-x-2 items-center">
            <button class="btn btn-sm btn-primary text-white tooltip" data-tip="Download File">
                <ArrowDownTrayIcon class="h-5" />
            </button>
            <button class="btn btn-sm btn-success text-white tooltip" data-tip="Lihat File">
                <EyeIcon class="h-5" />
            </button>
        </div>
        <div class="badge badge-accent text-white absolute top-4 right-4 tooltip" data-tip="Total File">
            12
        </div>
    </div>
</template>
<script>
import { FolderIcon, EyeIcon, ArrowDownTrayIcon, TrashIcon } from '@heroicons/vue/24/solid';
export default {
    components: { FolderIcon, EyeIcon, ArrowDownTrayIcon, TrashIcon },
    props: {
        folder: { type: String, required: true }
    }
}
</script>
<style lang="">
    
</style>