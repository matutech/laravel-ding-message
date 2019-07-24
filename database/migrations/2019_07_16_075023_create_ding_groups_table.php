<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDingGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ding_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('chatid')->comment('钉钉 chatid');
            $table->string('name')->comment('钉钉群名称');
            $table->string('open_conversation_id')->comment('钉钉 openConversationId');
            $table->string('conversation_tag')->comment('钉钉 conversationTag');
            $table->tinyInteger('is_send')->default(0)->comment('是否设置为发送群');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ding_groups');
    }
}
