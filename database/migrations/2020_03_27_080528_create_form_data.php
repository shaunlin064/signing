<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_data', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedTinyInteger('form_id')->comment('簽核表單ID');
            $table->unsignedBigInteger('form_apply_id')->comment('表單申請ID');
            $table->char('column',64)->comment('欄位名稱');
            $table->longText('value')->comment('欄位值');
        });

      DB::statement("ALTER TABLE `form_data` comment'表單填寫資料'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_data');
    }
}
