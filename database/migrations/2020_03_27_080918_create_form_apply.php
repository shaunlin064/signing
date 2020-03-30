<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormApply extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_apply', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedTinyInteger('form_id')->comment('簽核表單ID');
            $table->unsignedInteger('apply_member_id')->comment('申請人員ID');
            $table->unsignedTinyInteger('status')->comment('表單申請狀態 0:駁回 1:暫存中 2:簽核中 3:通過');
            $table->unsignedBigInteger('now')->nullable()->comment('目前簽核關卡ID');
            $table->unsignedBigInteger('next')->nullable()->comment('下個簽核關卡ID');
            $table->dateTime('fail_at')->nullable()->comment('作廢時間');
        });

      DB::statement("ALTER TABLE `form_apply` comment'表單申請紀錄'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_apply');
    }
}
