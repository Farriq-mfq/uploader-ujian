<template >
    <li
        class="w-full bg-white group dark:bg-slate-800 rounded-lg border p-2 border-gray-300 dark:border-slate-400 flex space-x-2 relative items-center z-10 overflow-hidden my-2">
        <FolderIcon class="h-5 text-slate-900 dark:text-white" />
        <div class="text-sm font-bold flex-1 dark:text-white"><span>{{ name }}</span> ({{ formatSize
        }})</div>
        <button type="button" class="absolute right-3" @click="$emit('removeFile')" v-if="!progress">
            <XMarkIcon class="text-red-500 h-5" v-if="!loading" />
        </button>
        <div class="absolute right-3 flex space-x-1" v-if="progress">
            <CloudArrowUpIcon class="text-primary dark:text-teal-500 h-5" />
            <span class="text-sm font-bold dark:text-white">{{ progress.percentage }}%</span>
        </div>
        <progress v-if="progress"
            :class="`bg-transparent absolute -left-2 progress progress-primary rounded-none  h-full w-full transition-all ease-linear`"
            style="z-index: -1; opacity: 0.3; border-radius: 0px !important;" :value="progress.percentage" max="100">
        </progress>
    </li>
</template>
<script>
import { FolderIcon, XMarkIcon, CloudArrowUpIcon } from '@heroicons/vue/24/solid';
import { formatBytes } from '../helper/format'
export default {
    components: { FolderIcon, XMarkIcon, CloudArrowUpIcon },

    computed: {
        formatSize() {
            return formatBytes(this.size)
        }
    },
    props: {
        name: { type: String, required: true },
        size: { type: String, required: true },
        progress: { type: Object, required: true }
    }

}
</script>
<style scoped>
progress::-webkit-progress-bar {
    border-radius: 0px !important;
}

progress::-webkit-progress-value {
    border-radius: 0px !important;
}

progress::-moz-progress-bar {
    border-radius: 0px !important;
}
</style>