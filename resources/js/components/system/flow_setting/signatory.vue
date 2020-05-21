<template>
    <ul class="todo-task-list-wrapper media-list" :data-id='flow_submit_data[form_type][id]["id"]'>
        <li class="list-group-item">
            <div class='row'>
                <div class='row col-md-1 align-items-center justify-content-md-center'>
                    <p>{{order}}</p>
                </div>
                <div class='row col-md-10'>
                    <div class='col-md-2 col-sm-6 mt-2'>
                        <div class="form-label-group">
                            <input type="text" class="form-control" placeholder="名稱"
                                   v-model='flow_submit_data[form_type][id]["name"]'
                                   required>
                            <label>名稱</label>
                        </div>
                    </div>
                    <div class='col-md-2 col-sm-6'>
                        <div class="form-group">
                            <label>簽核者</label>
                            <select class="custom-select select2 form-control" data-action='reviewer_id' :data-id='id' v-model='flow_submit_data[form_type][id]["reviewer_id"]' required>
                                <option v-if='review_type == 1' v-for='item in member' :value='item.id'>{{item.name}}</option>
                                <option v-if='review_type == 2' v-for='item in config.supervisor' :value='item.id'>{{item.name}}</option>
                                <option v-if='review_type == 3' v-for='item in config.own' :value='item.id'>{{item.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class='col-md-2 col-sm-6'>
                        <div class="form-group">
                            <label>類型</label>
                            <select class="custom-select select2 form-control" v-model='flow_submit_data[form_type][id]["review_type"]' data-action='review_type' :data-id='id' required>
                                <option value='1'>user</option>
                                <option value='2'>主管</option>
                                <option value='3'>申請人</option>
                            </select>
                        </div>
                    </div>
                    <div class='col-md-2 col-sm-6'>
                        <div class="form-group">
                            <label>身份</label>
                            <select class="custom-select select2 form-control" v-model='flow_submit_data[form_type][id]["role"]' data-action='role' :data-id='id' required>
                                <option value="1">簽核</option>
                                <option value="2">執行</option>
                            </select>
                        </div>
                    </div>
                    <div class='row col-md-4 col-sm-6'>
                        <div class="col-sm-auto vs-checkbox-con vs-checkbox-primary">
                            <input type="checkbox" v-model='flow_submit_data[form_type][id]["overwrite"]'>
                            <span class="vs-checkbox">
                                              <span class="vs-checkbox--check">
                                                <i class="vs-icon feather icon-check"></i>
                                              </span>
                                            </span>
                            <span class="">取代</span>
                        </div>
                        <div class="col-sm-auto vs-checkbox-con vs-checkbox-primary">
                            <input type="checkbox" v-model='replace'>
                            <span class="vs-checkbox">
                              <span class="vs-checkbox--check">
                                <i class="vs-icon feather icon-check"></i>
                              </span>
                        </span>
                            <span class="">代簽</span>
                        </div>
                    </div>
                    <div class='col-md-12 col-sm-auto' v-if='replace'>
                        <label>代簽人</label>
                        <select class="custom-select select2 form-control noreplace replace_id" multiple="multiple"
                                v-model='flow_submit_data[form_type][id]["replace_id"]' data-action='replace_id' :data-id='id' :required='replace'>
                            <option v-for='item in member' :value='item.id'>{{item.name}}</option>
                        </select>
                    </div>
                </div>
                <a class="row col-md-1 col-sm-auto todo-item-delete align-items-center justify-content-end" @click='deleteSignatory'><i
                    class="feather icon-trash"></i></a>
            </div>
        </li>
    </ul>
</template>

<script>
    import {mapState} from 'vuex';

    export default {
        name: "signatory",
        props: {
            form_type: String,
            form_id : String,
            index:Number,
            id: Number,
            review_order: Number,
        },
        data() {
            return {
                replace: 0,
                review_type: 1,
                order: 0,
                config:{
                    supervisor: [{name: '一階主管', id:"1"},{name:'最高主管', id:"3"}],
                    own:[{name:'表單申請人',id:"1"}]
                },
                FlowClass(){
                    this.order = this.review_order;
                    return {
                        form_id: this.form_id,
                        id: this.id,
                        name: '',
                        overwrite:0,
                        replace:0,
                        replace_id: [],
                        replace_member:[],
                        review_order: this.order,
                        review_type:1,
                        reviewer_id:0,
                        role:1,
                    }
                }
            }
        },
        computed: {
            ...mapState(['login_user', 'member', 'department', 'flow_submit_data']),
        },
        created: function () {
            bus.$on('getReviewOrder', this.getReviewOrder);
        },
        beforeMount: function () {

            if(this.flow_submit_data[this.form_type][this.id] === undefined){
                this.flow_submit_data[this.form_type][this.id] = this.FlowClass();
            }
            this.getReviewOrder();
        },
        mounted: function () {
            let vue =this;

            ['reviewer_id','role','review_type','replace_id'].map(actionName=>{
                $('.todo-app-list').on('change', '[data-action="'+actionName+'"]', (e, v) => {
                    if(vue.id  == e.currentTarget.dataset.id){
                        vue.flow_submit_data[vue.form_type][vue.id][actionName] = $(e.currentTarget).val()
                        if(actionName === 'review_type'){
                            vue.review_type = $(e.currentTarget).val();
                            vue.flow_submit_data[vue.form_type][vue.id]['reviewer_id'] = 0;
                        }
                    }
                });
            })
            this.replace = this.flow_submit_data[this.form_type][this.id]['replace'];
            this.review_type = this.flow_submit_data[this.form_type][this.id]['review_type'];
            bus.$on('listScroll',this.listScroll);
        },
        methods: {
            listScroll(type = 'top'){
                const dom = $('.todo-task-list.list-group');
                const domHight = dom.prop("scrollHeight");
                if(type === 'top') {
                    dom.scrollTop(0);
                }else{
                    dom.scrollTop(domHight);
                }
            },
            deleteSignatory(){
                bus.$emit('deleteSignatory',this.id);
            },
            getReviewOrder(){
                if(this.flow_submit_data[this.form_type][this.id]){
                    this.order = this.flow_submit_data[this.form_type][this.id]["review_order"];
                    return  this.flow_submit_data[this.form_type][this.id]["review_order"];
                }

            }
        },
        updated() {
            $(".select2").select2({
                dropdownAutoWidth: true,
                width: '100%'
            });
        },
        watch: {
            replace: {
                immediate: false,    // 这句重要
                handler(val, oldVal) {
                    if(!val){
                        this.flow_submit_data[this.form_type][this.id]['replace_id'] = [];
                    }
                    this.flow_submit_data[this.form_type][this.id]['replace'] = this.replace;
                }
            }

        }
    }
</script>

<style scoped>

</style>
