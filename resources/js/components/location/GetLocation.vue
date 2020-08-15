<template>
    <div>
        <div class="row no-gutters">
            <div>haha...</div>
            <div class="map">
                <gmap-map
                    :center="{lat:10,lng:10}"
                    :zoom="7"
                    style="width: 100%; height: 440px;">
                </gmap-map>
            </div>
        </div>
    </div>
</template>

<script>
    import * as VueGoogleMaps from 'vue2-google-maps';
    Vue.use(VueGoogleMaps, {
        load: {
            key: 'AIzaSyCAQ_RubvuB4Lu4Sk0vj5GX2eEN5gcjMHw'
        }
    });

    export default {
        data(){
            return{

            }
        },

        methods: {

        },

        created() {


        },

        mounted() {

        }
    }
</script>
