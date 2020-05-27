<template>
    <form onsubmit="return false" class="steps-validation wizard-circle" :id='dom_id'>
        <keep-alive>
            <component v-bind:is="form_type" :dom_id='form_type' :csrf_token='csrf_token' :id='id' :form_action='"edit"' :can_edit='can_edit'/>
        </keep-alive>
        <check-point v-show='check_list' :form_id='id' :check_list_props='check_list' :can_check='can_check'
                     :check_id='check_id'></check-point>
        <div class='row border-top-light mt-2 justify-content-end' v-show='form_type && can_edit'>
            <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light text-right mt-2"
                    @click='submit' :disabled='lodding'>
                <span role="status" aria-hidden="true" class="spinner-grow spinner-grow-sm" v-show='lodding'></span>
                <strong>送出</strong>
            </button>
        </div>
    </form>
</template>

<script>
    import {mapState} from 'vuex';
    import form from '../../mixins/form.js';
    import {apiFormEdit, apiFormChecking, apiGetForm} from '../../src/apis/form'
    export default {
        name: "form-edit",
        components: {
            // Payment, Sign
        },
        props: {
            id: Number,
            csrf_token:String,
        },
        mixins: [form],
        data() {
            return {
                form_type: '',
                check_list: null,
                dom_id: 'form-edit',
                init: false,
                can_edit: false,
                lodding: false,
                can_check: false,
                check_id: 0,
                validate_message: {},
            }
        },
        computed: {
            ...mapState(['login_user', 'member', 'department', 'form_submit_data']),
        },
        beforeMount: function () {
        },
        mounted: function () {
            $(document).ready(() => {
                this.initial();
                this.getAjaxFormData();

            });
        },
        created: function () {
            bus.$on('formPrint',this.formPrint);
        },
        methods: {
            formPrint(){
                let data = {
                    id:this.id,
                    _token: this.csrf_token
                }
                urlPost('/form/print',data);
            },
            initial() {
                $(".select2").select2({
                    dropdownautowidth: true,
                    width: '100%'
                });
            },
            submit() {
                this.lodding = true;
                let vue = this;

                /* some Array need to Json*/
                let data = this.formGetPostData();

                /*post validate*/
                let type = this.formValidate();
                if (type) {
                    return false;
                }

                data.id = vue.id;
                data = this.formToJson(data);

                // /*TODO::post 後續轉跳與錯誤動作*/
                apiFormEdit(data).then(function (response) {
                        let result = response.data;
                        if (result.status != 1 || result.status_string !== '編輯成功') {
                            alert(result.message + result.status_string);
                            vue.lodding = false;
                            return false;
                        }

                        javascript:location.href = '/form-edit?id=' + vue.id;

                    })
                    .catch(function (error) {
                        console.log(error);
                        alert(error);
                    });
            },
            getAjaxFormData() {
                // console.log(this.id);
                /*ajax get data*/
                let vue = this;

                apiGetForm({
                    id: vue.id,
                    member_id: vue.login_user.id,
                }).then(function (response) {
                    let result = response.data;
                    if (result.status !== 1) {
                        javascript:location.href = '/404';
                        alert(result.message);
                        return false;
                    }

                    switch (result.data.form_id) {
                        case 1:
                            vue.form_type = 'form-payment';
                            break;
                        case 2:
                            vue.form_type = 'form-sign';
                            break;
                        case 3:
                            vue.form_type = 'form-social';
                            break;
                        case 4:
                            vue.form_type = 'form-refund';
                            break;
                        case 5:
                            vue.form_type = 'form-travel_grant';
                            break;
                        case 6:
                            vue.form_type = 'form-travel_fee';
                            break;
                    }

                    if (result.data.apply_member_id === parseInt(vue.login_user.id)) {
                        if (result.data.status == 1) {
                            vue.can_edit = true;
                        }
                    }

                    vue.check_list = result.data.checkPoint;
                    vue.can_check = result.data.check_status.can_check == 0 ? false : true;

                    vue.check_id = result.data.check_status.form_check_point_id;

                    let date = new Date(result.data.created_at);
                    result.data.column.created_at = date.toLocaleDateString();

                    vue.jsonReverse(result.data.column);
                }).then(() => {

                }).catch(function (error) {
                    console.log(error);
                });

            },
            jsonReverse(data) {
                let vue = this;
                vue.form_submit_data[vue.form_type] = {};

                Object.keys(data).forEach(columnName => {
                    if ($.inArray(columnName, ['form_stamp_type', 'accompany_user_id', 'attend_member', 'items', 'apply_attachment']) != -1) {
                        if (columnName == 'items') {
                            vue.form_submit_data[vue.form_type][columnName] = {};
                            let tmpData = [];
                            if(!data[columnName].isArray){
                                tmpData = Object.values(data[columnName]);
                            }else{
                                tmpData = data[columnName];
                            }

                            tmpData.map((e) => {
                                    vue.form_submit_data[vue.form_type][columnName][e.id] = e;
                                    ['fee_items'].map((k) => {
                                        if (e[k] != undefined) {
                                            vue.form_submit_data[vue.form_type][columnName][e.id][k] = JSON.parse(e[k]);
                                        }
                                    });
                                });


                        } else {
                            vue.form_submit_data[vue.form_type][columnName] = JSON.parse(data[columnName]);
                        }

                    } else {
                        vue.form_submit_data[vue.form_type][columnName] = data[columnName];
                    }

                });
            },
        },
        updated() {
            let vue = this;
            vue.initial();

            /*file upload*/
            if (vue.init === false) {
                $("#" + vue.form_type + " #file_upload").dropzone({
                    addRemoveLinks: true,
                    thumbnailWidth: 300,
                    thumbnailHeight: 300,
                    maxFilesize: 2,
                    url: "/api/system/upload",
                    init: function () {
                        let formPostAttachment = vue.form_submit_data[vue.form_type].apply_attachment;
                        let thisDropzone = this;
                        /*set default images */
                        $.each(formPostAttachment, function (key, value) {
                            let mockFile = value;

                            thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                            thisDropzone.options.thumbnail.call(thisDropzone, mockFile, value.url);

                            /*append download link*/
                            let anchorEl = document.createElement('a');
                            anchorEl.setAttribute('href', value.url);
                            anchorEl.setAttribute('target', '_blank');
                            anchorEl.setAttribute('class', 'cursor-pointer');
                            anchorEl.innerHTML = "<br>Download";
                            mockFile.previewTemplate.appendChild(anchorEl);

                        });

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
                            formPostAttachment.map((e, k) => {
                                if (e.name == file.name) {
                                    formPostAttachment.splice(k, 1);
                                }
                            });
                            vue.lodding = false;
                        });
                    }
                });
                vue.init = true;
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
