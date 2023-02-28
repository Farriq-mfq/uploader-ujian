<template >
    <div class="btn-group">
        <Link :disabled="link.url == null" :href="link.url" as="button"
            :class="`btn btn-outline btn-primary disabled:bg-base-200 btn-sm ${link.active ? `btn-active` : ``}`"
            v-for="link in links" :key="link" v-html="link.label" preserve-state>
        </Link>
    </div>
</template>
<script>
import { Link } from '@inertiajs/vue3';

export default {
    props: {
        links: { type: Object, required: true }
    },
    mounted() {
        console.log(this.links);
    },
    components: { Link }
}
</script>
<style lang="">
    
</style>