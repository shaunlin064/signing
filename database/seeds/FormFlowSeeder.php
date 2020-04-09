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
    }
}
