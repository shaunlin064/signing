<template>
    <div class="row col-md-12 border-light">
        <div class='row col-md-12 mt-1 mb-1'>
            <div class='col-md-10'>
                <label>{{parseInt(id)}}</label>
            </div>

            <div class='col-md-2 text-right' v-if='plan_action === "new_plan"'>
                <button type="button" data-action='deleteItem' :data-id='id'
                        class="btn btn-icon btn-danger mr-1 mb-1 waves-effect waves-light">
                    <i
                        class="feather icon-x"></i></button>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-label-group">
                <input type="text" class="form-control"
                       placeholder="日期" v-model='form_submit_data[dom_id]["items"][id]["date"]' :disabled='plan_action !== "new_plan"'>
                <label>日期</label>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-label-group">

                <input type="text" class="form-control"
                       placeholder="洽訪公司" v-model='form_submit_data[dom_id]["items"][id]["customer_company"]' :disabled='plan_action !== "new_plan"'
                >
                <label>洽訪公司</label>
            </div>
        </div>
        <div class='col-md-3'>
            <div class="form-label-group">
                <input type="text" class="form-control"  placeholder="對象姓名/稱謂"  v-model='form_submit_data[dom_id]["items"][id]["customer_name"]' :disabled='plan_action !== "new_plan"'
                       >
                <label>對象姓名/稱謂</label>
            </div>
        </div>
        <div class='col-md-3'>
            <div class="form-label-group">
                <input type="text" class="form-control" placeholder="會議形式" v-model='form_submit_data[dom_id]["items"][id]["meet_type"]' :disabled='plan_action !== "new_plan"'
                      >
                <label>會議形式</label>
            </div>
        </div>
        <div class='col-md-6'>
            <div class="form-group">
                <label>負責業務</label>
                <!--TODO:: form submit removeAttr disabled-->
                <select class="custom-select select2 form-control" :disabled='form_submit_data[dom_id]["items"][id]["charge_user"] !== null'
                        >
                    <option value>請選擇</option>
                    <option v-for='item in member' :value='item.id' :selected='form_submit_data[dom_id]["items"][id]["charge_user"] == item.id' >{{item.name}}</option>
                </select>
            </div>
        </div>
        <div class='col-md-6'>
            <div class="form-label-group mt-2">
                <input type="text" class="form-control" v-model='form_submit_data[dom_id]["items"][id]["agenda"]' :disabled='plan_action !== "new_plan"'
                       placeholder="洽談內容"
                       >
                <label >洽談內容</label>
            </div>
        </div>
        <div class='row col-md-12' v-if='dom_id === "form-travel_fee"'>
            <div class="row col-md-12 mt-2">
                <div class='col-md-6'>
                    <div class="card">
                        <h5 class="card-title">費用明細</h5>
                    </div>
                </div>
                <div class='col-md-6 justify-content-end'>
                    <div class='text-right mt-1'>
                        <button type="button" @click='addItem'
                                class="btn btn-outline-primary mr-1 mb-1 waves-effect waves-light" v-if='form_action==="new"'>
                            新增
                        </button>
                    </div>
                </div>
            </div>
            <compoenents v-for='item in plan_fee' v-bind:is="item.type" :key='item.id' :id='item.id' :parent_id='item.parent_id'></compoenents>
        </div>
    </div>
</template>

<script>
    import {mapState, mapMutations, mapActions, mapGetters} from 'vuex';
    Vue.component('form-travel_fee_plan_item',require('../../components/form/form-travel_fee_plan_item').default);
        export default {
            name: "form_travel_fee_plan",
            props: {
                dom_id:String,
                plan_action: String,
                form_action:String,
                id: Number,
            },
            data() {
                return {
                    plan_fee:[

                    ],
                    count:0
                }
            },
            computed: {
                ...mapState(['form_submit_data', 'login_user', 'member', 'department']),
            },
            beforeMount: function () {
            },
            mounted: function () {
                var vue = this;
                $('.row').on('click','[data-action="deleteItem_fee"]',function(e){
                    vue.deleteItem(e);
                });
                this.initial();
            },
            methods: {
                initial(){
                },
                addItem(){
                    this.plan_fee.push({
                        type: 'form-travel_fee_plan_item',
                        id: this.count++,
                        parent_id: this.id,
                    })
                },
                deleteItem(target){
                    let id = $(target.currentTarget).data('id');
                    let parentId = $(target.currentTarget).data('parent_id');
                    this.plan_fee.map((e,v)=>{
                        if(e['id'] == id && e['parent_id'] == parentId){
                            this.plan_fee.splice(v,1);
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
