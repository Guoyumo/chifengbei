<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWechatAutoReplyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wechat_auto_reply', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rule_name');
            $table->string('key_words');
            $table->string('match_type');
            $table->string('reply_content', '10000');
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
        Schema::drop('wechat_auto_reply');
    }
}
