<template>
    <q-page class="insurance_layout_1 flex flex-center position-relative">
        <div>
            <img class="responsive-img fit-content" src="~assets/images/preset/image1.png" alt="">
        </div>
        <div class="m-auto text-center">
            <h4 class="fw-bold">Choose Your Insurance</h4>
            <q-select
                v-model="vendorInsurance"
                :options="vendorInsuranceList"
                class="insurance_select"
                standout="bg-primary text-white"
                label="Choose your type of insurance"
            />
            <q-btn
                @click="changePage('/member/insurance/form/' + vendorInsurance.value)"
                color="primary"
                size="xl" unelevated
                icon="fas fa-check"
                class="br-10px mt-20 q-px-lg q-py-xs"
            />
        </div>
        <div>
            <img class="responsive-img fit-content" src="~assets/images/preset/image2.png" alt="">
        </div>
    </q-page>
</template>

<script>
/* eslint-disable */
import Swal from 'sweetalert2'
import help from '../../js/help'
import { getVendorInsuranceList } from '../../api/InsuranceService'
import { LocalStorage } from 'quasar'

export default {
    data () {
        return {
            help,
            forLoad: true,
            vendorInsurance: null,
            vendorInsuranceList: []
        }
    },
    created () {
        this.doGetVendorInsuranceList()
    },
    methods: {
        doGetVendorInsuranceList () {
            let _this = this
            let token = LocalStorage.getItem('autoRepairUser').data.access_token
            getVendorInsuranceList(token).then(response => {
                let tempArr = []
                tempArr = response.data.objectReturn
                console.log(tempArr)
                tempArr.forEach(el1 => {
                    let tempObj = {
                        label: el1.insuranceName,
                        value: el1.id
                    }
                    _this.vendorInsuranceList.push(tempObj)
                })
            }) .catch((err) => {
                console.log(err)
            })
        },
        changePage (url) {
            this.$router.push(url)
        }
    }
}
</script>
