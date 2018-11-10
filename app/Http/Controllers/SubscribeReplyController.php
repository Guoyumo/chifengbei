<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\subscribeReply;

class SubscribeReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = subscribeReply::all();
        $count = subscribeReply::count();
        $showCreate = $count < 2 ? 'block' : 'none';
        return view('subscribe_reply.index', ['subscribe_replys' => $result, 'show_create' => $showCreate]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('subscribe_reply.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->input();
        if(!isset($data['name']) || !isset($data['content'])){
            return false;
        }
        $subscribeReply = new subscribeReply();
        $subscribeReply->title = $data['name'];
        $subscribeReply->content = $data['content'];
        $subscribeReply->save();
        return redirect('/admin/subscribeReplys/' . $subscribeReply->id);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(subscribeReply $subscribeReply)
    {
        return view('subscribe_reply.detail',['subscribe_reply'=>$subscribeReply]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(subscribeReply $subscribeReply)
    {

        return view('subscribe_reply.edit',['subscribe_reply'=>$subscribeReply]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, subscribeReply $subscribeReply)
    {
        $data = $request->input();
        if(!isset($data['name']) || !isset($data['content'])){
            return false;
        }
        $subscribeReply->title = $data['name'];
        $subscribeReply->content = $data['content'];
        $subscribeReply->save();
        return redirect('/admin/subscribeReplys/' . $subscribeReply->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(subscribeReply $subscribeReply)
    {
        $subscribeReply->delete();
        return redirect('/admin/subscribeReplys');
    }
}
