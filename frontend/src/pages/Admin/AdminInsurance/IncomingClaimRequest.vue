<template>
    <q-page class="flex flex-center">
        <div class="row w-80 m-auto">
            <div class="q-pa-md fw">
              <q-table
                title="Incoming Claim Insurance"
                :rows="data"
                :columns="columns"
                row-key="id"
                v-model:pagination="pagination"
                :loading="loading"
                :filter="filter"
                @request="onRequest"
                binary-state-sort
                class="table-yeet"
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
                    <q-td key="nama" :props="props">
                      {{ props.row.name }}
                    </q-td>
                    <q-td key="created_date" :props="props">
                      {{ props.row.created_date }}
                    </q-td>
                    <q-td key="polis_number" :props="props">
                      {{ props.row.iron }}
                    </q-td>
                    <q-td key="detail" :props="props" class="">
                      <q-btn
                        icon="far fa-file"
                        flat round color="primary"
                        class="fs-12"
                        @click="promptDetail = true"
                      />
                    </q-td>
                  </q-tr>
                </template>
              </q-table>
            </div>
        </div>
        <q-dialog v-model="promptDetail">
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
        </q-dialog>
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
        {
          name: 'nama',
          required: true,
          label: 'Claimer Name',
          align: 'left',
          field: row => row.name,
          format: val => `${val}`,
          sortable: true
        },

        { name: 'created_date', label: 'Created Date', field: 'created_date', sortable: true, sort: (a, b) => parseInt(a, 10) - parseInt(b, 10) },
        { name: 'polis_number', label: 'Polis Number', field: 'iron', sortable: true, sort: (a, b) => parseInt(a, 10) - parseInt(b, 10) },
        { name: 'detail', label: 'View Detail', field: 'detail' }
      ],
      data: [],
      original: [
        { id: 1, name: 'Frozen Yogurt', created_date: '14%', iron: '1%' },
        { id: 2, name: 'Ice cream sandwich', created_date: '8%', iron: '1%' },
        { id: 3, name: 'Eclair', created_date: '6%', iron: '7%' },
        { id: 4, name: 'Cupcake', created_date: '3%', iron: '8%' },
        { id: 5, name: 'Gingerbread', created_date: '7%', iron: '16%' },
        { id: 6, name: 'Jelly bean', created_date: '0%', iron: '0%' },
        { id: 7, name: 'Lollipop', created_date: '0%', iron: '2%' },
        { id: 8, name: 'Honeycomb', created_date: '0%', iron: '45%' },
        { id: 9, name: 'Donut', created_date: '2%', iron: '22%' },
        { id: 10, name: 'KitKat', created_date: '12%', iron: '6%' },
        { id: 11, name: 'Frozen Yogurt-1', created_date: '14%', iron: '1%' },
        { id: 12, name: 'Ice cream sandwich-1', created_date: '8%', iron: '1%' },
        { id: 13, name: 'Eclair-1', created_date: '6%', iron: '7%' },
        { id: 14, name: 'Cupcake-1', created_date: '3%', iron: '8%' },
        { id: 15, name: 'Gingerbread-1', created_date: '7%', iron: '16%' },
        { id: 16, name: 'Jelly bean-1', created_date: '0%', iron: '0%' },
        { id: 17, name: 'Lollipop-1', created_date: '0%', iron: '2%' },
        { id: 18, name: 'Honeycomb-1', created_date: '0%', iron: '45%' },
        { id: 19, name: 'Donut-1', created_date: '2%', iron: '22%' },
        { id: 20, name: 'KitKat-1',  created_date: '12%', iron: '6%' },
        { id: 21, name: 'Frozen Yogurt-2', created_date: '14%', iron: '1%' },
        { id: 22, name: 'Ice cream sandwich-2', created_date: '8%', iron: '1%' },
        { id: 23, name: 'Eclair-2', created_date: '6%', iron: '7%' },
        { id: 24, name: 'Cupcake-2', created_date: '3%', iron: '8%' },
        { id: 25, name: 'Gingerbread-2', created_date: '7%', iron: '16%' },
        { id: 26, name: 'Jelly bean-2', created_date: '0%', iron: '0%' },
        { id: 27, name: 'Lollipop-2', created_date: '0%', iron: '2%' },
        { id: 28, name: 'Honeycomb-2', created_date: '0%', iron: '45%' },
        { id: 29, name: 'Donut-2', created_date: '2%', iron: '22%' },
        { id: 30, name: 'KitKat-2', created_date: '12%', iron: '6%' },
        { id: 31, name: 'Frozen Yogurt-3', created_date: '14%', iron: '1%' },
        { id: 32, name: 'Ice cream sandwich-3', created_date: '8%', iron: '1%' },
        { id: 33, name: 'Eclair-3', created_date: '6%', iron: '7%' },
        { id: 34, name: 'Cupcake-3', created_date: '3%', iron: '8%' },
        { id: 35, name: 'Gingerbread-3', created_date: '7%', iron: '16%' },
        { id: 36, name: 'Jelly bean-3', created_date: '0%', iron: '0%' },
        { id: 37, name: 'Lollipop-3', created_date: '0%', iron: '2%' },
        { id: 38, name: 'Honeycomb-3', created_date: '0%', iron: '45%' },
        { id: 39, name: 'Donut-3', created_date: '2%', iron: '22%' },
        { id: 40, name: 'KitKat-3', created_date: '12%', iron: '6%' }
      ],
      promptDetail: false,
      promptDetailAccept: false,
      promptDetailReject: false
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
        ? this.original.filter(row => row.name.includes(filter))
        : this.original.slice()

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
        return this.original.length
      }
      let count = 0
      this.original.forEach((treat) => {
        if (treat.name.includes(filter)) {
          ++count
        }
      })
      return count
    }
  }
}
</script>
