<?php
	/**
	 * Created by PhpStorm.
	 * User: shaun
	 * Date: 2020/5/26
	 * Time: 15:05
	 */
	?>
@extends('pages.outPut.layouts.contentLayoutMaster')
@section('page')
    @if(count($signing['column']['items']) <=9)
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
                                <td colspan='4'>代墊明細</td>
                            </tr>
                            <tr>
                                <td colspan='4' style="padding: 0px;margin: 0px;">
                                    <table class='table'
                                           style="border: 1px solid black;border-top: none;border-left: none;"
                                           border='1' cellpadding="3" cellspacing="1">
                                        <tr>
                                            <th class='w2'>日期</th>
                                            <th>類型</th>
                                            <th>名稱</th>
                                            <th>編號/起始點</th>
                                            <th>金額</th>
                                        </tr>
                                        @foreach($signing['column']['items'] as $item)
                                            <tr>
                                                <td class='w2'>{{$item['date']}}</td>
                                                <td>{{$item['type']}}</td>
                                                <td class='w3'>{{$item['name']}}</td>
                                                @switch($item['type'])
                                                    @case('乘車')
                                                    <td>{{$item['get_on_start']}}</td>
                                                    @break
                                                    @case('案件')
                                                    <td>{{$item['campaign_id']}}</td>
                                                    @break
                                                    @case('交際')
                                                    <td>{{$item['form_pair_data_id']}}</td>
                                                    @break
                                                    @default
                                                    <td></td>
                                                @endswitch
                                                <td>{{$item['price']}}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan='4'>總計</td>
                            </tr>
                            <tr>
                                <td colspan='4' style="padding: 0px;margin: 0px;">
                                    <table class='table'
                                           style="border: 1px solid black;border-top: none;border-left: none;"
                                           border='1' cellpadding="3" cellspacing="1">
                                        <tr>
                                            <th>乘車</th>
                                            <th>案件</th>
                                            <th>交際</th>
                                            <th>其他</th>
                                            <th>Total</th>
                                        </tr>
                                        <tr>
                                            @foreach(['乘車','案件','交際','其他'] as $typeName)
                                                <td>
                                                    {{collect($signing['column']['items'])->where('type',$typeName)->sum('price')}}
                                                </td>
                                            @endforeach
                                            <td>{{collect($signing['column']['items'])->sum('price')}}</td>
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
            </div>
        </div>
    @else
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
                            <tr>
                                <td colspan='4'>總計</td>
                            </tr>
                            <tr>
                                <td colspan='4' style="padding: 0px;margin: 0px;">
                                    <table class='table'
                                           style="border: 1px solid black;border-top: none;border-left: none;"
                                           border='1' cellpadding="3" cellspacing="1">
                                        <tr>
                                            <th>乘車</th>
                                            <th>案件</th>
                                            <th>交際</th>
                                            <th>其他</th>
                                            <th>Total</th>
                                        </tr>
                                        <tr>
                                            @foreach(collect($signing['column']['items'])->groupBy('type') as $item)
                                                <td>{{$item->sum('price')}}</td>
                                            @endforeach
                                            <td>{{collect($signing['column']['items'])->sum('price')}}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            {{--                            --}}{{--check point--}}
                            <tr>
                                <th colspan="4" class='title w2'>{{$config['column']['remark']['name']}}</th>
                            </tr>
                            <tr>
                                <td colspan="4">{{$signing['column']['remark']}}</td>
                            </tr>
                            <tr class='breakLine'>
                                <td colspan="4" border='1'>簽核</td>
                            </tr>
                            @include('pages.outPut.layouts.checkPoint')
                            </tbody>
                        </table>
                    </div>
                    <div class='footer'>
                        <p class='text-right'>page :
                            1/{{collect($signing['column']['items'])->chunk(18)->count()+1}}</p>
                    </div>
                </div>
            </div>
        </div>
        @foreach(collect($signing['column']['items'])->chunk(18) as $pageKey =>  $itemPage)
            <div class='page'>
                <div class='subpage'>
                    <div class='row'>
                        @include('pages.outPut.layouts.head')
                        <div class='body'>
                            <table class='table' border='1' cellpadding="3" cellspacing="1">
                                <tbody>
                                {{--form content--}}
                                <tr>
                                    <td colspan='5'>代墊明細</td>
                                </tr>
                                <tr>
                                    <th class='w2'>日期</th>
                                    <th>類型</th>
                                    <th>名稱</th>
                                    <th>編號/起始點</th>
                                    <th>金額</th>
                                </tr>
                                @foreach($itemPage as $key => $item)
                                    <tr>
                                        <td class='w2'>{{$item['date']}}</td>
                                        <td>{{$item['type']}}</td>
                                        <td class='w3'>{{$item['name']}}</td>
                                        @switch($item['type'])
                                            @case('乘車')
                                            <td>{{$item['get_on_start']}}</td>
                                            @break
                                            @case('案件')
                                            <td>{{$item['campaign_id']}}</td>
                                            @break
                                            @case('交際')
                                            <td>{{$item['form_pair_data_id']}}</td>
                                            @break
                                            @default
                                            <td></td>
                                        @endswitch
                                        <td>{{$item['price']}}</td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div class='footer'>
                            <p class='text-right'>page : {{$pageKey+2}}
                                /{{collect($signing['column']['items'])->chunk(18)->count()+1}}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
@endsection
@section('script')

@endsection
