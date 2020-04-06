<template>
    <div class="row col-xl-6 align-items-center">
        <div class="col-md-3">
            <div class="form-group">
                <label>類型</label>
                <select class="custom-select select2 form-control" :name='"plan["+parent_id+"][plan_fee]["+id+"][type]"'
                         >
                    <option value="transfer">交通</option>
                    <option value="other">交際</option>
                    <option value="other">漫遊</option>
                    <option value="other">其他</option>
                </select>
            </div>
        </div>
        <div class='col-md-3'>
            <div class="form-label-group mt-2">
                <input type="text" class="form-control" :name='"plan["+parent_id+"][plan_fee]["+id+"][currency]"'
                       placeholder="幣別"
                       name="currency">
                <label >幣別</label>
            </div>
        </div>
        <div class='col-md-3'>
            <div class="form-label-group mt-2">
                <input type="text" class="form-control" :name='"plan["+parent_id+"][plan_fee]["+id+"][fee]"'
                       placeholder="應付費用"
                       name="fee">
                <label >應付費用</label>
            </div>
        </div>
        <!--delete-->
        <div class='col-md-auto mt-2'>
            <button type="button" data-action='deleteItem' :data-id='id'
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
                parent_id: Number,
                id: Number,
            },
            data() {
                return {

                }
            },
            computed: {
                ...mapState([]),
            },
            beforeMount: function () {
            },
            mounted: function () {

            },
            methods: {

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
