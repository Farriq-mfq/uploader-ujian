<template>
    <div class="grid lg:grid-cols-4 gap-4">
        <Folder v-for="room in rooms" :key="room.id" :room="room" @handle-download="handleDownload" />
    </div>
</template>
<script>
import BaseLayout from '../../Layouts/BaseLayout.vue';
import Folder from '../../components/Folder.vue';
export default {
    layout: BaseLayout,
    components: { Folder },
    props: {
        rooms: Array
    },
    methods: {
        handleDownload(id) {
            this.$inertia.get(this.$route('folder.download', id))
        }
    }
}
</script>
<style lang="">
    
</style>