<template>
    <div class="d-flex text-center bg-white">
        <div class="m-auto">
            <h4>Your Pos</h4>
            <span>Latitude: {{ currPost.lat.toFixed(2) }}, Longitude: {{ currPost.lng.toFixed(2) }}</span>
        </div>
        <div class="m-auto">
            <h4>distance</h4>
            <span>{{ distance.toFixed(2) }} miles </span>
        </div>
        <div class="m-auto" >
            <h4>Clicked Pos</h4>
            <span v-if="otherPos">Latitude: {{ otherPos.lat.toFixed(2) }}, Longitude: {{ otherPos.lng.toFixed(2) }}</span>
            <span v-else>Tes</span>
        </div>
        <div ref="mapDiv" style="width: 100%; height: 80vh"></div>
    </div>
</template>

<script>
/* eslint-disable-no-undef */
/* eslint-disable */
import { onUnmounted, onMounted, ref } from 'vue'
import { computed, watch } from 'vue'
import { useGeolocation } from '../gMapsScript/useGeolocation'
import { Loader } from '@googlemaps/js-api-loader'

const GOOGLE_MAPS_API_KEY = 'AIzaSyC5atMPJ2MGC-CxvCtMv7pSwCsOMPFX_kg'

export default {
    setup () {
        const { coords } = useGeolocation()
        const currPost = computed(() => ({
            lat: coords.value.latitude,
            lng: coords.value.longitude
        }))
        // distance
        const otherPos = ref(null)

        const loader = new Loader ({ apiKey: GOOGLE_MAPS_API_KEY })
        const mapDiv = ref(null)
        let map = ref(null)
        let clickListener = null
        onMounted(async () =>{
            await loader.load()
            map.value = new google.maps.Map(mapDiv.value, {
                center: currPost.value,
                zoom: 15
            })
            // click event
            clickListener = map.value.addListener('click', (
                { latLng: { lat, lng } }) => ( otherPos.value = { lat: lat(), lng: lng() } ))
        })
        onUnmounted(async () =>{
            if (clickListener) clickListener.remove()
        })

        // for calculating distance
        let line = null
        watch([map, currPost, otherPos], () => {
            if (line) line.setMap(null)
            if (map.value && otherPos.value != null){
                line = new google.maps.Polyline({
                    path: [currPost.value, otherPos.value],
                    map: map.value
                })
            }
        })

        // compute distance from 2 point
        const haversineDistance = ( pos1, pos2 ) => {
            const R = 3958.8 // Radius of earth in miles
            const rlat1 = pos1.lat * (Math.PI / 180) // convert degree to radians
            const rlat2 = pos2.lat * (Math.PI / 180)
            const difflat = rlat2 - rlat1 // radian difference (latitudes)
            const difflon = (pos2.lng - pos1.lng) * (Math.PI / 180)

            const d = 
                2 *
                R *
                Math.asin(
                    Math.sqrt(
                        Math.sin(difflat / 2) * (Math.sin(difflat / 2)) +
                        Math.cos(rlat1) *
                        Math.cos(rlat2) *
                        Math.sin(difflon / 2) *
                        Math.sin(difflon / 2)
                    )
                )
            return d
        }

        const distance = computed(() => 
            otherPos.value === null ? 0 : haversineDistance(currPost.value, otherPos.value)
        )

        return { currPost, otherPos, distance,  mapDiv }
    }   
}
</script>