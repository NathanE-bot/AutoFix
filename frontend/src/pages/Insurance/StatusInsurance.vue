<template>
    <q-page class="insurance_layout_3 flex flex-center">
      <q-card class="cardSize w-80">
        <span>Status Asuransi</span>
          <div style="overflow-y:auto; height: 320px;">
            <table class="listTable fw"  cellspacing="0" cellpadding="10">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Asuransi</th>
                  <th>Tanggal Pembuatan</th>
                  <th>Nomor Polis</th>
                  <th>Status</th>
                  <th>View</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="data in dummyDatas" :key="data.No">
                  <td>{{ data.No }}</td>
                  <td>{{ data.nama_asuransi }}</td>
                  <td>{{ data.tanggal_pembuatan }}</td>
                  <td>{{ data.nomor_polis }}</td>
                  <td>{{ data.status }}</td>
                  <td v-if="data.status === 'Accepted'"><i class="far fa-file accepted-color cursor-pointer"></i></td>
                  <td v-else-if="data.status === 'Rejected'"><i class="far fa-file rejected-color cursor-pointer"></i></td>
                  <td v-else><i class="far fa-file"></i></td>
                </tr>
              </tbody>
            </table>
          </div>
        <!-- <q-table
          title="Status Asuransi"
          :rows="rows"
          :columns="columns"
          row-key="name"
          hide-bottom
          :rows-per-page-options="[0]"
        /> -->
      </q-card>
    </q-page>
</template>

<script>
export default {
  data () {
    return {
      dummyDatas: [
        { No: '1', nama_asuransi: 'asuransi1', tanggal_pembuatan: '12-12-2021', nomor_polis: '0123456789', status: 'Waiting', view: 'a' },
        { No: '2', nama_asuransi: 'asuransi1', tanggal_pembuatan: '12-12-2021', nomor_polis: '0123456789', status: 'Rejected', view: 'a' },
        { No: '3', nama_asuransi: 'asuransi1', tanggal_pembuatan: '12-12-2021', nomor_polis: '0123456789', status: 'Accepted', view: 'a' },
        { No: '4', nama_asuransi: 'asuransi1', tanggal_pembuatan: '12-12-2021', nomor_polis: '0123456789', status: 'Accepted', view: 'a' },
        { No: '5', nama_asuransi: 'asuransi1', tanggal_pembuatan: '12-12-2021', nomor_polis: '0123456789', status: 'Accepted', view: 'a' },
        { No: '6', nama_asuransi: 'asuransi1', tanggal_pembuatan: '12-12-2021', nomor_polis: '0123456789', status: 'Rejected', view: 'a' },
        { No: '7', nama_asuransi: 'asuransi1', tanggal_pembuatan: '12-12-2021', nomor_polis: '0123456789', status: 'Rejected', view: 'a' },
        { No: '1', nama_asuransi: 'asuransi1', tanggal_pembuatan: '12-12-2021', nomor_polis: '0123456789', status: 'Rejected', view: 'a' },
        { No: '2', nama_asuransi: 'asuransi1', tanggal_pembuatan: '12-12-2021', nomor_polis: '0123456789', status: 'Accepted', view: 'a' },
        { No: '3', nama_asuransi: 'asuransi1', tanggal_pembuatan: '12-12-2021', nomor_polis: '0123456789', status: 'Accepted', view: 'a' },
        { No: '4', nama_asuransi: 'asuransi1', tanggal_pembuatan: '12-12-2021', nomor_polis: '0123456789', status: 'Rejected', view: 'a' },
        { No: '5', nama_asuransi: 'asuransi1', tanggal_pembuatan: '12-12-2021', nomor_polis: '0123456789', status: 'Accepted', view: 'a' },
        { No: '6', nama_asuransi: 'asuransi1', tanggal_pembuatan: '12-12-2021', nomor_polis: '0123456789', status: 'Accepted', view: 'a' },
        { No: '7', nama_asuransi: 'asuransi1', tanggal_pembuatan: '12-12-2021', nomor_polis: '0123456789', status: 'Rejected', view: 'a' },
        { No: '1', nama_asuransi: 'asuransi1', tanggal_pembuatan: '12-12-2021', nomor_polis: '0123456789', status: 'Accepted', view: 'a' },
        { No: '2', nama_asuransi: 'asuransi1', tanggal_pembuatan: '12-12-2021', nomor_polis: '0123456789', status: 'Accepted', view: 'a' },
        { No: '3', nama_asuransi: 'asuransi1', tanggal_pembuatan: '12-12-2021', nomor_polis: '0123456789', status: 'Rejected', view: 'a' },
        { No: '4', nama_asuransi: 'asuransi1', tanggal_pembuatan: '12-12-2021', nomor_polis: '0123456789', status: 'Rejected', view: 'a' },
        { No: '5', nama_asuransi: 'asuransi1', tanggal_pembuatan: '12-12-2021', nomor_polis: '0123456789', status: 'Accepted', view: 'a' },
        { No: '6', nama_asuransi: 'asuransi1', tanggal_pembuatan: '12-12-2021', nomor_polis: '0123456789', status: 'Accepted', view: 'a' },
        { No: '7', nama_asuransi: 'asuransi1', tanggal_pembuatan: '12-12-2021', nomor_polis: '0123456789', status: 'Rejected', view: 'a' },
        { No: '1', nama_asuransi: 'asuransi1', tanggal_pembuatan: '12-12-2021', nomor_polis: '0123456789', status: 'Accepted', view: 'a' },
        { No: '2', nama_asuransi: 'asuransi1', tanggal_pembuatan: '12-12-2021', nomor_polis: '0123456789', status: 'Rejected', view: 'a' },
        { No: '3', nama_asuransi: 'asuransi1', tanggal_pembuatan: '12-12-2021', nomor_polis: '0123456789', status: 'Accepted', view: 'a' },
        { No: '4', nama_asuransi: 'asuransi1', tanggal_pembuatan: '12-12-2021', nomor_polis: '0123456789', status: 'Accepted', view: 'a' },
        { No: '5', nama_asuransi: 'asuransi1', tanggal_pembuatan: '12-12-2021', nomor_polis: '0123456789', status: 'Accepted', view: 'a' },
        { No: '6', nama_asuransi: 'asuransi1', tanggal_pembuatan: '12-12-2021', nomor_polis: '0123456789', status: 'Accepted', view: 'a' },
        { No: '7', nama_asuransi: 'asuransi1', tanggal_pembuatan: '12-12-2021', nomor_polis: '0123456789', status: 'Accepted', view: 'a' }
      ],
      columns: [
        { name: 'no', required: true, label: 'No', align: 'left', field: row => row.no, format: val => `${val}` },
        { name: 'nama_asuransi', align: 'center', label: 'Nama Asuransi', field: 'nama_asuransi' },
        { name: 'tanggal_pembuatan', label: 'Tanggal Pembuatan', field: 'tanggal_pembuatan' },
        { name: 'nomor_polis', label: 'Nomor Polis', field: 'nomor_polis' },
        { name: 'status', label: 'Status', field: 'status' },
        { name: 'view', label: 'View', field: 'view' }
      ],
      rows: [
        { no: '1', nama_asuransi: 'asuransi1', tanggal_pembuatan: '12-12-2021', nomor_polis: '0123456789', status: 'Pending', view: 'a' },
        { no: '2', nama_asuransi: 'asuransi2', tanggal_pembuatan: '13-12-2021', nomor_polis: '0123456789', status: 'Rejected', view: 'b' },
        { no: '3', nama_asuransi: 'asuransi3', tanggal_pembuatan: '14-12-2021', nomor_polis: '0123456789', status: 'Rejected', view: 'c' },
        { no: '4', nama_asuransi: 'asuransi4', tanggal_pembuatan: '15-12-2021', nomor_polis: '0123456789', status: 'Accecpted', view: 'd' },
        { no: '5', nama_asuransi: 'asuransi5', tanggal_pembuatan: '16-12-2021', nomor_polis: '0123456789', status: 'Pending', view: 'e' },
        { no: '6', nama_asuransi: 'asuransi6', tanggal_pembuatan: '17-12-2021', nomor_polis: '0123456789', status: 'Accepted', view: 'f' },
        { no: '7', nama_asuransi: 'asuransi7', tanggal_pembuatan: '18-12-2021', nomor_polis: '0123456789', status: 'Accepted', view: 'g' }
      ]
    }
  }
}
</script>
