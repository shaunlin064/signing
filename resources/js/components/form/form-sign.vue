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
                    <input type="text" id="department" class="form-control" placeholder="部門" :value='department_name'
                           disabled>
                    <label for="department">部門</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-label-group">
                    <input type="text" id="member" class="form-control" placeholder="申請人" :value='member_name' disabled>
                    <label for="member">申請人</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-label-group mt-2">
                    <input type="text" id="apply_subject" class="form-control" placeholder="名稱" name="apply_subject"
                           v-model='form_submit_data[dom_id]["apply_subject"]' :disabled='form_action !== "new"'>
                    <label for="apply_subject">名稱</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="form">用印形式</label>
                    <select class="custom-select select2 form-control"
                            multiple="multiple" id="form_stamp_type" name="form_stamp_type"
                            v-model='form_submit_data[dom_id]["form_stamp_type"]' :disabled='form_action !== "new"'>
                        <option value="company">公司大章</option>
                        <option value="principal">負責人章</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="deployed">寄送方式</label>
                    <select class="custom-select select2 form-control" id="deployed"
                            name="deployed" v-model='form_submit_data[dom_id]["deployed"]'
                            :disabled='form_action !== "new"'>
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
                    <input type="text" id="recipient_company" class="form-control"
                           placeholder="收件人公司" name="recipient_company"
                           v-model='form_submit_data[dom_id]["recipient_company"]' :disabled='form_action !== "new"'>
                    <label for="recipient_company">收件人公司</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-label-group">
                    <input type="text" id="recipient_contact" class="form-control"
                           placeholder="收件人窗口" name="recipient_contact"
                           v-model='form_submit_data[dom_id]["recipient_contact"]'
                           :disabled='form_action !== "new"'>
                    <label for="recipient_contact">收件人窗口</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-label-group">
                    <input type="text" id="recipient_phone" class="form-control"
                           placeholder="收件人電話"
                           name="recipient_phone" v-model='form_submit_data[dom_id]["recipient_phone"]'
                           :disabled='form_action !== "new"'>
                    <label for="recipient_phone">收件人電話</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-label-group">
                    <input type="text" id="recipient_address" class="form-control"
                           placeholder="收件人地址"
                           name="recipient_address" v-model='form_submit_data[dom_id]["recipient_address"]'
                           :disabled='form_action !== "new"'>
                    <label for="recipient_address">收件人地址</label>
                </div>
            </div>
            <div class='col-md-6'>
                <div class="form-label-group">
                    <fieldset class="form-label-group">
                            <textarea class="form-control" id="remark" rows="3" placeholder="備註"
                                      name="remark" v-model='form_submit_data[dom_id]["remark"]'
                                      :disabled='form_action !== "new"'></textarea>
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
    import {mapState} from 'vuex';

    export default {
        name: "form-sign",
        props: {
            dom_id: String,
            form_action: String
        },
        data() {
            return {
                member_name:'',
                department_name:'',
            }
        },
        computed: {
            ...mapState(['form_submit_data','login_user', 'member', 'department']),
        },
        beforeMount: function () {
        },
        mounted: function () {
            this.initial();
        },
        methods: {
            initial(){
                if (this.form_action === 'new') {
                    this.department_name = this.login_user.department;
                    this.member_name = this.login_user.name;
                    this.form_submit_data[this.dom_id]["form_stamp_type"] = [];
                    $('#'+this.dom_id+' #form_stamp_type').change((e)=>{
                        this.form_submit_data[this.dom_id]["form_stamp_type"]= $('#'+this.dom_id+' #form_stamp_type').val();
                    });
                    $('#'+this.dom_id+' #deployed').change((e)=>{
                        this.form_submit_data[this.dom_id]["deployed"] = e.target.value;
                    });

                }
            }
        },
        updated() {

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
