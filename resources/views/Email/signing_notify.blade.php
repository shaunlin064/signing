@extends('Email.layouts.master')

@section('content')
    <div class="block_div">
        <div class="block-grid" style=" background-color: #FFFFFF;">
            <div class="block_raw" style="background-color: #FFFFFF;">
                <div class="col num12 block_col">
                    <div style="width:100% !important;">
                        <div class="col_div ptl_0" style="padding-top:0px; padding-bottom:5px;">
                            <div class="div_font div_padding_10" style="color:#0D0D0D;line-height:1.2;padding-top:10px;">
                                <div class="div_font" style="font-size: 12px; line-height: 1.2; color: #0D0D0D; mso-line-height-alt: 14px;">
                                    <p class="div_p" style="font-size: 28px; line-height: 1.2; mso-line-height-alt: 34px; margin: 0;"><span style="font-size: 28px;"><strong><span style="font-size: 28px;">傑思 愛德威 - 簽核系統通知</span></strong>
                                                        </span>
                                        <br/><span style="font-size: 28px;">Hi {{$name}},</span></p>
                                </div>
                            </div>
                            <div align="center" class="img-container center">
                                <img align="center" alt="Image" border="0" class="center div_image" src="{{$message->embed(asset('email_layout/images/divider.png'))}}" style="max-width: 318px;" title="Image" width="318" />
                            </div>
                            <div class="div_font div_padding_10" style="color:#555555;line-height: 1.5;padding-top:10px;">
                                <div sclass="div_font" tyle="font-size: 12px; line-height: 1.5; color: #555555; mso-line-height-alt: 18px;">
                                    <p class="div_p content_text">會收到這封信是簽核系統中有需要您簽核的單據
                                        <br/>資料如下 : </p>
                                </div>
                            </div>
                            <div class="div_font div_padding_10" style="color:#0D0D0D;line-height: 1.5;padding-top:20px;">
                                <div class="div_font" style="font-size: 12px; line-height: 1.5; color: #0D0D0D;mso-line-height-alt: 18px;">
                                    <p class="div_p content_text">
                                        <br/>單據類型 : {{ Config('form.'.$form_id.'.name') }}
                                        <br/>申請人 : {{$member}}
                                        <br/>申請日期 : {{$created_at}}
                                        <br/>其他詳細資料請上簽核系統查詢
                                    </p>
                                </div>
                            </div>
                            <div align="center" class="button-container div_padding_10" style="padding-top:25px;">
                                <div class="div_font" style="text-decoration:none;display:inline-block;color:#ffffff;background-color:#a8bf6f;border-radius:4px;-webkit-border-radius:4px;-moz-border-radius:4px;width:auto; width:auto;;border-top:1px solid #a8bf6f;border-right:1px solid #a8bf6f;border-bottom:1px solid #a8bf6f;border-left:1px solid #a8bf6f;padding-top:15px;padding-bottom:15px;text-align:center;mso-border-alt:none;word-break:keep-all;">
													<span style="padding-left:15px;padding-right:15px;font-size:16px;display:inline-block;">
														<span style="font-size: 16px; line-height: 2; word-break: break-word; mso-line-height-alt: 32px;">
															<a href="#" style="color:#fff">點我查看</a>
														</span>
													</span>
                                </div>
                            </div>
                            <table class="table_fixed" border="0" cellpadding="0" cellspacing="0" class="divider ms_text" role="presentation" style="min-width: 100%;" valign="top" width="100%">
                                <tbody>
                                <tr style="vertical-align: top;" valign="top">
                                    <td class="divider_inner table_td ms_text" style="min-width: 100%; padding-top: 30px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px;" valign="top">
                                        <table class="table_fixed" align="center" border="0" cellpadding="0" cellspacing="0" class="divider_content" role="presentation" style="border-top: 0px solid transparent; width: 100%;" valign="top" width="100%">
                                            <tbody>
                                            <tr style="vertical-align: top;" valign="top">
                                                <td class="table_td ms_text" valign="top"><span></span></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
