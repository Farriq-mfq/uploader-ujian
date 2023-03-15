<template>
    <div class="grid grid-cols-1 gap-5 lg:grid-cols-4">

        <Head>
            <title>Dashboard</title>
        </Head>
        <div class="stats shadow">

            <div class="stat">
                <div class="stat-title">Total Rooms</div>
                <div class="stat-value">{{ rooms }}</div>
            </div>

        </div>
        <div class="stats shadow" v-if="auth.role === 'master'">

            <div class="stat">
                <div class="stat-title">Total Operator</div>
                <div class="stat-value">{{ operators }}</div>
            </div>

        </div>
    </div>
</template>
<script>
import { Head, usePage } from '@inertiajs/vue3';
import BaseLayout from '../Layouts/BaseLayout.vue';

export default {
    layout: BaseLayout,
    props: {
        rooms: String,
        operators: String,
    },
    components: {
        Head
    }
    ,
    setup() {
        const auth = usePage().props.auth

        return { auth }
    }

}
</script>