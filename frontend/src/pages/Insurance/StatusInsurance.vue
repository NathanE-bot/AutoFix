<template>
  <q-page class="flex flex-center insurance_layout_3">
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
        <tbody>
          <tr v-for="(item, index) in tableBody" :key="'insurance-' + index">
            <td class="text-center">{{index + 1}}</td>
            <td class="text-center">{{item.insuranceName}}</td>
            <td class="text-center">{{item.createdDate}}</td>
            <td class="text-center">{{item.policeNumber}}</td>
            <td class="text-center">{{item.status}}</td>
            <td class="text-center">
              <q-btn
                icon="far fa-file"
                flat round :color="item.status == 'Accepted' ? 'primary' : 'grey'"
              />
            </td>
          </tr>
        </tbody>
      </q-markup-table>
      <div class="p-15 flex j-end">
        <q-pagination
          v-model="iPage"
          :max="5"
        />
      </div>
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
      user: {},
      userToken: null,
      filter: '',
      loader: false,
      iPage: 1,
      tableHeader: ['No', 'Insurance Name', 'Created Date', 'Police Number', 'Status', 'View'],
      tableBody: [
        {insuranceName: 'Astra', createdDate: '20/11/2021', policeNumber: '40239402934', status: 'Accepted'},
        {insuranceName: 'Garda', createdDate: '28/12/2021', policeNumber: '09420934234', status: 'Waiting Confirmation'},
        {insuranceName: 'Testing', createdDate: '18/1/2022', policeNumber: '4309528492', status: 'Cancelled'},
        {insuranceName: 'BCA', createdDate: '12/1/2022', policeNumber: '2380392422', status: 'Rejected'},
        {insuranceName: 'Prudential', createdDate: '14/1/2022', policeNumber: '2341287310923', status: 'Done'},
        {insuranceName: 'HA', createdDate: '14/1/2022', policeNumber: '345902384', status: 'Accepted'}
      ]
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
        _this.loader = true
      }) .catch((err) => {
        console.log(err)
        _this.loader = true
      })
    },
    changePage (url) {
      this.$router.push(url)
    }
  }
}
</script>
