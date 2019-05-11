<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Store;
// use Image;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $stores = Store::paginate(20);
        return view('store.index',['stores'=>$stores]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('store.create');
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
        $store = new Store;
        $store->name = $request->input("name");
        $store->address = $request->input("address");
        $store->details = $request->input("detail");
        $store->types = $request->input("type");
        $store->rate = $request->input("rate");
        $store->phone = $request->input("phone");
        $store->logo = $request->input("logo");
        $store->wechat = $request->input("wechat");
        $store->weight = $request->input("weight");
        $store->info = $request->input("info");
        $store->save();
        return response()->json($store->id);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Store $store)
    {
        //
        return view('store.detail',['store'=>$store]);
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
    public function destroy(Store $store)
    {
        //
       $store->delete();
        return redirect('admin/stores');
    }
    public function upload(Request $request){
        $file = $request->file("image");
        $fileName = $file->getClientOriginalName();
        $path = public_path('images/stores');
        $file->move($path, $fileName);
        // $img = Image::make($path."/".$fileName);
        // $img->resize(100,100)->save($path.'/'.$fileName);
        $return = "https://www.chifengbei.com/images/stores/".$fileName;
        return response()->json($return);
    }
    public function getStore(){
        $stores = Store::select("name","address","phone","rate","logo","id", "weight")->get();
        foreach($stores as &$store){
            $store->images = $store->images()->take(3)->get();
            $startDate = strtotime("2019-01-10");
            $expireDays = ceil((time()-$startDate)/60/60/24) + 1;
            $weight = $expireDays * 32 + intval($store->weight);
            $store->weight = $weight;
        }
        return $stores;
    }
    public function getStoreDetail(Request $request){
        $storeId = $request->input('storeId');
        $storeInfo = Store::where("id",(int)$storeId)->first();
        $images = $storeInfo->images()->take(3)->get();
        $storeInfo->images = $images;
        return $storeInfo;
    }
}
