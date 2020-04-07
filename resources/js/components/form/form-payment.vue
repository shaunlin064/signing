<template>
    <fieldset :id='dom_id'>
        <div class="row col-md-12 align-items-center">
            <div class="card">
                <h4 class="card-title">請款單</h4>
            </div>
        </div>
        <div class="row">
            <div class='row col-md-12'>
                <div class="col-md-6">
                    <div class="form-label-group">
                        <input type="text" id="department" class="form-control" placeholder="部門" name="department">
                        <label for="department">部門</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-label-group">
                        <input type="text" id="member" class="form-control" placeholder="申請人" name="member">
                        <label for="member">申請人</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-label-group">
                        <input type="text" id="name" class="form-control" placeholder="項目" name="name">
                        <label for="name">項目</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-label-group">
                        <input type="text" id="id_number" class="form-control" placeholder="案件編號" name="id_number">
                        <label for="id_number">案件編號</label>
                    </div>
                </div>
            </div>
            <div class='row col-md-12 p-1'>
                <div class='col-md-12 border-top-light mb-1'></div>
                <div class="col-md-6">
                    <div class="form-label-group">
                        <input type="text" id="customer" class="form-control" placeholder="受款人" name="customer">
                        <label for="customer">受款人</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-label-group">
                        <input type="text" id="receipt_number" class="form-control" placeholder="發票號碼"
                               name="receipt_number">
                        <label for="receipt_number">發票號碼</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-label-group">
                        <input type="text" id="receipt_date" class="form-control" placeholder="開立發票日期"
                               name="receipt_date">
                        <label for="receipt_date">開立發票日期</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-label-group">
                        <input type="text" id="receipt_price" class="form-control" placeholder="發票金額(稅)"
                               name="receipt_price">
                        <label for="receipt_price">發票金額(稅)</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="pay_type9">付款方式</label>
                        <select class="custom-select select2 form-control" id="pay_type9" name="pay_type9">
                            <option value="cash">現金</option>
                            <option value="transfer">電匯</option>
                            <option value="other">其他</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class='col-md-12'>
                <fieldset class="form-label-group">
                        <textarea class="form-control" id="remark" rows="1" placeholder="備註"
                                  name="remark"></textarea>
                    <label for="remark">備註</label>
                </fieldset>
            </div>
            <div class="col-md-12 mt-1">
                <div class="form-group">
                    <input class="dropzone dropzone-area" type="hidden"/>
                    <div class="dropzone dropzone-area" id="file_upload">
                        <div class="dz-message">Drop Files Here To Upload</div>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
</template>

<script>
    import {mapState} from 'vuex';

    export default {
        name: "name",
        props: {
            dom_id: String
        },
        data() {
            return {}
        },
        computed: {
            ...mapState([]),
        },
        beforeMount: function () {
        },
        mounted: function () {
            console.log(this.dom_id);
        },
        methods: {},
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
