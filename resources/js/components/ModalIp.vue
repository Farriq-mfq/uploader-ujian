<template>
    <!-- The button to open modal -->
    <label for="ipmodal" class="btn w-fit">Tambahkan</label>

    <!-- Put this part before </body> tag -->
    <input type="checkbox" id="ipmodal" class="modal-toggle" />
    <div class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <div class="tabs">
                <a :class="`tab tab-lifted uppercase ${currentTab === tab ? `tab-active` : ``}`"
                    @click.prevent="handleClickTabs(tab)" v-for="(tab, index) in tabs" :key="index">{{ tab }}</a>
            </div>
            <!-- tab content -->
            <div class="w-full mt-3" v-if="currentTab === 'single'">
                <div class="btn-group mb-2">
                    <button type="button" @click.prevent="increment" class="btn btn-sm btn-primary">
                        <PlusIcon class="h-3" />
                    </button>
                </div>
                <div class="flex space-x-2 items-center" v-for="c in countInput" :key="c">
                    <input type="text" placeholder="Masukan IP" class="input input-bordered w-full my-2 flex-1"
                        v-model="allow_ips[c - 1]" />
                    <button type="button" @click.prevent="decrement(c - 1)" class="btn btn-sm btn-error">
                        <MinusIcon class="h-4 text-white" />
                    </button>
                </div>
            </div>
            <div class="lg:columns-2 space-y-2 lg:space-y-0 mt-3" v-if="currentTab === 'range'">

                <input type="text" placeholder="Masukan IP awal" v-model="ipStart" class="input input-bordered w-full" />
                <!-- <p class="text-red-500 text-sm" v-if="form.errors.IpStart">{{ form.errors.IpStart }}</p> -->
                <input type="text" placeholder="Masukan IP akhir" v-model="ipEnd" class="input input-bordered w-full" />
                <!-- <p class="text-red-500 text-sm" v-if="form.errors.IpEnd">{{ form.errors.IpEnd }}</p> -->
            </div>
            <div class="modal-action">
                <label for="ipmodal" class="btn" ref="closeModalIp">Close</label>
                <button for="ipmodal" class="btn btn-primary" type="button" @click.prevent="handleSimpan">SImpan</button>
            </div>
        </div>
    </div>
</template>
<script>
import { PlusIcon, MinusIcon } from '@heroicons/vue/24/solid'
import { RangeIp } from '../helper/rangeIp'
export default {
    data() {
        return {
            tabs: ['single', 'range'],
            currentTab: 'single',
            countInput: 0,
            allow_ips: [],
            ipStart: null,
            ipEnd: null
        }
    },
    components: {
        PlusIcon, MinusIcon
    },

    methods: {
        handleClickTabs(tab) {
            this.currentTab = tab;
            this.allow_ips = []
        },
        increment() {
            this.countInput++
        },
        decrement(index) {
            if (this.countInput > 0) {
                this.countInput--
                this.allow_ips.splice(index, 1)
            }
        },
        handleClickCloseModal() {
            this.$refs.closeModalIp.click()
        },
        async handleSimpan() {
            if (this.currentTab === 'range') {
                try {
                    const ips = await RangeIp(this.ipStart, this.ipEnd);
                    this.$emit('submitIp',ips)
                    this.handleClickCloseModal()
                } catch (e) {
                    console.log(e)
                }
            } else if (this.currentTab === 'single') {
                this.$emit('submitIp', this.allow_ips)
                this.handleClickCloseModal()
            }
        },
    }
}
</script>
<style lang="">
    
</style>