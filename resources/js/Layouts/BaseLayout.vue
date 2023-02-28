
<template>
    <div class="drawer drawer-mobile">
        <Bars />
        <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content p-4">
            <div class="text-sm breadcrumbs">
                <ul>
                    <li><a>Home</a></li>
                    <li><a>Documents</a></li>
                    <li>Add Document</li>
                </ul>
            </div>
            <div class="container mx-auto py-4">
                <slot />
            </div>
        </div>
        <div class="drawer-side">
            <label for="my-drawer-2" class="drawer-overlay"></label>
            <Menu />
        </div>
    </div>
</template>
<script>
import Menu from '../components/Menu.vue';
import Bars from '../components/Bars.vue';

export default {
    components: { Menu, Bars }
}
</script>