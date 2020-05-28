<template>
    <div class="col-xl-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-content signatureparent">
                <div id="signature"></div>
                <div class="card-body">
                    <div class="card-btns d-flex justify-content-between mt-2">
                        <a href="#" @click='reset' class="btn btn-outline-danger mr-1 mb-1 waves-effect waves-light">清除</a>
                        <a href="#" @click='save' class="btn btn-outline-primary mr-1 mb-1 waves-effect waves-light">儲存</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import {mapState, mapMutations, mapActions, mapGetters} from 'vuex';
    import jsignature from 'jsignature';
        export default {
            name: "signature",
            props: {

            },
            data() {
                return {
                    sigdiv : '',
                    domName: '',
                }
            },
            computed: {
                    ...mapState([]),
            },
            beforeMount: function () {
            },
            mounted: function () {
                bus.$on('setNewSignture',this.setNewSignture);
                this.sigdiv = $("#signature");
                this.sigdiv.jSignature({
                    'background-color': 'transparent',
                    'decor-color': 'transparent',
                });
            },
            methods: {
                setNewSignture(dom_id){
                    this.domName = dom_id;
                    this.reset();
                },
                reset(){
                    this.sigdiv.jSignature("reset");
                },
                save(){
                    let datapair = this.sigdiv.jSignature("getData", "image");
                    let i = new Image();
                    i.src = "data:" + datapair[0] + "," + datapair[1];
                    i.className = "card-img-top img-fluid";
                    $("#"+this.domName).find('img').remove();
                    $(i).prependTo($("#"+this.domName)); // append the image (SVG) to DOM.
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
