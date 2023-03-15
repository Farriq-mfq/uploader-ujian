<template>
    <div>
        <Head>
            <title>Error</title>
        </Head>
        <PlayRandomImg :show="true" message="Rooms tidak di temukan atau belum diaktifkan" />
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