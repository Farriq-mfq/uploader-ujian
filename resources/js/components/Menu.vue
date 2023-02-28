<template lang="">
   <ul class="menu p-4 w-80 bg-slate-900 text-white space-y-3 shadow-lg">
        <div class="bg-white text-black p-2 rounded-xl grid place-items-center mb-4">
            <h1 class="font-bold text-3xl shadow-sm shadow-white uppercase text-center">
                Uploader <br>
                Stmik
            </h1>
        </div>
        <li>
            <BaseLink path="dashboard" #title>
                <div class="flex space-x-3 items-center">
                    <HomeIcon class="h-6 w-6 text-white" />
                    <span>Home</span>
                </div>
            </BaseLink>
        </li>
        <li>
            <BaseLink path="rooms.index" #title>
                <div class="flex space-x-3 items-center">
                    <InboxStackIcon class="h-6 w-6 text-white" />
                    <span>Rooms</span>
                </div>
            </BaseLink>
        </li>
        <!-- <li>
                    <BaseLink path="berkas" #title>
                        <div class="flex space-x-3 items-center">
                            <FolderOpenIcon class="h-6 w-6 text-white" />
                            <span>Berkas</span>
                        </div>
                    </BaseLink>
                </li>
                <li>
                    <BaseLink path="monitoring" #title>
                        <div class="flex space-x-3 items-center">
                            <ComputerDesktopIcon class="h-6 w-6 text-white" />
                            <span>Monitoring</span>
                        </div>
                    </BaseLink>
                </li>  -->
    </ul>
</template>
<script>
import { HomeIcon, FolderOpenIcon, ComputerDesktopIcon, InboxStackIcon } from '@heroicons/vue/24/solid'
import BaseLink from './BaseLink.vue';

export default {
    components: {
        BaseLink,
        HomeIcon,
        FolderOpenIcon,
        ComputerDesktopIcon,
        InboxStackIcon
    }
}
</script>