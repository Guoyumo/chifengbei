<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use \App\Http\Controllers\WechatService;
use App\Http\Requests;
use Cache;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Auth;
use QrCode;
use App\Repositories\UserRepository;

class WXPayService
{
    use CurlTrait;
    public function __construct() {
        $this->appId = env('MINI_APPID');
        $this->mchId = env('WECHAT_MCH_ID');
        $this->apiKey = env('WECHAT_API_KEY');
    }

    public function createOrder($openid){
    
        $arr['out_trade_no'] = $this->outTradeNo();
        $arr['spbill_create_ip'] = $this->getSpbillCreateIp();
        $arr['nonce_str'] = $this->createNonceStr();
        $arr['appid'] = $this->appId;
        $arr['mch_id'] = $this->mchId;
        $arr['openid'] = $openid;
        $arr['attach'] = "赤峰送呗";
        $arr['body'] = "赤峰送呗";
        $arr['total_fee'] = 1;
        $arr['trade_type'] = "JSAPI";
        $arr['notify_url'] = "http://www.chifengbei.com";
        $string = $this->createSign($arr);
        $arr['sign'] = $string;
        $xml = $this->inputXml($arr);
        $url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
        $result = $this->curlCallXML($url,$xml);

        $obj = simplexml_load_string($result, 'SimpleXMLElement', LIBXML_NOCDATA);
        $response = $this->createJssdkSign($obj);

        Log::debug($response);
        return response()->json($response);
    }

    private function createJssdkSign($obj){
        $arr['appId'] = $this->appId;
        $arr['timeStamp'] = time();
        $arr['nonceStr'] = $this->createNonceStr();
        $arr['package'] = 'prepay_id='.$obj->prepay_id;
        $arr['signType'] = 'MD5';
        ksort($arr);
        $string = '';
        foreach($arr as $key => $value){
            $string = $string.$key.'='.$value.'&';
        }
            $sign = $string.'key='.$this->apiKey;
            $sign = md5($sign);
            $sign = strtoupper($sign);
        $arr['paySign'] = $sign;
        return $arr;
    }
    private function inputXml($arr)
    {
        $textTpl = 
        '<xml>
            <appid><![CDATA[%s]]></appid>
            <attach>赤峰送呗</attach>
            <body>赤峰送呗</body>
            <mch_id><![CDATA[%s]]></mch_id>
            <nonce_str><![CDATA[%s]]></nonce_str>
            <notify_url>http://www.chifengbei.com</notify_url>
            <openid><![CDATA[%s]]></openid>
            <out_trade_no><![CDATA[%s]]></out_trade_no>
            <spbill_create_ip><![CDATA[%s]]></spbill_create_ip>
            <total_fee>1</total_fee>
            <trade_type>JSAPI</trade_type>
            <sign><![CDATA[%s]]></sign>
        </xml>';
        $result = sprintf($textTpl,$arr['appid'],$arr['mch_id'],$arr['nonce_str'],$arr['openid'],$arr['out_trade_no'],$arr['spbill_create_ip'],$arr['sign']);
        return $result;
    }

    //create sign
    private function createSign($arr)
    {  
        ksort($arr);
        $string = '';
        foreach($arr as $key => $value){
            $string = $string.$key.'='.$value.'&';
        }
            $sign = $string.'key='.$this->apiKey;
            $sign = md5($sign);
            $sign = strtoupper($sign); 
        return $sign;
    }

    //create NoceStr
    private function createNonceStr($length = 32) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
    return $str;
    }

    //create order number

    private function outTradeNo()
    {
        $time = time();
        return $time;
    }
    private function getSpbillCreateIp()
    {
        return $_SERVER['REMOTE_ADDR'];
    }

    
}