<?php
	/**
	 * Created by PhpStorm.
	 * User: shaun
	 * Date: 2020/5/26
	 * Time: 12:13
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
                                <td class='title w2'>{{$config['column']['beneficiary']['name']}}</td>
                                <td class='w3' colspan="3">{{$signing['column']['beneficiary']}}</td>
                            </tr>
                            <tr>
                                <td class='title w2'>{{$config['column']['receipt_number']['name']}}</td>
                                <td class='w3'>{{$signing['column']['receipt_number']}}</td>
                                <td class='title w2'>{{$config['column']['receipt_date']['name']}}</td>
                                <td class='w3'>{{$signing['column']['receipt_date']}}</td>
                            </tr>
                            <tr>
                                <td class='title w2'>{{$config['column']['campaign_id']['name']}}</td>
                                <td class='w3'>{{$signing['column']['campaign_id']}}</td>
                                <td class='title w2'>{{$config['column']['receipt_price']['name']}}</td>
                                <td class='w3'>{{$signing['column']['receipt_price']}}</td>
                            </tr>
                            <tr>
                                <td class='title w2'>{{$config['column']['pay_type']['name']}}</td>
                                <td colspan="3">
                                    @if($signing['column']['pay_type']==='cash')
                                        <div class='box'>
                                            <input type='checkbox' checked='checked'><label>現金</label>
                                        </div>
                                    @endif
                                    @if($signing['column']['pay_type'] ==='transfer')
                                        <div class='box'>
                                            <input type='checkbox' checked='checked'><label>電匯</label>
                                            <p class='content'>指定日期 ： {{$signing['column']['transfer_date']}}</p>
                                        </div>
                                    @endif
                                    @if($signing['column']['pay_type'] ==='other')
                                        <div class='box'>
                                            <input type='checkbox'
                                                   checked='checked'><label>其他</label>
                                            <p class='content'>__________________</p>
                                        </div>
                                    @endif
                                </td>
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

