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
        DB::table('form_flow')->insert([
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'form_id' => 1,
            'review_order' => 1,
            'review_type' => 1,
            'reviewer_id' => 172,
            'overwrite' => 1,
            'replace' => 0,
            'role' => 1,
        ]);

        DB::table('form_flow')->insert([
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'form_id' => 1,
            'review_order' => 2,
            'review_type' => 1,
            'reviewer_id' => 17,
            'overwrite' => 1,
            'replace' => 0,
            'role' => 1,
        ]);

        DB::table('form_flow')->insert([
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'form_id' => 1,
            'review_order' => 3,
            'review_type' => 1,
            'reviewer_id' => 106,
            'overwrite' => 1,
            'replace' => 0,
            'role' => 2,
        ]);
        /**
         * EDN請款單 ========================================================
         */

        /**
         * 用印申請 ========================================================
         */
        DB::table('form_flow')->insert([
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'form_id' => 2,
            'review_order' => 1,
            'review_type' => 1,
            'reviewer_id' => 17,
            'overwrite' => 1,
            'replace' => 0,
            'role' => 1,
        ]);

        DB::table('form_flow')->insert([
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'form_id' => 2,
            'review_order' => 2,
            'review_type' => 1,
            'reviewer_id' => 111,
            'overwrite' => 1,
            'replace' => 0,
            'role' => 1,
        ]);

        DB::table('form_flow')->insert([
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'form_id' => 2,
            'review_order' => 3,
            'review_type' => 1,
            'reviewer_id' => 106,
            'overwrite' => 1,
            'replace' => 0,
            'role' => 2,
        ]);
        /**
         * END用印申請 ========================================================
         */

        /**
         * 交際送禮 ========================================================
         */
        DB::table('form_flow')->insert([
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'form_id' => 3,
            'review_order' => 1,
            'review_type' => 1,
            'reviewer_id' => 17,
            'overwrite' => 1,
            'replace' => 0,
            'role' => 1,
        ]);

        DB::table('form_flow')->insert([
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'form_id' => 3,
            'review_order' => 2,
            'review_type' => 1,
            'reviewer_id' => 15,
            'overwrite' => 1,
            'replace' => 0,
            'role' => 1,
        ]);

        DB::table('form_flow')->insert([
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'form_id' => 3,
            'review_order' => 3,
            'review_type' => 1,
            'reviewer_id' => 106,
            'overwrite' => 1,
            'replace' => 0,
            'role' => 2,
        ]);
        /**
         * END交際送禮 ========================================================
         */

        /**
         * 代墊 ========================================================
         */
        DB::table('form_flow')->insert([
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'form_id' => 4,
            'review_order' => 1,
            'review_type' => 1,
            'reviewer_id' => 16,
            'overwrite' => 1,
            'replace' => 0,
            'role' => 1,
        ]);

        DB::table('form_flow')->insert([
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'form_id' => 4,
            'review_order' => 2,
            'review_type' => 1,
            'reviewer_id' => 17,
            'overwrite' => 1,
            'replace' => 0,
            'role' => 1,
        ]);

        DB::table('form_flow')->insert([
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'form_id' => 4,
            'review_order' => 3,
            'review_type' => 1,
            'reviewer_id' => 106,
            'overwrite' => 1,
            'replace' => 0,
            'role' => 2,
        ]);
        /**
         * END代墊 ========================================================
         */

        /**
         * 差旅申請 ========================================================
         */
        DB::table('form_flow')->insert([
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'form_id' => 5,
            'review_order' => 1,
            'review_type' => 1,
            'reviewer_id' => 111,
            'overwrite' => 1,
            'replace' => 0,
            'role' => 1,
        ]);

        DB::table('form_flow')->insert([
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'form_id' => 5,
            'review_order' => 2,
            'review_type' => 1,
            'reviewer_id' => 17,
            'overwrite' => 1,
            'replace' => 0,
            'role' => 1,
        ]);

        DB::table('form_flow')->insert([
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'form_id' => 5,
            'review_order' => 3,
            'review_type' => 1,
            'reviewer_id' => 106,
            'overwrite' => 1,
            'replace' => 0,
            'role' => 2,
        ]);
        /**
         * END差旅申請 ========================================================
         */

        /**
         * 差旅費用核銷 ========================================================
         */
        DB::table('form_flow')->insert([
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'form_id' => 6,
            'review_order' => 1,
            'review_type' => 1,
            'reviewer_id' => 63,
            'overwrite' => 1,
            'replace' => 0,
            'role' => 1,
        ]);

        DB::table('form_flow')->insert([
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'form_id' => 6,
            'review_order' => 2,
            'review_type' => 1,
            'reviewer_id' => 17,
            'overwrite' => 1,
            'replace' => 0,
            'role' => 1,
        ]);

        DB::table('form_flow')->insert([
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'form_id' => 6,
            'review_order' => 3,
            'review_type' => 1,
            'reviewer_id' => 106,
            'overwrite' => 1,
            'replace' => 0,
            'role' => 2,
        ]);
        /**
         * END差旅費用核銷 ========================================================
         */
    }
}
