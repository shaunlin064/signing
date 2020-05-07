<template>
    <div class="row col-md-12 border-light">
        <div class='row col-md-12 mt-1 mb-1'>
            <div class='col-md-10'>
                <label>{{parseInt(id)}}</label>
            </div>

            <div class='col-md-2 text-right' v-show='can_edit === true && plan_action === "new_plan"'>
                <button type="button" data-action='deleteItem' :data-id='id'
                        class="btn btn-icon btn-danger mr-1 mb-1 waves-effect waves-light">
                    <i
                        class="feather icon-x"></i></button>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-label-group">
                <input type="date" class="form-control"
                       placeholder="日期" v-model='form_submit_data[dom_id]["items"][id]["date"]'
                       :disabled='can_edit === false || plan_action !== "new_plan"' required>
                <label>日期</label>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-label-group">

                <input type="text" class="form-control"
                       placeholder="洽訪公司" v-model='form_submit_data[dom_id]["items"][id]["customer_company"]'
                       :disabled='can_edit === false || plan_action !== "new_plan"' required
                >
                <label>洽訪公司</label>
            </div>
        </div>
        <div class='col-md-3'>
            <div class="form-label-group">
                <input type="text" class="form-control" placeholder="對象姓名/稱謂"
                       v-model='form_submit_data[dom_id]["items"][id]["customer_name"]'
                       :disabled='can_edit === false || plan_action !== "new_plan"' required
                >
                <label>對象姓名/稱謂</label>
            </div>
        </div>
        <div class='col-md-3'>
            <div class="form-label-group">
                <input type="text" class="form-control" placeholder="會議形式"
                       v-model='form_submit_data[dom_id]["items"][id]["meet_type"]'
                       :disabled='can_edit === false || plan_action !== "new_plan"' required
                >
                <label>會議形式</label>
            </div>
        </div>
        <div class='col-md-6'>
            <div class="form-group">
                <label>負責業務</label>
                <!--TODO:: form submit removeAttr disabled-->
                <select class="custom-select select2 form-control"
                        :disabled='can_edit === false || plan_action !== "new_plan"'
                        :id='"charge_user_"+id' required
                >
                    <option value>請選擇</option>
                    <option v-for='item in member' :value='item.id'
                            :selected='form_submit_data[dom_id]["items"][id]["charge_user"] == item.id'>{{item.name}}
                    </option>
                </select>
            </div>
        </div>
        <div class='col-md-6'>
            <div class="form-label-group mt-2">
                <input type="text" class="form-control" v-model='form_submit_data[dom_id]["items"][id]["agenda"]'
                       :disabled='can_edit === false || plan_action !== "new_plan"'
                       placeholder="洽談內容" required
                >
                <label>洽談內容</label>
            </div>
        </div>
        <div class='row col-md-12' v-if='dom_id === "form-travel_fee"'>
            <div class="row col-md-12 mt-2">
                <div class='col-md-6'>
                    <div class="card">
                        <h5 class="card-title">費用明細</h5>
                    </div>
                </div>
                <div class='col-md-6 justify-content-end text-right' v-show='can_edit'>
                    <div class="btn-group dropdown mr-1 mb-1">
                        <button type="button" class="btn btn-outline-primary dropdown-toggle" @click='openMenu'
                                data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            新增
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" @click='addItem("交通")'>交通</a>
                            <a class="dropdown-item" @click='addItem("交際")'>交際</a>
                            <a class="dropdown-item" @click='addItem("漫遊")'>漫遊</a>
                            <a class="dropdown-item" @click='addItem("其他")'>其他</a>
                        </div>
                    </div>
                </div>
            </div>

            <compoenents v-for='item in plan_fee' v-bind:is="item.component" :key='item.id' :id='parseInt(item.id)' :dom_id='dom_id'
                         :parent_id='item.parent_id' :can_edit='can_edit'></compoenents>
            <div class="row col-md-12 justify-content-end text-right">
                <div class="p-1">
                    小計  :  <span class='plan_fee_item_total'>{{ plan_fee_item_total }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapState} from 'vuex';

    Vue.component('form-travel_fee_plan_item', require('../../components/form/form-travel_fee_plan_item').default);
    export default {
        name: "form_travel_fee_plan",
        props: {
            dom_id: String,
            plan_action: String,
            form_action: String,
            can_edit:Boolean,
            id: Number
        },
        data() {
            return {
                plan_fee: [],
                count: -1,
                plan_fee_item_total: 0
            }
        },
        computed: {
            ...mapState(['form_submit_data', 'login_user', 'member', 'department','plan_fee_count_total','plan_fee_counts']),
        },
        beforeMount: function () {
        },
        mounted: function () {
            this.initial();
            this.getPlanFeeItemTotal();
        },
        methods: {
            getPlanFeeItemTotal(){

                let count = 0;

                if(this.form_submit_data[this.dom_id]["items"][this.id] !== undefined) {
                    let formData = this.form_submit_data[this.dom_id]["items"][this.id]['fee_items'];
                    if (formData) {
                        Object.keys(formData).forEach((key) => {
                            count += parseInt(formData[key]['fee']);
                        });
                    }
                    this.$store.state.plan_fee_counts[this.id] = count;
                }

                this.plan_fee_item_total = count;

                let formItemData = this.plan_fee_counts;
                let count2 = 0;
                Object.keys(formItemData).forEach((k)=>{
                    count2 += parseFloat(formItemData[k]);
                });
                this.$store.state.plan_fee_count_total = count2;
            },
            initial() {
                var vue = this;
                $('.row').on('click', '[data-action="deleteItem_fee"]', function (e) {
                    vue.deleteItem(e);
                    vue.getPlanFeeItemTotal();
                });
                $('.row').on('change', '.form-control.price', function (e) {
                    vue.getPlanFeeItemTotal();
                });
                let chargeUserDom = $('#' + vue.dom_id + ' #charge_user_' + vue.id);
                chargeUserDom.change((e, v) => {
                    vue.form_submit_data[vue.dom_id]["items"][vue.id]['charge_user'] = chargeUserDom.val();
                });

                if (vue.form_action === 'edit') {

                    let itemsData = vue.form_submit_data[vue.dom_id]['items'][vue.id]['fee_items'];

                    if(itemsData[0] != undefined){
                        Object.keys(itemsData).forEach(key => {
                            let tmpdata = Object.assign({},itemsData[key]);
                            tmpdata.parent_id = parseInt(vue.id);
                            tmpdata.component = 'form-travel_fee_plan_item';
                            tmpdata.can_edit = vue.can_edit;
                            vue.plan_fee.push(tmpdata);
                            vue.count = tmpdata.id;
                        })
                    }
                }
            },
            openMenu(event) {
                let targetDom = $(event.currentTarget);
                targetDom.parent('.btn-group').addClass('show');
                targetDom.next().addClass('show');
            },
            addItem(type) {
                this.count++;
                this.plan_fee.push({
                    component: 'form-travel_fee_plan_item',
                    id: this.count,
                    parent_id: parseInt(this.id),
                });
                this.form_submit_data[this.dom_id]["items"][this.id]["fee_items"][this.count] = {
                    id: this.count.toString(),
                    type: type,
                    currency: 'TWD',
                    fee: 0,
                };
            },
            deleteItem(target) {
                let id = $(target.currentTarget).data('id');
                let parentId = $(target.currentTarget).data('parent_id');
                let vue = this;
                this.plan_fee.map((e, k) => {
                    if (e['id'] == id && e['parent_id'] == parentId) {
                        this.plan_fee.splice(k, 1);
                        delete vue.form_submit_data[vue.dom_id]["items"][parentId]["fee_items"][id];
                    }
                });

            }
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
