<template>
    <fieldset :id='dom_id'>
        <div class="row col-md-12 align-items-center">
            <div class="card">
                <h4 class="card-title">用印單</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-label-group">
                    <input type="text" id="department" class="form-control"
                           placeholder="部門" name="department">
                    <label for="department">部門</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-label-group">
                    <input type="text" id="member" class="form-control"
                           placeholder="申請人" name="member">
                    <label for="member">申請人</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-label-group mt-2">
                    <input type="text" id="name" class="form-control" placeholder="項目"
                           name="name">
                    <label for="name">項目</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="form">用印形式</label>
                    <select class="custom-select select2 form-control"
                            multiple="multiple" id="form" name="form">
                        <option value="company">公司大章</option>
                        <option value="principal">負責人章</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="deployed">寄送方式</label>
                    <select class="custom-select select2 form-control" id="deployed"
                            name="deployed">
                        <option value="company">總務寄出</option>
                        <option value="self">自行寄出</option>
                    </select>
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-12 border-top-light mb-1'></div>
            <div class="col-md-6">
                <div class="form-label-group">
                    <input type="text" id="customer" class="form-control"
                           placeholder="收件人公司" name="customer">
                    <label for="customer">收件人公司</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-label-group">
                    <input type="text" id="contact_name" class="form-control"
                           placeholder="收件人窗口"
                           name="contact_name">
                    <label for="contact_name">收件人窗口</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-label-group">
                    <input type="text" id="contact_phone" class="form-control"
                           placeholder="收件人電話"
                           name="contact_phone">
                    <label for="contact_phone">收件人電話</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-label-group">
                    <input type="text" id="contact_address" class="form-control"
                           placeholder="收件人地址"
                           name="contact_phone">
                    <label for="contact_address">收件人地址</label>
                </div>
            </div>
            <div class='col-md-6'>
                <div class="form-label-group">
                    <fieldset class="form-label-group">
                            <textarea class="form-control" id="remark" rows="3" placeholder="備註"
                                      name="remark"></textarea>
                        <label for="remark">備註</label>
                    </fieldset>
                </div>
            </div>
            <div class="col-md-12 mt-1">
                <div class="form-group">
                    <label>附件</label>
                    <input class="dropzone dropzone-area" type="hidden"/>
                    <div class="dropzone dropzone-area" id="file_upload">
                        <div class="dz-message">Drop Files Here To Upload</div>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
</template>

<script>
    import {mapState, mapMutations, mapActions, mapGetters} from 'vuex';

        export default {
            name: "form-sign",
            props: {
                dom_id:String
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
            methods: {},
            updated() {
                // console.log('view updated')
            },
            watch: {
             // change_date: {
                //     immediate: true,    // 这句重要
                //     handler(val, oldVal) {
                //         if (oldVal !== undefined) {
                //             this.getCampaignData(this.user_ids, val);
                //         }
                //     }
                // }
            }
        }
</script>

<style scoped>

</style>
