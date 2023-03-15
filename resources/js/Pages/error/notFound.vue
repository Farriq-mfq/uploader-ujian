<template>
    <div class="grid place-items-center min-h-[80vh]">
        <Head>
            <title>Not found</title>
        </Head>
        <div class="grid text-center gap-7">
            <h1 class="text-7xl font-bold">404</h1>
            <div class="kbd kbd-lg">Maaf Halaman tidak tersedia!</div>
        </div>
    </div>
</template>
<script>
import { Head } from '@inertiajs/vue3';
import PlayRandomImg from '../../components/PlayRandomImg.vue';

export default {
    components: { PlayRandomImg, Head }
}
</script>
<style lang="">
    
</style>