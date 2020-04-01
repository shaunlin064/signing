<template>
    <fieldset>
        <div class="row col-md-12 align-items-center">
            <div class="card">
                <h4 class="card-title">代墊申請</h4>
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
        </div>
        <div class="row justify-content-center border-top-light mt-2">
            <div class="row col-md-12">
                <div class="card mt-2">
                    <h4 class="card-title">項目</h4>
                </div>
            </div>
            <div class="row col-md-12">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="pay_type4">類型</label>
                        <select class="custom-select select2 form-control"
                                id="pay_typ4e" name="pay_type4">
                            <option value="cash" selected>乘車</option>
                            <option value="transfer">案件</option>
                            <option value="other">交際</option>
                            <option value="other">其他</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-label-group mt-2">
                        <input type="text" id="department" class="form-control"
                               placeholder="日期"
                               name="department">
                        <label for="department">日期</label>
                    </div>
                </div>
                <div class='col-md-2'>
                    <div class="form-label-group mt-2">
                        <input type="text" id="name" class="form-control"
                               placeholder="項目" name="name">
                        <label for="name">項目</label>
                    </div>
                </div>
                <div class='col-md-2'>
                    <div class="form-label-group mt-2">
                        <input type="text" id="department" class="form-control"
                               placeholder="乘車起始點"
                               name="department">
                        <label for="department">乘車起始點</label>
                    </div>
                </div>
                <div class='col-md-2'>
                    <div class="form-label-group mt-2">
                        <input type="text" id="name" class="form-control"
                               placeholder="金額" name="name">
                        <label for="name">金額</label>
                    </div>
                </div>
                <div class='col-md-auto mt-2'>
                    <button type="button"
                            class="btn btn-icon btn-danger mr-1 mb-1 waves-effect waves-light">
                        <i
                            class="feather icon-x"></i></button>
                </div>
            </div>
            <div class="row col-md-12">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="pay_type3">類型</label>
                        <select class="custom-select select2 form-control"
                                id="pay_type3" name="pay_type3">
                            <option value="cash">乘車</option>
                            <option value="transfer" selected>案件</option>
                            <option value="other">交際</option>
                            <option value="other">其他</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-label-group mt-2">
                        <input type="text" id="department" class="form-control"
                               placeholder="日期"
                               name="department">
                        <label for="department">日期</label>
                    </div>
                </div>
                <div class='col-md-2'>
                    <div class="form-label-group mt-2">
                        <input type="text" id="name" class="form-control"
                               placeholder="項目" name="name">
                        <label for="name">項目</label>
                    </div>
                </div>
                <div class='col-md-2'>
                    <div class="form-label-group mt-2">
                        <input type="text" id="department" class="form-control"
                               placeholder="案件委刊單號"
                               name="department">
                        <label for="department">案件委刊單號</label>
                    </div>
                </div>
                <div class='col-md-2'>
                    <div class="form-label-group mt-2">
                        <input type="text" id="name" class="form-control"
                               placeholder="金額" name="name">
                        <label for="name">金額</label>
                    </div>
                </div>
                <div class='col-md-auto mt-2'>
                    <button type="button"
                            class="btn btn-icon btn-danger mr-1 mb-1 waves-effect waves-light">
                        <i
                            class="feather icon-x"></i></button>
                </div>
            </div>
            <div class="row col-md-12">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="pay_type2">類型</label>
                        <select class="custom-select select2 form-control"
                                id="pay_type2" name="pay_type2">
                            <option value="cash">乘車</option>
                            <option value="transfer">案件</option>
                            <option value="other" selected>交際</option>
                            <option value="other">其他</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-label-group mt-2">
                        <input type="text" id="department" class="form-control"
                               placeholder="日期"
                               name="department">
                        <label for="department">日期</label>
                    </div>
                </div>
                <div class='col-md-2'>
                    <div class="form-label-group mt-2">
                        <input type="text" id="name" class="form-control"
                               placeholder="項目" name="name">
                        <label for="name">項目</label>
                    </div>
                </div>
                <div class='col-md-2'>
                    <div class="form-label-group mt-2">
                        <input type="text" id="department" class="form-control"
                               placeholder="交際送禮單號"
                               name="department">
                        <label for="department">交際送禮單號</label>
                    </div>
                </div>
                <div class='col-md-2'>
                    <div class="form-label-group mt-2">
                        <input type="text" id="name" class="form-control"
                               placeholder="金額" name="name">
                        <label for="name">金額</label>
                    </div>
                </div>
                <div class='col-md-auto mt-2'>
                    <button type="button"
                            class="btn btn-icon btn-danger mr-1 mb-1 waves-effect waves-light">
                        <i
                            class="feather icon-x"></i></button>
                </div>
            </div>
            <div class="row col-md-12">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="pay_type">類型</label>
                        <select class="custom-select select2 form-control"
                                id="pay_type1" name="pay_type1">
                            <option value="cash">乘車</option>
                            <option value="transfer">案件</option>
                            <option value="other">交際</option>
                            <option value="other" selected>其他</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-label-group mt-2">
                        <input type="text" id="department" class="form-control"
                               placeholder="日期"
                               name="department">
                        <label for="department">日期</label>
                    </div>
                </div>
                <div class='col-md-2'>
                    <div class="form-label-group mt-2">
                        <input type="text" id="name" class="form-control"
                               placeholder="項目" name="name">
                        <label for="name">項目</label>
                    </div>
                </div>
                <div class='col-md-2'>
                    <div class="form-label-group mt-2">
                        <input type="text" id="name" class="form-control"
                               placeholder="金額" name="name">
                        <label for="name">金額</label>
                    </div>
                </div>
                <div class='col-md-auto mt-2'>
                    <button type="button"
                            class="btn btn-icon btn-danger mr-1 mb-1 waves-effect waves-light">
                        <i
                            class="feather icon-x"></i></button>
                </div>
            </div>
            <div class='row col-md-12 justify-content-end border-top-light'>
                <div class='col-md-4 text-right mt-1'>
                    <button type="button"
                            class="btn btn-outline-primary mr-1 mb-1 waves-effect waves-light">
                        新增
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
        name: "form-refund"
    }
</script>

<style scoped>

</style>
