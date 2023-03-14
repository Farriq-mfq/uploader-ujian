<template>
    <div class="grid gap-3">
        <div v-bind="getRootProps()"
            :class="`w-full h-64 flex border-2 border-dashed border-gray-300 justify-center items-center rounded-lg ${isDragActive ? `bg-blue-100` : ``}`">
            <input v-bind="getInputProps()" />
            <div v-if="isDragActive" class="grid place-items-center first-letter gap-2">
                <FolderOpenIcon class="text-blue-500 h-24" />
                <p class="text-center text-gray-500 font-semibold divider">Letakan disini ...</p>
            </div>
            <div v-else class="grid place-items-center first-letter gap-2">
                <CloudArrowUpIcon class="text-blue-500 h-24" />
                <p class=" text-center text-gray-500 font-semibold leading-tight">Drag 'n' drop disini, atau <br><span
                        class="divider">Atau</span>
                <div
                    class="bg-blue-500 hover:bg-blue-500/90 p-2 rounded-lg text-white cursor-pointer btn border-none font-bold leading-tight hover:bg-blue-500/90 btn-block text-sm">
                    Pilih file</div>
                </p>
            </div>
        </div>
        <p class="text-gray-500 font-semibold leading-tight">
            {{ message }}
        </p>
    </div>
</template>
<script>
import { useDropzone } from "vue3-dropzone";
import { CloudArrowUpIcon, FolderOpenIcon } from '@heroicons/vue/24/solid';

export default {
    components: { CloudArrowUpIcon, FolderOpenIcon },
    props: {
        message: String
    },
    setup(props, ctx) {
        function onDrop(acceptFiles, rejectReasons) {
            ctx.emit("setFile", acceptFiles)
        }

        const { getRootProps, getInputProps, ...rest } = useDropzone({ onDrop, multiple: true });

        return {
            getRootProps,
            getInputProps,
            ...rest,
        };
    },
}
</script>
<style lang="">
    
</style>