<template>
    <fieldset>
        <div class="row col-md-12 align-items-center">
            <div class="card">
                <h4 class="card-title">差旅申請單</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-label-group">
                    <input type="text" id="member" class="form-control"
                           placeholder="申請人" name="member">
                    <label for="member">申請人</label>
                </div>
                <div class="form-label-group">
                    <input type="text" id="name" class="form-control" placeholder="項目"
                           name="name">
                    <label for="name">項目</label>
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
                <div class="form-group">
                    <label for="pay_type">出差人</label>
                    <select class="custom-select select2 form-control" id="pay_type"
                            name="pay_type">
                        <option value="cash">test1</option>
                        <option value="transfer">test2</option>
                        <option value="other">test3</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-label-group">
                    <input type="text" id="receipt_number" class="form-control"
                           placeholder="出差期間"
                           name="receipt_number">
                    <label for="receipt_number">出差期間</label>
                </div>
            </div>
            <div class='col-md-6'>
                <div class="form-label-group">
                    <input type="text" id="receipt_date" class="form-control"
                           placeholder="出差地點"
                           name="receipt_date">
                    <label for="receipt_date">出差地點</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-label-group">
                    <input type="text" id="customer" class="form-control"
                           placeholder="住宿地點" name="customer">
                    <label for="customer">住宿地點</label>
                </div>
            </div>

            <div class='col-md-6'>
                <div class="form-label-group">
                    <input type="text" id="receipt_price" class="form-control"
                           placeholder="預估費用(台幣)"
                           name="receipt_price">
                    <label for="receipt_price">預估費用(台幣)</label>
                </div>
            </div>
            <div class='col-md-12'>
                <fieldset class="form-label-group">
                            <textarea class="form-control" id="travel_remark" rows="1" placeholder="出差事由詳述"
                                      name="travel_remark"></textarea>
                    <label for="remark">出差事由詳述</label>
                </fieldset>
            </div>
        </div>
        <div class="row col-md-12 align-items-center mt-2">
            <div class="card">
                <h4 class="card-title">出差計畫</h4>
            </div>
        </div>
        <div class="row">
            <div class="row col-md-12">
                <div class="col-md-3">
                    <div class="form-label-group">
                        <input type="text" id="member" class="form-control"
                               placeholder="拜訪期間" name="member">
                        <label for="member">拜訪期間</label>
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
            </div>
            <div class='row col-md-12 justify-content-end'>
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
        name: "form-travel_grant"
    }
</script>

<style scoped>

</style>
