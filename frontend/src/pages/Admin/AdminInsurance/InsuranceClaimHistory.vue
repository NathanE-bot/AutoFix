<template>
    <q-page class="flex flex-center">
        <div class="row w-80 m-auto">
            <div class="col-md-12 text-h5 vertical-align-middle py-20">
                <span class="txt-white">Insurance Claim History</span>
            </div>
            <div class="col-md-12 white-1bg p-30 br-35px">
                <div style="overflow-y:auto; height: 480px;">
                    <table class="listTable fw table-sticky"  cellspacing="0" cellpadding="10">
                        <thead class=" sticky">
                            <tr class="row ">
                                <th class="col-md-1">No</th>
                                <th class="col-md-3">Claimer Name</th>
                                <th class="col-md-2">Accepted Date</th>
                                <th class="col-md-3">Polis Number</th>
                                <th class="col-md-1">View</th>
                                <th class="col-md-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="row align-item-center" v-for="(data,index) in dummyDatas" :key="data.No">
                                <td class="col-md-1">{{ index+1 }}</td>
                                <td class="col-md-3">{{ data.nama_asuransi }}</td>
                                <td class="col-md-2">{{ data.tanggal_pembuatan }}</td>
                                <td class="col-md-3">{{ data.nomor_polis }}</td>
                                <td class="col-md-1 fs-25"><i class="far fa-file accepted-color cursor-pointer"></i></td>
                                <td class="col-md-2">{{ data.status }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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
      ]
    }
  }
}
</script>
