<?php

namespace App\Listeners;

use App\Events\SendTextToUser;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;
use App\Http\Controllers\WechatService;
class SendTextToUserListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SendTextToUser  $event
     * @return void
     */
    public function handle(SendTextToUser $event)
    {
        //
        $wechat = new WechatService;
        $wechat->sendTextToUser($event->name,$event->media_id);

    }
}
