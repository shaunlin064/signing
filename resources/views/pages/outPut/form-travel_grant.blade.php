<?php
	/**
	 * Created by PhpStorm.
	 * User: shaun
	 * Date: 2020/5/26
	 * Time: 17:37
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
                                <td class='title w2'>{{$config['column']['accompany_user_id']['name']}}</td>
                                <td class='w3' colspan="3">
                                    {{$signing['column']['accompany_user_id']}}
                                </td>
                            </tr>
                            <tr>
                                <td class='title w2'>出差期間</td>
                                <td class='w3'>{{$signing['column']['travel_date_start'] .'  至  '. $signing['column']['travel_date_end']}} 共{{count(date_range($signing['column']['travel_date_start'] , $signing['column']['travel_date_end']))}}日</td>
                                <td class='title w2'>{{$config['column']['predict_cost']['name']}}</td>
                                <td class='w3'>{{$signing['column']['predict_cost']}}</td>
                            </tr>
                            <tr>
                                <td class='title w2'>{{$config['column']['travel_location']['name']}}</td>
                                <td class='w3'>{{$signing['column']['travel_location']}}</td>
                                <td class='title w2'>{{$config['column']['travel_stay_location']['name']}}</td>
                                <td class='w3'>{{$signing['column']['travel_stay_location']}}</td>
                            </tr>
                            <tr>
                                <td class='title w2'>{{$config['column']['travel_remark']['name']}}</td>
                                <td colspan="3" class='w3'>{{$signing['column']['travel_remark']}}</td>
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
                        <div class='footer'>
                            <p class='text-right'>page : 1/{{collect($signing['column']['items'])->chunk(16)->count()+1}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @foreach(collect($signing['column']['items'])->chunk(16) as $pageKey =>  $itemPage)
        <div class="page">
            <div class="subpage">
                <div class='row'>
                    {{--head Log--}}
                    @include('pages.outPut.layouts.head')
                    <div class='body'>
                        <table class='table' border='1' cellpadding="3" cellspacing="1">
                            <tbody>
                            <tr class='breakLine'>
                                <td colspan="6" border='1'>出　差　計　劃</td>
                            </tr>
                            <tr>
                                @foreach($config['column']['items']['sub_column'] as $subColumn)
                                    @if($subColumn['name'] !== 'id')
                                    <th>{{$subColumn['name']}}</th>
                                    @endif
                                @endforeach
                            </tr>
                            {{--出差計畫 明細--}}
                            @foreach($itemPage as $item)
                            <tr>
                                @foreach($config['column']['items']['sub_column'] as $subColumnKey => $subColumn)
                                    @if($subColumnKey == 'id')
                                        @continue
                                    @endif
                                    @switch($subColumnKey)
                                        @case('charge_user')
                                            <td>{{ session('js_signing.member')[$item[$subColumnKey]]['name']}}</td>
                                        @break
                                        @case('date')
                                            <td>{{ date('m/d', strtotime($item['date']) )}}</td>
                                        @break
                                        @default
                                            <td>{{$item[$subColumnKey]}}</td>
                                        @endswitch
                                @endforeach
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class='footer'>
                            <p class='text-right'>page : {{$pageKey+2}}/{{collect($signing['column']['items'])->chunk(16)->count()+1}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
@endsection
