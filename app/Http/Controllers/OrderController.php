<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Order;
use App\Events\SendTextToUser;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $orders = Order::where('isFinish',false)->orderBy('id','desc') -> paginate(15);
        return view('orders.index',['orders'=>$orders]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $orders = Order::where('isFinish',true)->orderBy('id','desc') -> paginate(15);
        return view('orders.finish',['orders'=>$orders]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
        $order->isFinish = true;
        $order->save();
        return redirect('admin/orders/finish');
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

    public function finish(){
        $orders = Order::where('isFinish',true)->orderBy('id','desc') -> paginate(15);
        return view('orders.finish',['orders'=>$orders]);
    }

    public function createOrder(Request $request){
        date_default_timezone_set('Asia/Shanghai'); 
        $event = new SendTextToUser();
        $event->openid = "oamd-5gCVEtHm-2Gn2PMgFdy1gCo";
        // $event->openid = "oamd-5g0Iw4SU05jBgaBQZ8T6F6w";
        // $event->media_id = "新订单 发件人：".$request->name."送件人电话:".$request->phone."收件人电话:".$request->remark."出发地点：".$request->startLocation."收货地址：".$request->finishLocation;
        $event->media_id = $request;
        event($event);

Log::debug("新订单 发件人：".$request->name."送件人电话:".$request->phone."收件人电话:".$request->remark."出发地点：".$request->startLocation."收货地址：".$request->finishLocation);


        $name= $request->name;
        $isImportant= $request->isImportant;
        $startLocation= $request->startLocation;
        $finishLocation= $request->finishLocation;
        $phone= $request->phone;
        $remark= $request->remark;
        $car = $request->car;
        $booking = $request->dateTime;
        $time = time();
        $time = date('Y-m-d H:i:s',$time);
        $order = new Order;
        $order->startLocation = $startLocation;
        $order->finishLocation =  $finishLocation;
        $order->remark = $remark;
        $order->isImprotant = $isImportant;
        $order->phone = $phone;
        $order->car = $car;
        $order->name = $name;
        $order->isFinish;
        $order->time = $time;
        $order->booking = $booking;

        $order->save();
        return $response->json($order->id);
      
    }
}
