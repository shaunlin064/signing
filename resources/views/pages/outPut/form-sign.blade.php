<?php
	/**
	 * Created by PhpStorm.
	 * User: shaun
	 * Date: 2020/5/26
	 * Time: 13:45
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
                            <td class='title w2'>{{$config['column']['apply_subject']['name']}}</td>
                            <td colspan="3" class='w3'>{{$signing['column']['apply_subject']}}</td>
                        </tr>
                        <tr>
                            <td class='title w2'>{{$config['column']['form_stamp_type']['name']}}</td>
                            <td class='w3'>
                                @foreach(json_decode($signing['column']['form_stamp_type']) as $item )
                                    <div class='box'>
                                        <input type='checkbox' checked='checked'><label>{{$config['column']['form_stamp_type']['value'][$item]}}</label>
                                    </div>
                                @endforeach
                            </td>
                            <td class='title w2'>{{$config['column']['deployed']['name']}}</td>
                            <td colspan="3" class='w3'>{{$config['column']['deployed']['value'][$signing['column']['deployed']]}}</td>
                        </tr>
                        <tr>
                            <td class='title w2'>{{$config['column']['recipient_company']['name']}}</td>
                            <td colspan="3" class='w3'>{{$signing['column']['recipient_company']}}</td>
                        </tr>
                        <tr>
                            <td class='title w2'>{{$config['column']['recipient_address']['name']}}</td>
                            <td colspan="3" class='w3'>{{$signing['column']['recipient_address']}}</td>
                        </tr>
                        <tr>
                            <td class='title w2'>{{$config['column']['recipient_contact']['name']}}</td>
                            <td class='w3'>{{$signing['column']['recipient_contact']}}</td>
                            <td class='title w2'>{{$config['column']['recipient_phone']['name']}}</td>
                            <td class='w3'>{{$signing['column']['recipient_phone']}}</td>
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
