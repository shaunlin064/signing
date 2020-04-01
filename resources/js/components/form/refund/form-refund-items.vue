<template>
    <div class="row col-md-12">
        <div class="col-md-2">
            <div class="form-label-group mt-2">
                <input type='hidden' :value='type' :name='"items["+id+"][type]"'>
                <input type="text" id="form_type" class="form-control"
                       placeholder="類型"  :value='type'
                       disabled>
                <label for="form_type">類型</label>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-label-group mt-2">
                <input type="text" class="form-control" :name='"items["+id+"][date]"'
                       placeholder="日期"
                       >
                <label>日期</label>
            </div>
        </div>
        <div class='col-md-2'>
            <div class="form-label-group mt-2">
                <input type="text" class="form-control" :name='"items["+id+"][name]"'
                       placeholder="項目" >
                <label>項目</label>
            </div>
        </div>
        <div class='col-md-2' v-if='type === "乘車"'>
            <div class="form-label-group mt-2">
                <input type="text" class="form-control" :name='"items["+id+"][departure]"'
                       placeholder="乘車起始點"
                       >
                <label >乘車起始點</label>
            </div>
        </div>
        <div class='col-md-2' v-else-if='type === "案件"'>
            <div class="form-label-group mt-2">
                <input type="text" class="form-control" :name='"items["+id+"][serial_number]"'
                       placeholder="委刊單號"
                >
                <label >委刊單號</label>
            </div>
        </div>
        <div class='col-md-2' v-else-if='type === "交際"'>
            <div class="form-label-group mt-2">
                <input type="text" class="form-control" :name='"items["+id+"][serial_number]"'
                       placeholder="交際送禮單號">
                <label >交際送禮單號</label>
            </div>
        </div>
        <div class='col-md-2'>
            <div class="form-label-group mt-2">
                <input type="text"  class="form-control" :name='"items["+id+"][price]"'
                       placeholder="金額">
                <label>金額</label>
            </div>
        </div>
        <div class='col-md-auto mt-2'>
            <button type="button" data-action='deleteItem'
                    class="btn btn-icon btn-danger mr-1 mb-1 waves-effect waves-light">
                <i
                    class="feather icon-x"></i></button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "form-refund-items",
        props: {
            type: String,
            id: Number,
        },
        mounted: function () {
        }
    }
</script>

<style scoped>

</style>
