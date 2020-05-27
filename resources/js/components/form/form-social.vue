<template>
    <fieldset :id='dom_id'>
        <div class="row col-md-12 align-items-center">
            <div class="card">
                <h4 class="card-title">交際送禮</h4>
            </div>
            <div class='card-body row justify-content-end'>
                <div class="modal-info mr-1 mb-1 d-inline-block">
                    <print-button></print-button>
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
                                                有任何與客戶交際、餐敘,或是需送花、禮品的狀況下,請預先提出交際申請。
                                                <br><br>
                                                Ex. 拜訪客戶時,購買咖啡做為伴手禮;部落客前來公司會議,準備會議餐食。
                                                <br><br>
                                                若交際活動較為臨時,請於三天內提出事後申請,否則恕不接受。
                                                <br><br>
                                                註 無論金額多寡,皆務必申請。
                                            </p>
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                事前申請者,請照下列「表單填寫」步驟申請。交際活動結束後,再填寫代墊申請,將當日花
                                                費憑證提交給 Ravin。
                                            </li>
                                        </ul>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                請名稱填寫交際事由簡述,如需詳述請填備註<br>
                                                確實填寫「交際或送禮當天」發生日期。<br>
                                            </li>
                                        </ul>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                請確實填寫交際出席人員 我方同仁<br>
                                                對象 請填寫 對方人員<br>
                                            </li>
                                        </ul>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                分為事前及事後申請: <br>
                                                事前申請:請填寫預估費用。 <br>
                                                事後補請:填寫實際花費,並附上有公司抬頭或統編等憑證。如發票、收據。<br>
                                            </li>
                                        </ul>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                此表單為申請交際送禮, 費用申請 請後續填寫代墊單
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
            <div class="col-md-6 mt-2">
                <div class="form-label-group">
                    <input type="text" id="apply_subject" class="form-control" placeholder="名稱" name="apply_subject"
                           v-model='form_submit_data[dom_id]["apply_subject"]' :disabled='can_edit === false' required>
                    <label for="apply_subject">名稱</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-label-group">
                    <input type="date" id="social_date" class="form-control" placeholder="送禮日期" name="social_date"
                           v-model='form_submit_data[dom_id]["social_date"]' :disabled='can_edit === false' required>
                    <label for="apply_subject">送禮日期</label>
                </div>
            </div>
<!--            <div class="col-md-6">-->
<!--                <div class="form-label-group">-->
<!--                    <input type="date" id="date" class="form-control" placeholder="日期"-->
<!--                           name="date" v-model='form_submit_data[dom_id]["date"]' :disabled='can_edit === false' required>-->
<!--                    <label for="date">日期</label>-->
<!--                </div>-->
<!--            </div>-->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="type">類型</label>
                    <select class="custom-select select2 form-control" id="type"
                            name="type" v-model='form_submit_data[dom_id]["type"]' :disabled='can_edit === false' required>
                        <option value>請選擇</option>
                        <option value="flower">送花</option>
                        <option value="meal">餐敘</option>
                        <option value="gift">送禮</option>
                        <option value="other">其他</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <div class="form-group">
                        <label>出席人員</label>
                        <select class="custom-select select2 form-control" multiple="multiple" id='attend_member'
                                name="attend_member" v-model='form_submit_data[dom_id]["attend_member"]'
                                :disabled='can_edit === false' required>
                            <option v-for='item in member' :value='item.id'>{{item.name}}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-label-group">
                    <input type="text" id="customer_company" class="form-control"
                           placeholder="客戶公司名稱" name="customer_company" v-model='form_submit_data[dom_id]["customer_company"]' :disabled='can_edit === false' required>
                    <label for="customer_company">客戶公司名稱</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-label-group">
                    <input type="text" id="customer_name" class="form-control"
                           placeholder="對象" name="customer_name" v-model='form_submit_data[dom_id]["customer_name"]' :disabled='can_edit === false' required>
                    <label for="customer_name">對象</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-label-group">
                    <input id="cost" class="form-control"
                           placeholder="預估費用" type="number" min='0' max='99999' step='1'
                           name="cost" v-model='form_submit_data[dom_id]["cost"]' :disabled='can_edit === false' required>
                    <label for="cost">預估費用</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-label-group">
                    <fieldset class="form-label-group">
                            <textarea class="form-control" id="remark" rows="1" placeholder="備註" v-model='form_submit_data[dom_id]["remark"]' :disabled='can_edit === false'
                                      name="remark"></textarea>
                        <label for="remark">備註</label>
                    </fieldset>
                </div>
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
    import {mapState, mapMutations, mapActions, mapGetters} from 'vuex';

        export default {
            name: "form-social",
            props: {
                dom_id:String,
                form_data: Object,
                form_action: String,
                can_edit: Boolean,
                id:Number,
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
                    let vue = this;
                    if (vue.form_action === 'new') {
                        vue.department_name = vue.login_user.department;
                        vue.member_name = vue.login_user.name;
                    }else{
                        vue.department_name = getDepartment(vue.form_submit_data[vue.dom_id]['apply_department_id']);
                        vue.member_name = getMember(vue.form_submit_data[vue.dom_id]['apply_member_id']);
                    }

                    ['type','attend_member'].map(k =>{
                        let targetDom = $(`#${vue.dom_id} #${k}`);
                        targetDom.change(() => {
                            vue.form_submit_data[vue.dom_id][k] = targetDom.val();
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
                //             this.getCampaignData(this.user_ids, val);
                //         }
                //     }
                // }
            }
        }
</script>

<style scoped>

</style>
