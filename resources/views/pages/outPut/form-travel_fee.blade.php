<?php
    /**
     * Created by PhpStorm.
     * User: shaun
     * Date: 2020/5/27
     * Time: 13:40
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
                            <td colspan='4'>旅費總計</td>
                        </tr>
                        <tr>
                            <td colspan='4' style="padding: 0px;margin: 0px;">
                                <table class='table'
                                       style="border: 1px solid black;border-top: none;border-left: none;"
                                       border='1' cellpadding="3" cellspacing="1">
                                    <tr>
                                        @foreach($config['column']['items']['sub_column']['fee_items']['sub_column']['type']['vale'] as $type)
                                            <th>{{$type}}</th>
                                        @endforeach
                                        <th>Total</th>
                                    </tr>
                                    <tr>
                                        @foreach($signing['fee_items_total']->groupBy('type') as $item)
                                            <td>{{$item->sum('fee')}}</td>
                                        @endforeach
                                        <td>{{$signing['fee_items_total']->sum('fee')}}</td>
                                    </tr>
                                </table>
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
            <div class='footer'>
                <p class='text-right'>page :
                    1/{{collect($signing['column']['items'])->chunk(16)->count()+1}}</p>
            </div>
        </div>
    </div>
    @foreach(collect($signing['column']['items'])->chunk(16) as $pageKey =>  $itemPage)
        <div class="page">
            <div class="subpage">
                <div class='row'>
                    {{-- head Log--}}
                    @include('pages.outPut.layouts.head')
                    <div class='body'>
                        <table class='table' border='1' cellpadding="3" cellspacing="1">
                            <tbody>
                            <tr class='breakLine'>
                                <td colspan="7" border='1'>費　用　明　細</td>
                            </tr>
                            <tr>
                                <th> {{ $config['column']['items']['sub_column']['date']['name'] }}</th>
                                <th> {{ $config['column']['items']['sub_column']['customer_company']['name'] }}</th>
                                <th>交通</th>
                                <th>交際</th>
                                <th>漫遊</th>
                                <th>其他</th>
                                <th>Total</th>
                            </tr>
                            {{--                                    出差計畫 明細--}}
                            @foreach($itemPage as $item)
                                <tr>
                                    <td>{{date('m/d',strtotime($item['date']))}}</td>
                                    <td>{{$item['customer_company']}}</td>
                                    <td>{{collect($item['fee_items'])->where('type','交通')->sum('fee')}}</td>
                                    <td>{{collect($item['fee_items'])->where('type','交際')->sum('fee')}}</td>
                                    <td>{{collect($item['fee_items'])->where('type','漫遊')->sum('fee')}}</td>
                                    <td>{{collect($item['fee_items'])->where('type','其他')->sum('fee')}}</td>
                                    <td>{{collect($item['fee_items'])->sum('fee')}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class='footer'>
                            <p class='text-right'>page : {{$pageKey+2}}
                                /{{collect($signing['column']['items'])->chunk(16)->count()+1}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
