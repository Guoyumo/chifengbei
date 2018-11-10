<?php

namespace App\Http\Controllers;

use App\QRcode;
use Illuminate\Http\Request;
use App\Http\Controllers\WechatService;
use Cache;
use Carbon\Carbon;

class TemporaryQRcodeController extends Controller
{
    use CurlTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, WechatService $wechat)
    {
        $data = $request->all();
        $openid = isset($data['openid']) ? $data['openid'] : '';
        $crmId = isset($data['crmId']) ? $data['crmId'] : '';

        $user_info = $wechat->getUserInfo($openid);

        $url = $this->mustFollowFirst($wechat, $user_info, $crmId);
        return $url;
    }

    private function mustFollowFirst($wechat, $userInfo, $sceneId) {
        if (!isset($userInfo['subscribe']) || (isset($userInfo['subscribe']) && !$userInfo['subscribe'])) {
            $url = $wechat->createFollowURL($sceneId);
            return $url;
        } else {
            return '';
        }
    }

    private function getJsApiTicket(WechatService $wechat) {
        $access_token = $wechat->getToken();

        if (Cache::has('ticket')) {
            $ticket = Cache::get('ticket');
        } else {
            $ticket_URL = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$access_token."&type=jsapi";
            $json = $this->curlCallGet($ticket_URL);
            $result = json_decode($json,true);
            $ticket = $result['ticket'];
            $expiresAt = Carbon::now()->addHours(2);
            Cache::put('ticket', $ticket, $expiresAt);
        }
        return $ticket;
    }
}
