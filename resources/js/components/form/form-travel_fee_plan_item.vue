<template>
    <div class="row col-xl-6 align-items-center">
        <div class="col-md-3">
            <div class="form-label-group">
                <input type="text" id="type"  name='type' class="form-control"
                       placeholder="類型"  v-model='form_submit_data[dom_id]["items"][parent_id]["fee_items"][id]["type"]'
                       disabled>
                <label for="type">類型</label>
            </div>
        </div>
        <div class='col-md-3'>
            <div class="form-label-group">

                <input type="text" class="form-control" id="currency"
                       placeholder="幣別" v-model='form_submit_data[dom_id]["items"][parent_id]["fee_items"][id]["currency"]'
                       disabled>
                <label for="currency">幣別</label>
            </div>
        </div>
        <div class='col-md-3'>
            <div class="form-label-group">
                <input type="text" class="form-control" id='fee' v-model='form_submit_data[dom_id]["items"][parent_id]["fee_items"][id]["fee"]'
                       placeholder="應付費用"
                       name="fee">
                <label for="fee">應付費用</label>
            </div>
        </div>
        <!--delete-->
        <div class='col-md-auto'>
            <button type="button" data-action='deleteItem_fee' :data-id='id' :data-parent_id='parent_id'
                    class="btn btn-icon btn-danger mr-1 mb-1 waves-effect waves-light">
                <i class="feather icon-x"></i></button>
        </div>
    </div>
</template>

<script>
    import {mapState, mapMutations, mapActions, mapGetters} from 'vuex';

        export default {
            name: "form-travel_fee_plan_item",
            props: {
                dom_id:String,
                parent_id: Number,
                id: Number,
            },
            data() {
                return {

                }
            },
            computed: {
                ...mapState(['form_submit_data', 'login_user', 'member', 'department']),
            },
            beforeMount: function () {
            },
            mounted: function () {

            },
            methods: {

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
