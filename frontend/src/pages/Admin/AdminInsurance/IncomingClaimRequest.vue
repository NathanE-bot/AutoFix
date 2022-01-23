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
                    <q-td key="desc" :props="props">
                      {{ props.row.name }}
                    </q-td>
                    <q-td key="calcium" :props="props">
                      {{ props.row.calcium }}
                    </q-td>
                    <q-td key="iron" :props="props">
                      {{ props.row.iron }}
                    </q-td>
                    <q-td key="detail" :props="props" class="">
                      <q-btn
                        icon="far fa-file"
                        flat round color="primary"
                        class="fs-12"
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

  // dummyDatas: [
  //   { No: '1', nama_asuransi: 'asuransi1', tanggal_pembuatan: '12-12-2021', nomor_polis: '0123456789', status: 'Waiting', view: 'a' },
  //   { No: '2', nama_asuransi: 'asuransi1', tanggal_pembuatan: '12-12-2021', nomor_polis: '0123456789', status: 'Rejected', view: 'a' },
  //   { No: '3', nama_asuransi: 'asuransi1', tanggal_pembuatan: '12-12-2021', nomor_polis: '0123456789', status: 'Accepted', view: 'a' },
  //   { No: '4', nama_asuransi: 'asuransi1', tanggal_pembuatan: '12-12-2021', nomor_polis: '0123456789', status: 'Accepted', view: 'a' },
  //   { No: '5', nama_asuransi: 'asuransi1', tanggal_pembuatan: '12-12-2021', nomor_polis: '0123456789', status: 'Accepted', view: 'a' },
  //   { No: '6', nama_asuransi: 'asuransi1', tanggal_pembuatan: '12-12-2021', nomor_polis: '0123456789', status: 'Rejected', view: 'a' },
  //   { No: '7', nama_asuransi: 'asuransi1', tanggal_pembuatan: '12-12-2021', nomor_polis: '0123456789', status: 'Rejected', view: 'a' },
  // ]

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
          name: 'desc',
          required: true,
          label: 'Dessert (100g serving)',
          align: 'left',
          field: row => row.name,
          format: val => `${val}`,
          sortable: true
        },

        { name: 'calcium', label: 'Calcium (%)', field: 'calcium', sortable: true, sort: (a, b) => parseInt(a, 10) - parseInt(b, 10) },
        { name: 'iron', label: 'Iron (%)', field: 'iron', sortable: true, sort: (a, b) => parseInt(a, 10) - parseInt(b, 10) },
        { name: 'detail', label: 'View Detail', field: 'detail' }
      ],
      data: [],
      original: [
        { id: 1, name: 'Frozen Yogurt', calcium: '14%', iron: '1%' },
        { id: 2, name: 'Ice cream sandwich', calcium: '8%', iron: '1%' },
        { id: 3, name: 'Eclair', calcium: '6%', iron: '7%' },
        { id: 4, name: 'Cupcake', calcium: '3%', iron: '8%' },
        { id: 5, name: 'Gingerbread', calcium: '7%', iron: '16%' },
        { id: 6, name: 'Jelly bean', calcium: '0%', iron: '0%' },
        { id: 7, name: 'Lollipop', calcium: '0%', iron: '2%' },
        { id: 8, name: 'Honeycomb', calcium: '0%', iron: '45%' },
        { id: 9, name: 'Donut', calcium: '2%', iron: '22%' },
        { id: 10, name: 'KitKat', calcium: '12%', iron: '6%' },
        { id: 11, name: 'Frozen Yogurt-1', calcium: '14%', iron: '1%' },
        { id: 12, name: 'Ice cream sandwich-1', calcium: '8%', iron: '1%' },
        { id: 13, name: 'Eclair-1', calcium: '6%', iron: '7%' },
        { id: 14, name: 'Cupcake-1', calcium: '3%', iron: '8%' },
        { id: 15, name: 'Gingerbread-1', calcium: '7%', iron: '16%' },
        { id: 16, name: 'Jelly bean-1', calcium: '0%', iron: '0%' },
        { id: 17, name: 'Lollipop-1', calcium: '0%', iron: '2%' },
        { id: 18, name: 'Honeycomb-1', calcium: '0%', iron: '45%' },
        { id: 19, name: 'Donut-1', calcium: '2%', iron: '22%' },
        { id: 20, name: 'KitKat-1',  calcium: '12%', iron: '6%' },
        { id: 21, name: 'Frozen Yogurt-2', calcium: '14%', iron: '1%' },
        { id: 22, name: 'Ice cream sandwich-2', calcium: '8%', iron: '1%' },
        { id: 23, name: 'Eclair-2', calcium: '6%', iron: '7%' },
        { id: 24, name: 'Cupcake-2', calcium: '3%', iron: '8%' },
        { id: 25, name: 'Gingerbread-2', calcium: '7%', iron: '16%' },
        { id: 26, name: 'Jelly bean-2', calcium: '0%', iron: '0%' },
        { id: 27, name: 'Lollipop-2', calcium: '0%', iron: '2%' },
        { id: 28, name: 'Honeycomb-2', calcium: '0%', iron: '45%' },
        { id: 29, name: 'Donut-2', calcium: '2%', iron: '22%' },
        { id: 30, name: 'KitKat-2', calcium: '12%', iron: '6%' },
        { id: 31, name: 'Frozen Yogurt-3', calcium: '14%', iron: '1%' },
        { id: 32, name: 'Ice cream sandwich-3', calcium: '8%', iron: '1%' },
        { id: 33, name: 'Eclair-3', calcium: '6%', iron: '7%' },
        { id: 34, name: 'Cupcake-3', calcium: '3%', iron: '8%' },
        { id: 35, name: 'Gingerbread-3', calcium: '7%', iron: '16%' },
        { id: 36, name: 'Jelly bean-3', calcium: '0%', iron: '0%' },
        { id: 37, name: 'Lollipop-3', calcium: '0%', iron: '2%' },
        { id: 38, name: 'Honeycomb-3', calcium: '0%', iron: '45%' },
        { id: 39, name: 'Donut-3', calcium: '2%', iron: '22%' },
        { id: 40, name: 'KitKat-3', calcium: '12%', iron: '6%' }
      ]
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
