<template>
    <div class="grid place-items-center min-h-[80vh]">
        <div class="text-center grid gap-2 max-w-sm p-4">
            <span>IP <kbd class="kbd kbd-lg">{{ ip }}</kbd> tidak diizinkan <br>untuk mengakses room ini.</span>
            <button class="btn btn-primary btn-sm" type="button" @click.prevent="reloadButton">
                Kembali
            </button>
        </div>
    </div>
</template>
<script>
import UploaderLayout from '../../Layouts/UploaderLayout.vue';
import { router } from '@inertiajs/vue3'
export default {
    layout: UploaderLayout,
    props: {
        ip: String
    },
    methods: {
        reloadButton() {
            router.visit('/');
        }
    }
}
</script>
<style lang="">
    
</style>