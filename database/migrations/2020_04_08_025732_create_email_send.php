<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailSend extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_send', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->char('notify_type',24)->comment('通知類型(文字)');
            $table->char('receiver_email',255)->comment('收件人email');
            $table->char('receiver_name',64)->comment('收件人名稱');
            $table->char('template',128)->comment('樣板路徑');
            $table->char('subject',64)->comment('主旨');
            $table->text('content')->comment('內容');
            $table->unsignedTinyInteger('status')->comment('狀態 0:未寄出 1:已寄出');
        });

        DB::statement("ALTER TABLE `email_send` comment'Email發送'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_send');
    }
}
