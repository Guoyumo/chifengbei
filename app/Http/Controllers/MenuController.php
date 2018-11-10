<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Menu;
use App\Http\Requests;
use App\Http\Controllers\WechatService;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(WechatService $wechat)
    {
        //
        $count = $wechat->getMaterialCount(); 
        // $count = [
        // 'image_count'=>5,
        // 'news_count' =>5
        // ];
        return view('menu.index',['image_count'=>$count['image_count'],'news_count'=>$count['news_count']]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request ,WechatService $wechat)
    {
        //
        
            $request = $request->all();
            $menu = new Menu; 
            $menu->menu = $request['menu'];
            $menu->save();
            $result = $wechat->createMenu($request['menu']);
            if($result === true){
                return 1;
            }else{
                return $result;
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getMenu(){
        $menu = Menu::orderBy('id','desc')->first();
        $menu = json_decode($menu->menu,true);
        return response()->json($menu);
    }
}
