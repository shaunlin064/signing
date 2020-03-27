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
                            <option value="travel_grant">差旅</option>
                            <option value="social">交際送禮</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </fieldset>

                  <!-- Step 2 -->
                  <h6><i class="step-icon feather icon-briefcase"></i> Step 2</h6>
                  <fieldset>
                    <div class="row col-md-12 align-items-center">
                      <div class="card">
                        <h4 class="card-title">請款單</h4>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="name">名稱(請款內容)</label>
                          <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="form-group">
                          <label for="money">含稅金額</label>
                          <input type="text" class="form-control" id="money" name="money">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="campaign_number">案件編號</label>
                          <input type="text" class="form-control" id="campaign_number" name="campaign_number">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="money">受款人</label>
                          <input type="text" class="form-control" id="money" name="money">
                        </div>
                        <div class="form-group">
                          <label for="money">開立發票日期</label>
                          <input type="text" class="form-control" id="money" name="money">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="money">發票號碼</label>
                          <input type="text" class="form-control" id="money" name="money">
                        </div>
                        <div class="form-group">
                          <label for="money">含稅金額</label>
                          <input type="text" class="form-control" id="money" name="money">
                        </div>
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


