<template>
    <div class="col-xl-4 col-md-6 col-sm-12">
        <div class="card">
            <div class="card-content" :id='dom_id'>
                <img class='card-img-top img-fluid mb1' src="../../../images/pages/content-img-2.jpg">
                <div class="card-body">
                    <h5>{{title}}</h5>
                    <div class="card-btns d-flex justify-content-between mt-2">
                        <a href="#" class="btn gradient-light-primary text-white">使用</a>
                        <a href="#" class="btn btn-outline-primary" @click='newAdd'>新增</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapState, mapMutations, mapActions, mapGetters} from 'vuex';

        export default {
            name: "signature-item",
            props: {
                dom_id: String,
                title: String,
            },
            data() {
                return {}
            },
            computed: {
                    ...mapState([]),
            },
            beforeMount: function () {
            },
            mounted: function () {

            },
            methods: {
                newAdd(){
                    bus.$emit('setNewSignture',this.dom_id);
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
