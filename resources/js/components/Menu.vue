<template lang="">
   <ul class="menu p-4 w-80 bg-slate-900 text-white space-y-3 shadow-lg">
        <div class="bg-white text-black p-2 rounded-xl grid place-items-center mb-4">
            <h1 class="font-extrabold text-4xl shadow-sm shadow-white uppercase text-center">
                SIUP <br>
            </h1>
        </div>
        <li>
            <BaseLink path="dashboard" :class="`${$page.component === 'index' ? `bg-primary`:``}`"  #title>
                <div class="flex space-x-3 items-center">
                    <HomeIcon class="h-6 w-6 text-white" />
                    <span>Home</span>
                </div>
            </BaseLink>
        </li>
        <li>
            <BaseLink path="rooms.index" :class="`${$page.component.startsWith('rooms') ? `bg-primary`:``}`" #title>
                <div class="flex space-x-3 items-center">
                    <InboxStackIcon class="h-6 w-6 text-white" />
                    <span>Rooms</span>
                </div>
            </BaseLink>
        </li>
        <li>
            <BaseLink path="folder.index"  :class="`${$page.component.startsWith('folder') ? `bg-primary`:``}`" #title>
                <div class="flex space-x-3 items-center">
                    <FolderOpenIcon class="h-6 w-6 text-white" />
                    <span>Folder</span>
                </div>
            </BaseLink>
        </li>
        <li v-if="auth.role === 'master'"> 
            <BaseLink path="operator.index"  :class="`${$page.component.startsWith('operator') ? `bg-primary`:``}`" #title>
                <div class="flex space-x-3 items-center">
                    <UserIcon class="h-6 w-6 text-white" />
                    <span>Operator</span>
                </div>
            </BaseLink>
        </li>  
        <li> 
            <button class="font-bold text-lg" @click.prevent="handleLogout">
                <div class="flex space-x-3 items-center">
                    <PowerIcon class="h-6 w-6 text-white" />
                    <span>Logout</span>
                </div>
            </button>
        </li>  
    </ul>
</template>
<script>
import { HomeIcon, FolderOpenIcon, ComputerDesktopIcon, InboxStackIcon, UserIcon, PowerIcon } from '@heroicons/vue/24/solid'
import BaseLink from './BaseLink.vue';
import Swal from 'sweetalert2'
import { usePage } from '@inertiajs/vue3';

export default {
    components: {
        BaseLink,
        HomeIcon,
        FolderOpenIcon,
        ComputerDesktopIcon,
        InboxStackIcon, UserIcon, PowerIcon
    },
    setup() {
        const auth = usePage().props.auth

        return { auth }
    },
    methods: {
        handleLogout() {
            Swal.fire({
                title: 'Yakin ?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4406CB',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Logout'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$inertia.post(this.$route('logout'), {}, { replace: true })
                }
            })
        }
    },
}
</script>