<template>
    <fieldset>
        <div class="row col-md-12 align-items-center">
            <div class="card">
                <h4 class="card-title">差旅申請單</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-label-group">
                    <input type="text" id="member" class="form-control"
                           placeholder="申請人" name="member">
                    <label for="member">申請人</label>
                </div>
                <div class="form-label-group">
                    <input type="text" id="name" class="form-control" placeholder="項目"
                           name="name">
                    <label for="name">項目</label>
                </div>
            </div>
            <div class='col-md-6'>
                <div class="form-label-group">
                    <input type="text" id="department" class="form-control"
                           placeholder="部門" name="department">
                    <label for="department">部門</label>
                </div>
            </div>
            <div class='col-md-12'>
                <div class="form-group">
                    <label>出差人</label>
                    <select class="custom-select select2 form-control"  multiple="multiple"
                            name="accompany_user_id">
                        <option value="179">Johnny</option>
                        <option value="187">Elynn</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-label-group">
                    <input type="text" id="receipt_number" class="form-control"
                           placeholder="出差期間"
                           name="receipt_number">
                    <label for="receipt_number">出差期間</label>
                </div>
            </div>
            <div class='col-md-6'>
                <div class="form-label-group">
                    <input type="text" id="receipt_date" class="form-control"
                           placeholder="出差地點"
                           name="receipt_date">
                    <label for="receipt_date">出差地點</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-label-group">
                    <input type="text" id="customer" class="form-control"
                           placeholder="住宿地點" name="customer">
                    <label for="customer">住宿地點</label>
                </div>
            </div>

            <div class='col-md-6'>
                <div class="form-label-group">
                    <input type="text" id="receipt_price" class="form-control"
                           placeholder="預估費用(台幣)"
                           name="receipt_price">
                    <label for="receipt_price">預估費用(台幣)</label>
                </div>
            </div>
            <div class='col-md-12'>
                <fieldset class="form-label-group">
                            <textarea class="form-control" id="travel_remark" rows="1" placeholder="出差事由詳述"
                                      name="travel_remark"></textarea>
                    <label for="remark">出差事由詳述</label>
                </fieldset>
            </div>
        </div>
        <div class="row col-md-12 align-items-center border-top-light mt-2">
            <div class="card mt-1">
                <h4 class="card-title">出差計畫</h4>
            </div>
        </div>
        <div class="row">
            <components v-for="item in plan_items" v-bind:is="item.type" :key='item.id' :id='item.id' :action='item.action'></components>
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
            name: "form-travel_grant",
            props: {

            },
            data() {
                return {
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
                var vue = this;
                $('.row').on('click','[data-action="deleteItem"]',function(e){
                    vue.deleteItem(e);
                });
            },
            methods: {
                addItem(){
                    this.plan_items.push({
                        type: 'form-travel_fee_plan',
                        action: 'new_form',
                        id: this.count++
                    });
                },
                deleteItem(event){
                    let id = $(event.currentTarget).data('id');

                    this.plan_items.map((e,v)=>{
                        if(e['id'] == id){
                            console.log('get');
                            this.plan_items.splice(v,1);
                        }
                    });
                },
            },
            updated() {

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
