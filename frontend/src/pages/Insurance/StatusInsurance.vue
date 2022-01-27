<template>
  <q-page class="flex flex-center insurance_layout_3">
    <div class="flex a-end flex-dir-col w-90 m-auto">
      <q-markup-table class="fw">
        <thead>
          <tr>
            <th colspan="6" class="no-border">
              <div class="row no-wrap items-center">
                <div class="text-h6">Insurance List</div>
              </div>
            </th>
          </tr>
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
      <q-pagination
      class="p-10"
        v-model="iPage"
        :max="5"
      />
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
  mounted () {
    if(!Auth.isUserLogin()){
      this.forLoad = false
      document.getElementsByClassName("q-layout")[0].style.display = "none"
      Swal.fire({
        title: 'Error',
        text: 'Please login first.',
        confirmButtonText: 'Login',
        confirmButtonColor: '#21a17b',
        showCancelButton: true,
        cancelButtonText: 'Back',
      }) .then((result) => {
        if(result.isConfirmed){
          this.changePage('/session/login')
          document.getElementsByClassName("q-layout")[0].style.display = "unset"
        } else {
          this.changePage('/')
          setTimeout(() => {
            document.getElementsByClassName("q-layout")[0].style.display = "unset"
          }, 500)
        }
      })
    }
  },
  methods: {
    doGetInsuranceList () {
      let _this = this
      _this.loader = true
      getInsuranceStatusApi(_this.user.id, _this.userToken).then(response => {
        console.log(response.data)
        _this.loader = true
      }) .catch((err) => {
        console.log(err)
        _this.loader = true
      })
    }
  }
}
</script>
