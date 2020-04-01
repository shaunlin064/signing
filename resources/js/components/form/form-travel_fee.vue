<template>
    <fieldset>
        <div class="row col-md-12 align-items-center">
            <div class="card">
                <h4 class="card-title">差旅費用報銷單</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-label-group">
                    <input type="text" class="form-control"
                            name="member">
                    <label>申請人</label>
                </div>
            </div>
            <div class='col-md-6'>
                <div class="form-label-group">
                    <input type="text"  class="form-control"
                           placeholder="部門" name="department">
                    <label>部門</label>
                </div>
            </div>
            <div class='col-md-12'>
                <div class="form-label-group">
                    <div class="form-group">
                        <label>差旅單</label>
                        <select class="custom-select select2 form-control" id='form_travel_grant_id'
                                name="form_travel_grant_id">
                            <option>請選擇</option>
                            <option v-for='(item, index) in travel_grant_datas' :value='index'>{{item.name}}</option>
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
            <components v-for="item in plan_items" v-bind:is="item.type" :key='item.id'
                        :id='item.id'
                        :date='item.date'
                        :customer_name='item.customer_name'
                        :customer_company='item.customer_company'
                        :meet_type='item.meet_type'
                        :agenda='item.agenda'
                        :charge_user='item.charge_user'
            ></components>
            <div class='row col-md-12 justify-content-end border-top-light' v-show='plan_items[0]'>
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
                                        name="remark"></textarea>
                    <label for="remark">備註</label>
                </fieldset>
            </div>
        </div>
    </fieldset>
</template>

<script>
    import {mapState, mapMutations, mapActions, mapGetters} from 'vuex';
    Vue.component('form-travel_fee_plan', require('../../components/form/form-travel_fee_plan').default);
        export default {
            name: "form-travel_fee",
            props: {

            },
            data() {
                return {
                    travel_grant_datas:[],
                    plan_items:[],
                    count: 0
                }
            },
            computed: {
                ...mapState([]),
            },
            beforeMount: function () {
            },
            mounted: function () {
                this.initial();
            },
            methods: {
                initial(){
                  $('#form_travel_grant_id').change((e,v)=>{
                      let targetDom = e.currentTarget;
                      this.plan_items = [];
                      this.count = 0;
                      this.getFormTravelGrantPlans(targetDom);
                  });
                    this.getTraveGrantData();

                },
                addItem(){
                    this.plan_items.push({
                        type: 'form-travel_fee_plan',
                        action: 'edit_form',
                        id: this.count++
                    });
                    this.initial();
                },
                getTraveGrantData(){
                    let fackData = [
                        {
                            id: 1,
                            member: 'test',
                            department: 'test',
                            name: '日本出差-part1',
                            plans: [{
                                id: 1,
                                date: '2020/04/01',
                                customer_name:'Noda Nobuyoshi',
                                customer_company: '日本總部',
                                meet_type: '公司開會',
                                agenda: '討論明年計畫',
                                charge_user: 187,
                            },{
                                id: 2,
                                date: '2020/04/01',
                                customer_name:'Noda Nobuyoshi',
                                customer_company: '日本總部',
                                meet_type: '餐敘',
                                agenda: '還沒講完,中午吃飯繼續講',
                                charge_user: 187,
                            },{
                                id: 3,
                                date: '2020/04/01',
                                customer_name:'Noda Nobuyoshi',
                                customer_company: '日本總部',
                                meet_type: '餐敘',
                                agenda: '還沒講完,下午茶繼續講',
                                charge_user: 187,
                            },
                            ]
                        },{
                            id: 2,
                            member: 'test',
                            department: 'test',
                            name: '日本出差-part2',
                            plans: [{
                                id: 1,
                                date: '2020/04/02',
                                customer_name:'Noda Nobuyoshi',
                                customer_company: '日本總部',
                                meet_type: '公司開會',
                                agenda: '換人來講明年計畫',
                                charge_user: 179,
                            },{
                                id: 2,
                                date: '2020/04/02',
                                customer_name:'Noda Nobuyoshi',
                                customer_company: '日本總部',
                                meet_type: '餐敘',
                                agenda: '還沒講完,中午吃飯繼續講',
                                charge_user: 179,
                            },{
                                id: 3,
                                date: '2020/04/02',
                                customer_name:'Noda Nobuyoshi',
                                customer_company: '日本總部',
                                meet_type: '餐敘',
                                agenda: '還沒講完,下午茶繼續講',
                                charge_user: 179,
                            },
                            ]
                        }
                    ];
                  this.travel_grant_datas = fackData;
                },
                getFormTravelGrantPlans(targetDom){
                    let index = targetDom.value;
                    let data = this.travel_grant_datas[index]['plans'];
                    let vue = this;
                    data.map((e,v)=>{
                        e.type ='form-travel_fee_plan';
                        e.action = 'edit_form';
                        vue.plan_items.push(e);
                        vue.count = parseInt(e.id) + 1;
                    });
                },
            },
            updated() {
                // console.log('view updated')
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
