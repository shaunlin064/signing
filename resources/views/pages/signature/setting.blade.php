<?php
	/**
	 * Created by PhpStorm.
	 * User: shaun
	 * Date: 2020/3/25
	 * Time: 18:33
	 */
?>
@extends('layouts/contentLayoutMaster')

@section('title', '設定簽名檔')

@section('vendor-style')
  <!-- vendor css files -->
@endsection

@section('page-style')
    <style>

        #signature {
            border: 2px dotted white;
        }
    </style>
  <!-- Page css files -->
@endsection

@section('content')
  {{-- Start --}}
  <section id="new">
      <signature></signature>
      <div class="row match-height">
          <signature-item :dom_id='"signature1"' :title='"簽名檔1"'></signature-item>
          <signature-item :dom_id='"signature2"' :title='"簽名檔2"'></signature-item>
          <signature-item :dom_id='"signature3"' :title='"簽名檔3"'></signature-item>
      </div>
  </section>
  <!-- end -->
@endsection


@section('vendor-script')
  <!-- vendor files -->

@endsection
@section('page-script')
  <!-- Page js files -->
@endsection
