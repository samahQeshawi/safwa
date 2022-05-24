<template>
    <div>
        <GmapMap
            ref="mapRef"
            :center="{ lat: path[0].lat, lng: path[0].lng }"
            :zoom="6"
            map-type-id="terrain"
            style="height:0; overflow:hidden; padding-bottom: 85.25%;padding-top:30px ; position:relative;"
        >
            <GmapMarker
                ref="myMarker"
                :position="google && new google.maps.LatLng(path[0].lat, path[0].lng)"
                :clickable="true"
                :draggable="true"
                @click="
                    center =
                        google && new google.maps.LatLng(path[0].lat, path[0].lng)
                "
            />
            <GmapMarker
                ref="myMarker"
                :position="google && new google.maps.LatLng(path[path.length-1].lat, path[path.length-1].lng)"
                :clickable="true"
                :draggable="true"
                @click="
                    center =
                        google && new google.maps.LatLng(path[0].lat, path[0].lng)
                "
            />
            <GmapPolyline
                :path="path"
                :options="{
                    strokeColor: '#FF0000',
                    strokeWeight: 2,
                    strokeOpacity: 0.5
                }"
            >
            </GmapPolyline>
        </GmapMap>
    </div>
</template>
<script>
import { gmapApi } from "gmap-vue";
export default {
    props:['trip'],

    computed: {
        // The below example is the same as writing
        // google() {
        //   return gmapApi();
        // },
        google: gmapApi
    },
    data() {
        return {
            markers: [],
            map: null,
            marker: null,
            latlng: {},
            myLatLng: { lat: 24.774265, lng: 46.738586 },
            path: []
        };
    },

    created() {
        this.fetchRoutes();
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
        fetchRoutes() {
            axios.get("/admin/drivers/trip-routes/" + this.trip).then(response => {
                this.path = _.map(response.data, function(x) {
                    return _.assign(x, {
                        lat: parseFloat(x.lat),
                        lng: parseFloat(x.lng)
                    });
                });
                //console.log(this.path);
            });
        }
    }
};
</script>
