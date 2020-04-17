<template>
    <fieldset :id='dom_id'>
        <div class="row col-md-12 align-items-center">
            <div class="card">
                <h4 class="card-title">交際送禮</h4>
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
            <div class="col-md-6">
                <div class="form-label-group">
                    <input type="text" id="apply_subject" class="form-control" placeholder="名稱" name="apply_subject"
                           v-model='form_submit_data[dom_id]["apply_subject"]' :disabled='can_edit === false'>
                    <label for="apply_subject">名稱</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-label-group">
                    <input type="text" id="date" class="form-control" placeholder="日期"
                           name="date" v-model='form_submit_data[dom_id]["date"]' :disabled='can_edit === false'>
                    <label for="date">日期</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="type">類型</label>
                    <select class="custom-select select2 form-control" id="type"
                            name="type" v-model='form_submit_data[dom_id]["type"]' :disabled='can_edit === false'>
                        <option value>請選擇</option>
                        <option value="flower">送花</option>
                        <option value="meal">餐敘</option>
                        <option value="gift">送禮</option>
                        <option value="other">其他</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <div class="form-group">
                        <label>出席人員</label>
                        <select class="custom-select select2 form-control" multiple="multiple" id='attend_member'
                                name="attend_member" v-model='form_submit_data[dom_id]["attend_member"]'
                                :disabled='can_edit === false'>
                            <option v-for='item in member' :value='item.id'>{{item.name}}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-label-group">
                    <input type="text" id="customer_company" class="form-control"
                           placeholder="客戶公司名稱" name="customer_company" v-model='form_submit_data[dom_id]["customer_company"]' :disabled='can_edit === false'>
                    <label for="customer_company">客戶公司名稱</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-label-group">
                    <input type="text" id="customer_name" class="form-control"
                           placeholder="對象" name="customer_name" v-model='form_submit_data[dom_id]["customer_name"]' :disabled='can_edit === false'>
                    <label for="customer_name">對象</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-label-group">
                    <input type="text" id="cost" class="form-control"
                           placeholder="預估費用"
                           name="cost" v-model='form_submit_data[dom_id]["cost"]' :disabled='can_edit === false'>
                    <label for="cost">預估費用</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-label-group">
                    <fieldset class="form-label-group">
                            <textarea class="form-control" id="remark" rows="1" placeholder="備註" v-model='form_submit_data[dom_id]["remark"]' :disabled='can_edit === false'
                                      name="remark"></textarea>
                        <label for="remark">備註</label>
                    </fieldset>
                </div>
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
    import {mapState, mapMutations, mapActions, mapGetters} from 'vuex';

        export default {
            name: "form-social",
            props: {
                dom_id:String,
                form_data: Object,
                form_action: String,
                can_edit: Boolean,
            },
            data() {
                return {
                    member_name:'',
                    department_name:'',
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
                initial(){
                    let vue = this;
                    if (vue.form_action === 'new') {
                        vue.department_name = vue.login_user.department;
                        vue.member_name = vue.login_user.name;
                    }else{
                        vue.department_name = getDepartment(vue.form_submit_data[vue.dom_id]['apply_department_id']);
                        vue.member_name = getMember(vue.form_submit_data[vue.dom_id]['apply_member_id']);
                    }

                    ['type','attend_member'].map(k =>{
                        let targetDom = $(`#${vue.dom_id} #${k}`);
                        targetDom.change(() => {
                            vue.form_submit_data[vue.dom_id][k] = targetDom.val();
                        });
                    });
                }
            },
            updated() {

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
