<template>
    <fieldset :id='dom_id'>
        <div class="row col-md-12 align-items-center">
            <div class="card">
                <h4 class="card-title">差旅申請單</h4>
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
                                                出差地點為雙北市以外之地區，須事先申請並於出差後一周內報銷。</p>
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                提出差旅申請(同行者只需填寫一份申請單)<br>

                                                國內外出差申請單<br>

                                                請詳載姓名、出差事由、出差地點、出差期間、工作計劃及逐日前往地點、訪洽對象等，並於一周前提出申請。<br>
                                            </li>
                                        </ul>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                若需公司協助交通及住宿安排，請於申請單註記，並於提交申請單時，與執行長室Ravin再次說明<br>
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
            <div class='col-md-6 mt-2'>
                <div class="form-label-group">
                    <input type="text" id="apply_subject" class="form-control" placeholder="出差事由" name="apply_subject"
                           v-model='form_submit_data[dom_id]["apply_subject"]' :disabled='can_edit === false' required>
                    <label for="apply_subject">出差事由</label>
                </div>
            </div>
            <div class='col-md-6'>
                <div class="form-group">
                    <label>出差人</label>
                    <select class="custom-select select2 form-control" multiple="multiple" id='accompany_user_id'
                            name="accompany_user_id" v-model='form_submit_data[dom_id]["accompany_user_id"]'
                            :disabled='can_edit === false' required>
                        <option v-for='item in member' :value='item.id'>{{item.name}}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-label-group">
                    <input type="date" id="travel_date_start" class="form-control"
                           placeholder="出差起始日期"
                           name="travel_date_start" v-model='form_submit_data[dom_id]["travel_date_start"]'
                           :disabled='can_edit === false' required>
                    <label for="travel_date_start">出差起始日期</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-label-group">
                    <input type="date" id="travel_date_end" class="form-control"
                           placeholder="出差結束日期"
                           name="travel_date_end" v-model='form_submit_data[dom_id]["travel_date_end"]'
                           :disabled='can_edit === false' required>
                    <label for="travel_date_end">出差結束日期</label>
                </div>
            </div>
            <div class='col-md-6'>
                <div class="form-label-group">
                    <input type="text" id="travel_location" class="form-control"
                           placeholder="出差地點"
                           name="travel_location" v-model='form_submit_data[dom_id]["travel_location"]'
                           :disabled='can_edit === false' required>
                    <label for="travel_location">出差地點</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-label-group">
                    <input type="text" id="travel_stay_location" class="form-control"
                           placeholder="住宿地點" name="travel_stay_location"
                           v-model='form_submit_data[dom_id]["travel_stay_location"]'
                           :disabled='can_edit === false' required>
                    <label for="travel_stay_location">住宿地點</label>
                </div>
            </div>

            <div class='col-md-6'>
                <div class="form-label-group">
                    <input type="number" min='0' max='99999' step='1' id="predict_cost" class="form-control"
                           placeholder="預估費用(台幣)"
                           name="predict_cost" v-model='form_submit_data[dom_id]["predict_cost"]'
                           :disabled='can_edit === false' required>
                    <label for="predict_cost">預估費用(台幣)</label>
                </div>
            </div>
            <div class='col-md-12'>
                <fieldset class="form-label-group">
                            <textarea class="form-control" id="travel_remark" rows="1" placeholder="出差事由詳述"
                                      v-model='form_submit_data[dom_id]["travel_remark"]'
                                      :disabled='can_edit === false'
                                      name="travel_remark" required></textarea>
                    <label for="travel_remark">出差事由詳述</label>
                </fieldset>
            </div>
        </div>
        <div class="row col-md-12 align-items-center border-top-light mt-2">
            <div class="card mt-1">
                <h4 class="card-title">出差計畫</h4>
            </div>
        </div>
        <div class="row">
            <components v-for="item in items" v-bind:is="item.component" :key='item.id' :id='parseInt(item.id)'
                        :dom_id='dom_id' :plan_action='"new_plan"' :can_edit='can_edit'></components>
            <div class='row col-md-12 justify-content-end' v-show='can_edit'>
                <div class='col-md-4 text-right mt-1'>
                    <button type="button" @click='addItem'
                            class="btn btn-outline-primary mr-1 mb-1 waves-effect waves-light">
                        新增計畫
                    </button>
                </div>
            </div>
            <div class='col-md-12 mt-2'>
                <fieldset class="form-label-group">
                              <textarea class="form-control" id="remark" rows="3" placeholder="備註"
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

    Vue.component('form-travel_fee_plan', require('../../components/form/form-travel_fee_plan').default);
    export default {
        name: "form-travel_grant",
        props: {
            dom_id: String,
            form_data: Object,
            form_action: String,
            can_edit: Boolean,
        },
        data() {
            return {
                items: [],
                count: -1,
                member_name: '',
                department_name: '',
            }
        },
        computed: {
            ...mapState(['form_submit_data', 'login_user', 'member', 'department']),
        },
        beforeMount: function () {
        },
        mounted: function () {

            this.initial();
        },
        methods: {
            initial() {
                var vue = this;
                $('.row').on('click', '[data-action="deleteItem"]', function (e) {
                    vue.deleteItem(e);
                });

                let accompanyUserDom = $('#'+this.dom_id+' #accompany_user_id');
                accompanyUserDom.change((e,v)=>{
                    vue.form_submit_data[vue.dom_id]["accompany_user_id"] = accompanyUserDom.val();
                });

                if (vue.form_action === 'new') {
                    vue.department_name = vue.login_user.department;
                    vue.member_name = vue.login_user.name;
                } else {
                    vue.department_name = getDepartment(vue.form_submit_data[vue.dom_id]['apply_department_id']);
                    vue.member_name = getMember(vue.form_submit_data[vue.dom_id]['apply_member_id']);
                    let itemsData = vue.form_submit_data[vue.dom_id]['items'];

                    Object.keys(itemsData).forEach(key => {
                        let tmpdata = Object.assign({},itemsData[key]);
                        tmpdata.component = 'form-travel_fee_plan';
                        vue.items.push(tmpdata);
                        vue.count = tmpdata.id;
                    })
                }
            },
            addItem() {
                this.count++;
                this.items.push({
                    component: 'form-travel_fee_plan',
                    id: this.count
                });
                this.form_submit_data[this.dom_id]["items"][this.count] = {
                    id: this.count.toString(),
                    date: '',
                    customer_name: '',
                    customer_company: '',
                    meet_type: '',
                    agenda:'',
                    charge_user:null,
                };
            },
            deleteItem(event) {
                let vue = this;
                let id = parseInt($(event.currentTarget).data('id'));

                this.items.map((e, k) => {
                    if (parseInt(e.id) === id) {
                        this.items.splice(k, 1);
                        delete vue.form_submit_data[vue.dom_id]["items"][id];
                    }
                });
            },
        },
        updated() {
            $(".select2").select2({
                dropdownAutoWidth: true,
                width: '100%'
            });
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
