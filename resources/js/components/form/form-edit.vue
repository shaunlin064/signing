<template>
    <form action="#" method='GET' class="steps-validation wizard-circle" :id='dom_id'>
        <keep-alive>
            <component v-bind:is="form_type" :dom_id='form_type' :form_action='"edit"' :can_edit='can_edit'/>
        </keep-alive>
    </form>
</template>

<script>
    import {mapState} from 'vuex';

    export default {
        name: "form-edit",
        components: {
            // Payment, Sign
        },
        props: {
            id: Number
        },
        data() {
            return {
                form_type: '',
                dom_id: 'form-edit',
                form_data: [],
                can_edit: false,
            }
        },
        computed: {
            ...mapState(['login_user','member','department','form_submit_data']),
        },
        beforeMount: function () {
        },
        mounted: function () {
            $(document).ready(() => {
                this.initial();
            });
        },
        methods: {
            getformdata() {
                // console.log(this.id);
                /*ajax get data*/
                let vue = this;

                axios.post('api/form/get', {
                    id:vue.id
                }).then(function (response) {
                    let result = response.data;
                    if (result.status !== 1) {
                        javascript:location.href='/404';
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
                    if(result.data.status == 1){
                        vue.can_edit = true;
                    }
                    vue.jsonReverse(result.data.column);
                }).then(()=> {

                }).catch(function (error) {
                        console.log(error);
                    });

            },
            initial() {
                $(".select2").select2({
                    dropdownautowidth: true,
                    width: '100%'
                });
                this.getformdata();
            },
            submit() {
                $('select[disabled]').removeattr("disabled");
                $('form#' + this.dom_id).submit();
            },
            jsonReverse(data){
                let vue = this;
                vue.form_submit_data[vue.form_type] = {};

                Object.keys(data).forEach(columnName=> {
                    if ($.inArray(columnName, ['form_stamp_type', 'accompany_user_id','attend_member','items']) != -1) {
                        if(columnName == 'items'){
                            vue.form_submit_data[vue.form_type][columnName] = {};
                            data[columnName].map((e)=>{

                                vue.form_submit_data[vue.form_type][columnName][e.id] = e;
                                ['fee_items'].map((k)=>{
                                    if (e[k] != undefined) {
                                        vue.form_submit_data[vue.form_type][columnName][e.id][k] = JSON.parse(e[k]);
                                    }
                                });
                            });
                        }else{
                            vue.form_submit_data[vue.form_type][columnName] = JSON.parse(data[columnName]);
                        }

                    }else{
                        vue.form_submit_data[vue.form_type][columnName] = data[columnName];
                    }

                });
            },
        },
        updated() {
            this.initial();
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
