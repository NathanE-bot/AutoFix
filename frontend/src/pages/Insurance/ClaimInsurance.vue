<template>
  <q-page class="insurance_layout_1 flex flex-center position-relative" :class="{'row' : window.width < 500}">
    <div :class="{'col-xs-12' : window.width < 500}">
      <img class="responsive-img fit-content il_1_img m-auto m-d-flex" src="~assets/images/preset/image1.png" alt="">
    </div>
    <div class="m-auto text-center" :class="{'col-xs-10' : window.width < 500}">
      <h4 class="fw-bold m-fs-24px">Choose Your Insurance</h4>
        <q-select
          v-model="vendorInsurance"
          :options="vendorInsuranceList"
          class="insurance_select"
          standout="bg-primary text-white"
          label="Choose your type of insurance"
        />
        <q-btn
          @click="doCheckVendorNotNull(vendorInsurance)"
          color="primary"
          size="xl" unelevated
          icon="fas fa-check"
          class="br-10px mt-20 q-px-lg q-py-xs"
        />
    </div>
    <div :class="{'col-xs-12' : window.width < 500}">
      <img class="responsive-img fit-content il_1_img m-auto m-d-flex" src="~assets/images/preset/image2.png" alt="">
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
      vendorInsuranceList: [],
      window: {
        width: 0,
        height: 0
      }
    }
  },
  created () {
    this.doGetVendorInsuranceList()
  },
  mounted() {
    window.addEventListener('resize', this.handleResize)
    this.handleResize()
  },
  unmounted () {
    window.removeEventListener('resize', this.handleResize)
  },
  methods: {
    handleResize () {
      this.window.width = window.innerWidth
      this.window.height = window.innerHeight
    },
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
    doCheckVendorNotNull (value) {
        if(!help.isDataEmpty(value)){
          this.changePage('/member/insurance/form/' + this.vendorInsurance.value)
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Insurance Not Found',
            text: 'Please Choose your insurance'
          })
        }
    },
    changePage (url) {
      this.$router.push(url)
    }
  }
}
</script>
