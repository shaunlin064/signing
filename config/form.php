<?php


    return [
        1 => [
            'id'        => 1,
            'name'      => '請款單',
            'html_name' => 'form-payment',
            'column'    => [
                'apply_member_id'     => [
                    'name' => '請款人'
                ],
                'apply_department_id' => [
                    'name' => '請款單位'
                ],
                'apply_subject'       => [
                    'name' => '項目'
                ],
                'campaign_id'         => [
                    'name' => '案件'
                ],
                'beneficiary'         => [
                    'name' => '受款人'
                ],
                'receipt_number'      => [
                    'name' => '發票號碼'
                ],
                'receipt_date'        => [
                    'name' => '開票日期'
                ],
                'receipt_price'       => [
                    'name' => '發票金額'
                ],
                'pay_type'            => [
                    'name' => '付款方式'
                ],
                'remark'              => [
                    'name' => '備註'
                ],
                'apply_attachment'    => [
                    'name' => '附件'
                ],
            ]
        ],
        2 => [
            'id'        => 2,
            'name'      => '用印申請',
            'html_name' => 'form-sign',
            'column'    => [
                'apply_member_id'     => [
                    'name' => '申請人'
                ],
                'apply_department_id' => [
                    'name' => '請款單位'
                ],
                'apply_subject'       => [
                    'name' => '項目'
                ],
                'form_stamp_type'     => [
                    'name' => '用印形式'
                ],
                'deploy'              => [
                    'name' => '寄送方式'
                ],
                'recipient_company'   => [
                    'name' => '收件人公司'
                ],
                'recipient_contact'   => [
                    'name' => '收件人窗口'
                ],
                'recipient_phone'     => [
                    'name' => '收件人電話'
                ],
                'recipient_address'   => [
                    'name' => '收件人地址'
                ],
                'remark'              => [
                    'name' => '備註'
                ],
                'apply_attachment'    => [
                    'name' => '附件'
                ],
            ]
        ],
        3 => [
            'id'        => 3,
            'name'      => '交際送禮',
            'html_name' => 'form-social',
            'column'    => [
                'apply_member_id'     => [
                    'name' => '申請人'
                ],
                'apply_department_id' => [
                    'name' => '請款單位'
                ],
                'apply_subject'       => [
                    'name' => '項目'
                ],
                'customer_company'         => [
                    'name' => '客戶名稱'
                ],
                'customer_name'         => [
                    'name' => '客戶名稱'
                ],
                'attend_member'    => [
                    'name' => '出席人員'
                ],
                'type'             => [
                    'name' => '類型'
                ],
                'date'             => [
                    'name' => '事由日期'
                ],
                'cost'             => [
                    'name' => '預估費用'
                ],
                'remark'           => [
                    'name' => '備註'
                ],
                'apply_attachment' => [
                    'name' => '附件'
                ],
            ]
        ],
        4 => [
            'id'        => 4,
            'name'      => '代墊',
            'html_name' => 'form-refund',
            'column'    => [
                'apply_member_id'     => [
                    'name' => '申請人'
                ],
                'apply_department_id' => [
                    'name' => '請款單位'
                ],
                'apply_subject'       => [
                    'name' => '項目'
                ],
                'items'               => [
                    'name' => '代墊項目',
                    'sub_column' => [
                        'type' =>[
                            'name' => '類型'
                        ],
                        'date' =>[
                            'name' => '日期'
                        ],
                        'item' =>[
                            'name' => '項目'
                        ],
                        'get_on_start' =>[
                            'name' => '乘車起始點'
                        ],
                        'campaign_id' =>[
                            'name' => '委刊編號'
                        ],
                        'gift_id' =>[
                            'name' => '交際送禮單號'
                        ],
                        'price' =>[
                            'name' => '金額'
                        ],
                    ]
                ],
                'remark'              => [
                    'name' => '備註'
                ],
                'apply_attachment'    => [
                    'name' => '附件'
                ],
            ]
        ],
        5 => [
            'id'        => 5,
            'name'      => '差旅申請',
            'html_name' => 'form-travel_grant',
            'column'    => [
                'apply_member_id'     => [
                    'name' => '申請人'
                ],
                'apply_department_id' => [
                    'name' => '請款單位'
                ],
                'apply_subject'       => [
                    'name' => '項目'
                ],
                'accompany_user_id'     => [
                    'name' => '出差人'
                ],
                'travel_date_start' =>[
                    'name' => '出差起始日期'
                ],
                'travel_date_end' =>[
                    'name' => '出差結束日期'
                ],
                'travel_location' =>[
                    'name' => '出差地點'
                ],
                'travel_stay_location' => [
                    'name' => '住宿地點'
                ],
                'predict_cost' => [
                    'name' => '預估費用'
                ],
                'travel_remark' => [
                  'name' => '出差事由詳述'
                ],
                'items'=>[
                    'name' => '出差計畫',
                    'sub_column' => [
                        'date' =>[
                            'name' => '日期'
                        ],
                        'customer_name' =>[
                            'name' => '對象姓名'
                        ],
                        'customer_company' =>[
                            'name' => '洽訪公司'
                        ],
                        'meet_type' =>[
                            'name' => '會議形式'
                        ],
                        'agenda' =>[
                            'name' => '洽談內容'
                        ],
                        'charge_user' =>[
                            'name' => '負責業務'
                        ],
                    ]
                ],
                'remark'              => [
                    'name' => '備註'
                ],
                'apply_attachment'    => [
                    'name' => '附件'
                ],
            ]
        ],
        6 => [
            'id'        => 6,
            'name'      => '差旅費用核銷',
            'html_name' => 'form-travel_fee',
            'column'    => [
                'apply_member_id'     => [
                    'name' => '申請人'
                ],
                'apply_department_id' => [
                    'name' => '請款單位'
                ],
                'apply_subject'       => [
                    'name' => '項目'
                ],
                'form_travel_grant_id'     => [
                    'name' => '差旅單'
                ],
                'items'=>[
                    'name' => '出差計畫',
                    'sub_column' => [
                        'cost_type' =>[
                            'name' => '費用類型'
                        ],
                        'currency' =>[
                            'name' => '幣別'
                        ],
                        'fee' =>[
                            'name' => '費用'
                        ]
                    ]
                ],
                'remark'              => [
                    'name' => '備註'
                ],
                'apply_attachment'    => [
                    'name' => '附件'
                ],
            ]
        ],
    ];
