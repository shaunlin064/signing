<template>
    <fieldset :id='dom_id'>
        <div class="row col-md-12 align-items-center">
            <div class="card">
                <h4 class="card-title">代墊申請</h4>
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
            <div class='col-md-6'>
                <div class="form-label-group">
                    <input type="text" id="member" class="form-control" placeholder="申請人" :value='member_name' disabled>
                    <label for="member">申請人</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-label-group">
                    <input type="text" id="apply_subject" class="form-control" placeholder="項目" name="apply_subject"
                           v-model='form_submit_data[dom_id]["apply_subject"]' :disabled='form_action !== "new"'>
                    <label for="apply_subject">項目</label>
                </div>
            </div>
        </div>
        <div class="row justify-content-center border-top-light mt-2">
            <div class="row col-md-12">
                <div class="card mt-2">
                    <h4 class="card-title">項目</h4>
                </div>
            </div>
            <component v-for="(item,key) in items" v-bind:is="item.component" :id='item.id' :dom_id='dom_id' :key='item.id'
                       :type='item.type' :form_action='form_action'></component>
            <div class='row col-md-12 justify-content-end border-top-light' v-show='form_action === "new"'>

                <div class='col-md-4 text-right mt-1'>
                    <div class="btn-group dropdown mr-1 mb-1">
                        <button type="button" class="btn btn-outline-primary dropdown-toggle" @click='openMenu'
                                data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            新增
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" @click='addItem("乘車")'>乘車</a>
                            <a class="dropdown-item" @click='addItem("案件")'>案件</a>
                            <a class="dropdown-item" @click='addItem("交際")'>交際</a>
                            <a class="dropdown-item" @click='addItem("其他")'>其他</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class='col-md-12 mt-2'>
                <fieldset class="form-label-group">
                              <textarea class="form-control" id="remark" rows="1" placeholder="備註"
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

    export default {
        name: "form-refund",
        props: {
            dom_id: String,
            form_data: Object,
            form_action: String
        },
        data() {
            return {
                member_name:'',
                department_name:'',
                items: [],
                count: -1
            }
        },
        computed: {
            ...mapState(['form_submit_data','login_user', 'member', 'department']),
        },
        beforeMount: function () {
        },
        mounted: function () {
            this.initial();

        },
        methods: {
            initial() {
                // $(".select2").select2({
                //     dropdownAutoWidth: true,
                //     width: '100%'
                // });
                let vue = this;
                $('.row').on('click', '[data-action="deleteItem"]', function (e) {
                    vue.deleteItem(e);
                });
                if (this.form_action === 'new') {
                    this.department_name = this.login_user.department;
                    this.member_name = this.login_user.name;
                }else{

                    this.department_name = getDepartment(this.form_submit_data[this.dom_id]['apply_department_id']);
                    this.member_name = getMember(this.form_submit_data[this.dom_id]['apply_member_id']);
                    let itemsData = this.form_submit_data[this.dom_id]['items'];

                    Object.keys(itemsData).forEach(key=>{
                        vue.items.push(itemsData[key]);
                    })
                }
            },
            deleteItem(event) {
                // $(event.currentTarget).parents('.row.col-md-12').remove();
                let id =$(event.currentTarget).data('id');
                let vue = this;
                this.items.map((e,k)=>{
                    if(e.id === id){
                        vue.items.splice(k,1);
                        // vue.form_submit_data[vue.dom_id]["items"].splice(k,1);
                        delete vue.form_submit_data[vue.dom_id]["items"][id];
                    }

                });

            },
            openMenu(event) {
                let targetDom = $(event.currentTarget);
                targetDom.parent('.btn-group').addClass('show');
                targetDom.next().addClass('show');
            },
            addItem(type) {
                this.count++;
                // this.items[`${this.count}`] ={
                //     component: 'form-refund-items',
                //     form: type,
                //     id: this.count,
                // };
                // console.log(this.count);


                this.items.push({
                    component: 'form-refund-items',
                    type: type,
                    id: this.count,
                });
                this.form_submit_data[this.dom_id]["items"][this.count] = {
                    component: 'form-refund-items',
                    type: type,
                    id: this.count,
                    item:'',
                    date: '',
                    get_on_start:'',
                    campaign_id:'',
                    gift_id:'',
                    price:'',

                };
                // console.log(this.count);
                // this.form_submit_data[this.dom_id]["items"].push({
                //     component: 'form-refund-items',
                //     form: type,
                //     id: this.count,
                //     name:'',
                //     date: '',
                //     departure:'',
                //     serial_number:'',
                //     price:'',
                // });
                console.log(this.count);
                // this.initial();
            }
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
