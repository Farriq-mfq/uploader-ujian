<template >
    <div v-if="show" class="w-full min-h-[80vh] grid place-items-center">
        <div class="max-w-xl w-full p-3 grid place-items-center gap-7 text-center">
            <img :src="random" />
            <kbd class="kbd kbd-lg">{{ message }}</kbd>
            <button class="btn btn-primary btn-sm" type="button" @click.prevent="reloadButton">
                Kembali
            </button>
        </div>
    </div>
</template>
<script>
import { router } from '@inertiajs/vue3'
import { randomImg } from '../helper/randomImage';
export default {
    props: {
        show: { type: Boolean, required: true },
        message: { type: Boolean, required: true }
    },
    computed: {
        random() {
            return randomImg()
        }
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