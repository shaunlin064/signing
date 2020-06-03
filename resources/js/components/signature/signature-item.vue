<template>
    <div class="col-xl-4 col-md-6 col-sm-12">
        <div class="card">
            <div class="fonticon-wrap" v-if='favorite'>
                <i class="feather icon-star"></i>
            </div>
<!--            <div class="card-header">-->
<!--                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>-->
<!--                <div class="heading-elements">-->
<!--                    <ul class="list-inline mb-0">-->
<!--                        <li><a data-action="reload"><i class="feather icon-rotate-cw"></i></a></li>-->
<!--                    </ul>-->
<!--                </div>-->
<!--            </div>-->
            <div class="card-content" :id='"signature"+id'>
                <img class='card-img-top img-fluid mb1' :src="image_base64">
                <div class="card-body">
                    <h5>signature{{id}}</h5>
                    <div class="card-btns d-flex justify-content-between mt-2">
                        <a class="btn btn-outline-danger mr-1 mb-1 waves-effect waves-light" @click='deleteSignature'>刪除</a>
                        <a class="btn btn btn-outline-primary mr-1 mb-1 waves-effect waves-light" @click='setFavorite'>預設</a>
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
                id: Number,
                image_base64 : String,
                favorite:Number,
            },
            data() {
                return {
                    title : '',
                }
            },
            computed: {
                    ...mapState([]),
            },
            beforeMount: function () {

            },
            mounted: function () {
            },
            methods: {
                deleteSignature(){
                    bus.$emit('deleteSignature',this.id);
                },
                setFavorite(){
                    bus.$emit('setFavorite',this.id);
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
    .card-img-top.img-fluid{
        border: 2px dotted white;
    }
    .feather.icon-star{
        font-size: 30px;
        color: white;
        position: absolute;
    }
</style>
