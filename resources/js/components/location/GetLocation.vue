<template>
    <div>
        <div class="row no-gutters">
            <div>haha...</div>
            <div class="map">
                <gmap-map
                    :center="mapCenter"
                    :zoom="10"
                    style="width: 100%; height: 440px;"><!-- @click="handleMapClick" -->
                    <gmap-info-window
                        :options="infoWindowOptions"
                        :position="infoWindowPosition"
                        :opened="infoWindowOpened"
                        @closeclick="handleInfoWindowClose">
                        <div class="info-window">
                            <h2 v-text="activeLocation.name"></h2>
                            <h5 v-text="'Weekday: ' + activeLocation.weekday_hours"></h5>
                            <h5 v-text="'Weekend,Public Holiday: ' + activeLocation.weekend_hours"></h5>
                            <h5 v-text="activeLocation.address"></h5>
                            <h5 v-text="activeLocation.surburb + ', ' + activeLocation.city"></h5>
                        </div>
                    </gmap-info-window>
                    <gmap-marker v-for="(location) in locations"
                        :key="location.id"
                        :position="getPosition(location)"
                        :clickable="true"
                        :draggable="false"
                        @click="handleMarkerClicked(location)">
                    </gmap-marker>
                </gmap-map>
            </div>
        </div>
    </div>
</template>

<script>
    // import * as VueGoogleMaps from 'vue2-google-maps';
    // Vue.use(VueGoogleMaps, {
    //     load: {
    //         key: process.env.MIX_GOOGLE_MAP_KEY
    //     }
    // });

    export default {
        data(){
            return{
                locations: {},
                infoWindowOptions: {
                    pixelOffset: {
                        width: 0,
                        height: -35
                    }
                },
                activeLocation: {},
                infoWindowOpened: false
            }
        },

        methods: {
            getPosition(location) {
                return {
                    lat: parseFloat(location.latitude),
                    lng: parseFloat(location.longitude)
                }
            },
            handleMarkerClicked(location) {
                this.activeLocation = location;
                this.infoWindowOpened = true;
            },
            handleInfoWindowClose() {
                this.activeLocation = {};
                this.infoWindowOpened = false;
            },
        },

        created() {
            axios.get('/location/getLocations',{
                params: {

                }
            })
            .then(response => {
                //console.log(response);
                this.locations = response.data.locations;
            })
            .catch(error => {
                //console.log(error);
            });

        },

        mounted() {

        },
        computed: {
            mapCenter() {
                if (!this.locations.length) {
                    return {
                        lat: 10,
                        lng: 10
                    }
                }
                return {
                    lat: parseFloat(this.locations[0].latitude),
                    lng: parseFloat(this.locations[0].longitude)
                }
            },
            infoWindowPosition() {
                return {
                    lat: parseFloat(this.activeLocation.latitude),
                    lng: parseFloat(this.activeLocation.longitude)
                };
            },
        },
    }
</script>
