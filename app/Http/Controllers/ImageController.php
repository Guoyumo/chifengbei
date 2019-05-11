<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Image;
use App\Http\Requests;
use App\Image as StoreImage;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function upload(Request $request){
        $file = $request->file("image");
        $fileName = $file->getClientOriginalName();
        $path = public_path('images/storeImage');
        $file->move($path, $fileName);
        // $img = Image::make($path."/".$fileName);
        // $img->resize(320,200)->save($path.'/'.$fileName);
        $url = "https://www.chifengbei.com/images/storeImage/".$fileName;
        $image = new StoreImage;
        $image->store_id = $request->input('store_id');
        $image->url = $url;
        $image->save();
        return $url;
    }
}
