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
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title"></h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form-new></form-new>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
    <!-- <script src="{{ asset(mix('js/scripts/forms/wizard-steps.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/forms/select/form-select2.js')) }}"></script> -->
    <script type="text/javascript">

    </script>
@endsection


