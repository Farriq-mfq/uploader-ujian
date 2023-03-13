<template>
    <div>
        <div class="mb-3">
            <Link :href="$route('rooms.create')" class="btn btn-primary">Tambahkan Operator</Link>
        </div>
        <div class="overflow-x-auto w-full card shadow-xl p-2">
            <table class="table w-full">
                <!-- head -->
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="operator in operators" :key="operator.id">
                        <td>{{ operator.name }}</td>
                        <td>{{ operator.username }}</td>
                        <td>
                            <button>Click</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
import BaseLayout from '../../Layouts/BaseLayout.vue'
export default {
    layout: BaseLayout,
    props: {
        operators: Array
    }
}
</script>
<style lang="">
    
</style>