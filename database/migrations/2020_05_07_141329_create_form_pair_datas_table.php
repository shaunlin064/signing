<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormPairDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_pair_datas', function (Blueprint $table) {

            $table->id();
            $table->timestamps();
            $table->unsignedInteger('form_apply_id')->comment('表單id');
            $table->unsignedInteger('use_to_form_apply_id')->nullable()->comment('使用的表單id');
            $table->unsignedTinyInteger('form_id')->comment('簽核表單ID(類型)');
            $table->unsignedInteger('member_id')->comment('申請人員ID');
            $table->char('apply_subject',64)->comment('名稱');
            $table->unsignedTinyInteger('status')->comment('狀態 0 未使用 , 1 已使用');
            $table->longText('value')->comment('欄位值');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_pair_datas');
    }
}
