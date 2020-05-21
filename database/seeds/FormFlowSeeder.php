<?php

use Illuminate\Database\Seeder;

class FormFlowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        /**
         * 請款單 ========================================================
         */
//        $table->unsignedTinyInteger('form_id')->comment('簽核表單ID');
//        $table->unsignedTinyInteger('review_order')->comment('簽核順位');

//        $table->unsignedTinyInteger('review_type')->comment('簽核人類型 1:指定人 2:指定位階');
//        $table->unsignedInteger('reviewer_id')->comment('指定簽核人ID or 簽核位階 1:一階主管 2:二階主管 3:三階主管');
//        $table->unsignedTinyInteger('overwrite')->comment('是否可被上層簽核取代 0:不可 1:可');
//        $table->unsignedTinyInteger('replace')->comment('是否有代簽 0:不可 1:可');
//        $table->unsignedTinyInteger('role')->comment('角色 1:簽核 2:執行');
        $obj = new \App\Http\Controllers\API\FormFlowController();
        $data = [
            [
                'name' => '表單驗證',
                'review_type' => 1,
                'reviewer_id' => 106, //雨涵
                'overwrite' => 0,
                'replace' => 0,
                'role' => 1,
            ],
            [
                'name' => '部級主管',
                'review_type' => 2,
                'reviewer_id' => 1, //一階主管
                'overwrite' => 1,
                'replace' => 0,
                'role' => 1,
            ],
            [
                'name' => '單位最高主管',
                'review_type' => 2,
                'reviewer_id' => 3, //最高主管
                'overwrite' => 1,
                'replace' => 0,
                'role' => 1,
            ],
            [
                'name' => '財務長',
                'review_type' => 1,
                'reviewer_id' => 17, //van
                'overwrite' => 1,
                'replace' => 0,
                'role' => 1,
            ],
            [
                'name' => '執行長',
                'review_type' => 1,
                'reviewer_id' => 15, //老大
                'overwrite' => 0,
                'replace' => 0,
                'role' => 1,
            ],
            [
                'name' => '財務',
                'review_type' => 1,
                'reviewer_id' => 202, //Parin
                'overwrite' => 0,
                'replace' => 1,
                'role' => 2,
                'replace_type' => [1,1,1],
                'replace_id' => [63,178,203]
            ],
        ];

        foreach($data as $k => $item){

            $item['form_id'] = 1;
            $item['review_order'] = $k+1;
            $obj->add(newRequest($item));
        }

        /**
         * EDN請款單 ========================================================
         */

        /**
         * 用印申請 ========================================================
         */
        $data = [
            [
                'name' => '執行長室',
                'review_type' => 1,
                'reviewer_id' => 106, //雨涵
                'overwrite' => 0,
                'replace' => 0,
                'role' => 1,
            ],
            [
                'name' => '部級主管',
                'review_type' => 2,
                'reviewer_id' => 1, //一階主管
                'overwrite' => 1,
                'replace' => 0,
                'role' => 1,
            ],
            [
                'name' => '單位最高主管',
                'review_type' => 2,
                'reviewer_id' => 3, //最高主管
                'overwrite' => 1,
                'replace' => 0,
                'role' => 1,
            ],
            [
                'name' => '財務長',
                'review_type' => 1,
                'reviewer_id' => 17, //van
                'overwrite' => 1,
                'replace' => 0,
                'role' => 1,
            ],
            [
                'name' => '執行長',
                'review_type' => 1,
                'reviewer_id' => 15, //老大
                'overwrite' => 0,
                'replace' => 0,
                'role' => 1,
            ],
            [
                'name' => '總務',
                'review_type' => 1,
                'reviewer_id' => 190, //Ann
                'overwrite' => 0,
                'replace' => 1,
                'role' => 2,
                'replace_type' => [1],
                'replace_id' => [106]
            ],
        ];

        foreach($data as $k => $item){

            $item['form_id'] = 2;
            $item['review_order'] = $k+1;
            $obj->add(newRequest($item));
        }


        /**
         * END用印申請 ========================================================
         */

        /**
         * 交際送禮 ========================================================
         */
        $data = [
            [
                'name' => '執行長室',
                'review_type' => 1,
                'reviewer_id' => 106, //雨涵
                'overwrite' => 0,
                'replace' => 0,
                'role' => 1,
            ],
            [
                'name' => '部級主管',
                'review_type' => 2,
                'reviewer_id' => 1, //一階主管
                'overwrite' => 1,
                'replace' => 0,
                'role' => 1,
            ],
            [
                'name' => '單位最高主管',
                'review_type' => 2,
                'reviewer_id' => 3, //最高主管
                'overwrite' => 1,
                'replace' => 0,
                'role' => 1,
            ],
            [
                'name' => '財務長',
                'review_type' => 1,
                'reviewer_id' => 17, //van
                'overwrite' => 1,
                'replace' => 0,
                'role' => 1,
            ],
            [
                'name' => '執行長',
                'review_type' => 1,
                'reviewer_id' => 15, //老大
                'overwrite' => 0,
                'replace' => 0,
                'role' => 1,
            ]
        ];

        foreach($data as $k => $item){

            $item['form_id'] = 3;
            $item['review_order'] = $k+1;
            $obj->add(newRequest($item));
        }
        /**
         * END交際送禮 ========================================================
         */

        /**
         * 代墊 ========================================================
         */
        $data = [
            [
                'name' => '執行長室',
                'review_type' => 1,
                'reviewer_id' => 106, //雨涵
                'overwrite' => 0,
                'replace' => 0,
                'role' => 1,
            ],
            [
                'name' => '部級主管',
                'review_type' => 2,
                'reviewer_id' => 1, //一階主管
                'overwrite' => 1,
                'replace' => 0,
                'role' => 1,
            ],
            [
                'name' => '單位最高主管',
                'review_type' => 2,
                'reviewer_id' => 3, //最高主管
                'overwrite' => 1,
                'replace' => 0,
                'role' => 1,
            ],
            [
                'name' => '財務長',
                'review_type' => 1,
                'reviewer_id' => 17, //van
                'overwrite' => 1,
                'replace' => 0,
                'role' => 1,
            ],
            [
                'name' => '執行長',
                'review_type' => 1,
                'reviewer_id' => 15, //老大
                'overwrite' => 0,
                'replace' => 0,
                'role' => 1,
            ],
            [
                'name' => '財務',
                'review_type' => 1,
                'reviewer_id' => 202, //Parin
                'overwrite' => 0,
                'replace' => 1,
                'role' => 2,
                'replace_type' => [1,1,1],
                'replace_id' => [63,178,203]
            ],
            [
                'name' => '請款人',
                'review_type' => 3,
                'reviewer_id' => 1, //Parin
                'overwrite' => 0,
                'replace' => 0,
                'role' => 2,
            ],
        ];

        foreach($data as $k => $item){

            $item['form_id'] = 4;
            $item['review_order'] = $k+1;
            $obj->add(newRequest($item));
        }
        /**
         * END代墊 ========================================================
         */

        /**
         * 差旅申請 ========================================================
         */

        $data = [
            [
                'name' => '執行長室',
                'review_type' => 1,
                'reviewer_id' => 106, //雨涵
                'overwrite' => 0,
                'replace' => 0,
                'role' => 1,
            ],
            [
                'name' => '部級主管',
                'review_type' => 2,
                'reviewer_id' => 1, //一階主管
                'overwrite' => 1,
                'replace' => 0,
                'role' => 1,
            ],
            [
                'name' => '單位最高主管',
                'review_type' => 2,
                'reviewer_id' => 3, //最高主管
                'overwrite' => 1,
                'replace' => 0,
                'role' => 1,
            ],
            [
                'name' => '財務長',
                'review_type' => 1,
                'reviewer_id' => 17, //van
                'overwrite' => 1,
                'replace' => 0,
                'role' => 1,
            ],
            [
                'name' => '執行長',
                'review_type' => 1,
                'reviewer_id' => 15, //老大
                'overwrite' => 0,
                'replace' => 0,
                'role' => 1,
            ]
        ];

        foreach($data as $k => $item){

            $item['form_id'] = 5;
            $item['review_order'] = $k+1;
            $obj->add(newRequest($item));
        }

        /**
         * END差旅申請 ========================================================
         */

        /**
         * 差旅費用核銷 ========================================================
         */
        $data = [
            [
                'name' => '執行長室',
                'review_type' => 1,
                'reviewer_id' => 106, //雨涵
                'overwrite' => 0,
                'replace' => 0,
                'role' => 1,
            ],
            [
                'name' => '部級主管',
                'review_type' => 2,
                'reviewer_id' => 1, //一階主管
                'overwrite' => 1,
                'replace' => 0,
                'role' => 1,
            ],
            [
                'name' => '單位最高主管',
                'review_type' => 2,
                'reviewer_id' => 3, //最高主管
                'overwrite' => 1,
                'replace' => 0,
                'role' => 1,
            ],
            [
                'name' => '財務長',
                'review_type' => 1,
                'reviewer_id' => 17, //van
                'overwrite' => 1,
                'replace' => 0,
                'role' => 1,
            ],
            [
                'name' => '執行長',
                'review_type' => 1,
                'reviewer_id' => 15, //老大
                'overwrite' => 0,
                'replace' => 0,
                'role' => 1,
            ],
            [
                'name' => '財務',
                'review_type' => 1,
                'reviewer_id' => 202, //Parin
                'overwrite' => 0,
                'replace' => 1,
                'role' => 2,
                'replace_type' => [1,1,1],
                'replace_id' => [63,178,203]
            ],
            [
                'name' => '請款人',
                'review_type' => 3,
                'reviewer_id' => 1, //申請人自己
                'overwrite' => 0,
                'replace' => 0,
                'role' => 2,
            ],
        ];

        foreach($data as $k => $item){

            $item['form_id'] = 6;
            $item['review_order'] = $k+1;
            $obj->add(newRequest($item));
        }
        /**
         * END差旅費用核銷 ========================================================
         */
    }
}
