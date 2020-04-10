<template>

    <form action="#" method='GET' class="steps-validation wizard-circle" :id='dom_id'>
        <!-- Step 1 -->
        <h6><i class="step-icon feather icon-home"></i> Step 1</h6>
        <fieldset>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="form-group">
                        <label :for="dom_target">
                            請選擇簽核表單
                        </label>
                        <select class="custom-select select2 form-control" :id="dom_target" :name="dom_target">
                            <option value >請選擇</option>
                            <option value="form-payment" >請款</option>
                            <option value="form-sign">用印</option>
                            <option value="form-refund">代墊</option>
                            <option value="form-social">交際送禮</option>
                            <option value="form-travel_grant">差旅申請</option>
                            <option value="form-travel_fee">差旅費用核銷</option>
                        </select>
                    </div>
                </div>
            </div>
        </fieldset>
        <!-- Step 2 -->
        <h6 v-show='form_type'><i class="step-icon feather icon-briefcase"></i> Step 2</h6>
        <keep-alive>
            <component v-bind:is="form_type" :dom_id='form_type' :form_action='"new"'/>
        </keep-alive>
        <div class='row border-top-light mt-2 justify-content-end' v-show='form_type'>
            <button type="button" class="btn btn-primary mr-1 mb-1 waves-effect waves-light text-right mt-2" @click='submit'>送出</button>
        </div>
    </form>
</template>

<script>
    import {mapState, mapMutations, mapActions, mapGetters} from 'vuex';
    export default {
        name: "form_new",
        components: {
            // Payment, Sign
        },
        props: {
            form_config:Object,
        },
        data() {
            return {
                form_type : '',
                already_open: [],
                dom_id: 'form-new',
                dom_target: 'form_type',
            }
        },
        computed: {
            ...mapState(['form_submit_data','login_user', 'member', 'department']),

        },
        beforeMount: function () {
        },
        mounted: function () {

            $(document).ready(() => {
                this.initial();
            });
        },
        methods: {
            currentComponent(event) {
                let formConfig = this.form_config;
                let form_type = event.target.value;
                let vue = this;
                let token = $('input[name="_token"]').val();
                /*get formConfig*/
                let selectFormConfig = {};
                Object.keys(formConfig).forEach(key=>{
                    if(formConfig[key]['html_name'] === form_type){
                        selectFormConfig = formConfig[key];
                    }
                });
                vue.form_type = event.target.value;
                /*set default*/
                if(eval(`this.form_submit_data['${vue.form_type}']`) === undefined){
                    eval(`this.form_submit_data['${vue.form_type}'] = {};`);
                    let column = selectFormConfig.column;

                    eval(`vue.form_submit_data['${vue.form_type}']['form_id'] = '${selectFormConfig['id']}';`);
                    Object.keys(column).forEach(key=>{
                        /*TODO::set fake default 之後待討論驗證與形態問題*/
                        eval(`vue.form_submit_data['${vue.form_type}']['${key}'] = '1';`);
                    });
                    eval(`vue.form_submit_data['${vue.form_type}']['apply_member_id'] = '${vue.login_user.id}';`);
                    eval(`vue.form_submit_data['${vue.form_type}']['apply_department_id'] = '${vue.login_user.department_id}';`);
                }

            },
            initial(){
                $(".select2").select2({
                    dropdownAutoWidth: true,
                    width: '100%'
                });
                $('#'+this.dom_target).change((e)=>{
                    this.currentComponent(e);
                });
            },
            submit(){
                $('select[disabled]').removeAttr("disabled");
                // $('form#'+this.dom_id).submit();
                /*TODO::form submit error*/
                let data = eval(`this.form_submit_data['${this.form_type}']`);
                if(data['apply_attachment'] === ''){
                    // delete data.column.apply_attachment;
                    data['apply_attachment'] = '0';
                }

                axios.post('api/form/apply', data)
                    .then(function (response) {
                        console.log(response);

                    })
                    .catch(function (error) {
                        console.log(error);
                    });

            },
        },
        updated() {
            this.initial();
            if(this.already_open.indexOf(this.form_type) === -1){
                this.already_open.push(this.form_type);
                $("#"+this.form_type+" #file_upload").dropzone({url: "/file/post"});
            }
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
