<template>
    <fieldset :id='dom_id'>
        <div class="row col-md-12 align-items-center">
            <div class="card">
                <h4 class="card-title">請款單</h4>
            </div>
            <div class='card-body row justify-content-end'>
                <div class="modal-info mr-1 mb-1 d-inline-block">
                    <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#info">
                        注意事項
                    </button>

                    <div class="modal fade text-left" id="info" tabindex="-1" role="dialog"
                         aria-labelledby="myModalLabel130" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-info white">
                                    <h5 class="modal-title" id="myModalLabel130">Info</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <br class="modal-body">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <h4 class="card-title">表單填寫事項</h4>
                                            <p class="card-text">凡須申請付款之各項成本,如:媒體成本、案件用物品、活動用贈品、點數成本...
                                                等。或,一般公司費用如:辦公室文具用品、耗材...等各項費用,都應填寫請款
                                                單提出申請付款。</p>
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                若該請款項目為案件用物品,請填寫「委刊編號」於案件編號欄位。
                                            </li>
                                        </ul>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                應填寫受款人姓名或公司寶號、發票號碼、發票開立日、含稅金額。請注意,受款人非寫申請人姓名,而是憑證開立方。 <br> <br>Ex.
                                                將會議室投影機送回原廠維修,而廠商開立發票索款,受款人便
                                                為「奧圖瑪科技有限公司」,而非寫自己的名字。
                                            </li>
                                        </ul>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                應填寫受款人姓名或公司寶號、發票號碼、發票開立日、含稅金額。
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-info" data-dismiss="modal">Accept</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class='row col-md-12 justify-content-end mb-2'>
                <div class='mr-2' v-if='id'>id：{{id}}</div>
                <div>申請日期：{{form_submit_data[dom_id]['created_at']}}</div>
            </div>
            <div class='row col-md-12'>
                <div class="col-md-6">
                    <div class="form-label-group">
                        <input type="text" id="department" class="form-control" placeholder="部門"
                               :value='department_name' disabled>
                        <label for="department">部門</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-label-group">
                        <input type="text" id="member" class="form-control" placeholder="申請人" :value='member_name'
                               disabled>
                        <label for="member">申請人</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-label-group">
                        <input type="text" id="apply_subject" class="form-control" placeholder="名稱" name="apply_subject"
                               v-model='form_submit_data[dom_id]["apply_subject"]' :disabled='can_edit === false'
                               required>
                        <label for="apply_subject">名稱</label>
                    </div>
                </div>
                <div class='col-md-6'>
                    <li class="d-inline-block mr-2">
                        <fieldset>
                            <div class="vs-checkbox-con vs-checkbox-primary">
                                <input type="checkbox" v-model="campaign" :disabled='can_edit === false'>
                                <span class="vs-checkbox">
                      <span class="vs-checkbox--check">
                        <i class="vs-icon feather icon-check"></i>
                      </span>
                    </span>
                                <span class="">後台案件</span>
                            </div>
                        </fieldset>
                    </li>
                    <li class="d-inline-block mr-2">
                        <fieldset>
                            <div class="vs-checkbox-con vs-checkbox-primary">
                                <input type="checkbox" v-model="receipt" :disabled='can_edit === false'>
                                <span class="vs-checkbox">
                      <span class="vs-checkbox--check">
                        <i class="vs-icon feather icon-check"></i>
                      </span>
                    </span>
                                <span class="">有發票</span>
                            </div>
                        </fieldset>
                    </li>
                </div>
                <div class="col-md-6" v-if='campaign'>
                    <div class="form-label-group">
                        <input type="text" id="campaign_id" class="form-control" placeholder="案件編號" name="campaign_id"
                               v-model='form_submit_data[dom_id]["campaign_id"]' :disabled='can_edit === false'
                               :required='campaign'>
                        <label for="campaign_id">案件編號</label>
                    </div>
                </div>
            </div>
            <div class='row col-md-12 p-1'>
                <div class='col-md-12 border-top-light mb-3'></div>
                <div class="col-md-6">
                    <div class="form-label-group">
                        <input type="text" id="beneficiary" class="form-control" placeholder="受款人" name="beneficiary"
                               v-model='form_submit_data[dom_id]["beneficiary"]' :disabled='can_edit === false'
                               required>
                        <label for="beneficiary">受款人</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-label-group">
                        <input type="number" min='0' max='99999' step='1' id="receipt_price" class="form-control"
                               placeholder="金額(稅)" v-model='form_submit_data[dom_id]["receipt_price"]'
                               :disabled='can_edit === false'
                               name="receipt_price" required>
                        <label for="receipt_price">金額(稅)</label>
                    </div>
                </div>
                <div class="col-md-6" v-if='receipt'>
                    <div class="form-label-group">
                        <input type="text" id="receipt_number" class="form-control" placeholder="發票號碼"
                               v-model='form_submit_data[dom_id]["receipt_number"]' :disabled='can_edit === false'
                               name="receipt_number" :required='receipt'>
                        <label for="receipt_number">發票號碼</label>
                    </div>
                </div>
                <div class="col-md-6" v-if='receipt'>
                    <div class="form-label-group">
                        <input type="date" id="receipt_date" class="form-control" placeholder="開立發票日期"
                               v-model='form_submit_data[dom_id]["receipt_date"]' :disabled='can_edit === false'
                               name="receipt_date" :required='receipt'>
                        <label for="receipt_date">開立發票日期</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="pay_type">付款方式</label>
                        <select class="custom-select select2 form-control" id="pay_type" name="pay_type"
                                v-model='form_submit_data[dom_id]["pay_type"]' :disabled='can_edit === false' required>
                            <option value>請選擇</option>
                            <option value="cash">現金</option>
                            <option value="transfer">電匯</option>
                            <option value="other">其他</option>
                        </select>
                    </div>
                </div>
                <div class='col-md-6 mt-2' v-if='transfer'>
                    <div class="form-label-group">
                        <input type="date" class="form-control" placeholder="指定匯款日期" id='transfer_date'
                               v-model='form_submit_data[dom_id]["transfer_date"]'
                               :disabled='can_edit === false'
                               name="transfer_date" :required='transfer'>
                        <label for="transfer_date">指定匯款日期</label>
                    </div>
                </div>
            </div>
            <div class='col-md-12'>
                <fieldset class="form-label-group">
                        <textarea class="form-control" id="remark" rows="1" placeholder="備註"
                                  v-model='form_submit_data[dom_id]["remark"]' :disabled='can_edit === false'
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
    import form from "../../mixins/form.js";

    export default {
        name: "form_payment",
        props: {
            dom_id: String,
            form_action: String,
            can_edit: Boolean,
            id:Number,
        },
        mixins: [form],
        data() {
            return {
                member_name: '',
                department_name: '',
                campaign: false,
                receipt: false,
                transfer: false,
            }
        },
        computed: {
            ...mapState(['form_submit_data', 'login_user', 'member', 'department', 'exPassCheckColumn']),
        },
        beforeMount: function () {
        },
        mounted: function () {
            this.initial();
        },
        methods: {
            initial() {
                this.$store.state.exPassCheckColumn = this.exPassCheckColumn.concat(['campaign_id', 'receipt_number', 'receipt_date', 'transfer_date']);
                if (this.form_action === 'new') {
                    this.department_name = this.login_user.department;
                    this.member_name = this.login_user.name;
                } else {
                    this.department_name = getDepartment(this.form_submit_data[this.dom_id]['apply_department_id']);
                    this.member_name = getMember(this.form_submit_data[this.dom_id]['apply_member_id']);
                    this.transfer = this.form_submit_data[this.dom_id]["pay_type"] === 'transfer';
                    this.campaign = !nullCheck(this.form_submit_data[this.dom_id]["campaign_id"]);
                    this.receipt = !nullCheck(this.form_submit_data[this.dom_id]["receipt_number"]);
                }
                $('#' + this.dom_id + ' #pay_type').change((e) => {
                    this.form_submit_data[this.dom_id]["pay_type"] = e.target.value;
                    this.transfer = e.target.value === 'transfer';
                });
            },
            setValidateColumn(add, columnNames) {
                if (add) {
                    /*remove*/
                    columnNames.map((v, k) => {
                        let index = this.exPassCheckColumn.indexOf(v);
                        this.$store.state.exPassCheckColumn.splice(index, 1);
                    });
                } else {
                    /*add*/
                    this.$store.state.exPassCheckColumn = this.exPassCheckColumn.concat(columnNames);
                    this.setEmptyData(columnNames);
                }
            },
            setEmptyData(columnNames) {
                columnNames.map((columnName) => {
                    this.form_submit_data[this.dom_id][columnName] = null;
                });
            }
        },
        updated() {
        },
        watch: {
            campaign: function (val) {
                this.setValidateColumn(val, ['campaign_id']);
            },
            receipt: function (val) {
                this.setValidateColumn(val, ['receipt_number', 'receipt_date']);
            },
            transfer: function (val) {
                this.setValidateColumn(val, ['transfer_date']);
            },
        }
    }
</script>

<style scoped>

</style>
