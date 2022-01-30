<template>
    <q-page class="flex flex-center">
        <div class="row w-80 m-auto ">
            <div class="q-pa-md fw">
              <q-table
                title="Incoming Claim Insurance"
                :rows="dataIncomingClaim"
                :columns="columns"
                row-key="insuranceID"
                :loading="loading"
                :filter="filter"
                @request="onRequest"
                binary-state-sort hide-pagination
                class="incoming-claim-insurance-table-layout"
              >
                <template v-slot:top-right>
                  <q-input borderless dense debounce="300" v-model="filter" placeholder="Search">
                    <template v-slot:append>
                      <q-icon name="search" />
                    </template>
                  </q-input>
                </template>
                <template v-slot:body="props">
                  <q-tr :props="props">
                    <q-td key="insuredName" :props="props">
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
                      {{ props.row.submitDate }}
                    </q-td>
                    <q-td key="claimedInsuranceDate" :props="props">
                      {{ props.row.claimedInsuranceDate }}
                    </q-td>
                    <q-td key="detail" :props="props" class="">
                      <q-btn
                        icon="far fa-file"
                        flat round color="primary"
                        class="fs-12"
                        @click="changePage('/admin/insurance/incoming-claim-request/detail/' + props.row.insuranceID)"
                      />
                    </q-td>
                  </q-tr>
                </template>
              </q-table>
            </div>
        </div>
        <!-- <q-dialog v-model="promptDetail">
            <q-card class="fh fw m-auto" >
                <q-card-section>
                    <div class="black-1 m-auto fw-semibold text-align-center">Isi data yang mau di show</div>
                </q-card-section>

                <q-card-actions align="center" class="text-primary">
                    <q-btn color="negative" label="Reject" v-close-popup  @click="promptDetailReject = true"/>
                    <q-btn color="primary" label="Accept" v-close-popup @click="promptDetailAccept = true"/>
                </q-card-actions>
            </q-card>
        </q-dialog>
        <q-dialog v-model="promptDetailAccept">
            <q-card style="min-width: 480px" class="py-20" >
                <q-card-section>
                    <div class="black-1 m-auto fw-semibold text-align-center">Accept Insurance Claim Request?</div>
                </q-card-section>

                <q-card-actions align="center" class="text-primary">
                    <q-btn label="Cancel" v-close-popup  @click="promptDetail = true"/>
                    <q-btn color="primary" label="Accept" v-close-popup/>
                </q-card-actions>
            </q-card>
        </q-dialog>
        <q-dialog v-model="promptDetailReject">
            <q-card class="fw m-auto" >
                <q-card-section>
                    <div class="black-1 m-auto fw-semibold text-align-center">Insert rejecting reason</div>
                </q-card-section>
                <div class="fw m-auto">
                  <q-input
                    outlined
                    type="textarea"
                    class="fix-txt-field default-textarea-1 w-80 m-auto"
                  >
                  </q-input>
                </div>
                <q-card-actions align="center" class="text-primary">
                    <q-btn label="Cancel" v-close-popup  @click="promptDetail = true"/>
                    <q-btn color="primary" label="Done" v-close-popup @click="doHandleIncomingOrder('accept', '')"/>
                </q-card-actions>
            </q-card>
        </q-dialog> -->
    </q-page>
</template>

<script>
/* eslint-disable */
import { getIncomingClaimRequest } from '../../../api/AdminInsuranceServices'
import { LocalStorage } from 'quasar'

export default {
  data () {
    return {
      user: {},
      filter: '',
      loading: false,
      pagination: {
        sortBy: 'desc',
        descending: false,
        page: 1,
        rowsPerPage: 5,
        rowsNumber: 10
      },
      columns: [
        { name: 'insuredName', label: 'Insured Name', field: 'insuredName', required: true, align: 'center', field: row => row.name, format: val => `${val}`, sortable: true },
        { name: 'insuredStatus', label: 'Status', field: 'insuranceStatus', required: true, align: 'center', field: row => row.name, format: val => `${val}`, sortable: true },
        { name: 'polisNumber', label: 'Polis Number', field: 'polisNumber', sortable: true, sort: (a, b) => parseInt(a, 10) - parseInt(b, 10) },
        { name: 'emailClaimer', label: 'Email', field: 'emailClaimer', align: 'center' },
        { name: 'phoneNumberClaimer', label: 'Phone Number', field: 'phoneNumberClaimer', align: 'center', sortable: true, sort: (a, b) => parseInt(a, 10) - parseInt(b, 10) },
        { name: 'licensePlateNumber', label: 'License Plate', field: 'licensePlateNumber', align: 'center' },
        { name: 'submitDate', label: 'Submit Date', field: 'submitDate', align: 'center', sortable: true, sort: (a, b) => parseInt(a, 10) - parseInt(b, 10) },
        { name: 'claimedInsuranceDate', label: 'Claimed Insurance Date', field: 'claimedInsuranceDate', align: 'center', sortable: true, sort: (a, b) => parseInt(a, 10) - parseInt(b, 10) },
        { name: 'detail', label: 'View Detail', field: 'detail', align: 'center' }
      ],
      data: [],
      dataIncomingClaim: [],
      // promptDetail: false,
      // promptDetailAccept: false,
      // promptDetailReject: false
    }
  },
  created() {
    this.user = LocalStorage.getItem('autoRepairUser').data.user
    console.log('this user', this.user)
    this.doGetIncomingClaimRequest()
  },
  mounted () {
    // get initial data from server (1st page)
    this.onRequest({
      pagination: this.pagination,
      filter: undefined
    })
  },
  methods: {
    doGetIncomingClaimRequest() {
      getIncomingClaimRequest(this.user.id).then(response =>{
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
                claimedInsuranceDate: el1.claimedInsuranceDate || '',
              }
          this.dataIncomingClaim.push(templateDataIncoming)
        })
        console.log('dataIncomingClaim', this.dataIncomingClaim)
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
        ? this.dataIncomingClaim.filter(row => row.name.includes(filter))
        : this.dataIncomingClaim.slice()

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
        return this.dataIncomingClaim.length
      }
      let count = 0
      this.dataIncomingClaim.forEach((treat) => {
        if (treat.name.includes(filter)) {
          ++count
        }
      })
      return count
    },
    changePage (url) {
        this.$router.push(url)
      }
  }
}
</script>
