<script setup lang="ts">
import { usePage } from '@inertiajs/inertia-vue3'
import { Link ,Head} from '@inertiajs/vue3';
import { getCurrentInstance } from 'vue';
type SetupIndexProps = {
    check_db_is_connected: boolean
}
const { check_db_is_connected } = usePage().props as unknown as SetupIndexProps
const $route = getCurrentInstance()?.appContext.config.globalProperties.$route
</script>
<template>
    <div class="container  mx-auto min-h-screen grid place-items-center">
        <Head>
            <title>Install</title>
        </Head>
        <div class="bg-white h-auto w-1/2 p-4 rounded-lg shadow text-center">
            <p :class="`font-bold ${check_db_is_connected ? `text-green-500` : `text-red-500`}`">{{ check_db_is_connected ?
                'Database Sudah Konek' : 'Database Belum Konek' }}</p>
            <Link class="btn btn-primary mt-4" replace :href="$route('setup.index')">
            Reload
            </Link>
        </div>
    </div>
</template>
<style lang="">
    
</style>