<template>
    <div class="grid lg:grid-cols-4 gap-4">
        <Folder v-for="room in rooms" :key="room.id" :folder="room.folder" />
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
    }
}
</script>
<style lang="">
    
</style>