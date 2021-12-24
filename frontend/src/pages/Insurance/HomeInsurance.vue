<template>
    <q-page class="insurance_layout_1 flex flex-center position-relative">
        <div>
            <img class="responsive-img" src="~assets/images/preset/image1.png" alt="">
        </div>
        <div class="m-auto text-center">
            <h4 class="fw-bold">Choose Your Insurance</h4>
            <q-select
                v-model="model"
                :options="options"
                class="insurance_select"
                standout="bg-primary text-white"
                label="Choose your type of insurance"
                transition-show="jump-down"
                transition-hide="jump-up" />
            <q-btn
                color="primary"
                size="xl"
                icon="fas fa-check"
                class="br-10px mt-20 q-px-lg q-py-xs" />
        </div>
        <div>
            <img class="responsive-img" src="~assets/images/preset/image2.png" alt="">
        </div>
    </q-page>
</template>

<script>
/* eslint-disable */
export default {
    data () {
        return {
            model: null,
            options: [
                'Testing1', 'Testing2', 'Testing3'
            ]
        }
    }
}
</script>
