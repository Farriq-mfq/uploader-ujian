<template>
    <div class="grid place-items-center min-h-[80vh]">
        <div class="text-center grid gap-2 max-w-sm p-4">
            <span>IP <kbd class="kbd kbd-lg">{{ ip }}</kbd> tidak diizinkan <br>untuk mengakses room ini.</span>
            <Link class="btn btn-primary btn-sm" as="button" :href="$route('uploader.index')" replace>
            Kembali
            </Link>
        </div>
    </div>
</template>
<script>
import UploaderLayout from '../../Layouts/UploaderLayout.vue';
import { Link, router } from '@inertiajs/vue3'
export default {
    layout: UploaderLayout,
    props: {
        ip: String
    },
    components: { Link }
}
</script>
<style lang="">
    
</style>