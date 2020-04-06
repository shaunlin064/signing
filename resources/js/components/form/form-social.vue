<template>
    <fieldset :id='dom_id'>
        <div class="row col-md-12 align-items-center">
            <div class="card">
                <h4 class="card-title">交際送禮</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-label-group">
                    <input type="text" id="department" class="form-control"
                           placeholder="部門" name="department">
                    <label for="department">部門</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-label-group">
                    <input type="text" id="member" class="form-control"
                           placeholder="申請人" name="member">
                    <label for="member">申請人</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-label-group">
                    <input type="text" id="name" class="form-control" placeholder="項目"
                           name="name">
                    <label for="name">項目</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-label-group">
                    <input type="text" id="date" class="form-control" placeholder="日期"
                           name="date">
                    <label for="date">日期</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="type">類型</label>
                    <select class="custom-select select2 form-control" id="type"
                            name="type">
                        <option value="flower">送花</option>
                        <option value="meal">餐敘</option>
                        <option value="gift">送禮</option>
                        <option value="other">其他</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-label-group mt-2">
                    <input type="text" id="customer" class="form-control"
                           placeholder="客戶公司名稱" name="customer">
                    <label for="customer">客戶公司名稱</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-label-group">
                    <input type="text" id="customer" class="form-control"
                           placeholder="對象" name="customer">
                    <label for="customer">對象</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-label-group">
                    <input type="text" id="price" class="form-control"
                           placeholder="預估費用"
                           name="price">
                    <label for="price">預估費用</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-label-group">
                    <fieldset class="form-label-group">
                            <textarea class="form-control" id="remark" rows="1" placeholder="備註"
                                      name="remark"></textarea>
                        <label for="remark">備註</label>
                    </fieldset>
                </div>
            </div>
            <div class="col-md-12 mt-1">
                <div class="form-group">
                    <label for="attachment">附件</label>
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
    import {mapState, mapMutations, mapActions, mapGetters} from 'vuex';

        export default {
            name: "form-social",
            props: {
                dom_id:String
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
