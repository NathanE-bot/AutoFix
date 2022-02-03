<template>
    <q-page class="flex flex-center">
        <div class="row w-80 m-auto ">
            <div class="q-pa-md fw">
              <q-table
                title="Insurance Claim History"
                :rows="dataClaimHistory"
                :columns="columns"
                row-key="insuranceID"
                :loading="loading"
                :filter="filter"
                @request="onRequest"
                binary-state-sort hide-pagination
                class="incoming-claim-insurance-table-layout br-10px-i"
                :rows-per-page-options="[0]"
                >
                <template v-slot:top-right>
                  <q-input borderless dense debounce="300" v-model="filter" placeholder="Search">
                    <template v-slot:append>
                      <q-icon name="search" />
                    </template>
                  </q-input>
                </template>
                <template v-slot:body="props">
                  <q-tr :props="props" :class="['', {'set-bg-red-rejected' : props.row.insuranceStatus === 'Rejected'}]">
                    <q-td class="text-white"  key="insuredName" :props="props">
                      {{ props.row.insuredName }}
                    </q-td>
                    <q-td key="insuredStatus" :props="props" class="tf-capitalize">
                      {{ props.row.insuranceStatus }}
                    </q-td>
                    <q-td key="polisNumber" :props="props">
                      {{ props.row.polisNumber }}
                    </q-td>
                    <q-td key="emailClaimer" :props="props">
                      {{ props.row.emailClaimer }}
                    </q-td>
                    <q-td key="phoneNumberClaimer" :props="props">
                      {{ props.row.phoneNumberClaimer }}
                    </q-td>
                    <q-td key="licensePlateNumber" :props="props">
                      {{ props.row.licensePlateNumber }}
                    </q-td>
                    <q-td key="submitDate" :props="props">
                      {{ help.defaultFormat(props.row.submitDate, help.data().dmy_8) }}
                    </q-td>
                    <q-td key="claimedInsuranceDate" :props="props">
                      {{ help.defaultFormat(props.row.claimedInsuranceDate, help.data().dmy_8) }}
                    </q-td>
                    <q-td key="detail" :props="props" class="">
                      <q-btn
                        icon="far fa-file"
                        flat round color="primary"
                        class="fs-12"
                        @click="changePage('/admin/insurance/insurance-claim-history/detail/' + props.row.insuranceID)"
                      />
                    </q-td>
                  </q-tr>
                </template>
              </q-table>
            </div>
        </div>
    </q-page>
</template>

<script>
/* eslint-disable */
import { getInsuranceHistory } from '../../../api/AdminInsuranceServices'
import { LocalStorage } from 'quasar'
import help from '../../../js/help'

export default {
  data () {
    return {
      help,
      user: {},
      filter: '',
      loading: false,
      data: [],
      dataClaimHistory: [],
      columns: [
        { name: 'insuredName', label: 'Insured Name', field: 'insuredName', required: true, align: 'center' },
        { name: 'insuredStatus', label: 'Status', field: 'insuranceStatus', required: true, align: 'center' },
        { name: 'polisNumber', label: 'Polis Number', field: 'polisNumber' },
        { name: 'emailClaimer', label: 'Email', field: 'emailClaimer', align: 'center' },
        { name: 'phoneNumberClaimer', label: 'Phone Number', field: 'phoneNumberClaimer', align: 'center' },
        { name: 'licensePlateNumber', label: 'License Plate', field: 'licensePlateNumber', align: 'center' },
        { name: 'submitDate', label: 'Submit Date', field: 'submitDate', align: 'center' },
        { name: 'claimedInsuranceDate', label: 'Claimed Insurance Date', field: 'claimedInsuranceDate', align: 'center' },
        { name: 'detail', label: 'View Detail', field: 'detail', align: 'center' }
      ],
      pagination: {
        sortBy: 'desc',
        descending: false,
        page: 1,
        rowsPerPage: 5,
        rowsNumber: 10
      },
    }
  },
  created() {
    this.user = LocalStorage.getItem('autoRepairUser').data.user
    this.doGetInsuranceHistory()
  },
  mounted () {
    // get initial data from server (1st page)
    this.onRequest({
      pagination: this.pagination,
      filter: undefined
    })
  },
  methods: {
    changePage (url) {
      this.$router.push(url)
    },
    doGetInsuranceHistory() {
      getInsuranceHistory(this.user.id).then(response =>{
        console.log('response', response)
        response.data.forEach(el1 => {
          let templateDataIncoming = {
                insuranceID: el1.insuranceID,
                insuranceStatus: el1.insuranceStatus,
                insuredName: el1.insuredName,
                polisNumber: el1.polisNumber,
                emailClaimer: el1.emailClaimer,
                phoneNumberClaimer: el1.phoneNumberClaimer,
                licensePlateNumber: el1.licensePlateNumber,
                submitDate: el1.submitDate,
                claimedInsuranceDate: el1.claimedInsuranceDate
              }
          this.dataClaimHistory.push(templateDataIncoming)
        })
        console.log('dataClaimHistory', this.dataClaimHistory)
      })
    },
    onRequest (props) {
      const { page, rowsPerPage, sortBy, descending } = props.pagination
      const filter = props.filter

      this.loading = true

      // emulate server
      setTimeout(() => {
        // update rowsCount with appropriate value
        this.pagination.rowsNumber = this.getRowsNumberCount(filter)

        // get all rows if "All" (0) is selected
        const fetchCount = rowsPerPage === 0 ? this.pagination.rowsNumber : rowsPerPage

        // calculate starting row of data
        const startRow = (page - 1) * rowsPerPage

        // fetch data from "server"
        const returnedData = this.fetchFromServer(startRow, fetchCount, filter, sortBy, descending)

        // clear out existing data and add new
        this.data.splice(0, this.data.length, ...returnedData)

        // don't forget to update local pagination object
        this.pagination.page = page
        this.pagination.rowsPerPage = rowsPerPage
        this.pagination.sortBy = sortBy
        this.pagination.descending = descending

        // ...and turn of loading indicator
        this.loading = false
      }, 1500)
    },
    // emulate ajax call
    // SELECT * FROM ... WHERE...LIMIT...
    fetchFromServer (startRow, count, filter, sortBy, descending) {
      const data = filter
        ? this.dataClaimHistory.filter(row => row.name.includes(filter))
        : this.dataClaimHistory.slice()

      // handle sortBy
      if (sortBy) {
        const sortFn = sortBy === 'desc'
          ? (descending
            ? (a, b) => (a.name > b.name ? -1 : a.name < b.name ? 1 : 0)
            : (a, b) => (a.name > b.name ? 1 : a.name < b.name ? -1 : 0)
          )
          : (descending
            ? (a, b) => (parseFloat(b[sortBy]) - parseFloat(a[sortBy]))
            : (a, b) => (parseFloat(a[sortBy]) - parseFloat(b[sortBy]))
          )
        data.sort(sortFn)
      }

      return data.slice(startRow, startRow + count)
    },
    // emulate 'SELECT count(*) FROM ...WHERE...'
    getRowsNumberCount (filter) {
      if (!filter) {
        return this.dataClaimHistory.length
      }
      let count = 0
      this.dataClaimHistory.forEach((treat) => {
        if (treat.name.includes(filter)) {
          ++count
        }
      })
      return count
    },
  }
}
</script>
