<template>
    <div
        class="w-full bg-white shadow-sm h-auto border flex justify-center flex-col items-center gap-3 rounded-3xl p-3 relative">
        <Link :href="$route('folder.detail', room.id)">
        <FolderIcon class="text-blue-500 h-48" />
        </Link>
        <h1 class="text-xl font-bold">{{ room.folder }}</h1>
        <div class="flex space-x-2 items-center">
            <a :href="$route('folder.download', room.id)" class="btn btn-sm btn-primary text-white tooltip flex space-x-2"
                data-tip="Download File">
                <ArrowDownTrayIcon class="h-5" />
                <span class="text-sm">Download</span>
            </a>
        </div>
        <div class="font-mono text-slate-900 text-2xl font-bold absolute top-4 right-4 tooltip" data-tip="Total Uploader">
            {{ room.uploads.length }}
        </div>
    </div>
</template>
<script>
import { FolderIcon, EyeIcon, ArrowDownTrayIcon, TrashIcon } from '@heroicons/vue/24/solid';
import { Link } from '@inertiajs/vue3'
export default {
    components: { FolderIcon, EyeIcon, ArrowDownTrayIcon, TrashIcon, Link },
    props: {
        room: { type: Object, required: true }
    }
}
</script>
<style lang="">
    
</style>