
<template>
    <Link :href="$route(path)" :class="`font-bold text-lg ${active ? `bg-primary` : ``}`">
    <slot name="title"></slot>
    </Link>
</template>


<script>
import { Link } from '@inertiajs/vue3';

export default {
    components: { Link },
    data() {
        return {
            current: this.currentRoute
        }
    },
    props: {
        path: { type: String, required: true },
        active: { type: String, required: true }
    },
}
</script>