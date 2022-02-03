<template>
  <q-page class="pt-40 insurance_layout_3">
    <div class="flex flex-dir-col w-80 m-auto">
      <div class="text-h5 fw-semibold text-white mb-40">Insurance List</div>
      <q-markup-table class="fw br-10px insurance-status-table" wrap-cells>
        <thead>
          <tr>
            <th class="text-center" v-for="(header, index) in tableHeader" :key="'iList' + index">
              <span class="fw-semibold text-subtitle2">{{ header }}</span>
            </th>
          </tr>
        </thead>
        <tbody v-if="!help.isObjectEmpty(dataInsuranceList)">
          <tr v-for="(item, index) in dataInsuranceList" :key="'insurance-' + index">
            <td class="text-center">{{index + 1}}</td>
            <td class="text-center tf-capitalize">{{item.insuranceName}}</td>
            <td class="text-center">{{item.submitDate}}</td>
            <td class="text-center">{{item.polisNumber}}</td>
            <td class="text-center tf-capitalize">{{item.insuranceStatus}}</td>
            <td class="text-center">
              <q-btn
                icon="far fa-file"
                flat round
                :color="item.insuranceStatus === 'on progress' ? 'grey' : 'primary'"
                :disable="item.insuranceStatus === 'on progress'"
                @click="doOpenMenuList(index+1, item.insuranceStatus, item.id)"
              />
            </td>
          </tr>
        </tbody>
        <tbody v-else>
          <tr>
            <td>No Data</td>
          </tr>
        </tbody>
      </q-markup-table>
      <!-- <div class="p-15 flex j-end">
        <q-pagination
          v-model="iPage"
          :max="5"
        />
      </div> -->
      <q-dialog v-model="promptDetail">
        <q-card style="min-width: 480px" class="py-20 m-auto text-align-center">
          <q-card-section>
            <div class="black-1 m-auto fw-semibold text-align-center fs-18">Menu List</div>
          </q-card-section>
          <div class="w-90 j-sp-around flex m-auto">
            <q-btn
              rounded color="primary"
              :disable="openDetail.filePDF === null ? true : false"
              class="tf-capitalize w-30">
              Download PDF
            </q-btn>
            <q-btn
              rounded color="primary"
              @click="doChangePage()"
              class="tf-capitalize w-30">
              View Detail
            </q-btn>
          </div>
        </q-card>
      </q-dialog>
    </div>
  </q-page>
</template>

<script>
/* eslint-disable */
import Swal from 'sweetalert2'
import Auth from '../../js/AuthValidation'
import help from '../../js/help'
import { LocalStorage } from 'quasar'
import { getInsuranceStatusApi } from '../../api/InsuranceService'

export default {
  data () {
    return {
      help,
      user: {},
      userToken: null,
      filter: '',
      loader: false,
      iPage: 1,
      tableHeader: ['No', 'Insurance Name', 'Created Date', 'Polis Number', 'Status', 'View'],
      dataInsuranceList: [],
      promptDetail: false,
      openDetail: {
        index: null,
        insuranceStatus: null,
        insuranceID: null
      },

    }
  },
  created() {
    this.user = LocalStorage.getItem('autoRepairUser').data.user
    this.userToken = LocalStorage.getItem('autoRepairUser').data.access_token
    this.doGetInsuranceList()
  },
  methods: {
    doGetInsuranceList () {
      let _this = this
      _this.loader = true
      getInsuranceStatusApi(_this.user.id, _this.userToken).then(response => {
        this.dataInsuranceList = response.data.objectReturn
        console.log(this.dataInsuranceList)
        _this.loader = true
      }) .catch((err) => {
        console.log(err)
        _this.loader = true
      })
    },
    changePage (url) {
      this.$router.push(url)
    },
    doOpenMenuList (index, insuranceStatus1, insuranceID1) {
      console.log('insuranceStatus', insuranceStatus1)
      this.promptDetail = true;
      this.openDetail.insuranceStatus = insuranceStatus1
      this.openDetail.insuranceID = insuranceID1
      this.openDetail.filePDF = !help.isDataEmpty(this.dataInsuranceList[index].filePDF) ? this.dataInsuranceList[index].filePDF : null
      console.log('menu', this.openDetail)
    },
    doChangePage () {
      this.changePage('/insurance/status-insurance/detail/' + this.openDetail.insuranceStatus + '/' + this.openDetail.insuranceID)
    }
  }
}
</script>
