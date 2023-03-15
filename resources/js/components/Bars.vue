<template >
    <label for="my-drawer-2" ref="bars"
        class="fixed z-[9999] lg:hidden  h-12 w-12 bottom-10 right-10 btn bg-slate-900  grid place-items-center shadow-lg drawer-button">
        <Bars3CenterLeftIcon class=" h-10" />
    </label>
</template>
<script>
import { Bars3CenterLeftIcon } from '@heroicons/vue/24/solid';
export default {
    components: {
        Bars3CenterLeftIcon
    },
}
</script>
<style lang="">
    
</style>