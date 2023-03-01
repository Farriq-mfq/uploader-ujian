<template>
    <div>
        <vue-countdown :time="time" @end="handleEnd" :interval="100" v-slot="{ days, hours, minutes, seconds }">
            Time Remaining：{{ days }} days, {{ hours }} hours, {{ minutes }} minutes, {{ seconds }} seconds.
        </vue-countdown>
        <p>WELCOME TO DASHBOORD</p>
    </div>
</template>
<script>
import BaseLayout from '../Layouts/BaseLayout.vue';
import { ConvertDate } from '../helper/convertDate'
export default {
    layout: BaseLayout,
    data() {
        const now = new Date();
        const convertDate = ConvertDate("2023-03-01 13:12:41");
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