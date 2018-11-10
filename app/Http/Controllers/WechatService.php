<?php
namespace App\Http\Controllers;

use App;
use Cache;
use Log;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WechatService {
    use CurlTrait;

    public function getToken(){
        $token = Cache::get('accessToken');
        if (empty($token)) {
          if (isset($token)) {
            $token->delete();
          }
          $wechat_config = config('services.wechat');
          extract($wechat_config);

          $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$APPID&secret=$APPSECRET";
         
          $token = $this->curlCallGet($url);
          $token = json_decode($token, true);
          $expiresAt = Carbon::now()->addHours(2);
          Cache::put('accessToken', $token['access_token'], $expiresAt);
          return $token['access_token'];
        } else {
          return $token;
        }
    }


    public function getMaterialCount(){
        $token = $this->getToken();
        $url = "https://api.weixin.qq.com/cgi-bin/material/get_materialcount?access_token=$token";

        $result = $this->curlCallGet($url);
        $result = json_decode($result,true);
        return $result;
    }

    public function getMaterialList($type,$count){
        $token = $this->getToken();
        $offset = ($count - 1) * 20;
        $data = [
            'type'=>$type,
            'offset'=>$offset,
            'count'=>20
        ];
        $data = json_encode($data);
        $url = "https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=$token";
        $result = $this->curlCallPost($url,$data);
        $result = json_decode($result,true);
        return $result;
    }

    public function generatePermanentQRcode($scene_id){
        $data=[
            'action_name'=>'QR_LIMIT_SCENE',
            'action_info'=>[
                'scene'=>[
                    'scene_id'=>$scene_id
                ]
            ]
        ];
        $data=json_encode($data);
        $token = $this->getToken();
        $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=$token";
        $result = $this->curlCallPost($url,$data);
        Log::debug($result);
        Log::debug($scene_id);
        $result = json_decode($result,true);
        $ticket = urlencode($result['ticket']);
        $image = file_get_contents('https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$ticket);
        $path = public_path();
        file_put_contents($path."/qrCode/permanent_$scene_id.jpg",$image);
    }
    
    public function sendTextToUser($openid,$media_id){
        Log::debug('ssdsdsdsd');
        $data=[
            'touser'=>$openid,
            'msgtype'=>'text',
            'text'=>[
                'content'=>$media_id
            ]
        ];
        $data=json_encode($data,JSON_UNESCAPED_UNICODE);
        $token = $this->getToken();
        $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=$token";
        $result = $this->curlCallPost($url,$data);
        Log::debug($result);
    }

    public function SendImageToUser($openid,$media_id){
        $data=[
            'touser'=>$openid,
            'msgtype'=>'image',
            'image'=>[
                'media_id'=>$media_id
            ]
        ];
        $data=json_encode($data);
        $token = $this->getToken();
        $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=$token";
        $result = $this->curlCallPost($url,$data);
    }

    public function SendArticleToUser($openid,$media_id){
        $data=[
            'touser'=>$openid,
            'msgtype'=>'mpnews',
            'mpnews'=>[
                'media_id'=>$media_id
            ]
        ];
        $data=json_encode($data);
        $token = $this->getToken();
        $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=$token";
        $result = $this->curlCallPost($url,$data);
        Log::debug($result);
    }

    public function createMenu($json){
        $token = $this->getToken();
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=$token";
        $result = $this->curlCallPost($url,$json);
        Log::debug("menu log".$result);
        $checkError = json_decode($result,true);
        if($checkError['errcode'] != 0){
            return $result;
        }else{
            return true;
        }
    }

    public function createFollowURL($sceneId) {
        $token = $this->getToken();
        $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=$token";
        $postData = [
            'action_name' => 'QR_STR_SCENE',
            'expire_seconds' => 1800,
            'action_info' => [
                'scene' => [
                    'scene_str' => 'crm' . $sceneId
                ]
            ]
        ];

        $postData = json_encode($postData);

        $result = $this->curlCallPost($url, $postData);
        $result = json_decode($result, true);

        $url = '';
        if (isset($result['ticket']) && $result['ticket']) {
            $url = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . $result['ticket'];
        }
        return $url;
    }

    public function getUserInfo($openid) {
        $token = $this->getToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$token.'&openid='.$openid;
        $result = $this->curlCallGet($url);
        $result = json_decode($result, true);
        return $result;
    }
    public function getUserInfoSim($openid) {
        $token = $this->getTokenSim();
        $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$token.'&openid='.$openid;
        $result = $this->curlCallGet($url);
        $result = json_decode($result, true);
        return $result;
    }

    public function getMateriaByMediaId($media_id){
        $token = $this->getToken();
        $url = "https://api.weixin.qq.com/cgi-bin/material/get_material?access_token=$token";
        $params = array(
            "media_id"=> $media_id
        );
        $params = json_encode($params);
        $result = $this->curlCallPost($url, $params);
        $result = json_decode($result,true);
        return $result;
    }

    public function getAutoReplyInfo(){
        $token = $this->getToken();
        $url = "https://api.weixin.qq.com/cgi-bin/get_current_autoreply_info?access_token=$token";
        $params = array();
        $result = $this->curlCallPost($url, $params);
        $result = json_decode($result,true);
        return $result;
    }
}
