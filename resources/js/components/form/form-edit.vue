<template>
    <form action="#" method='GET' class="steps-validation wizard-circle" :id='dom_id'>
        <keep-alive>
            <component v-bind:is="form_type" :dom_id='form_type' :form_data='form_data'/>
        </keep-alive>
    </form>
</template>

<script>
    import {mapState, mapMutations, mapActions, mapGetters} from 'vuex';

    export default {
        name: "name",
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
            }
        },
        computed: {
            ...mapState(['login_user','member','department']),
        },
        beforeMount: function () {
        },
        mounted: function () {
            $(document).ready(() => {
                this.initial();
            });
        },
        methods: {
            getFormData() {
                // console.log(this.id);
                /*ajax get data*/
                this.form_data = {
                    department: '資訊工程部',
                    member: 'shaun',

                };
                switch (this.id) {
                    case 1:
                        this.form_type = 'form-payment';
                        break;
                    case 2:
                        this.form_type = 'form-sign';
                        break;
                    case 3:
                        this.form_type = 'form-refund';
                        break;
                    case 4:
                        this.form_type = 'form-social';
                        break;
                    case 5:
                        this.form_type = 'form-travel_grant';
                        break;
                    case 6:
                        this.form_type = 'form-travel_fee';
                        break;
                }



            },
            initial() {
                $(".select2").select2({
                    dropdownAutoWidth: true,
                    width: '100%'
                });
                this.getFormData();
            },
            submit() {
                $('select[disabled]').removeAttr("disabled");
                $('form#' + this.dom_id).submit();
            },
        },
        updated() {
            this.initial();
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
