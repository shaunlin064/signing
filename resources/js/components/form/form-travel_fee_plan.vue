<template>
    <div class="row col-md-12 border-light">
        <div class='row col-md-12 mt-1 mb-1'>
            <div class='col-md-10'>
                <label>{{parseInt(id)}}</label>
            </div>

            <div class='col-md-2 text-right' v-if='action === "new_form"'>
                <button type="button" data-action='deleteItem' :data-id='id'
                        class="btn btn-icon btn-danger mr-1 mb-1 waves-effect waves-light">
                    <i
                        class="feather icon-x"></i></button>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-label-group">
                <input type="text" class="form-control"
                       placeholder="日期" :name='"items["+id+"][plan][date]"' :value='date' :readonly='date'>
                <label>日期</label>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-label-group">

                <input type="text" class="form-control" :name='"items["+id+"][plan][customer_company]"'
                       placeholder="洽訪公司" :value='customer_company' :readonly='customer_company'
                >
                <label>洽訪公司</label>
            </div>
        </div>
        <div class='col-md-3'>
            <div class="form-label-group">
                <input type="text" class="form-control"  :value='customer_name' :readonly='customer_name'
                       placeholder="對象姓名/稱謂" :name='"plan["+id+"][customer_name]"' >
            </div>
        </div>
        <div class='col-md-3'>
            <div class="form-label-group">
                <input type="text" class="form-control" :name='"plan["+id+"][meet_type]"'  :value='meet_type' :readonly='meet_type'
                       placeholder="會議形式"
                      >
                <label>會議形式</label>
            </div>
        </div>
        <div class='col-md-6'>
            <div class="form-group">
                <label>負責業務</label>
                <!--TODO:: form submit removeAttr disabled-->
                <select class="custom-select select2 form-control"  :name='"plan["+id+"][charge_user]"'  :disabled='charge_user'
                        >
                    <option value>請選擇</option>
                    <option v-for='item in all_user' :value='item.id' :selected='charge_user == item.id'>{{item.name}}</option>
                </select>
            </div>
        </div>
        <div class='col-md-6'>
            <div class="form-label-group mt-2">
                <input type="text" class="form-control" :name='"plan["+id+"][agenda]"' :readonly='agenda' :value='agenda'
                       placeholder="洽談內容"
                       >
                <label >洽談內容</label>
            </div>
        </div>
        <div class='row col-md-12' v-if='action !== "new_form"'>
            <div class="row col-md-12 mt-2">
                <div class='col-md-6'>
                    <div class="card">
                        <h5 class="card-title">費用明細</h5>
                    </div>
                </div>
                <div class='col-md-6 justify-content-end'>
                    <div class='text-right mt-1'>
                        <button type="button" @click='addItem'
                                class="btn btn-outline-primary mr-1 mb-1 waves-effect waves-light">
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
                action: String,
                id: Number,
                date: String,
                customer_name: String,
                customer_company: String,
                meet_type: String,
                agenda: String,
                charge_user: Number,
            },
            data() {
                return {
                    all_user : [

                    ],
                    plan_fee:[

                    ],
                    count:0
                }
            },
            computed: {
                    ...mapState([]),
            },
            beforeMount: function () {
            },
            mounted: function () {
                var vue = this;
                $('.row').on('click','[data-action="deleteItem"]',function(e){
                    vue.deleteItem(e);
                });
                this.initial();
            },
            methods: {
                initial(){
                  this.getAllUser();

                },
                /*TODO::all user Data in Vuex*/
                getAllUser(){
                    let fack = [
                        {
                            id:179,
                            name:'Johnny'
                        },
                        {
                            id:187,
                            name:'Elynn'
                        }
                    ];
                    this.all_user = fack;
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
                    this.plan_fee.map((e,v)=>{
                        if(e['id'] == id){
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
