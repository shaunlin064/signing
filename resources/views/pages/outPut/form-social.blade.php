<?php
	/**
	 * Created by PhpStorm.
	 * User: shaun
	 * Date: 2020/5/26
	 * Time: 14:11
	 */
	?>
@extends('pages.outPut.layouts.contentLayoutMaster')
@section('page')
    <div class="page">
        <div class="subpage">
            <div class='row'>
                {{--head Log--}}
                @include('pages.outPut.layouts.head')
                <div class='body'>
                    <table class='table' border='1' cellpadding="3" cellspacing="1">
                        <tbody>
                        <tr class='breakLine'>
                            <td colspan="4" border='1'>申請內容</td>
                        </tr>
                        @include('pages.outPut.layouts.formUser')
                        {{--form content--}}
                        <tr>
                            <td class='title w2'>{{$config['column']['attend_member']['name']}}</td>
                            <td class='w3' colspan="3">
                                {{$signing['column']['attend_member']}}
                            </td>
                        </tr>
                        <tr>
                            <td class='title w2'>{{$config['column']['apply_subject']['name']}}</td>
                            <td colspan='3' class='w3'>{{$signing['column']['apply_subject']}}</td>
                        </tr>
                        <tr>
                            <td class='title w2'>{{$config['column']['social_date']['name']}}</td>
                            <td class='w3'>{{$signing['column']['social_date']}}</td>
                            <td class='title w2'>{{$config['column']['type']['name']}}</td>
                            <td class='w3'>{{$config['column']['type']['value'][$signing['column']['type']]}}</td>
                        </tr>
                        <tr>
                            <td class='title w2'>{{$config['column']['customer_company']['name']}}</td>
                            <td colspan='3' class='w3'>{{$signing['column']['customer_company']}}</td>
                        </tr>
                        <tr>
                            <td class='title w2'>{{$config['column']['customer_name']['name']}}</td>
                            <td class='w3'>{{$signing['column']['customer_name']}}</td>
                            <td class='title w2'>{{$config['column']['cost']['name']}}</td>
                            <td class='w3'>NT${{$signing['column']['cost']}}</td>
                        </tr>
                        <tr>
                            <th colspan="4" class='title w2'>{{$config['column']['remark']['name']}}</th>
                        </tr>
                        <tr>
                            <td colspan="4">{{$signing['column']['remark']}}</td>
                        </tr>
                        {{--check point--}}
                        <tr class='breakLine'>
                            <td colspan="4" border='1'>簽核</td>
                        </tr>
                        @include('pages.outPut.layouts.checkPoint')
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
