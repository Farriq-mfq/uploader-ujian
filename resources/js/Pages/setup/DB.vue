<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import { getCurrentInstance, ref } from 'vue';
import { useToast } from 'vue-toastification';
type SetupDbProps = {
    get_db_name: boolean
}
const $route = getCurrentInstance()?.appContext.config.globalProperties.$route
const $inertia = getCurrentInstance()?.appContext.config.globalProperties.$inertia

const { get_db_name } = usePage().props as unknown as SetupDbProps
const isLoading = ref(false)
const $toast = useToast();
function handleCreateDb() {
    $inertia?.post($route('setup.createdb'), {}, {
        onBefore() {
            isLoading.value = true
        },
        onSuccess(){
            $toast.success('Berhasil Setup Database')
        },
        onFinish() {
            $inertia?.visit($route('setup.index'), { replace: true })
        }
    })
}


</script>
<template>
    <div class="container  mx-auto min-h-screen grid place-items-center">
        <Head>
            <title>Database</title>
        </Head>
        <div class="bg-white h-auto w-1/2 p-4 rounded-lg shadow text-center">
            Database <b>{{ get_db_name }}</b> belum di buat <br>
            <button @click.prevent="handleCreateDb" type="button" class="btn btn-primary mt-4" :disabled="isLoading">
                {{ isLoading ? "Sedang Dibuat..." : "Buat Database ?" }}
            </button>
        </div>

    </div>
</template>
<style lang="">
    
</style>