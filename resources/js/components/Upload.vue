<template>
    <div class="grid gap-3">
        <div v-bind="getRootProps()"
            :class="`w-full h-64 flex border-2 border-dashed border-gray-300 justify-center items-center ${isDragActive ? `bg-blue-100` : ``}`">
            <input v-bind="getInputProps()" />
            <p class="text-center text-gray-500 font-semibold leading-tight" v-if="isDragActive">Letakan disini ...</p>
            <div v-else class="grid place-items-center first-letter gap-2">
                <CloudArrowUpIcon class="text-blue-500 h-24" />
                <p class=" text-center text-gray-500 font-semibold leading-tight">Drag 'n' drop disini, atau <br><span
                        class="divider">Atau</span>
                <div
                    class="bg-blue-500 p-2 rounded-lg text-white cursor-pointer btn bg-blue-500 border-none font-bold leading-tight hover:bg-blue-500 btn-block text-sm">
                    Pilih file</div>
                </p>
            </div>
        </div>
        <p class="text-gray-500 font-semibold leading-tight">
            JAMES
        </p>
    </div>
</template>
<script>
import { useDropzone } from "vue3-dropzone";
import { CloudArrowUpIcon } from '@heroicons/vue/24/solid'
export default {
    components: { CloudArrowUpIcon },
    setup() {
        function onDrop(acceptFiles, rejectReasons) {
            console.log(acceptFiles);
            console.log(rejectReasons);
        }

        const { getRootProps, getInputProps, ...rest } = useDropzone({ onDrop });

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