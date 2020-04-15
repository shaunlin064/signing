<template>
    <fieldset :id='dom_id'>
        <div class="row col-md-12 align-items-center">
            <div class="card">
                <h4 class="card-title">差旅費用報銷單</h4>
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
                        <select class="custom-select select2 form-control" id='form_travel_grant_id'
                                name="form_travel_grant_id">
                            <option value>請選擇</option>
                            <option v-for='item in travel_grant_datas' :value='item.id'>
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
            <components v-for="item in items" v-bind:is="item.component" :key='item.id'
                        :id='item.id' :dom_id='dom_id' :plan_action='item.plan_action' :form_action='form_action'

            ></components>
            <div class='row col-md-12 justify-content-end border-top-light' v-show='items[0]'>
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
            form_action: String
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

                if (this.form_action === 'new') {
                    this.department_name = this.login_user.department;
                    this.member_name = this.login_user.name;
                } else {
                    this.department_name = getDepartment(this.form_submit_data[this.dom_id]['apply_department_id']);
                    this.member_name = getMember(this.form_submit_data[this.dom_id]['apply_member_id']);
                    let itemsData = this.form_submit_data[this.dom_id]['items'];

                    Object.keys(itemsData).forEach(key => {
                        vue.items.push(itemsData[key]);
                    })
                }
                this.getTraveGrantData();
                $('#' + this.dom_id + ' #form_travel_grant_id').change((e, v) => {
                    this.getFromData(e.target.value);
                    this.form_submit_data[this.dom_id]["form_travel_grant_id"] = e.target.value;
                });
            },
            addItem() {
                this.count++;
                this.items.push({
                    component: 'form-travel_fee_plan',
                    plan_action: 'new_plan',
                    id: this.count
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
                let fackData = [
                    {
                        id: 1,
                        member: 'test',
                        department: 'test',
                        name: '日本出差-part1',
                        items: [{
                            id: 0,
                            date: '2020/04/01',
                            customer_name: 'Noda Nobuyoshi',
                            customer_company: '日本總部',
                            meet_type: '公司開會',
                            agenda: '討論明年計畫',
                            charge_user: 187,
                        }, {
                            id: 1,
                            date: '2020/04/01',
                            customer_name: 'Noda Nobuyoshi',
                            customer_company: '日本總部',
                            meet_type: '餐敘',
                            agenda: '還沒講完,中午吃飯繼續講',
                            charge_user: 187,
                        }, {
                            id: 2,
                            date: '2020/04/01',
                            customer_name: 'Noda Nobuyoshi',
                            customer_company: '日本總部',
                            meet_type: '餐敘',
                            agenda: '還沒講完,下午茶繼續講',
                            charge_user: 187,
                        },
                        ]
                    }, {
                        id: 2,
                        member: 'test',
                        department: 'test',
                        name: '日本出差-part2',
                        items: [{
                            id: 0,
                            date: '2020/04/02',
                            customer_name: 'Noda Nobuyoshi',
                            customer_company: '日本總部',
                            meet_type: '公司開會',
                            agenda: '換人來講明年計畫',
                            charge_user: 179,
                        }, {
                            id: 1,
                            date: '2020/04/02',
                            customer_name: 'Noda Nobuyoshi',
                            customer_company: '日本總部',
                            meet_type: '餐敘',
                            agenda: '還沒講完,中午吃飯繼續講',
                            charge_user: 179,
                        }, {
                            id: 2,
                            date: '2020/04/02',
                            customer_name: 'Noda Nobuyoshi',
                            customer_company: '日本總部',
                            meet_type: '餐敘',
                            agenda: '還沒講完,下午茶繼續講',
                            charge_user: 179,
                        },
                        ]
                    }
                ];
                // this.form_submit_data[this.dom_id]['items'] = fackData;
                let vue = this;
                let data = {
                    form_id: 5,
                    apply_member_id: this.login_user.id
                };
                /*TODO:: 確認簽核流程完成 拉回來的資料還需要再做判斷處理*/
                axios.post('api/form/all', data)
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
