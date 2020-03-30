{{--	/**
	 * Created by PhpStorm.
	 * User: shaun
	 * Date: 2020/3/25
	 * Time: 17:35
	 */--}}
@extends('layouts/contentLayoutMaster')

@section('title', '申請簽核')

@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/ui/prism.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/file-uploaders/dropzone.min.css')) }}">
@endsection

@section('page-style')
  <!-- Page css files -->
  <link rel="stylesheet" href="{{ asset(mix('css/plugins/forms/wizard.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/plugins/file-uploaders/dropzone.css')) }}">
@endsection

@section('content')
  {{-- Start --}}
  <section id="form-new">
    <section id="validation">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title"></h4>
            </div>
            <div class="card-content">
              <div class="card-body">
                <form action="#" class="steps-validation wizard-circle">
                  <!-- Step 1 -->
                  <h6><i class="step-icon feather icon-home"></i> Step 1</h6>
                  <fieldset>
                    <div class="row justify-content-center">

                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="location">
                            請選擇簽核表單
                          </label>
                          <select class="custom-select select2 form-control" id="form_type" name="form_type">
                            <option value="payment_request">請款</option>
                            <option value="sign_form">用印</option>
                            <option value="refund">代墊</option>
                            <option value="social">交際送禮</option>
                            <option value="travel_grant">差旅申請</option>
                            <option value="travel_grant">差旅費用核銷</option>
                            <option value="travel_grant">代墊申請</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </fieldset>

                  <!-- Step 2 -->
                  {{--請款單--}}
                  <h6><i class="step-icon feather icon-briefcase"></i> Step 2</h6>
                  <fieldset>
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
                      <div class='row col-md-12 border-top-light p-1'>
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
                  {{--用印單--}}
                  <h6><i class="step-icon feather icon-briefcase"></i> Step 2</h6>
                  <fieldset>
                    <div class="row col-md-12 align-items-center">
                      <div class="card">
                        <h4 class="card-title">用印單</h4>
                      </div>
                    </div>
                    <div class="row">
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
                        <div class="form-label-group mt-2">
                          <input type="text" id="name" class="form-control" placeholder="項目" name="name">
                          <label for="name">項目</label>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="form">用印形式</label>
                          <select class="custom-select select2 form-control" multiple="multiple" id="form" name="form">
                            <option value="company">公司大章</option>
                            <option value="principal">負責人章</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="deployed">寄送方式</label>
                          <select class="custom-select select2 form-control" id="deployed" name="deployed">
                            <option value="company">總務寄出</option>
                            <option value="self">自行寄出</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class='row'>
                      <div class='col-md-12 border-top-light mb-1'></div>
                      <div class="col-md-6">
                        <div class="form-label-group">
                          <input type="text" id="customer" class="form-control" placeholder="收件人公司" name="customer">
                          <label for="customer">收件人公司</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-label-group">
                          <input type="text" id="contact_name" class="form-control" placeholder="收件人窗口"
                                 name="contact_name">
                          <label for="contact_name">收件人窗口</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-label-group">
                          <input type="text" id="contact_name" class="form-control" placeholder="收件人電話"
                                 name="contact_name">
                          <label for="contact_name">收件人電話</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-label-group">
                          <input type="text" id="contact_phone" class="form-control" placeholder="收件人地址"
                                 name="contact_phone">
                          <label for="contact_phone">收件人地址</label>
                        </div>
                      </div>
                      <div class='col-md-6'>
                        <div class="form-label-group">
                          <fieldset class="form-label-group">
                            <textarea class="form-control" id="remark" rows="3" placeholder="備註"
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
                  {{--交際送禮--}}
                  <h6><i class="step-icon feather icon-briefcase"></i> Step 2</h6>
                  <fieldset>
                    <div class="row col-md-12 align-items-center">
                      <div class="card">
                        <h4 class="card-title">交際送禮</h4>
                      </div>
                    </div>
                    <div class="row">
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
                          <input type="text" id="date" class="form-control" placeholder="日期"
                                 name="date">
                          <label for="date">日期</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="type">類型</label>
                          <select class="custom-select select2 form-control" id="type" name="type">
                            <option value="flower">送花</option>
                            <option value="meal">餐敘</option>
                            <option value="gift">送禮</option>
                            <option value="other">其他</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-label-group mt-2">
                          <input type="text" id="customer" class="form-control" placeholder="客戶公司名稱" name="customer">
                          <label for="customer">客戶公司名稱</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-label-group">
                          <input type="text" id="customer" class="form-control" placeholder="對象" name="customer">
                          <label for="customer">對象</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-label-group">
                          <input type="text" id="price" class="form-control" placeholder="預估費用"
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
                  {{--差旅申請單--}}
                  <h6><i class="step-icon feather icon-briefcase"></i> Step 2</h6>
                  <fieldset>
                    <div class="row col-md-12 align-items-center">
                      <div class="card">
                        <h4 class="card-title">差旅申請單</h4>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-label-group">
                          <input type="text" id="member" class="form-control" placeholder="申請人" name="member">
                          <label for="member">申請人</label>
                        </div>
                        <div class="form-label-group">
                          <input type="text" id="name" class="form-control" placeholder="項目" name="name">
                          <label for="name">項目</label>
                        </div>
                      </div>
                      <div class='col-md-6'>
                        <div class="form-label-group">
                          <input type="text" id="department" class="form-control" placeholder="部門" name="department">
                          <label for="department">部門</label>
                        </div>
                      </div>
                      <div class='col-md-12'>
                        <div class="form-group">
                          <label for="pay_type">出差人</label>
                          <select class="custom-select select2 form-control" id="pay_type" name="pay_type">
                            <option value="cash">test1</option>
                            <option value="transfer">test2</option>
                            <option value="other">test3</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-label-group">
                          <input type="text" id="receipt_number" class="form-control" placeholder="出差期間"
                                 name="receipt_number">
                          <label for="receipt_number">出差期間</label>
                        </div>
                      </div>
                      <div class='col-md-6'>
                        <div class="form-label-group">
                          <input type="text" id="receipt_date" class="form-control" placeholder="出差地點"
                                 name="receipt_date">
                          <label for="receipt_date">出差地點</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-label-group">
                          <input type="text" id="customer" class="form-control" placeholder="住宿地點" name="customer">
                          <label for="customer">住宿地點</label>
                        </div>
                      </div>

                      <div class='col-md-6'>
                        <div class="form-label-group">
                          <input type="text" id="receipt_price" class="form-control" placeholder="預估費用(台幣)"
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
                            <input type="text" id="member" class="form-control" placeholder="拜訪期間" name="member">
                            <label for="member">拜訪期間</label>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-label-group">
                            <input type="text" id="department" class="form-control" placeholder="洽訪公司"
                                   name="department">
                            <label for="department">洽訪公司</label>
                          </div>
                        </div>
                        <div class='col-md-3'>
                          <div class="form-label-group">
                            <input type="text" id="name" class="form-control" placeholder="對象姓名/稱謂" name="name">
                            <label for="name">對象姓名/稱謂</label>
                          </div>
                        </div>
                        <div class='col-md-3'>
                          <div class="form-label-group">
                            <input type="text" id="department" class="form-control" placeholder="會議形式"
                                   name="department">
                            <label for="department">會議形式</label>
                          </div>
                        </div>
                        <div class='col-md-6'>
                          <div class="form-label-group">
                            <input type="text" id="name" class="form-control" placeholder="負責業務" name="name">
                            <label for="name">負責業務</label>
                          </div>
                        </div>
                        <div class='col-md-6'>
                          <div class="form-label-group">
                            <input type="text" id="department" class="form-control" placeholder="洽談內容"
                                   name="department">
                            <label for="department">洽談內容</label>
                          </div>
                        </div>
                      </div>
                      <div class='row col-md-12 justify-content-end'>
                        <div class='col-md-4 text-right mt-1'>
                          <button type="button" class="btn btn-outline-primary mr-1 mb-1 waves-effect waves-light">新增
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
                  {{--差旅費用報銷單--}}
                  <h6><i class="step-icon feather icon-briefcase"></i> Step 2</h6>
                  <fieldset>
                    <div class="row col-md-12 align-items-center">
                      <div class="card">
                        <h4 class="card-title">差旅費用報銷單</h4>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-label-group">
                          <input type="text" id="member" class="form-control" placeholder="申請人" name="member">
                          <label for="member">申請人</label>
                        </div>
                      </div>
                      <div class='col-md-6'>
                        <div class="form-label-group">
                          <input type="text" id="department" class="form-control" placeholder="部門" name="department">
                          <label for="department">部門</label>
                        </div>
                      </div>
                      <div class='col-md-12'>
                        <div class="form-label-group">
                          <div class="form-group">
                            <label for="pay_type88">差旅單</label>
                            <select class="custom-select select2 form-control" id="pay_type88" name="pay_type88">
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
                            <input type="text" id="member" class="form-control" placeholder="日期" name="member">
                            <label for="member">日期</label>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-label-group">
                            <input type="text" id="department" class="form-control" placeholder="洽訪公司"
                                   name="department">
                            <label for="department">洽訪公司</label>
                          </div>
                        </div>
                        <div class='col-md-3'>
                          <div class="form-label-group">
                            <input type="text" id="name" class="form-control" placeholder="對象姓名/稱謂" name="name">
                            <label for="name">對象姓名/稱謂</label>
                          </div>
                        </div>
                        <div class='col-md-3'>
                          <div class="form-label-group">
                            <input type="text" id="department" class="form-control" placeholder="會議形式"
                                   name="department">
                            <label for="department">會議形式</label>
                          </div>
                        </div>
                        <div class='col-md-6'>
                          <div class="form-label-group">
                            <input type="text" id="name" class="form-control" placeholder="負責業務" name="name">
                            <label for="name">負責業務</label>
                          </div>
                        </div>
                        <div class='col-md-6'>
                          <div class="form-label-group">
                            <input type="text" id="department" class="form-control" placeholder="洽談內容"
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
                                        class="btn btn-outline-primary mr-1 mb-1 waves-effect waves-light">新增
                                </button>
                              </div>
                            </div>
                          </div>
                          <div class="row col-xl-12 align-items-center">
                            <div class="col-md-2">
                              <div class="form-group">
                                <label for="pay_type77">類型</label>
                                <select class="custom-select select2 form-control" id="pay_type77" name="pay_type77">
                                  <option value="transfer">交通</option>
                                  <option value="other">交際</option>
                                  <option value="other">漫遊</option>
                                  <option value="other">其他</option>
                                </select>
                              </div>
                            </div>
                            <div class='col-md-3'>
                              <div class="form-label-group mt-2">
                                <input type="text" id="department" class="form-control" placeholder="幣別"
                                       name="department">
                                <label for="department">幣別</label>
                              </div>
                            </div>
                            <div class='col-md-3'>
                              <div class="form-label-group mt-2">
                                <input type="text" id="department" class="form-control" placeholder="應付費用"
                                       name="department">
                                <label for="department">應付費用</label>
                              </div>
                            </div>
                            <!--delete-->
                            <div class='col-md-auto mt-2'>
                              <button type="button" class="btn btn-icon btn-danger mr-1 mb-1 waves-effect waves-light">
                                <i class="feather icon-x"></i></button>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class='row col-md-12 justify-content-end border-top-light'>
                        <div class='col-md-4 text-right mt-1'>
                          <button type="button" class="btn btn-outline-primary mr-1 mb-1 waves-effect waves-light">
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
                  {{--代墊申請--}}
                  <h6><i class="step-icon feather icon-briefcase"></i> Step 2</h6>
                  <fieldset>
                    <div class="row col-md-12 align-items-center">
                      <div class="card">
                        <h4 class="card-title">代墊申請</h4>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-label-group">
                          <input type="text" id="member" class="form-control" placeholder="申請人" name="member">
                          <label for="member">申請人</label>
                        </div>
                      </div>
                      <div class='col-md-6'>
                        <div class="form-label-group">
                          <input type="text" id="department" class="form-control" placeholder="部門" name="department">
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
                            <select class="custom-select select2 form-control" id="pay_typ4e" name="pay_type4">
                              <option value="cash" selected>乘車</option>
                              <option value="transfer">案件</option>
                              <option value="other">交際</option>
                              <option value="other">其他</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="form-label-group mt-2">
                            <input type="text" id="department" class="form-control" placeholder="日期"
                                   name="department">
                            <label for="department">日期</label>
                          </div>
                        </div>
                        <div class='col-md-2'>
                          <div class="form-label-group mt-2">
                            <input type="text" id="name" class="form-control" placeholder="項目" name="name">
                            <label for="name">項目</label>
                          </div>
                        </div>
                        <div class='col-md-2'>
                          <div class="form-label-group mt-2">
                            <input type="text" id="department" class="form-control" placeholder="乘車起始點"
                                   name="department">
                            <label for="department">乘車起始點</label>
                          </div>
                        </div>
                        <div class='col-md-2'>
                          <div class="form-label-group mt-2">
                            <input type="text" id="name" class="form-control" placeholder="金額" name="name">
                            <label for="name">金額</label>
                          </div>
                        </div>
                        <div class='col-md-auto mt-2'>
                          <button type="button" class="btn btn-icon btn-danger mr-1 mb-1 waves-effect waves-light"><i
                              class="feather icon-x"></i></button>
                        </div>
                      </div>
                      <div class="row col-md-12">
                        <div class="col-md-2">
                          <div class="form-group">
                            <label for="pay_type3">類型</label>
                            <select class="custom-select select2 form-control" id="pay_type3" name="pay_type3">
                              <option value="cash">乘車</option>
                              <option value="transfer" selected>案件</option>
                              <option value="other">交際</option>
                              <option value="other">其他</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="form-label-group mt-2">
                            <input type="text" id="department" class="form-control" placeholder="日期"
                                   name="department">
                            <label for="department">日期</label>
                          </div>
                        </div>
                        <div class='col-md-2'>
                          <div class="form-label-group mt-2">
                            <input type="text" id="name" class="form-control" placeholder="項目" name="name">
                            <label for="name">項目</label>
                          </div>
                        </div>
                        <div class='col-md-2'>
                          <div class="form-label-group mt-2">
                            <input type="text" id="department" class="form-control" placeholder="案件委刊單號"
                                   name="department">
                            <label for="department">案件委刊單號</label>
                          </div>
                        </div>
                        <div class='col-md-2'>
                          <div class="form-label-group mt-2">
                            <input type="text" id="name" class="form-control" placeholder="金額" name="name">
                            <label for="name">金額</label>
                          </div>
                        </div>
                        <div class='col-md-auto mt-2'>
                          <button type="button" class="btn btn-icon btn-danger mr-1 mb-1 waves-effect waves-light"><i
                              class="feather icon-x"></i></button>
                        </div>
                      </div>
                      <div class="row col-md-12">
                        <div class="col-md-2">
                          <div class="form-group">
                            <label for="pay_type2">類型</label>
                            <select class="custom-select select2 form-control" id="pay_type2" name="pay_type2">
                              <option value="cash">乘車</option>
                              <option value="transfer">案件</option>
                              <option value="other" selected>交際</option>
                              <option value="other">其他</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="form-label-group mt-2">
                            <input type="text" id="department" class="form-control" placeholder="日期"
                                   name="department">
                            <label for="department">日期</label>
                          </div>
                        </div>
                        <div class='col-md-2'>
                          <div class="form-label-group mt-2">
                            <input type="text" id="name" class="form-control" placeholder="項目" name="name">
                            <label for="name">項目</label>
                          </div>
                        </div>
                        <div class='col-md-2'>
                          <div class="form-label-group mt-2">
                            <input type="text" id="department" class="form-control" placeholder="交際送禮單號"
                                   name="department">
                            <label for="department">交際送禮單號</label>
                          </div>
                        </div>
                        <div class='col-md-2'>
                          <div class="form-label-group mt-2">
                            <input type="text" id="name" class="form-control" placeholder="金額" name="name">
                            <label for="name">金額</label>
                          </div>
                        </div>
                        <div class='col-md-auto mt-2'>
                          <button type="button" class="btn btn-icon btn-danger mr-1 mb-1 waves-effect waves-light"><i
                              class="feather icon-x"></i></button>
                        </div>
                      </div>
                      <div class="row col-md-12">
                        <div class="col-md-2">
                          <div class="form-group">
                            <label for="pay_type">類型</label>
                            <select class="custom-select select2 form-control" id="pay_type1" name="pay_type1">
                              <option value="cash">乘車</option>
                              <option value="transfer">案件</option>
                              <option value="other">交際</option>
                              <option value="other" selected>其他</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="form-label-group mt-2">
                            <input type="text" id="department" class="form-control" placeholder="日期"
                                   name="department">
                            <label for="department">日期</label>
                          </div>
                        </div>
                        <div class='col-md-2'>
                          <div class="form-label-group mt-2">
                            <input type="text" id="name" class="form-control" placeholder="項目" name="name">
                            <label for="name">項目</label>
                          </div>
                        </div>
                        <div class='col-md-2'>
                          <div class="form-label-group mt-2">
                            <input type="text" id="name" class="form-control" placeholder="金額" name="name">
                            <label for="name">金額</label>
                          </div>
                        </div>
                        <div class='col-md-auto mt-2'>
                          <button type="button" class="btn btn-icon btn-danger mr-1 mb-1 waves-effect waves-light"><i
                              class="feather icon-x"></i></button>
                        </div>
                      </div>
                      <div class='row col-md-12 justify-content-end border-top-light'>
                        <div class='col-md-4 text-right mt-1'>
                          <button type="button" class="btn btn-outline-primary mr-1 mb-1 waves-effect waves-light">新增
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
                  {{--                  <!-- Step 3 -->--}}
                  {{--                  <h6><i class="step-icon feather icon-image"></i> Step 3</h6>--}}
                  {{--                  <fieldset>--}}
                  {{--                      --}}
                  {{--                  </fieldset>--}}
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </section>
  <!-- end -->
@endsection


@section('vendor-script')
  <!-- vendor files -->
  <script src="{{ asset(mix('vendors/js/extensions/jquery.steps.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/extensions/dropzone.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/ui/prism.min.js')) }}"></script>
@endsection
@section('page-script')
  <!-- Page js files -->
  <script src="{{ asset(mix('js/scripts/forms/wizard-steps.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/forms/select/form-select2.js')) }}"></script>
  <script type="text/javascript">

    $(document).ready(function () {

      $("div#file_upload").dropzone({url: "/file/post"});
    });
  </script>
@endsection


