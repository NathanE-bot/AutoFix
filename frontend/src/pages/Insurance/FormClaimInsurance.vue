<template>
    <q-page class="insurance_layout_2 flex flex-center">
        <q-card class="my-card insurance_form_layout w-95">
            <q-card-section class="d-flex a-center j-center position-relative p-35 pb-16">
                <h5 class="fw-bold m-0">Form Claim Insurance</h5>
                <img class="responsive_img logo-img-form" src="~assets/images/logo/allianz.png" alt="">
            </q-card-section>
            <q-card-section class="row d-flex j-sp-between p-35 pt-0">
                <div class="col-md-5 q-gutter-y-md row">
                    <q-input
                        v-model="form.name"
                        :rules="rules.name_r"
                        lazy-rules="ondemand"
                        class="col-md-12" filled
                        label="Nama Tertanggung" />
                    <q-input
                        v-model="form.phoneNumber"
                        :rules="rules.phoneNumber_r"
                        lazy-rules="ondemand"
                        class="col-md-12" filled
                        label="Nomor Telepon" />
                    <q-input
                        v-model="form.email"
                        :rules="rules.email_r"
                        lazy-rules="ondemand"
                        class="col-md-12" filled
                        label="Email" />
                    <q-input
                        v-model="form.brandType"
                        :rules="rules.brandType_r"
                        lazy-rules="ondemand"
                        class="col-md-12" filled
                        label="Merk dan tipe kendaraan" />
                    <q-input
                        v-model="form.number"
                        :rules="rules.number_r"
                        lazy-rules="ondemand"
                        class="col-md-12" filled
                        label="No. Rangka" />
                </div>
                <div class="col-md-5 row d-flex flex-dir-col j-sp-between">
                    <div class="q-gutter-y-md">
                        <q-input
                            v-model="form.address"
                            :rules="rules.address_r"
                            lazy-rules="ondemand"
                            type="textarea"
                            class="col-md-12 fix-txt-field mb-20" filled
                            label="Alamat"
                        />
                        <div class="row col-md-12 d-flex a-center j-sp-between">
                            <q-input
                            v-model="form.polisNumber"
                                :rules="rules.polisNumber_r"
                                lazy-rules="ondemand"
                                class="col-md-5" filled
                                label="No. Polisx" />
                            <q-input
                                v-model="form.polisiNumber"
                                :rules="rules.polisiNumber_r"
                                lazy-rules="ondemand"
                                class="col-md-5" filled
                                label="No. Polisi" />
                        </div>
                    </div>
                    <div class="col-md-12 q-gutter-y-md d-flex j-end">
                        <q-btn
                            padding="6px 32px"
                            rounded unelevated
                            type="submit"
                            label="Next"
                            color="primary"/>
                    </div>
                </div>
            </q-card-section>
        </q-card>
    </q-page>
</template>

<script>
/* eslint-disable */
export default {
    data () {
        return{
            form: {
                name: '',
                phoneNumber: '',
                email: '',
                brandType: '',
                number: null,
                polisNumber: null,
                polisiNumber: null
            },
            rules: {
                name_r: [
                    v => !!v || 'Nama harus diisi'
                ],
                phoneNumber_r: [
                    v => !!v || 'Nomor telepon harus diisi'
                ],
                email_r: [
                    v => !!v || 'Email harus diisi',
                    v => /^\w+([.+-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'Format Email Salah'
                ],
                brandType_r: [
                    v => !!v || 'Brand dan tipe harus diisi'
                ],
                number_r: [
                    v => !!v || 'Nomor rangka harus diisi'
                ],
                polisNumber_r: [
                    v => !!v || 'Nomor polis harus diisi'
                ],
                polisiNumber_r: [
                    v => !!v || 'Nomor polisi mobil harus diisi'
                ]
            }
        }
    }
}
</script>