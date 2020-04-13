<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormDataSub extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_data_sub', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('form_data_id')->comment('主資料ID');
            $table->char('column',64)->comment('欄位名稱');
            $table->longText('value')->nullable()->comment('欄位值');
        });

        DB::statement("ALTER TABLE `form_data_sub` comment'表單填寫資料 - 子欄位'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_data_sub');
    }
}
