<?php

namespace App\Http\Controllers;

use App\QRcode;
use Illuminate\Http\Request;
use App\Http\Controllers\WechatService;

class QRcodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(WechatService $wechat)
    {
        //

        $qrcodes = QRcode::paginate(15);
        return view('qrcode.index',['qrcodes'=>$qrcodes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(WechatService $wechat)
    {
        //
        // $count = $wechat->getMaterialCount(); 
        // var_dump($count['image_count']);exit;
        return view('qrcode.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,WechatService $wechat)
    {
        //
        $qrCode = new QRcode; 
        $qrCode->name = $request->input('name');
        $qrCode->type = "";
        $qrCode->media_id = "";
        $qrCode->save();
        $wechat->generatePermanentQRcode($qrCode->id);
        return redirect('/admin/qRcodes/' . $qrCode->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\QRcode  $qRcode
     * @return \Illuminate\Http\Response
     */
    public function show(QRcode $qRcode)
    {
        //
        return view('qrcode.detail',['qrcode'=>$qRcode]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\QRcode  $qRcode
     * @return \Illuminate\Http\Response
     */
    public function edit(QRcode $qRcode,WechatService $wechat)
    {
        //
        // $count = [
        //    'image_count'=>5,
        //    'news_count' =>5
        // ];
        return view('qrcode.edit',['qrcode'=>$qRcode]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\QRcode  $qRcode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QRcode $qRcode)
    {
        //
        $qRcode->name = $request->input('name');
        // $qRcode->type = $request->input('type');
        // $qRcode->media_id = $request->input('media_id');
        $qRcode->save();
        return redirect('/admin/qRcodes/' . $qRcode->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\QRcode  $qRcode
     * @return \Illuminate\Http\Response
     */
    public function destroy(QRcode $qRcode)
    {
        //
        $qRcode->delete();
        return redirect('/admin/qRcodes');
    }

    public function download(QRcode $qRcode){
        $path = public_path();
        $image = file_get_contents($path."/qrCode/permanent_".$qRcode->id.".jpg");
        header("Pragma: cache");
        header("Content-type: application/octet-stream; charset=utf-8");
        header('Content-Disposition: attachment; filename="'.$qRcode->name.'_'.$qRcode->id.'.jpg"');
        header("Content-transfer-encoding: binary");
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . date('Y-m-d H  '));
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Content-Length: " . mb_strlen($image, '8bit'));
        ob_start();
        print $image;

        ob_end_flush();
    }

    public function inputInfo($id)
    {
        return view('inputInfo',['id'=>$id]);
    }
    public function updateCarOwnerInfo(Request $request){
        $id = $request->input('id');
        $phone = " /^((\+?[0-9]{1,4})|(\(\+86\)))?(13[0-9]|14[57]|15[012356789]|16[6]|17[035678]|18[0-9]|19[8-9])\d{8}$/";
        preg_match($phone, $request->input('carOwnerPhone'), $matchephone, PREG_OFFSET_CAPTURE);
        if($request->input('carOwnerPhone') == "" || sizeof($matchephone) == 0){
            return view('signFail');
        }
        $qrCode = QRcode::where('id',$id)->first();
        $qrCode->type = $request->input('carOwner');
        $qrCode->media_id = $request->input('carOwnerPhone');
        $qrCode->openid = $request->input('openid');
        $qrCode->save();
        return redirect('signSuccess');
    }
    public function changeQRcodeInfoList(Request $request){
        $userInfo = $request->session()->get('userInfo');
        $openid = $userInfo['openid'];
        $qrcodes = QRcode::where('openid',$openid)->get();
        return view('changeQRcodeInfoList',['qrcodes'=>$qrcodes]);
    }
}
