<template>
    <div>
        <GmapMap
            ref="mapRef"
            :center="{ lat: 24.774265, lng: 46.738586 }"
            :zoom="5"
            map-type-id="terrain"
            style="height:0; overflow:hidden; padding-bottom: 35.25%;padding-top:30px ; position:relative;"
        >
            <GmapMarker
                ref="myMarker"
                :key="index"
                v-for="(m, index) in drivers"
                :position="google && new google.maps.LatLng(m.lat, m.lng)"
                :clickable="true"
                :draggable="true"
                @click="
                    center =
                        google && new google.maps.LatLng(24.774265, 46.738586)
                "
            />
        </GmapMap>
    </div>
</template>
<script>
import { gmapApi } from "gmap-vue";
export default {
    //props: ["user"],
    computed: {
        // The below example is the same as writing
        // google() {
        //   return gmapApi();
        // },
        google: gmapApi
    },
    data() {
        return {
            drivers: [],
            markers: [],
            map: null,
            marker: null,
            latlng: {},
            myLatLng: { lat: 24.774265, lng: 42.738586 }
        };
    },

    created() {
        this.fetchDrivers();
        Echo.private("driverLocation").listen(
            "UpdateDriverLocationEvent",
            event => {
                //console.log(event);
                this.drivers = this.drivers.filter(
                    u => u.user_id != event.user_id
                );
                this.drivers.push(event);
            }
        );
    },

    mounted() {
        // At this point, the child GmapMap has been mounted, but
        // its map has not been initialized.
        // Therefore we need to write mapRef.$mapPromise.then(() => ...)

        this.$refs.mapRef.$mapPromise.then(map => {
            map.panTo(this.myLatLng);
        });
    },

    methods: {
        fetchDrivers() {
            axios.get("drivers/online-drivers").then(response => {
                this.drivers = response.data;
                //console.log(this.drivers);
            });
        }
    }
};
</script>
