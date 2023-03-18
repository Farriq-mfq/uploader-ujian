<template>
    <div class="w-full border bg-white dark:bg-slate-800 dark:border-slate-400 p-3 rounded-lg relative flex items-center text-sm">
        {{ attch.file }}
        <a class="rounded-lg btn-sm bg-primary absolute right-3 flex items-center" :href="$route('uploader.download.attch', attch.id)">
            <ArrowDownTrayIcon class="h-5 text-white" />
        </a>
    </div>
</template>
<script>
import { ArrowDownTrayIcon } from '@heroicons/vue/24/solid'
export default {
    components: {
        ArrowDownTrayIcon
    },
    props: {
        attch: { type: Object, required: true }
    }
}
</script>
<style lang="">
    
</style>