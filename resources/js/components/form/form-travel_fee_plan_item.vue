<template>
    <div class="row col-xl-6 align-items-center">
        <div class="col-md-3">
            <div class="form-label-group mt-2">
                <input type="text" id="type"  name='type' class="form-control"
                       placeholder="類型"  v-model='form_submit_data[dom_id]["items"][parent_id]["fee_items"][id]["type"]'
                       disabled>
                <label for="type">類型</label>
            </div>
        </div>
        <div class='col-md-4'>
            <div class="form-group">
                <label>幣別</label>
                <select class="custom-select select2 form-control"
                        :disabled='can_edit === false' required
                >
                    <option value>請選擇</option>
                    <option v-for='item in currency_type' :value='item[0]'
                            :selected='form_submit_data[dom_id]["items"][parent_id]["fee_items"][id]["currency"] == item[0]'>{{item[1]}}({{item[0]}})
                    </option>
                </select>
            </div>
        </div>
        <div class='col-md-3'>
            <div class="form-label-group mt-2">
                <input type="number" min='0' max='99999' step='1' class="form-control price" id='fee' v-model='form_submit_data[dom_id]["items"][parent_id]["fee_items"][id]["fee"]'
                       placeholder="應付費用"
                       name="fee" :disabled='can_edit === false' required>
                <label for="fee">應付費用</label>
            </div>
        </div>
        <!--delete-->
        <div class='col-md-auto' v-show='can_edit'>
            <button type="button" data-action='deleteItem_fee' :data-id='id' :data-parent_id='parent_id'
                    class="btn btn-icon btn-danger mr-1 mb-1 waves-effect waves-light mt-2">
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
                can_edit: Boolean,
            },
            data() {
                return {

                }
            },
            computed: {
                ...mapState(['form_submit_data', 'login_user', 'member', 'department','currency_type']),
            },
            beforeMount: function () {
            },
            mounted: function () {

            },
            methods: {

            },
            updated() {
                $(".select2").select2({
                    dropdownAutoWidth: true,
                    width: '100%'
                });
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
