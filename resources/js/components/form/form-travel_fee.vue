<template>
    <fieldset :id='dom_id'>
        <div class="row col-md-12 align-items-center">
            <div class="card">
                <h4 class="card-title">差旅費用報銷單</h4>
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
                                                旅費核銷單,需勾選已申請通過之差旅單<br>
                                                可以填寫的費用為 該出差計畫負責業務<br>
                                                請檢附差旅申請單及各項憑證單據並填妥國內外出差旅費報銷單，於出差後一周內提出申請。由於款項會直接匯入同仁薪資戶.<br>
                                            </p>
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                國外出差之差旅費用申請，除檢附各項費用憑證外，並附上出入境之來回飛機票票根(或電子機票)及登機證與機票購票證明單(或代收轉付收據)<br><br>
                                                若遺失登機證者，請檢附足資證明出國事實之護照影本代替,<br>
                                                但若無法及時提供者，則須自行向航空公司申請搭機證明並負擔相關費用<br>
                                                若前往大陸出差，請檢附台胞證影本代替。<br>
                                            </li>
                                        </ul>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                國外出差交通費申請，請註明起迄地點並附上車票票根或購票證明為原始憑證。<br>
                                            </li>
                                        </ul>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                國外出差旅費之換算匯率將以出國前一日（如逢假日往前順推）臺灣銀行即期賣出參考匯價 為計算基

                                                礎。(此部份由財務部換算成台幣)。<br>
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
            <div class='col-md-12'>
                <div class="form-label-group">
                    <div class="form-group">
                        <label>差旅單</label>
                        <select class="custom-select select2 form-control" id='form_grant_id' :disabled='form_action=="edit"'
                                name="form_grant_id" required>
                            <option value>請選擇</option>
                            <option v-for='item in travel_grant_datas' :value='item.id' :selected='form_submit_data[dom_id]["form_grant_id"]'
                            >
                                {{item.apply_subject}}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center border-top-light mt-2">
            <div class="row col-md-12">
                <div class="card mt-2">
                    <h4 class="card-title">出差計畫</h4>
                </div>
            </div>
            <components v-for="item in items" v-bind:is="item.component" :key='parseInt(item.id)'
                        :id='parseInt(item.id)' :dom_id='dom_id' :plan_action='item.plan_action' :form_action='form_action' :can_edit='can_edit'
            ></components>
            <div class='row col-md-12 justify-content-end border-top-light' v-show='items[0]'>
                <div class='col-md-4 text-right mt-1' v-show='can_edit'>
                    <button type="button" @click='addItem'
                            class="btn btn-outline-primary mr-1 mb-1 waves-effect waves-light">
                        新增計畫
                    </button>
                </div>
            </div>
            <div class='col-md-12 mt-2'>
                <fieldset class="form-label-group">
                            <textarea class="form-control" id="remark" rows="3" placeholder="備註"
                                      name="remark" v-model='form_submit_data[dom_id]["remark"]'
                                      :disabled='form_action !== "new"'></textarea>
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
        name: "form-travel_fee",
        props: {
            dom_id: String,
            form_action: String,
            can_edit: Boolean
        },
        data() {
            return {
                member_name: '',
                department_name: '',
                travel_grant_datas: [],
                items: [],
                count: 0
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
                this.getTraveGrantData();
                if (this.form_action === 'new') {
                    this.department_name = this.login_user.department;
                    this.member_name = this.login_user.name;
                    $('#' + this.dom_id + ' #form_grant_id').change((e, v) => {
                        this.getFromData(e.target.value);
                        this.form_submit_data[this.dom_id]["form_grant_id"] = e.target.value;
                    });
                } else {
                    this.department_name = getDepartment(this.form_submit_data[this.dom_id]['apply_department_id']);
                    this.member_name = getMember(this.form_submit_data[this.dom_id]['apply_member_id']);
                    let itemsData = this.form_submit_data[this.dom_id]['items'];

                    Object.keys(itemsData).forEach(key => {
                        let tmpdata = Object.assign({},itemsData[key]);
                        tmpdata.component = 'form-travel_fee_plan';
                        tmpdata.can_edit = vue.can_edit;
                        vue.items.push(tmpdata);
                        vue.count = tmpdata.id;
                    })
                }

            },
            addItem() {
                this.count++;
                this.items.push({
                    component: 'form-travel_fee_plan',
                    plan_action: 'new_plan',
                    id: this.count,
                    can_edit : this.can_edit,
                });
                this.form_submit_data[this.dom_id]["items"][this.count] = {
                    id: this.count.toString(),
                    date: '',
                    customer_name: '',
                    customer_company: '',
                    meet_type: '',
                    agenda: '',
                    charge_user: null,
                    fee_items: {}
                };
            },
            getTraveGrantData() {
                let vue = this;
                let data = {
                    form_id: 5,
                    apply_member_id: this.login_user.id
                };
                if(this.form_action == 'new'){
                    /*TODO:: 確認簽核流程完成 拉回來的資料還需要再做判斷處理*/
                    axios.post('api/form/depend', data)
                        .then(function (response) {
                            let result = response.data;
                            if (result.status !== 1) {
                                alert(result.message);
                                return false;
                            }
                            vue.travel_grant_datas = result.data;
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }else{
                    let id = this.form_submit_data[this.dom_id]['form_grant_id'];
                    axios.post('api/form/get', {id:id})
                        .then(function (response) {
                            let result = response.data;
                            if (result.status !== 1) {
                                alert(result.message);
                                return false;
                            }
                            vue.travel_grant_datas = [{id:result.data.id,apply_subject:result.data.column.apply_subject}];
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }

            },
            getFormTravelGrantPlans() {
                let vue = this;
                let data = Object.assign([], vue.form_submit_data[vue.dom_id]['items']);
                if (data !== '') {
                    data.map((e, v) => {
                        e.fee_items = {};
                        this.form_submit_data[this.dom_id]['items'][e.id] = e;
                        let copyData = Object.assign([], e);
                        copyData.id = parseInt(e.id);
                        copyData.plan_action = 'new_fee';
                        copyData.component = 'form-travel_fee_plan';
                        vue.items.push(copyData);
                        vue.count = copyData.id;
                    });
                }
            },
            getFromData(id) {
                let vue = this;
                if(id === undefined || id === ''){
                    vue.items = [];
                    vue.form_submit_data[vue.dom_id]['items'] = {};
                }else{
                    axios.post('api/form/get', {'id': id})
                        .then(function (response) {
                            let result = response.data;
                            if (result.status !== 1) {
                                alert(result.message);
                                return false;
                            }
                            vue.form_submit_data[vue.dom_id]["items"] = result.data.column.items;
                        }).then(() => {
                        vue.items = [];
                        vue.getFormTravelGrantPlans();
                    }).catch(function (error) {
                        console.log(error);
                    });
                }
            },
            deleteItem(event) {
                let vue = this;
                let id = $(event.currentTarget).data('id');
                this.items.map((e, k) => {
                    if (e.id === id) {
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
