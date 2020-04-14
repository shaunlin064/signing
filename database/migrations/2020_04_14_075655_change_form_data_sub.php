<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFormDataSub extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('form_data_sub', function (Blueprint $table) {
            //
            $table->unsignedTinyInteger('key')->after('form_data_id')->comment('sub_key');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('form_data_sub', function (Blueprint $table) {
            //
            $table->dropColumn('key');
        });
    }
}
