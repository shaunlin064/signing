<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuperUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('super_user', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedInteger('member_id')->comment('人員ID');
            $table->char('name',24)->comment('人員姓名');
        });

        DB::statement("ALTER TABLE `super_user` comment'超級管理員名單'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('super_user');
    }
}
