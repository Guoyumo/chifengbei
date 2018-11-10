<?php

namespace App\Listeners;

use App\Events\SendArticleToUser;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Http\Controllers\WechatService;
use Log;
class SendArticleToUserListener
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
     * @param  SendArticleToUser  $event
     * @return void
     */
    public function handle(SendArticleToUser $event)
    {
        //
        $wechat = new WechatService;
        $wechat->SendArticleToUser($event->name,$event->media_id);
    }
}
