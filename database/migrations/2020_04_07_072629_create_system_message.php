<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemMessage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_message', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedInteger('member_id')->comment('接收者ID');
            $table->char('title','64')->comment('標題');
            $table->text('content')->comment('訊息內容');
            $table->text('url')->comment('點選跳轉URL');
            $table->unsignedInteger('send_by')->comment('發送者ID 0:系統');
            $table->dateTime('read_at')->nullable()->comment('讀取時間');
        });

        DB::statement("ALTER TABLE `system_message` comment'系統訊息'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_message');
    }
}
