<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMessaseTypeAndMediaIdColumnToAutoReplyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wechat_auto_reply', function (Blueprint $table) {
            $table->string('message_type');
            $table->string('media_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wechat_auto_reply', function (Blueprint $table) {
            //
        });
    }
}
