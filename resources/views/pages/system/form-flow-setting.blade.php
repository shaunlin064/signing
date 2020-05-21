<?php
    /**
     * Created by PhpStorm.
     * User: shaun
     * Date: 2020/5/19
     * Time: 12:21
     */


?>
@extends('layouts/contentLayoutMaster')

@section('title', '簽核關卡設定')
@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/dragula.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection
@section('page-style')
    <!-- Page css files -->
    <link rel="stylesheet" href="{{ asset(mix('css/pages/app-todo.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/pages/form-flow-setting.css')) }}">
    <!-- Page css files -->
    <link rel="stylesheet" href="{{ asset(mix('css/plugins/extensions/drag-and-drop.css')) }}">
@endsection

@section('content-sidebar')
    <system-flow_setting-sidebar-left :form_config='{{json_encode(Config('form'))}}'></system-flow_setting-sidebar-left>
@endsection

@section('content')
    <system-flow_setting-content-right></system-flow_setting-content-right>
@endsection
@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/extensions/dragula.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection
@section('page-script')
    <!-- Page js files -->
    <script src="{{ asset(mix('js/scripts/pages/app-todo.js')) }}"></script>
@endsection
