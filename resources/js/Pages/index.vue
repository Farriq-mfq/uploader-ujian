<template>
    <div class="grid grid-cols-1 gap-5 lg:grid-cols-4">

        <Head>
            <title>Dashboard</title>
        </Head>
        <div class="stats shadow">

            <div class="stat">
                <div class="stat-title">Total Page Views</div>
                <div class="stat-value">89,400</div>
                <div class="stat-desc">21% more than last month</div>
            </div>

        </div>
        <div class="stats shadow">

            <div class="stat">
                <div class="stat-title">Total Page Views</div>
                <div class="stat-value">89,400</div>
                <div class="stat-desc">21% more than last month</div>
            </div>

        </div>
        <div class="stats shadow">

            <div class="stat">
                <div class="stat-title">Total Page Views</div>
                <div class="stat-value">89,400</div>
                <div class="stat-desc">21% more than last month</div>
            </div>

        </div>
        <div class="stats shadow">

            <div class="stat">
                <div class="stat-title">Total Page Views</div>
                <div class="stat-value">89,400</div>
                <div class="stat-desc">21% more than last month</div>
            </div>

        </div>
    </div>
</template>
<script>
import { Head } from '@inertiajs/vue3';
import BaseLayout from '../Layouts/BaseLayout.vue';

export default {
    layout: BaseLayout,
    props: {
        auth: Object
    },
    components: {
        Head
    }


}
</script>