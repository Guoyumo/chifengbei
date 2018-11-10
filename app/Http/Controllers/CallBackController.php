<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\WechatService;
use DB;
use Illuminate\Support\Facades\Log;
use App\Events\SendTextToUser;
use App\Events\SendImageToUser;
use App\Events\SendArticleToUser;
use App\QRcode;

class CallBackController extends Controller
{
    //
    public function index(Request $request){
        
        // $event = new SendTextToUser();
        // $event = new SendImageToUser();
        // $event = new SendArticleToUser();
        // $event->name = '123';
        // event($event);
        $data = $request->all();
        if(!isset($data["echostr"])){
            $postStr = file_get_contents("php://input");
            $result = "";
            if (!empty($postStr)){
                $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $RX_TYPE = trim($postObj->MsgType);
                switch($RX_TYPE){
                    case "event":
                        $result = $this->receiveEvent($postObj);
                        break;
                    case "text":
                        $result = $this->receiveText($postObj);
                        break;
                }
            }
            echo $result;
        }else{
            if($this->checkSignature($data)){
                echo $data["echostr"];
            }
        }
        exit;
    }
	
    private function checkSignature($data)
    {
        $signature = $data["signature"];
        $timestamp = $data["timestamp"];
        $nonce = $data["nonce"];
        $token = env('WECHAT_TOKEN');
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if ($tmpStr == $signature) {
            return true;
        }
        return false;
    }
    private function receiveText($object){
        $returnContent = "";
        $resultReturn = $this->getReplyFromDb($object);
        if ($object->Content && !$resultReturn) {
            $input = $object->Content;
            $wechat = new WechatService;
            $accessToken = $wechat->getToken();
            $url = "https://api.weixin.qq.com/cgi-bin/get_current_autoreply_info?access_token=" . $accessToken;
            $json = file_get_contents($url);
            $result = json_decode($json,true);
            $rules = array();

            if (isset($result['keyword_autoreply_info']['list'])) {
                $rules = $result['keyword_autoreply_info']['list'];
            }
            $newRules = array();
            foreach ($rules as $k => $rule) {
                $content = array();
                foreach ($rule['keyword_list_info'] as $ruleKey) {
                    $content[] = $ruleKey['content'];
                }
                $newRules[$k]['keys'] = implode('|', $content);
                $newRules[$k]['reply'] = isset($rule['reply_list_info'][0]['content']) ? $rule['reply_list_info'][0]['content'] : '';
                $newRules[$k]['type'] = isset($rule['reply_list_info'][0]['type']) ? $rule['reply_list_info'][0]['type'] : 'unsetType';
            }
            if ($newRules) {
                foreach ($newRules as $newRule) {
                    $ruleStr = '/' . $newRule['keys'] . '/';
                    if(preg_match($ruleStr,$input)) {
                        if($newRule['type'] == 'text'){
                            $returnContent = $newRule['reply'];
                            break;
                        }
                        if($newRule['type'] == 'news'){
                            $event = new SendArticleToUser();
                            $event->name = trim((string)$object->FromUserName);
                            $event->media_id = $newRule['reply'];
                            event($event);
                            break;
                        }
                    }
                }
            }

            if($returnContent) {
                $resultReturn = $this->transmitText($object,$returnContent);
            }
        }

        return $resultReturn;

    }


    private function receiveEvent($object){
        $content = "";
	$dir = public_path() . '/lock/';
        $lockFile = $dir . $object->FromUserName . '.lock';
        switch ($object->Event){
            case "subscribe":
		//Log::debug("subscribe: " . $object->EventKey);
                $EventKey = trim((string)$object->EventKey);
                if(empty($EventKey)){
//                    $content = '感谢关注大葡萄，即日起欧缇丽全新会员积分系统上线，立刻点击链接<a href ="https://cn.caudalie.com">绑定账户</a>，赢取免费50积分！';
                    $content = $this->getSubscribeReply(true);
                    $result = $this->transmitText($object,$content);
                    return $result;
                }
                $keyArray = explode("_", $EventKey);
                if(strpos($keyArray[1], 'crm') !== false) {
                    $crmId = str_replace('crm','',$keyArray[1]);
                    Log::debug($keyArray[1]);
                    if($crmId) {
                        $welcomeLink = "https://cn.caudalie.com?crm_id=" . $crmId;
                    } else {
                        $welcomeLink = "https://cn.caudalie.com";
                    }

//                    $content = '感谢关注大葡萄，即日起欧缇丽全新会员积分系统上线，立刻点击链接<a href ="' .$welcomeLink.'">绑定账户</a>，赢取免费50积分！';
                    $content = $this->getSubscribeReply(false);
                    $result = $this->transmitText($object,$content);
                    return $result;
                }
		Log::debug($keyArray[1]);

		if(!file_exists($lockFile)){
                    if(!file_exists($dir)){
                        mkdir($dir);
                    }
                    file_put_contents($lockFile, 'locked');
                }else{
                    return $content;
                }

		$action = DB::table('q_rcodes')->where('id', $keyArray[1])->first();
                if($action->type == 'news'){
                    $event = new SendArticleToUser();
                    $event->name = trim((string)$object->FromUserName);
                    $event->media_id = $action->media_id;
                    event($event);
                }
                if($action->type == 'image'){
                    $event = new SendImageToUser();
                    $event->name = trim((string)$object->FromUserName);
                    $event->media_id = $action->media_id;
                    event($event);
                }
                if($action->type == 'content'){
                    $event = new SendTextToUser();
                    $event->name = trim((string)$object->FromUserName);
                    $event->media_id = $action->media_id;
                    event($event);
                }

		   
                break;
            case "SCAN":
	        if(!file_exists($lockFile)){
                    if(!file_exists($dir)){
                	mkdir($dir);
            	    }
            	    file_put_contents($lockFile, 'locked');
        	}else{
	            return $content;
        	}
                $EventKey = trim((string)$object->EventKey);
                $action = DB::table('q_rcodes')->where('id', $EventKey)->first();
                if($action->type == 'news'){
                    $event = new SendArticleToUser();
                    $event->name = trim((string)$object->FromUserName);
                    $event->media_id = $action->media_id;
                    event($event);
                }
                if($action->type == 'image'){
                    $event = new SendImageToUser();
                    $event->name = trim((string)$object->FromUserName);
                    $event->media_id = $action->media_id;
                    event($event);
                }
                if($action->type == 'content'){
                    $event = new SendTextToUser();
                    $event->name = trim((string) $object->FromUserName);
                    $event->media_id = $action->media_id;
                    event($event);
                }
		break;
		default:
                $content = "";
                break;
        }
        $this->callCRMApi($object);
	if(file_exists($lockFile)){
            unlink($lockFile);
        }
   //     $result = $this->transmitText($object,$content);
        return $content;
    }

    private function transmitText($object,$content)
    {
        $textTpl = "<xml> 
       <ToUserName><![CDATA[%s]]></ToUserName> 
       <FromUserName><![CDATA[%s]]></FromUserName> 
       <CreateTime>%s</CreateTime> 
       <MsgType><![CDATA[text]]></MsgType> 
       <Content><![CDATA[%s]]></Content> 
       <FuncFlag>0</FuncFlag> 
       </xml>";
        $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content);
        return $result;
    }

    public function getMaterialList(Request $request,WechatService $wechat){
        $request = $request->all();
        $type = $request['type'];
        $count = $request['count'];
        $result = $wechat->getMaterialList($type,$count);
        $returnData = [];
        if($type == 'image'){
            $returnData = $result['item'];
        }

        if($type == 'news'){
            foreach($result['item'] as $key => $val){
                $returnData[$key]['media_id'] = $val['media_id'];
                $returnData[$key]['content']= $val['content']['news_item'];
            }
        }
        return $returnData;

    }

    public function getReplyFromDb($object){
        $return = "";
        $input = $object->Content ? $object->Content : '';
        if(!$input){
            return $return;
        }
        //full metch first
        $match = DB::table('wechat_auto_reply')->where('key_words', '=', $input)->first();
        if(!$match){
            //then half metch
            $match = DB::table('wechat_auto_reply')->where('key_words', 'like', "%$input%")->first();
        }
        if($match){
            $textTpl = $match->reply_content;
            $textTpl = str_replace('%', '%%',$textTpl);
            $textTpl = str_replace('%s', 's',$textTpl);
            $return = sprintf($textTpl, $object->FromUserName, $object->ToUserName);
        }
        return $return;
    }

    public function getSubscribeReply($type = false){
        if($type){
            $result =  DB::table('subscribe_replies')->first();
        }else{
            $result =  DB::table('subscribe_replies')->orderBy('upload_time', 'desc')->first();
        }
        return $result->content;
    }

    public function callCRMApi($object=null){
        if(!isset($object->FromUserName)){
            return 'false';
        }
        $openId = trim((string)$object->FromUserName);
        $username = 'ex_wechat_hk';
        $password = 'Jjkk3JciQDVQE7yJBqKZIoCH672SYFolY6jYHTq6SoXLF6ZQa2u0FUNAzqCIWfxV';
        $url = 'https://wscrm.caudaliepro.com/clients/search/';
        $authBasic = md5($username) . ':' . password_hash(hash('sha256', $password),PASSWORD_BCRYPT, ['cost' => date('N') + 4]);
        $authBasic = base64_encode($authBasic);
         $guzzle = new \GuzzleHttp\Client([
             'headers' => [
                 'Authorization' => 'Basic ' . $authBasic,
                 'Cache-Control' => 'no-cache',
                 'Impersonate' => $username,
                 'Content-Type ' => 'application/x-www-form-urlencoded'
             ],
         ]);
         $params = [
             'query[0][f]' => 'ExternalKeys.WeChatID',
             'query[0][op]' => '==',
             'query[0][c1]' => $openId,
             'fields[]' => 'Id'
         ];
        $data = ['headers' => ['Content-Type' => 'application/x-www-form-urlencoded'], 'form_params' => $params];
        $response = $guzzle->request('POST', $url, $data);
        $body = $response->getBody();
        Log::debug('check:' . $body);
        $body = json_decode($body, true);
        if($body['code'] != '200'){
            return 'false';
        }
        if(empty($body['results'])){
            $wechatService = new WechatService();
            $wechatUserInfo = $wechatService->getUserInfo($openId);
            if(empty($wechatUserInfo)){
                return 'false';
            }
            $sex = $wechatUserInfo['nickname'] == 1 ? '3' : '2';
            $params_create = [
                'on' => 'ExternalKeys.WeChatID',
                'ExternalKeys[WeChatID]' => $openId,
                'Client[FirstName]' => $wechatUserInfo['nickname'],
                'Client[Salutation]' => $sex,
                'Client[City]' => $wechatUserInfo['city'],
                'ExternalKeys[WeChatUnionID]' => $wechatUserInfo['unionid'],
            ];
            $url_create = 'https://wscrm.caudaliepro.com/clients/';
            $data_create = ['headers' => ['Content-Type' => 'application/x-www-form-urlencoded'], 'form_params' => $params_create];
            $response_create = $guzzle->request('PATCH', $url_create, $data_create);
            $body_create = $response_create->getBody();
            Log::debug('create:' . $body_create);
            $body_create = json_decode($body_create, true);
            if($body_create['code'] != '200'){
                return 'false';
            }
            $id = $body_create['id'];
        }else{
            $id = $body['results'][0]['Id'];
        }
        if(!$id){
            return 'false';
        }
        $sceneId = explode('_', $object->EventKey);
        $sceneId = isset($sceneId[1]) ? $sceneId[1] : $object->EventKey;
        $qrCode = QRcode::find($sceneId);
        $params_origin = [
            'on' => 'Id',
            'Client[Id]' => $id,
            'Origins[]' => 'QR > ' . $sceneId . '.' .$qrCode->name
        ];
        $url_origin = 'https://wscrm.caudaliepro.com/clients/';
        $data_origin = ['headers' => ['Content-Type' => 'application/x-www-form-urlencoded'], 'form_params' => $params_origin];
        $response_origin = $guzzle->request('PATCH', $url_origin, $data_origin);
        $body_origin = $response_origin->getBody();
        Log::debug('origin:' . $body_origin);
    }

    /**
     * get wechat token
     */
    function getWechatToken(){
        $wechat = new WechatService();
        $return = array('code' => '200', 'status' => 'success', 'wechatToken' => $wechat->getToken());
        return response()->json($return);
    }

}
