
<template>
    <Link :href="$route(path)" class="font-bold text-lg">
    <slot name="title"></slot>
    </Link>
</template>


<script>
import { Link } from '@inertiajs/vue3';

export default {
    components: { Link },
    props: {
        path: { type: String, required: true }
    }
}
</script>