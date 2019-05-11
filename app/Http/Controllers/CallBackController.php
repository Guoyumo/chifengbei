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
        switch ($object->Event){
            case "subscribe":
                $EventKey = trim((string)$object->EventKey);
                if(empty($EventKey)){
                  $content = '你好，欢迎关注赤峰呗！';
                  break;
                }
                $keyArray = explode("_", $EventKey);
                $openid = trim((string)$object->FromUserName);
        $action = DB::table('q_rcodes')->where('id', $keyArray[1])->first();
                if($action->media_id == ''){
                    if($keyArray[1] >= 200 && $keyArray[1] <= 700){
                        $content = '赤峰小九窝音乐烤吧恭喜您领取一张挪呗挪车二维码，<a href="http://www.chifengbei.com/inputInfo/'.$keyArray[1].'?openid='.$openid.'">点击此处填写挪车电话！</a>';
                    }else if(($keyArray[1] >= 1301 && $keyArray[1] <= 1400) || ($keyArray[1] >= 1701 && $keyArray[1] <= 1800)){
                        $content = '赤峰月星二手车恭喜您领取一张挪呗挪车二维码，<a href="http://www.chifengbei.com/inputInfo/'.$keyArray[1].'?openid='.$openid.'">点击此处填写挪车电话！</a>';
                    }else if($keyArray[1] >= 1401 && $keyArray[1] <= 1500){
                        $content = '赤峰巨森农资恭喜您领取一张挪呗挪车二维码，<a href="http://www.chifengbei.com/inputInfo/'.$keyArray[1].'?openid='.$openid.'">点击此处填写挪车电话！</a>';
                    }else if ($keyArray[1] >= 2401 && $keyArray[1] <= 4000){
                        $content = '赤峰居然之家联手赤百电器恭喜您领取一张挪呗挪车二维码，<a href="http://www.chifengbei.com/inputInfo/'.$keyArray[1].'?openid='.$openid.'">点击此处填写挪车电话！</a>'."\n".'居然之家携手赤百电器打造赤峰顶尖家具家电一站式购买服务平台';
                    }else if ($keyArray[1] >= 4001 && $keyArray[1] <= 4200){
                        $content = '龙发家之初装饰恭喜您领取一张挪呗挪车二维码，<a href="http://www.chifengbei.com/inputInfo/'.$keyArray[1].'?openid='.$openid.'">点击此处填写挪车电话！</a>';
                    }else if ($keyArray[1] >= 4201 && $keyArray[1] <= 4400){
                        $content = '赤峰奔驰俱乐部携手路捷名车恭喜您领取一张挪呗挪车二维码，<a href="http://www.chifengbei.com/inputInfo/'.$keyArray[1].'?openid='.$openid.'">点击此处填写挪车电话！</a>';
                    }else if($keyArray[1] >= 4401 && $keyArray[1] <= 4450){
                        $content = '恒大华府恭喜您领取一张挪呗挪车二维码，<a href="http://www.chifengbei.com/inputInfo/'.$keyArray[1].'?openid='.$openid.'">点击此处填写挪车电话！</a>'. "\n"."双城芯，公园家，御湖名邸";
                    }else if ($keyArray[1] >= 4501 && $keyArray[1] <= 4700){
                        $content = '平庄弹个车恭喜您领取一张挪呗挪车二维码，<a href="http://www.chifengbei.com/inputInfo/'.$keyArray[1].'?openid='.$openid.'">点击此处填写挪车电话！</a>';
                    }else if ($keyArray[1] >= 4451 && $keyArray[1] <= 4500){
                        $content = '利丰二手车“行认证”恭喜您领取一张挪呗挪车二维码，<a href="http://www.chifengbei.com/inputInfo/'.$keyArray[1].'?openid='.$openid.'">点击此处填写挪车电话！</a>'."\n".'买卖二手，鉴定二手车请找行认证';
                    }else if ($keyArray[1] >= 2352 && $keyArray[1] <= 2400){
                        $content = '利丰二手车“行认证”恭喜您领取一张挪呗挪车二维码，<a href="http://www.chifengbei.com/inputInfo/'.$keyArray[1].'?openid='.$openid.'">点击此处填写挪车电话！</a>'."\n".'买卖二手，鉴定二手车请找行认证';
                    }else if($keyArray[1] >= 4851 && $keyArray[1] <= 4898){
                        $content = '安信精品车行恭喜您领取一张挪呗挪车二维码，<a href="http://www.chifengbei.com/inputInfo/'.$keyArray[1].'?openid='.$openid.'">点击此处填写挪车电话！</a>';
                    }else if($keyArray[1] >= 4901 && $keyArray[1] <= 5100){
                        $content = '悦山壹号恭喜您领取一张挪呗挪车二维码，<a href="http://www.chifengbei.com/inputInfo/'.$keyArray[1].'?openid='.$openid.'">点击此处填写挪车电话！</a>'. "\n"."悦山壹号售房热线：0476-8249000";
                    }else{
                        $content = '恭喜您领取一张挪呗挪车二维码，<a href="http://www.chifengbei.com/inputInfo/'.$keyArray[1].'?openid='.$openid.'">点击此处填写挪车电话！</a>';
                    }
                   
                }else{
                    if($action->type != ''){
                        if($keyArray[1] >= 200 && $keyArray[1] <= 700){
                            $content="赤峰小九窝音乐烤吧感谢您使用赤峰挪呗\n车主电话".$action->media_id."\n ".$action->type;
                        }else if(($keyArray[1] >= 1301 && $keyArray[1] <= 1400) || ($keyArray[1] >= 1701 && $keyArray[1] <= 1800)){
                            $content="赤峰月星二手车感谢您使用赤峰挪呗\n车主电话".$action->media_id."\n ".$action->type;
                        }else if($keyArray[1] >= 1401 && $keyArray[1] <= 1500){
                            $content="赤峰巨森农资感谢您使用赤峰挪呗\n车主电话".$action->media_id."\n ".$action->type;
                        }else if ($keyArray[1] >= 2401 && $keyArray[1] <= 4000){
                            $content="赤峰居然之家联手赤百电器感谢您使用赤峰挪呗\n车主电话".$action->media_id."\n ".$action->type."\n\n".'居然之家携手赤百电器打造赤峰顶尖家具家电一站式购买服务平台';
                        }else if ($keyArray[1] >= 4001 && $keyArray[1] <= 4200){
                            $content="龙发家之初装饰感谢您使用赤峰挪呗\n车主电话".$action->media_id."\n ".$action->type;
                        }else if ($keyArray[1] >= 4201 && $keyArray[1] <= 4400){
                            $content="赤峰奔驰俱乐部携手路捷名车感谢您使用赤峰挪呗\n车主电话".$action->media_id."\n ".$action->type."\n\n".'让爱出发   温暖回家';
                        }else if($keyArray[1] >= 4401 && $keyArray[1] <= 4450){
                            $content="恒大华府恭喜感谢您使用赤峰挪呗\n车主电话".$action->media_id."\n ".$action->type."\n\n".'双城芯，公园家，御湖名邸';
                        }else if ($keyArray[1] >= 4501 && $keyArray[1] <= 4700){
                            $content="平庄弹个车感谢您使用赤峰挪呗\n车主电话".$action->media_id."\n ".$action->type."\n\n".'阿里巴巴一成首付弹个车——平庄吉祥花园店宣';
                        }else if ($keyArray[1] >= 4451 && $keyArray[1] <= 4500){
                             $content="利丰二手车“行认证”感谢您使用赤峰挪呗\n车主电话".$action->media_id."\n ".$action->type."\n\n".'“行认证”，由中国汽车流通协会背书推出，基于国标GB/T 30323-2013技术规范打造；以服务消费者、为消费者提供可靠的购车保障为根本宗旨，立足于帮您挑选到优质的爱车，以专业的检测技术和诚信品质，保障您的购车利益不受侵害。行认证检测能力能覆盖全国110个城市，2018年11月入驻利丰二手车交易市场.';
                        }else if ($keyArray[1] >= 2352 && $keyArray[1] <= 2400){
                             $content="利丰二手车“行认证”感谢您使用赤峰挪呗\n车主电话".$action->media_id."\n ".$action->type."\n\n".'“行认证”，由中国汽车流通协会背书推出，基于国标GB/T 30323-2013技术规范打造；以服务消费者、为消费者提供可靠的购车保障为根本宗旨，立足于帮您挑选到优质的爱车，以专业的检测技术和诚信品质，保障您的购车利益不受侵害。行认证检测能力能覆盖全国110个城市，2018年11月入驻利丰二手车交易市场.';
                        }else if($keyArray[1] >= 4851 && $keyArray[1] <= 4898){
                             $content="感谢您使用赤峰挪呗\n车主电话".$action->media_id."\n ".$action->type;
                        }else if($keyArray[1] >= 4901 && $keyArray[1] <= 5100){
                            $content="悦山壹号感谢您使用赤峰挪呗\n车主电话".$action->media_id."\n ".$action->type."\n\n".'悦山壹号售房热线：0476-8249000';
                        }else{
                            $content="安信精品车行感谢您使用赤峰挪呗\n车主电话".$action->media_id."\n ".$action->type;
                        }
                        
                     }else{
                        if($keyArray[1] >= 200 && $keyArray[1] <= 700){
                            $content="赤峰小九窝音乐烤吧感谢您使用赤峰挪呗\n车主电话".$action->media_id;
                        }else if(($keyArray[1] >= 1301 && $keyArray[1] <= 1400) || ($keyArray[1] >= 1701 && $keyArray[1] <= 1800)){
                           $content="赤峰月星二手车感谢您使用赤峰挪呗\n车主电话".$action->media_id;
                        }else if($keyArray[1] >= 1401 && $keyArray[1] <= 1500){
                            $content="赤峰巨森农资感谢您使用赤峰挪呗\n车主电话".$action->media_id;
                        }else if ($keyArray[1] >= 2401 && $keyArray[1] <= 4000){
                             $content="赤峰居然之家联手赤百电器感谢您使用赤峰挪呗\n车主电话".$action->media_id."\n\n".'居然之家携手赤百电器打造赤峰顶尖家具家电一站式购买服务平台';
                        }else if ($keyArray[1] >= 4001 && $keyArray[1] <= 4200){
                            $content="龙发家之初装饰感谢您使用赤峰挪呗\n车主电话".$action->media_id;
                        }else if ($keyArray[1] >= 4201 && $keyArray[1] <= 4400){
                             $content="赤峰奔驰俱乐部携手路捷名车感谢您使用赤峰挪呗\n车主电话".$action->media_id."\n\n".'让爱出发   温暖回家';
                        }else if($keyArray[1] >= 4401 && $keyArray[1] <= 4450){
                            $content="恒大华府感谢您使用赤峰挪呗\n车主电话".$action->media_id."\n\n".'双城芯，公园家，御湖名邸';
                        }else if ($keyArray[1] >= 4501 && $keyArray[1] <= 4700){
                             $content="平庄弹个车感谢您使用赤峰挪呗\n车主电话".$action->media_id."\n\n".'阿里巴巴一成首付弹个车——平庄吉祥花园店宣';
                        }else if ($keyArray[1] >= 4451 && $keyArray[1] <= 4500){
                            $content="利丰二手车“行认证”感谢您使用赤峰挪呗\n车主电话".$action->media_id."\n\n".'“行认证”，由中国汽车流通协会背书推出，基于国标GB/T 30323-2013技术规范打造；以服务消费者、为消费者提供可靠的购车保障为根本宗旨，立足于帮您挑选到优质的爱车，以专业的检测技术和诚信品质，保障您的购车利益不受侵害。行认证检测能力能覆盖全国110个城市，2018年11月入驻利丰二手车交易市场.';
                        }else if ($keyArray[1] >= 2352 && $keyArray[1] <= 2400){
                            $content="利丰二手车“行认证”感谢您使用赤峰挪呗\n车主电话".$action->media_id."\n\n".'“行认证”，由中国汽车流通协会背书推出，基于国标GB/T 30323-2013技术规范打造；以服务消费者、为消费者提供可靠的购车保障为根本宗旨，立足于帮您挑选到优质的爱车，以专业的检测技术和诚信品质，保障您的购车利益不受侵害。行认证检测能力能覆盖全国110个城市，2018年11月入驻利丰二手车交易市场.';
                        }else if($keyArray[1] >= 4851 && $keyArray[1] <= 4898){
                             $content="安信精品车行感谢您使用赤峰挪呗\n车主电话".$action->media_id;
                        }else if($keyArray[1] >= 4901 && $keyArray[1] <= 5100){
                            $content="悦山壹号感谢您使用赤峰挪呗\n车主电话".$action->media_id."\n\n".'悦山壹号售房热线：0476-8249000';
                        }else{
                             $content="感谢您使用赤峰挪呗\n车主电话".$action->media_id;
                        }
                        
                     }
                }

		   
                break;
            case "SCAN":
                $EventKey = trim((string)$object->EventKey);
                $openid = trim((string)$object->FromUserName);
                $action = DB::table('q_rcodes')->where('id', $EventKey)->first();
                if($action->media_id == ''){
                    if($EventKey >= 200 && $EventKey <= 700){
                        $content = '赤峰小九窝音乐烤吧恭喜您领取一张挪呗挪车二维码，<a href="http://www.chifengbei.com/inputInfo/'.$EventKey.'?openid='.$openid.'">点击此处填写挪车电话！</a>';
                    }else if(($EventKey >= 1301 && $EventKey <= 1400) || ($EventKey >= 1701 && $EventKey <= 1800)){
                         $content = '赤峰月星二手车恭喜您领取一张挪呗挪车二维码，<a href="http://www.chifengbei.com/inputInfo/'.$EventKey.'?openid='.$openid.'">点击此处填写挪车电话！</a>';
                    }else if($EventKey >= 1401 && $EventKey <= 1500){
                         $content = '赤峰巨森农资恭喜您领取一张挪呗挪车二维码，<a href="http://www.chifengbei.com/inputInfo/'.$EventKey.'?openid='.$openid.'">点击此处填写挪车电话！</a>';
                    }else if ($EventKey >= 2401 && $EventKey <= 4000){
                        $content = '赤峰居然之家联手赤百电器恭喜您领取一张挪呗挪车二维码，<a href="http://www.chifengbei.com/inputInfo/'.$EventKey.'?openid='.$openid.'">点击此处填写挪车电话！</a>'."\n".'居然之家携手赤百电器打造赤峰顶尖家具家电一站式购买服务平台';
                    }else if ($EventKey >= 4001 && $EventKey <= 4200){
                         $content = '龙发家之初装饰恭喜您领取一张挪呗挪车二维码，<a href="http://www.chifengbei.com/inputInfo/'.$EventKey.'?openid='.$openid.'">点击此处填写挪车电话！</a>';
                    }else if ($EventKey >= 4201 && $EventKey <= 4400){
                         $content = '赤峰奔驰俱乐部携手路捷名车恭喜您领取一张挪呗挪车二维码，<a href="http://www.chifengbei.com/inputInfo/'.$EventKey.'?openid='.$openid.'">点击此处填写挪车电话！</a>';
                    }else if($EventKey >= 4401 && $EventKey <= 4450){
                        $content = '恒大华府喜您领取一张挪呗挪车二维码，<a href="http://www.chifengbei.com/inputInfo/'.$EventKey.'?openid='.$openid.'">点击此处填写挪车电话！</a>';
                    }else if ($EventKey >= 4501 && $EventKey <= 4700){
                         $content = '平庄弹个车恭喜您领取一张挪呗挪车二维码，<a href="http://www.chifengbei.com/inputInfo/'.$EventKey.'?openid='.$openid.'">点击此处填写挪车电话！</a>';
                    }else if ($EventKey >= 4451 && $EventKey <= 4500){
                        $content = '利丰二手车“行认证”恭喜您领取一张挪呗挪车二维码，<a href="http://www.chifengbei.com/inputInfo/'.$EventKey.'?openid='.$openid.'">点击此处填写挪车电话！</a>'."\n".'买卖二手，鉴定二手车请找行认证';
                    }else if ($EventKey >= 2352 && $EventKey <= 2400){
                        $content = '利丰二手车“行认证”恭喜您领取一张挪呗挪车二维码，<a href="http://www.chifengbei.com/inputInfo/'.$EventKey.'?openid='.$openid.'">点击此处填写挪车电话！</a>'."\n".'买卖二手，鉴定二手车请找行认证';
                    }else if($EventKey >= 4851 && $EventKey <= 4898){
                        $content = '安信精品车行恭喜您领取一张挪呗挪车二维码，<a href="http://www.chifengbei.com/inputInfo/'.$EventKey.'?openid='.$openid.'">点击此处填写挪车电话！</a>';
                    }else if($EventKey >= 4901 && $EventKey <= 5100){
                        $content = '悦山壹号喜您领取一张挪呗挪车二维码，<a href="http://www.chifengbei.com/inputInfo/'.$EventKey.'?openid='.$openid.'">点击此处填写挪车电话！</a>'."\n\n".'悦山壹号售房热线：0476-8249000';
                    }else{
                        $content = '恭喜您领取一张挪呗挪车二维码，<a href="http://www.chifengbei.com/inputInfo/'.$EventKey.'?openid='.$openid.'">点击此处填写挪车电话！</a>';
                    }
                   
                 }else{
                     if($action->type != ''){
                        if($EventKey >= 200 && $EventKey <= 700){
                            $content="赤峰小九窝音乐烤吧感谢您使用赤峰挪呗\n车主电话".$action->media_id."\n ".$action->type;
                        }else if(($EventKey >= 1301 && $EventKey <= 1400) || ($EventKey >= 1701 && $EventKey <= 1800)){
                            $content="赤峰月星二手车感谢您使用赤峰挪呗\n车主电话".$action->media_id."\n ".$action->type;
                        }else if($EventKey >= 1401 && $EventKey <= 1500){
                            $content="赤峰巨森农资感谢您使用赤峰挪呗\n车主电话".$action->media_id."\n ".$action->type;
                        }else if ($EventKey >= 2401 && $EventKey <= 4000){
                            $content="赤峰居然之家联手赤百电器感谢您使用赤峰挪呗\n车主电话".$action->media_id."\n ".$action->type."\n\n".'居然之家携手赤百电器打造赤峰顶尖家具家电一站式购买服务平台';
                        }else if ($EventKey >= 4001 && $EventKey <= 4200){
                             $content="龙发家之初装饰感谢您使用赤峰挪呗\n车主电话".$action->media_id."\n ".$action->type;
                        }else if ($EventKey >= 4201 && $EventKey <= 4400){
                            $content="赤峰奔驰俱乐部携手路捷名车感谢您使用赤峰挪呗\n车主电话".$action->media_id."\n ".$action->type."\n\n".'让爱出发   温暖回家';
                        }else if($EventKey >= 4401 && $EventKey <= 4450){
                            $content="恒大华府感谢您使用赤峰挪呗\n车主电话".$action->media_id."\n ".$action->type."\n\n".'双城芯，公园家，御湖名邸';
                        }else if ($EventKey >= 4501 && $EventKey <= 4700){
                            $content="平庄弹个车感谢您使用赤峰挪呗\n车主电话".$action->media_id."\n ".$action->type."\n\n".'阿里巴巴一成首付弹个车——平庄吉祥花园店宣';
                        }else if ($EventKey >= 4451 && $EventKey <= 4500){
                            $content="利丰二手车“行认证”感谢您使用赤峰挪呗\n车主电话".$action->media_id."\n ".$action->type."\n\n".'“行认证”，由中国汽车流通协会背书推出，基于国标GB/T 30323-2013技术规范打造；以服务消费者、为消费者提供可靠的购车保障为根本宗旨，立足于帮您挑选到优质的爱车，以专业的检测技术和诚信品质，保障您的购车利益不受侵害。行认证检测能力能覆盖全国110个城市，2018年11月入驻利丰二手车交易市场.';
                        }else if ($EventKey >= 2352 && $EventKey <= 2400){
                            $content="利丰二手车“行认证”感谢您使用赤峰挪呗\n车主电话".$action->media_id."\n ".$action->type."\n\n".'“行认证”，由中国汽车流通协会背书推出，基于国标GB/T 30323-2013技术规范打造；以服务消费者、为消费者提供可靠的购车保障为根本宗旨，立足于帮您挑选到优质的爱车，以专业的检测技术和诚信品质，保障您的购车利益不受侵害。行认证检测能力能覆盖全国110个城市，2018年11月入驻利丰二手车交易市场.';
                        }else if($EventKey >= 4851 && $EventKey <= 4898){
                            $content="安信精品车行感谢您使用赤峰挪呗\n车主电话".$action->media_id."\n ".$action->type;
                        }else if($EventKey >= 4901 && $EventKey <= 5100){
                            $content="悦山壹号感谢您使用赤峰挪呗\n车主电话".$action->media_id."\n ".$action->type."\n\n".'悦山壹号售房热线：0476-8249000';
                        }else{
                            $content="感谢您使用赤峰挪呗\n车主电话".$action->media_id."\n ".$action->type;
                        }
                        
                     }else{
                        if($EventKey >= 200 && $EventKey <= 700){
                            $content="赤峰小九窝音乐烤吧感谢您使用赤峰挪呗\n车主电话".$action->media_id;
                        }else if(($EventKey >= 1301 && $EventKey <= 1400) || ($EventKey >= 1701 && $EventKey <= 1800)){
                            $content="赤峰月星二手车感谢您使用赤峰挪呗\n车主电话".$action->media_id;
                        }else if($EventKey >= 1401 && $EventKey <= 1500){
                            $content="赤峰巨森农资感谢您使用赤峰挪呗\n车主电话".$action->media_id;
                        }else if ($EventKey >= 2401 && $EventKey <= 4000){
                             $content="赤峰居然之家联手赤百电器感谢您使用赤峰挪呗\n车主电话".$action->media_id."\n\n".'居然之家携手赤百电器打造赤峰顶尖家具家电一站式购买服务平台';
                        }else if ($EventKey >= 4001 && $EventKey <= 4200){
                             $content="龙发家之初装饰感谢您使用赤峰挪呗\n车主电话".$action->media_id;
                        }else if ($EventKey >= 4201 && $EventKey <= 4400){
                             $content="赤峰奔驰俱乐部携手路捷名车感谢您使用赤峰挪呗\n车主电话".$action->media_id."\n\n".'让爱出发   温暖回家';
                        }else if($EventKey >= 4401 && $EventKey <= 4450){
                             $content="恒大华府感谢您使用赤峰挪呗\n车主电话".$action->media_id."\n\n".'双城芯，公园家，御湖名邸';
                        }else if ($EventKey >= 4501 && $EventKey <= 4700){
                             $content="平庄弹个车感谢您使用赤峰挪呗\n车主电话".$action->media_id."\n\n".'阿里巴巴一成首付弹个车——平庄吉祥花园店宣';
                        }else if ($EventKey >= 2352 && $EventKey <= 2400){
                            $content="利丰二手车“行认证”感谢您使用赤峰挪呗\n车主电话".$action->media_id."\n\n".'“行认证”，由中国汽车流通协会背书推出，基于国标GB/T 30323-2013技术规范打造；以服务消费者、为消费者提供可靠的购车保障为根本宗旨，立足于帮您挑选到优质的爱车，以专业的检测技术和诚信品质，保障您的购车利益不受侵害。行认证检测能力能覆盖全国110个城市，2018年11月入驻利丰二手车交易市场.';
                        }else if ($EventKey >= 4451 && $EventKey <= 4500){
                            $content="利丰二手车“行认证”感谢您使用赤峰挪呗\n车主电话".$action->media_id."\n\n".'“行认证”，由中国汽车流通协会背书推出，基于国标GB/T 30323-2013技术规范打造；以服务消费者、为消费者提供可靠的购车保障为根本宗旨，立足于帮您挑选到优质的爱车，以专业的检测技术和诚信品质，保障您的购车利益不受侵害。行认证检测能力能覆盖全国110个城市，2018年11月入驻利丰二手车交易市场.';
                        }else if($EventKey >= 4901 && $EventKey <= 5100){
                            $content="悦山壹号感谢您使用赤峰挪呗\n车主电话".$action->media_id."\n\n".'悦山壹号售房热线：0476-8249000';
                        }else if($EventKey >= 4851 && $EventKey <= 4898){
                            $content="安信精品车行感谢您使用赤峰挪呗\n车主电话".$action->media_id;
                        }else{
                            $content="感谢您使用赤峰挪呗\n车主电话".$action->media_id;
                        }
                        
                     }
                     
                 }
		break;
		default:
                $content = "你好，欢迎关注赤峰呗！";
                break;
        }
       $result = $this->transmitText($object,$content);
        return $result;
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
