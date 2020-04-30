<template>
    <fieldset :id='dom_id'>
        <div class="row col-md-12 align-items-center">
            <div class="card">
                <h4 class="card-title">用印單</h4>
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
                                            <p class="card-text">
                                                有任何需要蓋用公司大小章的情形,便需要填寫用印申請單。</p>
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                請勾選合約簽核後是否需總務協助寄出,否則請勾選自行寄出即可
                                            </li>
                                        </ul>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                若需總務協助寄出者,務必填寫以下資訊。<br>
                                                a.收件公司名稱<br>
                                                b.收件窗口資料:請務必填寫收件窗口及電話,而非合約後公司負責人。<br>
                                                c.收件公司地址:填寫收件公司窗口地址,而非合約後公司代表地址。<br>
                                            </li>
                                        </ul>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                用印完畢後,若選擇「自行寄出」者,將收到用完印之合約;勾選「總務寄出」
                                                者,將直接由總務協助寄出。
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
                           v-model='form_submit_data[dom_id]["apply_subject"]' :disabled='can_edit === false' required>
                    <label for="apply_subject">名稱</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="form">用印形式</label>
                    <select class="custom-select select2 form-control"
                            multiple="multiple" id="form_stamp_type" name="form_stamp_type"
                            v-model='form_submit_data[dom_id]["form_stamp_type"]' :disabled='can_edit === false' required>
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
                            :disabled='can_edit === false' required>
                        <option value="company">總務寄出</option>
                        <option value="self">自行寄出</option>
                    </select>
                </div>
            </div>
        </div>
        <!--收件人-->
        <div class='row' v-show='deployed' id='deployed_form'>
            <div class='col-md-12 border-top-light mb-3'></div>
            <div class="col-md-6">
                <div class="form-label-group">
                    <input type="text" id="recipient_company" class="form-control"
                           placeholder="收件人公司" name="recipient_company"
                           v-model='form_submit_data[dom_id]["recipient_company"]' :disabled='can_edit === false' :required='deployed'>
                    <label for="recipient_company">收件人公司</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-label-group">
                    <input type="text" id="recipient_contact" class="form-control"
                           placeholder="收件人窗口" name="recipient_contact"
                           v-model='form_submit_data[dom_id]["recipient_contact"]'
                           :disabled='can_edit === false' :required='deployed'>
                    <label for="recipient_contact">收件人窗口</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-label-group">
                    <input type="text" id="recipient_phone" class="form-control"
                           placeholder="收件人電話"
                           name="recipient_phone" v-model='form_submit_data[dom_id]["recipient_phone"]'
                           :disabled='can_edit === false' :required='deployed'>
                    <label for="recipient_phone">收件人電話</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-label-group">
                    <input type="text" id="recipient_address" class="form-control"
                           placeholder="收件人地址"
                           name="recipient_address" v-model='form_submit_data[dom_id]["recipient_address"]'
                           :disabled='can_edit === false' :required='deployed'>
                    <label for="recipient_address">收件人地址</label>
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-12'>
                <div class="form-label-group">
                    <fieldset class="form-label-group">
                            <textarea class="form-control" id="remark" rows="3" placeholder="備註"
                                      name="remark" v-model='form_submit_data[dom_id]["remark"]'
                                      :disabled='can_edit === false'></textarea>
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
            form_action: String,
            can_edit: Boolean,
        },
        data() {
            return {
                deployed: false,
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
                let vue = this;
                if (vue.form_action === 'new') {
                    vue.department_name = vue.login_user.department;
                    vue.member_name = vue.login_user.name;
                    vue.form_submit_data[vue.dom_id]["form_stamp_type"] = [];
                }else{
                    vue.department_name = getDepartment(vue.form_submit_data[vue.dom_id]['apply_department_id']);
                    vue.member_name = getMember(vue.form_submit_data[vue.dom_id]['apply_member_id']);

                    if(vue.form_submit_data[vue.dom_id]['deployed'] === 'company'){
                        vue.deployed = true;
                    }
                }

                /*select tigger*/
                ['form_stamp_type','deployed'].map(k=>{
                    let targetDom = $(`#${vue.dom_id} #${k}`);
                    targetDom.change(() => {
                        vue.form_submit_data[vue.dom_id][k] = targetDom.val();
                        if(k === 'deployed'){
                            if(targetDom.val() === 'company'){
                                vue.deployed = true;
                            }else{
                                vue.deployed = false;
                            }
                        }
                    });
                });
            }
        },
        updated() {

        },
        watch: {
            // change_date: {
            //     immediate: true,
            //     handler(val, oldVal) {
            //         if (oldVal !== undefined) {
            //             vue.getCampaignData(this.user_ids, val);
            //         }
            //     }
            // }
        }
    }
</script>

<style scoped>

</style>
