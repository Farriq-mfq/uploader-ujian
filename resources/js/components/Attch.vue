<template>
    <div class="w-full border bg-white p-3 rounded-lg relative flex items-center text-sm">
        {{ name }}
        <button class="rounded-lg btn-sm bg-blue-500 absolute right-3" @click.prevent="$emit('handleDownload')">
            <ArrowDownTrayIcon class="h-5 text-white" />
        </button>
    </div>
</template>
<script>
import { ArrowDownTrayIcon } from '@heroicons/vue/24/solid'
export default {
    components: {
        ArrowDownTrayIcon
    },
    props: {
        name: { type: String, required: true }
    }
}
</script>
<style lang="">
    
</style>