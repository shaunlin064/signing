<template>
    <form onsubmit="return false" class="steps-validation wizard-circle" :id='dom_id'>
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
                            <option value>請選擇</option>
                            <option value="form-payment">請款</option>
                            <option value="form-sign">用印</option>
                            <option value="form-social">交際送禮</option>
                            <option value="form-refund">代墊</option>
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
            <component v-bind:is="form_type" :dom_id='form_type' :form_action='"new"' :can_edit='true'/>
        </keep-alive>
        <div class='row border-top-light mt-2 justify-content-end' v-show='form_type'>
            <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light text-right mt-2"
                    @click='submit' :disabled='lodding'>
                <span role="status" aria-hidden="true" class="spinner-grow spinner-grow-sm" v-show='lodding'></span>
                送出
            </button>
        </div>
    </form>
</template>

<script>
    import {mapState} from 'vuex';

    export default {
        name: "form_new",
        components: {
            // Payment, Sign
        },
        props: {
            form_config: Object,
        },
        data() {
            return {
                form_type: '',
                already_open: [],
                dom_id: 'form-new',
                dom_target: 'form_type',
                lodding: false,
                validate_message: {},
            }
        },
        computed: {
            ...mapState(['form_submit_data', 'login_user', 'member', 'department']),

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
                let vue = this;
                vue.form_type = event.target.value;
                /*get formConfig*/
                let selectFormConfig = {};
                Object.keys(formConfig).forEach(key => {
                    if (formConfig[key]['html_name'] === vue.form_type) {
                        selectFormConfig = formConfig[key];
                    }
                });
                /*set default*/
                if (eval(`this.form_submit_data['${vue.form_type}']`) === undefined) {
                    eval(`this.form_submit_data['${vue.form_type}'] = {};`);
                    let column = selectFormConfig.column;

                    eval(`vue.form_submit_data['${vue.form_type}']['form_id'] = '${selectFormConfig['id']}';`);
                    Object.keys(column).forEach(columnName => {
                        /*TODO::set fake default 之後待討論驗證與形態問題*/
                        eval(`vue.form_submit_data['${vue.form_type}']['${columnName}'] = '';`);

                        /*default Array*/
                        if ($.inArray(columnName, ['form_stamp_type', 'accompany_user_id', 'attend_member', 'apply_attachment']) != -1) {
                            eval(`vue.form_submit_data['${vue.form_type}']['${columnName}'] = [];`);
                        }
                        /*default Object*/
                        if ($.inArray(columnName, ['items']) != -1) {
                            eval(`vue.form_submit_data['${vue.form_type}']['${columnName}'] = {};`);
                        }
                    });
                    eval(`vue.form_submit_data['${vue.form_type}']['apply_member_id'] = '${vue.login_user.id}';`);
                    eval(`vue.form_submit_data['${vue.form_type}']['apply_department_id'] = '${vue.login_user.department_id}';`);
                }
            },
            initial() {
                $(".select2").select2({
                    dropdownAutoWidth: true,
                    width: '100%'
                });
                $('#' + this.dom_target).change((e) => {
                    this.currentComponent(e);
                });
            },
            validate() {
                let vue = this;
                let data = this.getPostData();
                this.lodding = true;
                vue.validate_message = {};
                let checkColumn = ['apply_attachment', 'remark'];
                switch (vue.form_type) {
                    case 'form-payment':
                        checkColumn.push('campaign_id');
                        break;
                    case 'form-sign':
                        checkColumn.push('recipient_company', 'recipient_contact', 'recipient_phone', 'recipient_address');
                        break;
                }
                Object.keys(data).forEach(key => {
                    if (data[key].length == 0) {
                        if ($.inArray(key, checkColumn) === -1) {
                            console.log(checkColumn, $.inArray(key, checkColumn),key);
                            vue.lodding = false;
                            vue.validate_message[key] = 'required';
                        }
                    }
                });
                if (Object.keys(vue.validate_message).length !== 0) {
                    return true; // 如果为空,返回false
                }
                return false;

            },
            submit() {
                this.lodding = true;
                let data = this.getPostData();
                let vue = this;

                /*post validate*/
                let type = this.validate();
                console.log(type);
                if (type) {
                    return false;
                }
                // console.log('post success');
                /* some Array need to Json*/
                data = this.toJson(data);

                /*TODO::post 後續轉跳與錯誤動作*/
                axios.post('api/form/apply', data)
                    .then(function (response) {
                        let result = response.data;
                        if(result.status != 1 || result.status_string !== '申請成功'){
                            alert(result.message + result.status_string);
                            vue.lodding = false;
                            return false;
                        }
                        javascript:location.href='/form-list';

                    })
                    .catch(function (error) {
                        console.log(error);
                        alert(error);
                    });

            },
            getPostData() {
                return Object.assign({}, eval(`this.form_submit_data['${this.form_type}']`));
            },
            toJson(data) {
                /* other Array to Json*/
                Object.keys(data).forEach(columnName => {
                    if ($.inArray(columnName, ['form_stamp_type', 'accompany_user_id', 'attend_member', 'apply_attachment']) != -1) {
                        data[columnName] = JSON.stringify(data[columnName]);
                    }
                });
                /*travel_fee*/
                if (data['items'] !== undefined) {
                    let itemsData = data['items'];
                    Object.keys(itemsData).forEach(key => {

                        if (itemsData[key]['fee_items'] !== undefined) {
                            itemsData[key]['fee_items'] = JSON.stringify(itemsData[key]['fee_items']);
                        }
                    });
                    data['items'] = itemsData;
                }
                return data;
            },
        },
        updated() {
            let vue = this;
            vue.initial();
            /*file upload*/
            if (vue.already_open.indexOf(vue.form_type) === -1) {
                vue.already_open.push(vue.form_type);
                $("#" + vue.form_type + " #file_upload").dropzone({
                    addRemoveLinks: true,
                    thumbnailWidth: 300,
                    thumbnailHeight: 300,
                    url: "/api/system/upload",
                    init: function () {
                        let formPostAttachment = vue.form_submit_data[vue.form_type].apply_attachment;
                        this.on("sending", function (file, xhr, formData) {
                            formData.append("dir", vue.form_type);
                            vue.lodding = true;
                        });
                        this.on("success", function (file, responseText) {
                            if (responseText.status != 1) {
                                alert(responseText.status_string + responseText.message);
                                return false;
                            }
                            let anchorEl = document.createElement('a');
                            anchorEl.setAttribute('href', responseText.data.url);
                            anchorEl.setAttribute('target', '_blank');
                            anchorEl.setAttribute('class', 'cursor-pointer');

                            anchorEl.innerHTML = "<br>Download";
                            file.previewTemplate.appendChild(anchorEl);
                            formPostAttachment.push({
                                name: file.name,
                                size: file.size,
                                type: file.type,
                                width: file.width,
                                height: file.height,
                                url: responseText.data.url
                            });
                            vue.lodding = false;
                        });
                        this.on("removedfile", function (file) {
                            vue.form_submit_data[vue.form_type].apply_attachment.map((e, k) => {
                                if (e.name === file.name) {
                                    vue.form_submit_data[vue.form_type].apply_attachment.splice(k, 1);
                                    console.log(vue.form_submit_data[vue.form_type].apply_attachment);
                                }
                            });
                            vue.lodding = false;
                        });
                    }
                });
            }
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
