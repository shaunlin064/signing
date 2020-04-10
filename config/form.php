<?php


    return [
        1 => [
            'id'        => 1,
            'name'      => '請款單',
            'html_name' => 'form-payment',
            'column'    => [
                'apply_attachment'    => [
                    'name'    => '附件'
                ],
                'apply_subject'       => [
                    'name'    => '項目'
                ],
                'apply_member_id'     => [
                    'name'    => '請款人'
                ],
                'apply_department_id' => [
                    'name'    => '請款單位'
                ],
                'campaign_id'         => [
                    'name'    => '案件'
                ],
                'beneficiary'         => [
                    'name'    => '受款人'
                ],
                'receipt_number'      => [
                    'name'    => '發票號碼'
                ],
                'receipt_date'        => [
                    'name'    => '開票日期'
                ],
                'receipt_price'       => [
                    'name'    => '發票金額'
                ],
                'pay_type'            => [
                    'name'    => '付款方式'
                ],
                'remark'              => [
                    'name'    => '備註'
                ]
            ]
        ],
        2 => [
            'id'        => 2,
            'name'      => '用印申請',
            'html_name' => 'form-sign',
            'column'    => [
                'apply_member_id'   => [
                    'name' => '申請人'
                ],
                'apply_subject'       => [
                    'name'    => '項目'
                ],
                'apply_department_id' => [
                    'name'    => '請款單位'
                ],
                'form_stamp_type'    => [
                    'name' => '用印形式'
                ],
                'deploy'            => [
                    'name' => '寄送方式'
                ],
                'recipient_company' => [
                    'name' => '收件人公司'
                ],
                'recipient_contact' => [
                    'name' => '收件人窗口'
                ],
                'recipient_phone'   => [
                    'name' => '收件人電話'
                ],
                'recipient_address' => [
                    'name' => '收件人地址'
                ],
                'remark'              => [
                    'name'    => '備註'
                ]
            ]
        ],
        3 => [
            'id'        => 3,
            'name'      => '交際送禮',
            'html_name' => '',
            'column'    => [
                'customer'      => [
                    'name' => '客戶名稱'
                ],
                'attend_member' => [
                    'name' => '出席人員'
                ],
                'type'          => [
                    'name' => '類型'
                ],
                'date'          => [
                    'name' => '事由日期'
                ],
                'cost'          => [
                    'name' => '預估費用'
                ],
                'remark'        => [
                    'name' => '備註'
                ]
            ]
        ]
    ];
