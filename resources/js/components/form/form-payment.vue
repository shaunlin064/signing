<template>
    <fieldset :id='dom_id'>
        <div class="row col-md-12 align-items-center">
            <div class="card">
                <h4 class="card-title">請款單</h4>
            </div>
        </div>
        <div class="row">
            <div class='row col-md-12'>
                <div class="col-md-6">
                    <div class="form-label-group">
                        <input type="text" id="department" class="form-control" placeholder="部門" :value='department_name' disabled>
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
                    <div class="form-label-group">
                        <input type="text" id="apply_subject" class="form-control" placeholder="名稱" name="apply_subject" v-model='form_submit_data[dom_id]["apply_subject"]' :disabled='form_action !== "new"'>
                        <label for="apply_subject">名稱</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-label-group">
                        <input type="text" id="campaign_id" class="form-control" placeholder="案件編號" name="campaign_id" v-model='form_submit_data[dom_id]["campaign_id"]' :disabled='form_action !== "new"'>
                        <label for="campaign_id">案件編號</label>
                    </div>
                </div>
            </div>
            <div class='row col-md-12 p-1'>
                <div class='col-md-12 border-top-light mb-1'></div>
                <div class="col-md-6">
                    <div class="form-label-group">
                        <input type="text" id="beneficiary" class="form-control" placeholder="受款人" name="beneficiary" v-model='form_submit_data[dom_id]["beneficiary"]' :disabled='form_action !== "new"'>
                        <label for="beneficiary">受款人</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-label-group">
                        <input type="text" id="receipt_number" class="form-control" placeholder="發票號碼" v-model='form_submit_data[dom_id]["receipt_number"]' :disabled='form_action !== "new"'
                               name="receipt_number">
                        <label for="receipt_number">發票號碼</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-label-group">
                        <input type="text" id="receipt_date" class="form-control" placeholder="開立發票日期" v-model='form_submit_data[dom_id]["receipt_date"]' :disabled='form_action !== "new"'
                               name="receipt_date">
                        <label for="receipt_date">開立發票日期</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-label-group">
                        <input type="text" id="receipt_price" class="form-control" placeholder="發票金額(稅)" v-model='form_submit_data[dom_id]["receipt_price"]' :disabled='form_action !== "new"'
                               name="receipt_price">
                        <label for="receipt_price">發票金額(稅)</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="pay_type">付款方式</label>
                        <select class="custom-select select2 form-control" id="pay_type" name="pay_type" v-model='form_submit_data[dom_id]["pay_type"]' :disabled='form_action !== "new"'>
                            <option value>請選擇</option>
                            <option value="cash">現金</option>
                            <option value="transfer">電匯</option>
                            <option value="other">其他</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class='col-md-12'>
                <fieldset class="form-label-group">
                        <textarea class="form-control" id="remark" rows="1" placeholder="備註" v-model='form_submit_data[dom_id]["remark"]' :disabled='form_action !== "new"'
                                  name="remark"></textarea>
                    <label for="remark">備註</label>
                </fieldset>
            </div>
            <div class="col-md-12 mt-1">
                <div class="form-group">
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
        name: "form_payment",
        props: {
            dom_id: String,
            form_data: Object,
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
                    $('#'+this.dom_id+' #pay_type').change((e)=>{
                        this.form_submit_data[this.dom_id]["pay_type"] = e.target.value;
                    });
                }else{
                    this.department_name = getDepartment(this.form_submit_data[this.dom_id]['apply_department_id']);
                    this.member_name = getMember(this.form_submit_data[this.dom_id]['apply_member_id']);
                }
            }
        },
        updated() {

        },
        watch: {
            // change_date: {
            //     immediate: true,
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
