<template >
    <div class="grid place-items-center min-h-[80vh]">
        <div class="grid gap-2 max-w-sm w-full">
            <h4 class="text-lg font-bold">ROOM YANG TERSEDIA</h4>
            <span class="text-sm text-gray-700 font-semibold">Private Rooms</span>
            <p class="text-gray-800 uppercase font-bold text-sm" v-if="!allows.length">tidak tersedia</p>
            <Link :href="$route('uploader.show', allow.room.name)" as="button" class="btn btn-primary uppercase tooltip"
                data-tip="JOIN ROOM" v-for="allow in allows" :key="allow.id" replace>
            {{ allow.room.name }}
            </Link>
            <span class="text-sm text-gray-700 font-semibold">Global Rooms</span>
            <p class="text-gray-800 uppercase font-bold text-sm" v-if="!globals.length">tidak tersedia</p>
            <Link :href="$route('uploader.show', global.name)" as="button" class="btn btn-primary uppercase tooltip"
                data-tip="JOIN ROOM" v-for=" global in globals" :key="global.id" replace>
            {{ global.name }}
            </Link>
        </div>
    </div>
</template>
<script>
import { Link } from '@inertiajs/vue3';
import UploaderLayout from '../../Layouts/UploaderLayout.vue';

export default {
    layout: UploaderLayout,
    props: {
        allows: Array,
        globals: Array
    },
    components: { Link }
}
</script>
<style lang="">
    
</style>