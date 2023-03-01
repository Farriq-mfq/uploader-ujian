<template >
    <div class="grid gap-5 my-20">
        <div class="bg-white shadow-lg px-4 py-2 rounded-sm max-w-xl mx-auto w-full border grid gap-3">
            <div class="p-3 border  shadow-lg text-lg font-semibold text-gray-700 justify-self-center bg-white">
                <vue-countdown :time="time" @end="handleEnd" :interval="1000" v-slot="{ hours, minutes, seconds }">
                    <span v-if="hours > 0">
                        {{ hours }}&nbsp;:
                    </span>
                    <span>
                        {{ minutes }}&nbsp;:
                    </span>
                    <span>
                        {{ seconds }}
                    </span>
                </vue-countdown>
            </div>
            <h3 class="font-bold text-gray-600 uppercase">UPLOAD HASIL UJIAN</h3>
            <form action="">
                <div class="my-2 w-full">
                    <input type="text" placeholder="Masukan nama" class="input input-bordered w-full " />
                </div>
                <div class="my-2 w-full">
                    <input type="text" placeholder="NIM" class="input input-bordered w-full " />
                </div>
                <div class="my-2 w-full">
                    <input type="text" placeholder="Masukan Kode Kelas" class="input input-bordered w-full " />
                </div>
                <div class="my-2 w-full">
                    <Upload />
                </div>
                <div class="my-2 w-full">
                    <button
                        class="btn bg-blue-500 border-none font-bold leading-tight hover:bg-blue-500 btn-block text-lg disabled:bg-blue-400 disabled:text-white disabled:cursor-not-allowed">Upload</button>
                </div>
            </form>

        </div>
        <div class="overflow-x-auto shadow-lg">
            <table class="table w-full ">
                <!-- head -->
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIM</th>
                        <th>Kelas</th>
                        <th>File</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- row 1 -->
                    <tr>
                        <th>1</th>
                        <td>Farriq Muwaffaqi</td>
                        <td>21.240.0088</td>
                        <td>
                            <div class="badge badge-accent uppercase">4p42</div>
                        </td>
                        <td>asdflkasdfnal.zip</td>
                    </tr>
                    <tr>
                        <th>1</th>
                        <td>Farriq Muwaffaqi</td>
                        <td>21.240.0088</td>
                        <td>
                            <div class="badge badge-accent uppercase">4p42</div>
                        </td>
                        <td>asdflkasdfnal.zip</td>
                    </tr>
                    <tr>
                        <th>1</th>
                        <td>Farriq Muwaffaqi</td>
                        <td>21.240.0088</td>
                        <td>
                            <div class="badge badge-accent uppercase">4p42</div>
                        </td>
                        <td>asdflkasdfnal.zip</td>
                    </tr>
                    <tr>
                        <th>1</th>
                        <td>Farriq Muwaffaqi</td>
                        <td>21.240.0088</td>
                        <td>
                            <div class="badge badge-accent uppercase">4p42</div>
                        </td>
                        <td>asdflkasdfnal.zip</td>
                    </tr>
                    <tr>
                        <th>1</th>
                        <td>Farriq Muwaffaqi</td>
                        <td>21.240.0088</td>
                        <td>
                            <div class="badge badge-accent uppercase">4p42</div>
                        </td>
                        <td>asdflkasdfnal.zip</td>
                    </tr>
                    <tr>
                        <th>1</th>
                        <td>Farriq Muwaffaqi</td>
                        <td>21.240.0088</td>
                        <td>
                            <div class="badge badge-accent uppercase">4p42</div>
                        </td>
                        <td>asdflkasdfnal.zip</td>
                    </tr>
                    <tr>
                        <th>1</th>
                        <td>Farriq Muwaffaqi</td>
                        <td>21.240.0088</td>
                        <td>
                            <div class="badge badge-accent uppercase">4p42</div>
                        </td>
                        <td>asdflkasdfnal.zip</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
import Upload from '../../components/Upload.vue';
import { ConvertDate } from '../../helper/convertDate';
import UploaderLayout from '../../Layouts/UploaderLayout.vue';
export default {
    layout: UploaderLayout,
    components: {
        Upload
    },
    data() {
        const now = new Date();
        const convertDate = ConvertDate("2023-03-01 17:00:41");
        return {
            time: convertDate - now,
        };
    },

    methods: {
        handleEnd() {
            alert("WAKTU HABIS")
        }
    }

}
</script>
<style lang="">
    
</style>