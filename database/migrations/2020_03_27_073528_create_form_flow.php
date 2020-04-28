<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormFlow extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_flow', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->char('name',64)->comment('簽核關卡名稱');
            $table->unsignedTinyInteger('form_id')->comment('簽核表單ID');
            $table->unsignedTinyInteger('review_order')->comment('簽核順位');
            $table->unsignedTinyInteger('review_type')->comment('簽核人類型 1:指定人 2:指定位階 3:表單申請人驗收');
            $table->unsignedInteger('reviewer_id')->comment('指定簽核人ID or 簽核位階 1:一階主管 2:二階主管 3:三階主管');
            $table->unsignedTinyInteger('overwrite')->comment('是否可被上層簽核取代 0:不可 1:可');
            $table->unsignedTinyInteger('replace')->comment('是否有代簽 0:不可 1:可');
            $table->unsignedTinyInteger('role')->comment('角色 1:簽核 2:執行');
            $table->softDeletes();
        });

      DB::statement("ALTER TABLE `form_flow` comment'表單流程設定'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_flow');
    }
}
