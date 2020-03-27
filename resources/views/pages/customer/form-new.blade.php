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
                {{--<h6><i class="step-icon feather icon-home"></i> Step 1</h6>
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
                          <option value="travel_grant">差旅</option>
                          <option value="social">交際送禮</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </fieldset>--}}

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
                      <div class="col-md-6">
                        <div class="form-label-group">
                          <input type="text" id="name" class="form-control" placeholder="項目" name="name">
                          <label for="name">項目</label>
                        </div>
                        <div class="form-label-group">
                          <input type="text" id="department" class="form-control" placeholder="部門" name="department">
                          <label for="department">部門</label>
                        </div>
                        <div class="form-label-group">
                          <input type="text" id="member" class="form-control" placeholder="申請人" name="member">
                          <label for="member">申請人</label>
                        </div>
                        <div class="form-label-group">
                          <input type="text" id="id_number" class="form-control" placeholder="案件編號" name="id_number">
                          <label for="id_number">案件編號</label>
                        </div>
                        <div class="form-label-group">
                          <input type="text" id="price" class="form-control" placeholder="金額(稅)" name="price">
                          <label for="price">請款金額(稅)</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-label-group">
                          <input type="text" id="customer" class="form-control" placeholder="受款人" name="customer">
                          <label for="customer">受款人</label>
                        </div>
                        <div class="form-label-group">
                          <input type="text" id="receipt_number" class="form-control" placeholder="發票號碼"
                                 name="receipt_number">
                          <label for="receipt_number">發票號碼</label>
                        </div>
                        <div class="form-label-group">
                          <input type="text" id="receipt_date" class="form-control" placeholder="開立發票日期"
                                 name="receipt_date">
                          <label for="receipt_date">開立發票日期</label>
                        </div>
                        <div class="form-label-group">
                          <input type="text" id="receipt_price" class="form-control" placeholder="發票金額(稅)"
                                 name="receipt_price">
                          <label for="receipt_price">發票金額(稅)</label>
                        </div>
                        <div class="form-group">
                          <label for="pay_type">付款方式</label>
                          <select class="custom-select select2 form-control" id="pay_type" name="pay_type">
                            <option value="cash">現金</option>
                            <option value="transfer">電匯</option>
                            <option value="other">其他</option>
                          </select>
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
                          <input type="text" id="name" class="form-control" placeholder="項目" name="name">
                          <label for="name">項目</label>
                        </div>
                        <div class="form-label-group">
                          <input type="text" id="department" class="form-control" placeholder="部門" name="department">
                          <label for="department">部門</label>
                        </div>
                        <div class="form-label-group">
                          <input type="text" id="member" class="form-control" placeholder="申請人" name="member">
                          <label for="member">申請人</label>
                        </div>
                        <div class="form-group">
                          <label for="form">用印形式</label>
                          <select class="custom-select select2 form-control" id="form" name="form">
                            <option value="company">公司大章</option>
                            <option value="principal">負責人章</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="deployed">寄送方式</label>
                          <select class="custom-select select2 form-control" id="deployed" name="deployed">
                            <option value="company">總務寄出</option>
                            <option value="self">自行寄出</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-label-group">
                          <input type="text" id="customer" class="form-control" placeholder="收件人公司" name="customer">
                          <label for="customer">收件人公司</label>
                        </div>
                        <div class="form-label-group">
                          <input type="text" id="contact_name" class="form-control" placeholder="收件人窗口"
                                 name="contact_name">
                          <label for="contact_name">收件人窗口</label>
                        </div>
                        <div class="form-label-group">
                          <input type="text" id="contact_name" class="form-control" placeholder="收件人電話"
                                 name="contact_name">
                          <label for="contact_name">收件人電話</label>
                        </div>
                        <div class="form-label-group">
                          <input type="text" id="contact_phone" class="form-control" placeholder="收件人地址"
                                 name="contact_phone">
                          <label for="contact_phone">收件人地址</label>
                        </div>
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
                          <input type="text" id="name" class="form-control" placeholder="項目" name="name">
                          <label for="name">項目</label>
                        </div>
                        <div class="form-label-group">
                          <input type="text" id="department" class="form-control" placeholder="部門" name="department">
                          <label for="department">部門</label>
                        </div>
                        <div class="form-label-group">
                          <input type="text" id="member" class="form-control" placeholder="申請人" name="member">
                          <label for="member">申請人</label>
                        </div>
                        <div class="form-label-group">
                          <input type="text" id="price" class="form-control" placeholder="預估費用"
                                 name="price">
                          <label for="price">預估費用</label>
                        </div>
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
                        <div class="form-label-group">
                          <input type="text" id="customer" class="form-control" placeholder="受款人" name="customer">
                          <label for="customer">客戶公司名稱</label>
                        </div>
                        <div class="form-label-group">
                          <input type="text" id="date" class="form-control" placeholder="事由日期"
                                 name="date">
                          <label for="date">事由日期</label>
                        </div>
                        <div class="form-label-group">
                          <fieldset class="form-label-group">
                            <textarea class="form-control" id="remark" rows="7" placeholder="備註"
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


