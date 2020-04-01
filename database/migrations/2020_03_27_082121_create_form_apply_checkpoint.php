<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormApplyCheckpoint extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_apply_checkpoint', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('form_apply_id')->comment('表單申請ID');
            $table->unsignedTinyInteger('review_order')->comment('簽核順位');
            $table->unsignedTinyInteger('role')->comment('角色 1:簽核 2:執行');
            $table->unsignedInteger('signed_member_id')->comment('簽署者ID');
            $table->unsignedInteger('replace_signed_member_id')->nullable()->comment('代簽者ID');
            $table->unsignedTinyInteger('overwrite')->comment('是否可被上層簽核取代 0:不可 1:可');
            $table->text('replace_members')->comment('可代簽人員');
            $table->unsignedTinyInteger('status')->comment('簽核狀態 0:駁回 1:待簽核 2:通過');
            $table->dateTime('signed_at')->nullable()->comment('簽核時間');
            $table->longText('signature')->nullable()->comment('簽名檔');
            $table->longText('remark')->nullable()->comment('備註');
        });

      DB::statement("ALTER TABLE `form_apply_checkpoint` comment'表單申請簽核關卡'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_apply_checkpoint');
    }
}
