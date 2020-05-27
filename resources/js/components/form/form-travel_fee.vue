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
                                                需先勾選已申請通過之差旅單，並檢附差旅申請單及各項憑證單據並填妥國內外出差旅費報銷單，於出差後二周內提出申請。由於款項會直接匯入同仁薪資戶，所以報銷單提出請以「個人」為單位，請同仁勿合併報差旅費以免後續請款作業有問題。<br>
                                            </p>
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                國外出差之差旅費用申請，除檢附各項費用憑證外，並附上出入境之來回飛機票票根(或電子機票)及登機證與機票購票證明單(或代收轉付收據)<br><br>
                                                若遺失登機證者，請檢附足資證明出國事實之護照影本代替,但若無法及時提供者，則須自行向航空公司申請搭機證明並負擔相關費用，若前往大陸出差，請檢附台胞證影本代替。<br>
                                            </li>
                                        </ul>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                國外出差交通費申請，請註明起迄地點並附上車票票根或購票證明為原始憑證。<br>
                                            </li>
                                        </ul>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                國外出差旅費之換算匯率將以出國前一日（如逢假日往前順推）臺灣銀行即期賣出參考匯價 為計算基 礎。(此部份由財務部換算成台幣)。<br>
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
            <div class='col-md-6'>
                <div class="form-label-group">
                    <div class="form-group">
                        <label>差旅單</label>
                        <select class="custom-select select2 form-control" id='form_pair_data_id' :disabled='form_action=="edit"'
                                name="form_pair_data_id" required>
                            <option value>請選擇</option>
                            <option v-for='item in travel_grant_datas' :value='item.id' :selected='form_submit_data[dom_id]["form_pair_data_id"]'
                            >
                                {{item.apply_subject}}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-2">
                <div class="form-label-group">
                    <input type="text" id="apply_subject" class="form-control" placeholder="名稱" name="apply_subject"
                           v-model='form_submit_data[dom_id]["apply_subject"]' :disabled='can_edit === false' required>
                    <label for="apply_subject">名稱</label>
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
            <div class='row col-md-12 justify-content-end '>
                <div class='col-md-12 m-1 text-right'>
                    總計  ：  <span>{{plan_fee_count_total}}</span>
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
    import {apiGetDependList,apiGetForm,apiGetPairData} from '../../src/apis/form'
    Vue.component('form-travel_fee_plan', require('../../components/form/form-travel_fee_plan').default);
    export default {
        name: "form-travel_fee",
        props: {
            dom_id: String,
            form_action: String,
            can_edit: Boolean,
            id:Number,
        },
        data() {
            return {
                member_name: '',
                department_name: '',
                travel_grant_datas: [],
                items: [],
                count: 0,
                feeCount: 0,
            }
        },
        computed: {
            ...mapState(['form_submit_data', 'login_user', 'member', 'department','plan_fee_count_total','plan_fee_counts']),
        },
        beforeMount: function () {
        },
        mounted: function () {
            this.initial();
            this.asyncGet();
        },
        methods: {
            async asyncGet() {
                let wait = await this.settime();
                if (wait) {
                    this.getPlanFeeTotal();
                }
            },
            settime() {
                return new Promise((resolve, reject) => {
                    setTimeout(() => {
                        resolve(true)
                    }, 1 * 100)
                });
            },
            initial() {
                var vue = this;
                $('.row').on('click', '[data-action="deleteItem"]', function (e) {
                    vue.deleteItem(e);
                    vue.getPlanFeeTotal();
                });

                this.getTraveGrantData();

                if (this.form_action === 'new') {
                    this.department_name = this.login_user.department;
                    this.member_name = this.login_user.name;
                    $('#' + this.dom_id + ' #form_pair_data_id').change((e, v) => {
                        this.getFromData(e.target.value);
                        this.form_submit_data[this.dom_id]['apply_subject'] = $(e.target).find(':selected').html().trim();
                        this.form_submit_data[this.dom_id]["form_pair_data_id"] = e.target.value;
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
            getPlanFeeTotal(){
                let count = 0;

                if(this.form_submit_data[this.dom_id]["items"] !== undefined) {
                    let formData = this.form_submit_data[this.dom_id]["items"];
                    if (formData) {

                        Object.keys(formData).forEach((key) => {
                            let tmpData = formData[key]['fee_items'];

                            Object.keys(tmpData).forEach((key) => {
                                count += parseInt(tmpData[key]['fee']);
                            });
                        });
                    }
                }
                this.$store.state.plan_fee_count_total = count;
                this.feeCount = count;
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
                    member_id: this.login_user.id
                };

                if(this.form_action == 'new'){
                    /*TODO:: 確認簽核流程完成 拉回來的資料還需要再做判斷處理*/
                    apiGetDependList(data)
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
                    let id = this.form_submit_data[this.dom_id]['form_pair_data_id'];
                    apiGetPairData({id:id})
                        .then(function (response) {
                            let result = response.data;
                            if (result.status !== 1) {
                                alert(result.message);
                                return false;
                            }
                            vue.travel_grant_datas = [{id:result.data.id,apply_subject:result.data.apply_subject}];
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }

            },
            getFormTravelGrantPlans(data) {
                let vue = this;
                // let data = Object.assign([], vue.form_submit_data[vue.dom_id]['items']);

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
            async getFromData(id) {
                let vue = this;
                if(id === undefined || id === ''){
                    vue.items = [];
                    vue.form_submit_data[vue.dom_id]['items'] = {};
                }else{
                    vue.items = [];
                    let data;
                    vue.travel_grant_datas.map((v)=>{
                        if( parseInt(id) === parseInt(v['id'])){
                            // vue.form_submit_data[vue.dom_id]["items"] = JSON.parse(v['value']);
                            data = JSON.parse(v['value']);
                        }
                    });
                    let wait = await vue.settime();
                    if (wait) {
                        vue.getFormTravelGrantPlans(data);
                    }
                }
            },
            deleteItem(event) {
                let vue = this;
                let id = $(event.currentTarget).data('id');
                delete vue.plan_fee_counts[id];
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
            plan_fee_count_total : {
                deep: true,
                immediate: true,
                handler(val, oldVal) {
                    this.feeCount = val;
                },
            }
        }
    }
</script>

<style scoped>

</style>
