<template>
    <fieldset>
        <div class="row col-md-12 align-items-center">
            <div class="card">
                <h4 class="card-title">差旅費用報銷單</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-label-group">
                    <input type="text" id="member" class="form-control"
                           placeholder="申請人" name="member">
                    <label for="member">申請人</label>
                </div>
            </div>
            <div class='col-md-6'>
                <div class="form-label-group">
                    <input type="text" id="department" class="form-control"
                           placeholder="部門" name="department">
                    <label for="department">部門</label>
                </div>
            </div>
            <div class='col-md-12'>
                <div class="form-label-group">
                    <div class="form-group">
                        <label for="pay_type88">差旅單</label>
                        <select class="custom-select select2 form-control"
                                id="pay_type88" name="pay_type88">
                            <option value="transfer">20200430日本拜訪</option>
                            <option value="other">20200410中國拜訪</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center border-top-light mt-2">
            <div class="row col-md-12">
                <div class="card mt-2">
                    <h4 class="card-title">出差計畫</h4>
                </div>
            </div>
            <div class="row col-md-12">
                <div class="col-md-3">
                    <div class="form-label-group">
                        <input type="text" id="member" class="form-control"
                               placeholder="日期" name="member">
                        <label for="member">日期</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-label-group">
                        <input type="text" id="department" class="form-control"
                               placeholder="洽訪公司"
                               name="department">
                        <label for="department">洽訪公司</label>
                    </div>
                </div>
                <div class='col-md-3'>
                    <div class="form-label-group">
                        <input type="text" id="name" class="form-control"
                               placeholder="對象姓名/稱謂" name="name">
                        <label for="name">對象姓名/稱謂</label>
                    </div>
                </div>
                <div class='col-md-3'>
                    <div class="form-label-group">
                        <input type="text" id="department" class="form-control"
                               placeholder="會議形式"
                               name="department">
                        <label for="department">會議形式</label>
                    </div>
                </div>
                <div class='col-md-6'>
                    <div class="form-label-group">
                        <input type="text" id="name" class="form-control"
                               placeholder="負責業務" name="name">
                        <label for="name">負責業務</label>
                    </div>
                </div>
                <div class='col-md-6'>
                    <div class="form-label-group">
                        <input type="text" id="department" class="form-control"
                               placeholder="洽談內容"
                               name="department">
                        <label for="department">洽談內容</label>
                    </div>
                </div>
                <div class='row col-md-12 border-top-light'>
                    <div class="row col-md-12 mt-2">
                        <div class='col-md-6'>
                            <div class="card">
                                <h5 class="card-title">費用明細</h5>
                            </div>
                        </div>
                        <div class='col-md-6 justify-content-end'>
                            <div class='text-right mt-1'>
                                <button type="button"
                                        class="btn btn-outline-primary mr-1 mb-1 waves-effect waves-light">
                                    新增
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row col-xl-12 align-items-center">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="pay_type77">類型</label>
                                <select class="custom-select select2 form-control"
                                        id="pay_type77" name="pay_type77">
                                    <option value="transfer">交通</option>
                                    <option value="other">交際</option>
                                    <option value="other">漫遊</option>
                                    <option value="other">其他</option>
                                </select>
                            </div>
                        </div>
                        <div class='col-md-3'>
                            <div class="form-label-group mt-2">
                                <input type="text" id="department" class="form-control"
                                       placeholder="幣別"
                                       name="department">
                                <label for="department">幣別</label>
                            </div>
                        </div>
                        <div class='col-md-3'>
                            <div class="form-label-group mt-2">
                                <input type="text" id="department" class="form-control"
                                       placeholder="應付費用"
                                       name="department">
                                <label for="department">應付費用</label>
                            </div>
                        </div>
                        <!--delete-->
                        <div class='col-md-auto mt-2'>
                            <button type="button"
                                    class="btn btn-icon btn-danger mr-1 mb-1 waves-effect waves-light">
                                <i class="feather icon-x"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class='row col-md-12 justify-content-end border-top-light'>
                <div class='col-md-4 text-right mt-1'>
                    <button type="button"
                            class="btn btn-outline-primary mr-1 mb-1 waves-effect waves-light">
                        新增計畫
                    </button>
                </div>
            </div>
            <div class='col-md-12 mt-2'>
                <fieldset class="form-label-group">
                              <textarea class="form-control" id="remark" rows="3" placeholder="備註"
                                        name="remark"></textarea>
                    <label for="remark">備註</label>
                </fieldset>
            </div>
        </div>
    </fieldset>
</template>

<script>
    export default {
        name: "form-travel_fee"
    }
</script>

<style scoped>

</style>
