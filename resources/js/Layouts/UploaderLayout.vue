<template>
    <div class="min-h-screen container mx-auto lg:px-0 px-3 py-3">
        <!-- <div class="w-full top-0 left-0" ref="navbar">
            <div class="navbar bg-slate-800 shadow-xl text-white flex justify-between">
                <a class="btn btn-ghost normal-case text-xl">UPLOADER</a>
                <div class="flex space-x-3">
                    <a href="">Profile</a>
                    <a href="">Dark</a>
                </div>
            </div>
        </div> -->
        <slot></slot>
    </div>
</template>
<script>
export default {
    // mounted() {
    //     const app = this;
    //     window.addEventListener('scroll', function () {
    //         if (app.$refs.navbar.offsetHeight != null) {
    //             if (window.scrollY > 100) {
    //                 app.$refs.navbar.classList.add('fixed')
    //                 app.$refs.navbar.classList.remove('mt-2')
    //             } else {
    //                 app.$refs.navbar.classList.remove('fixed')
    //                 app.$refs.navbar.classList.add('mt-2')
    //             }
    //         }
    //     })
    // },

}
</script>
<style lang="">
    
</style>