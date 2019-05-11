@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">商户详情</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tr>
                  <td width="200px">商户名称</td>
                  <td>{{$store->name}}</td>
                </tr>
                <tr>
                     <td width="200px">商户类型</td>
                    <td>{{$store->types}}</td>
                </tr>
                <tr>
                    <td width="200px">商户详情</td>
                    <td>{{$store->details }}</td>
                </tr>
                <tr>
                    <td width="200px">商户地址</td>
                    <td>{{$store->address}}</td>
                </tr>
                <tr>
                    <td width="200px">营业时间</td>
                    <td>{{$store->rate}}</td>
                </tr>
                 <tr>
                    <td width="200px">初始点击量</td>
                    <td>{{$store->weight}}</td>
                </tr>
                <tr>
                    <td width="200px">商户logo</td>
                    <td>
                    <img src="{{$store->logo}}">
                    </td>
                </tr>
                <tr>
                    <td width="200px">商户微信</td>
                    <td>
                    <img src="{{$store->wechat}}">
                    </td>
                </tr>
              </table>
              <button type="button" class="btn btn-default btn-block"><a href="{{url('admin/stores/'.$store->id.'/edit')}}">Edit</a></button>
            </div>

            <div class="box" id="imageUpload">
                <div class="box-header with-border">
                <h3 class="box-title">轮播图</h3>
                </div>
                <div class="box-body">
                    <form action="" class="form-horizontal">
                    
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">轮播图1</label>
                            <div class="col-sm-5">
                                <input type="file" ref="image1" class="col-sm-8">
                                <button type="button" v-on:click="upload1" class="col-sm-4">上传</button>
                            </div>
                            <div class="col-sm-5">
                                <img v-bind:src="image1" alt="IMAGE HERE">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">轮播图2</label>
                            <div class="col-sm-5">
                                <input type="file" ref="image2" class="col-sm-8">
                                <button type="button" v-on:click="upload2" class="col-sm-4">上传</button>
                            </div>
                            <div class="col-sm-5">
                                <img v-bind:src="image2" alt="IMAGE HERE">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">轮播图3</label>
                            <div class="col-sm-5">
                                <input type="file" ref="image3" class="col-sm-8">
                                <button type="button" v-on:click="upload3" class="col-sm-4">上传</button>
                            </div>
                            <div class="col-sm-5">
                                <img v-bind:src="image3" alt="IMAGE HERE">
                            </div>
                        </div>
                    </form>
                </div>
            </div>


          </div>
          <!-- /.box -->
        </div>
        <div class="col-md-1"></div>
    </div>
@endsection

@section('custom-javascript')
<script>
var imageUpload = new Vue({
    el: '#imageUpload',
    data:{
      image1:"",
      image2:"",
      image3:"",
      store:"{{$store->id}}"
    }, 
    methods : {
      upload1: function(e) {
        e.preventDefault();
        var files = this.$refs.image1.files;
        console.log(files);
        var data = new FormData();
        var that = this;
        data.append('image', files[0]);
        data.append('store_id',this.store);
        //  data.append('_method', 'PUT');

        $.ajax({
          url: '{{url("/admin/images/upload")}}',
          method: "POST",
          data: data,
          headers:{
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
	        processData: false,
          contentType: false
        }).done(function(result) {
            //display the image in IMAGE HERE
           console.log(result);
           that.image1 = result;
        });
      },
      upload2:function(e){
        e.preventDefault();
        var files = this.$refs.image2.files;
        console.log(files);
        var data = new FormData();
        var that = this;
        data.append('image', files[0]);
        data.append('store_id',this.store);
        //  data.append('_method', 'PUT');
    
        $.ajax({
          url: '{{url("/admin/images/upload")}}',
          method: "POST",
          data: data,
          headers:{
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
	        processData: false,
          contentType: false
        }).done(function(result) {
            //display the image in IMAGE HERE
           console.log(result);
           that.image2 = result;
        });
      },
      upload3:function(e){
        e.preventDefault();
        var files = this.$refs.image3.files;
        console.log(files);
        var data = new FormData();
        var that = this;
        data.append('image', files[0]);
        data.append('store_id',this.store);
        //  data.append('_method', 'PUT');
    
        $.ajax({
          url: '{{url("/admin/images/upload")}}',
          method: "POST",
          data: data,
          headers:{
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
	        processData: false,
          contentType: false
        }).done(function(result) {
            //display the image in IMAGE HERE
           console.log(result);
           that.imaage3 = result;
        });
      }
    }
});
</script>
@endsection