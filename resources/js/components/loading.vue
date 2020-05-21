<template>
    <div class='col-md-12' v-if='loading'>
        <div class='row col-md-12 align-items-center justify-content-md-center' style="height: 100%;">
            <div class="spinner-border text-primary" style="width: 5rem; height: 5rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapState} from 'vuex';

        export default {
            name: "loading",
            props: {

            },
            data() {
                return {
                    loading:true,
                }
            },
            computed: {
                    ...mapState([]),
            },
            beforeMount: function () {
            },
            mounted: function () {
                bus.$on('loadingStart', this.loadingStart);
                bus.$on('loadingEnd', this.loadingEnd);
            },
            methods: {
                loadingStart(){
                    this.loading = true;
                },
                loadingEnd(){
                    this.loading = false;
                }
            },
            updated() {
                // console.log('view updated')
            },
            watch: {
            }
        }
</script>

<style scoped>

</style>
