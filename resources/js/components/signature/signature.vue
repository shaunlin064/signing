<template>
    <div class="col-xl-12 col-md-12 col-sm-12">
        <div class="modal-backdrop fade show" v-if='show'></div>
        <button type="button" class="btn btn-outline-primary block btn-lg" data-toggle="modal"
                data-target="#animation" @click='open'>
            新增簽名檔
        </button>
        <div class="modal fade text-left" :class='show ? "show" : ""' :style='show ? styleList : {}' id="backdrop">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel4">設定簽名</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" @click='close'>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-content signatureparent">
                                <div id="signature" style='min-height: 83px;min-width:334px;'></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <a href="#" @click='reset'
                           class="btn btn-outline-danger mr-1 mb-1 waves-effect waves-light">清除</a>
                        <a href="#" @click='save'
                           class="btn btn-outline-primary mr-1 mb-1 waves-effect waves-light">儲存</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row match-height mt-2">
            <components v-for="item in signature_items" v-bind:is="'signature-item'" :key='parseInt(item.id)'
                        :id='parseInt(item.id)'
                        :image_base64='item.image_base64' :favorite='item.favorite'
            ></components>
        </div>
    </div>
</template>

<script>
    import {mapState} from 'vuex';
    import jsignature from 'jsignature';
    import signature from "../../mixins/signature";
    export default {
        name: "signature",
        props: {
        },
        data() {
            return {
                sigdiv: '',
            }
        },
        mixins: [signature],
        computed: {
            ...mapState(['login_user']),
        },
        beforeMount: function () {
        },
        mounted: function () {

            $(window).resize(function () {
                this.asyncSetting()
            });

        },
        methods: {
            async asyncSetting() {
                let vue = this;
                if (await vue.settime()) {
                    $("#signature").empty();
                    vue.sigdiv = $("#signature").jSignature({
                        'background-color': 'transparent',
                        'decor-color': 'transparent',
                        'autoFit': true
                    });
                }
            },
            settime() {
                return new Promise((resolve, reject) => {
                    setTimeout(() => {
                        resolve(true)
                    }, 500)
                });
            },
            reset() {
                this.sigdiv.jSignature("reset");
                this.itemDefaultReset();
            },
            save() {
                let datapair = this.sigdiv.jSignature("getData", "image");
                let image_base64 = "data:" + datapair[0] + "," + datapair[1];

                let item = {
                    erp_user_id: this.login_user.id,
                    image_base64,
                    favorite: 1,
                };
                this.addNewSignature(item);

            },
        },
        updated() {
            // console.log('view updated')
        },
        watch: {}
    }
</script>

<style scoped>
    #signature {
        border: 2px dotted white;
    }
</style>
