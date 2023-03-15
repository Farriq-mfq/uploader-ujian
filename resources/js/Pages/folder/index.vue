<template>
    <div>
        
        <Head>
            <title>Folder</title>
        </Head>
        <div v-if="!rooms.length">
            Folder Belum ada
        </div>
        <div class="grid lg:grid-cols-4 gap-4" v-if="rooms.length">
            <Folder v-for="room in rooms" :key="room.id" :room="room" @handle-download="handleDownload" />
        </div>
    </div>
</template>
<script>
import BaseLayout from '../../Layouts/BaseLayout.vue';
import Folder from '../../components/Folder.vue';
import { useToast } from 'vue-toastification'
import { Head } from '@inertiajs/vue3';
export default {
    layout: BaseLayout,
    components: { Folder, Head },
    props: {
        rooms: Array,
        errors: Object
    },
    setup({ errors }) {
        const toast = useToast();
        if (errors.ftp) {
            toast.warning(errors.ftp)
        }
        return { toast }
    },
    methods: {
        handleDownload(id) {
            this.$inertia.get(this.$route('folder.download', id))
        },
    },
}
</script>
<style lang="">
    
</style>