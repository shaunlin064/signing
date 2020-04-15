<template>
    <div class="row col-md-12">
        <div class="col-md-2">
            <div class="form-label-group mt-2">
                <input type="text" id="form_type" class="form-control"
                       placeholder="類型"  :value='type'
                       disabled>
                <label for="form_type">類型</label>
            </div>
        </div>
        <div class="col-md-2">

            <div class="form-label-group mt-2">
                <input type="text" class="form-control" v-model='form_submit_data[dom_id]["items"][id]["date"]'
                       placeholder="日期" :disabled='form_action !== "new"'
                       >
                <label>日期</label>
            </div>
        </div>
        <div class='col-md-2'>
            <div class="form-label-group mt-2">
                <input type="text" class="form-control" v-model='form_submit_data[dom_id]["items"][id]["item"]'
                       placeholder="名稱" :disabled='form_action !== "new"'>
                <label>名稱</label>
            </div>
        </div>
        <div class='col-md-2' v-if='type === "乘車"'>
            <div class="form-label-group mt-2">
                <input type="text" class="form-control"
                       placeholder="乘車起始點" v-model='form_submit_data[dom_id]["items"][id]["get_on_start"]' :disabled='form_action !== "new"'
                       >
                <label >乘車起始點</label>
            </div>
        </div>
        <div class='col-md-2' v-else-if='type === "案件"'>
            <div class="form-label-group mt-2">
                <input type="text" class="form-control"
                       placeholder="委刊單號" v-model='form_submit_data[dom_id]["items"][id]["campaign_id"]' :disabled='form_action !== "new"'
                >
                <label >委刊單號</label>
            </div>
        </div>
<!--        <div class='col-md-2' v-else-if='type === "交際"'>-->
<!--            <div class="form-label-group mt-2">-->
<!--                <input type="text" class="form-control" v-model='form_submit_data[dom_id]["items"][id]["gift_id"]' :disabled='form_action !== "new"'-->
<!--                       placeholder="交際送禮單號">-->
<!--                <label >交際送禮單號</label>-->
<!--            </div>-->
<!--        </div>-->
        <div class='col-md-2'>
            <div class="form-label-group mt-2">
                <input type="text"  class="form-control"
                       v-model='form_submit_data[dom_id]["items"][id]["price"]' :disabled='form_action !== "new"'
                       placeholder="金額">
                <label>金額</label>
            </div>
        </div>
        <div class='col-md-auto mt-2' v-if='form_action === "new"'>
            <button type="button" data-action='deleteItem' :data-id='id'
                    class="btn btn-icon btn-danger mr-1 mb-1 waves-effect waves-light">
                <i
                    class="feather icon-x"></i></button>
        </div>
    </div>
</template>

<script>
    import {mapState} from "vuex";

    export default {
        name: "form-refund-items",
        props: {
            dom_id : String,
            type: String,
            form_action: String,
            id: Number
        },
        computed: {
            ...mapState(['form_submit_data','login_user', 'member', 'department']),
        },
        mounted: function () {
        }
    }
</script>

<style scoped>

</style>
