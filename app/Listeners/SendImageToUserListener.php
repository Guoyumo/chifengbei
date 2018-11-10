<?php

namespace App\Listeners;

use App\Events\SendImageToUser;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Http\Controllers\WechatService;
class SendImageToUserListener
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
     * @param  SendImageToUser  $event
     * @return void
     */
    public function handle(SendImageToUser $event)
    {
        //
        $wechat = new WechatService;
        $wechat->SendImageToUser($event->name,$event->media_id);
    }
}
