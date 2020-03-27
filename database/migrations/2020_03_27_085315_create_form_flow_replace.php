<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormFlowReplace extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_flow_replace', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('form_flow_id')->comment('表單簽核流程ID');
            $table->unsignedTinyInteger('review_type')->comment('簽核人類型 1:指定人 2:指定位階');
            $table->unsignedInteger('reviewer_id')->comment('指定簽核人ID or 簽核位階 1:一階主管 2:二階主管 3:三階主管');
        });

      DB::statement("ALTER TABLE `form_flow_replace` comment'表單簽核流程代簽'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_flow_replace');
    }
}
