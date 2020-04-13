<template>
    <fieldset :id='dom_id'>
        <div class="row col-md-12 align-items-center">
            <div class="card">
                <h4 class="card-title">差旅申請單</h4>
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
            <div class='col-md-6 mt-2'>
                <div class="form-label-group">
                    <input type="text" id="apply_subject" class="form-control" placeholder="項目" name="apply_subject"
                           v-model='form_submit_data[dom_id]["apply_subject"]' :disabled='form_action !== "new"'>
                    <label for="apply_subject">出差事由</label>
                </div>
            </div>
            <div class='col-md-6'>
                <div class="form-group">
                    <label>出差人</label>
                    <select class="custom-select select2 form-control" multiple="multiple"
                            name="accompany_user_id" v-model='form_submit_data[dom_id]["accompany_user_id"]'
                            :disabled='form_action !== "new"'>
                        <option value>請選擇</option>
                        <option v-for='item in member' :value='item.id'>{{item.name}}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-label-group">
                    <input type="text" id="travel_date_start" class="form-control"
                           placeholder="出差起始日期"
                           name="travel_date_start" v-model='form_submit_data[dom_id]["travel_date_start"]'
                           :disabled='form_action !== "new"'>
                    <label for="travel_date_start">出差起始日期</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-label-group">
                    <input type="text" id="travel_date_end" class="form-control"
                           placeholder="出差結束日期"
                           name="travel_date_end" v-model='form_submit_data[dom_id]["travel_date_end"]'
                           :disabled='form_action !== "new"'>
                    <label for="travel_date_end">出差結束日期</label>
                </div>
            </div>
            <div class='col-md-6'>
                <div class="form-label-group">
                    <input type="text" id="travel_location" class="form-control"
                           placeholder="出差地點"
                           name="travel_location" v-model='form_submit_data[dom_id]["travel_location"]'
                           :disabled='form_action !== "new"'>
                    <label for="travel_location">出差地點</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-label-group">
                    <input type="text" id="travel_stay_location" class="form-control"
                           placeholder="住宿地點" name="travel_stay_location"
                           v-model='form_submit_data[dom_id]["travel_stay_location"]'
                           :disabled='form_action !== "new"'>
                    <label for="travel_stay_location">住宿地點</label>
                </div>
            </div>

            <div class='col-md-6'>
                <div class="form-label-group">
                    <input type="text" id="predict_cost" class="form-control"
                           placeholder="預估費用(台幣)"
                           name="predict_cost" v-model='form_submit_data[dom_id]["predict_cost"]'
                           :disabled='form_action !== "new"'>
                    <label for="predict_cost">預估費用(台幣)</label>
                </div>
            </div>
            <div class='col-md-12'>
                <fieldset class="form-label-group">
                            <textarea class="form-control" id="travel_remark" rows="1" placeholder="出差事由詳述"
                                      v-model='form_submit_data[dom_id]["travel_remark"]'
                                      :disabled='form_action !== "new"'
                                      name="travel_remark"></textarea>
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
            <components v-for="(item,key) in items" v-bind:is="item.component" :key='item.id' :id='item.id'
                        :dom_id='dom_id' :plan_action='"new_plan"'></components>
            <div class='row col-md-12 justify-content-end'>
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
                                        v-model='form_submit_data[dom_id]["remark"]' :disabled='form_action !== "new"'
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
            form_action: String
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
            },
            addItem() {
                this.count++;
                this.items.push({
                    component: 'form-travel_fee_plan',
                    id: this.count
                });
                this.form_submit_data[this.dom_id]["items"][this.count] = {
                    component: 'form-travel_fee_plan',
                    action: 'new_form',
                    id: this.count,
                    name: '',
                    date: '',
                    customer_name: '',
                    customer_company: '',
                    meet_type: '',
                    agenda:'',
                    charge_user:'',
                };
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
