<?php
    /**
     * Created by PhpStorm.
     * User: shaun
     * Date: 2020/3/25
     * Time: 18:30
     */
?>
@extends('layouts/contentLayoutMaster')

@section('title', '待執行簽核')

@section('vendor-style')
    {{-- vendor css files --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/ag-grid/ag-grid.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/ag-grid/ag-theme-material.css')) }}">
@endsection

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/pages/aggrid.css')) }}">
@endsection

@section('content')
    {{-- Start --}}
    <section id="form-list">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <ag :dom_id='"ag_action"' :api_parmater_role='2'></ag>
                </div>
            </div>
        </div>
    </section>
    <!-- end -->
@endsection


@section('vendor-script')
    {{-- vendor files --}}
    <script src="{{ asset(mix('vendors/js/tables/ag-grid/ag-grid-community.min.noStyle.js')) }}"></script>
@endsection
@section('page-script')

@endsection
