<template>
    <q-page>
        <div class="q-page-height">

        </div>
        <div class="flex flex-dir-col flex-center q-page-height">
            <img class="responsive_img" width="400" src="~assets/images/preset/no_schedule_bg.png" alt="">
            <span class="fs-25 txt-white fw-semibold mt-10">No Favorite</span>
        </div>
    </q-page>
</template>

<script>
/* eslint-disable */
import { getFavoritesByUserID, removeFavoriteFromUser } from '../../api/FavoriteService'
import { getWorkshopById } from '../../api/workshopService'
import { LocalStorage } from 'quasar'
import help from '../../js/help'
import ValidationFunction from '../../js/ValidationFunction'
import Swal from 'sweetalert2'

export default {
    data(){
        return{
            help,
            ValidationFunction,
            pageLoader: false,
            user: {}
        }
    },
    created () {
        this.user = LocalStorage.getItem('autoRepairUser').data.user
    },
    methods: {

    }
}
</script>