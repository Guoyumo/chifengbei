<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\AutoReply;
use App\Http\Controllers\WechatService;

class AutoReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auto_replys = AutoReply::paginate(15);
        return view('auto_reply.index',['auto_replys'=>$auto_replys]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(WechatService $wechat)
    {
        $count = $wechat->getMaterialCount();
        return view('auto_reply.create',['image_count'=>$count['image_count'],'news_count'=>$count['news_count']]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->input();
        if(empty($inputs)){
            return;
        }
        $msgTemplateStr = '';
        $name = $inputs['name'];
        $keyWords = $inputs['key_words'];
        $matchType = $inputs['match_type'];
        $msgType = $inputs['type'];
        $content = $inputs['media_id'];
        $meida_content = $inputs['media_content'];
        $msgTemplateStr = $this->getMsgTplStr($content, $msgType);

        $auto_reply = new AutoReply();
        $auto_reply->rule_name = $name;
        $auto_reply->key_words = $keyWords;
        $auto_reply->match_type = $matchType;
        $auto_reply->reply_content = $msgTemplateStr;
        $auto_reply->media_content = $meida_content;
        $auto_reply->message_type = $msgType;
        $auto_reply->media_id = $content;
        $auto_reply->save();

        return redirect('/admin/autoReplys/' . $auto_reply->id);

    }

    public function getMsgTplStr($content, $msgType){
//        $time = date('Y-m-d H:i:s', time());
        $time = time();
        switch ($msgType){
            case 'text' :
                $msgTemplateStr = "<xml><ToUserName><![CDATA[%s]]></ToUserName> <FromUserName><![CDATA[%s]]></FromUserName> <CreateTime>$time</CreateTime> <MsgType><![CDATA[text]]></MsgType> <Content><![CDATA[$content]]></Content> </xml>";
                break;
            case 'image' :
                $msgTemplateStr = "<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>$time</CreateTime><MsgType><![CDATA[image]]></MsgType><Image><MediaId><![CDATA[$content]]></MediaId></Image></xml>";
                break;
            case 'news' :
                $wechatService = new WechatService();
                $news = $wechatService->getMateriaByMediaId($content);
                $newsCount = count($news['news_item']);
                $msgTemplateStr = "<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>$time</CreateTime><MsgType><![CDATA[news]]></MsgType><ArticleCount>$newsCount</ArticleCount><Articles>";
                foreach ($news['news_item'] as $item){
                    $newsTitle = $item['title'];
                    $author = $item['author'];
                    $digest = $item['digest'];
                    $content = $item['content'];
                    $content_source_url = $item['content_source_url'];
                    $thumb_media_id = $item['thumb_media_id'];
                    $show_cover_pic = $item['show_cover_pic'];
                    $url = $item['url'];
                    $thumb_url = $item['thumb_url'];
                    $need_open_comment = $item['need_open_comment'];
                    $only_fans_can_comment = $item['only_fans_can_comment'];
                    $msgTemplateStr .= "<item><Title><![CDATA[$newsTitle]]></Title> <Description><![CDATA[$digest]]></Description><PicUrl><![CDATA[$thumb_url]]></PicUrl><Url><![CDATA[$url]]></Url></item>";
                }
                $msgTemplateStr .= "</Articles></xml>";
                break;
        }

        return $msgTemplateStr;
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(AutoReply $autoReply)
    {
        return view('auto_reply.detail',['auto_reply'=>$autoReply]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(AutoReply $autoReply, WechatService $wechat)
    {
        $count = $wechat->getMaterialCount();
        return view('auto_reply.edit',['auto_reply'=>$autoReply, 'image_count'=>$count['image_count'],'news_count'=>$count['news_count']]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AutoReply $autoReply)
    {
        $inputs = $request->input();
        if(empty($inputs)){
            return;
        }
        $msgTemplateStr = '';
        $name = $inputs['name'];
        $keyWords = $inputs['key_words'];
        $matchType = $inputs['match_type'];
        $msgType = $inputs['type'];
        $content = isset($inputs['media_id']) ? $inputs['media_id'] : $autoReply->media_id;
        $meida_content = $inputs['media_content'];
        $msgTemplateStr = $this->getMsgTplStr($content, $msgType);

        $autoReply->rule_name = $name;
        $autoReply->key_words = $keyWords;
        $autoReply->match_type = $matchType;
        $autoReply->reply_content = $msgTemplateStr;
        $autoReply->media_content = $meida_content;
        $autoReply->message_type = $msgType;
        $autoReply->media_id = $content;

        $autoReply->save();
        return redirect('/admin/autoReplys/' . $autoReply->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AutoReply $autoReply)
    {
        $autoReply->delete();
        return redirect('/admin/autoReplys');
    }

    public function syncDataFromWechat(){
        $wechatService = new WechatService();
        $reply = $wechatService->getAutoReplyInfo();
        foreach($reply['keyword_autoreply_info']['list'] as $reply_detail){
            foreach ($reply_detail['keyword_list_info'] as $keyword){
                foreach ($reply_detail['reply_list_info'] as $reply_content){

                }
            }
        }
        var_dump($reply['keyword_autoreply_info']['list'][0], $reply['keyword_autoreply_info']['list'][1]);exit;
    }
}
