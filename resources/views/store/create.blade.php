@extends('layouts.admin')

@section('content')
    <div class="col-md-1"></div>
    <div class="box box-success col-md-10" id="createStore">
            <div class="box-header with-border">
              <h3 class="box-title">新增商家</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal">
              <div class="box-body">
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">商户名称</label>
                    <div class="col-sm-10">
                        <input type="text" v-model="name" name="name" class="form-control" id="name" placeholder="不得大于36字节">
                    </div>
                </div>
                 <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">商户地址</label>
                    <div class="col-sm-10">
                        <textarea v-model="address" class="form-control" rows="3" name="address"></textarea>
                    </div>
                </div>
                <div class="form-group">
                  <label for="name" class="col-sm-2 control-label">商户详情</label>
                  <div class="col-sm-10">
                      <textarea v-model="detail" class="form-control"  name=""></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label for="name" class="col-sm-2 control-label">分类</label>
                  <div class="col-sm-4">
                     <select class="form-control" name="type" v-model="type">
                        <option value="1">餐饮</option>
                        <option value="2">新车</option>
                        <option value="3">二手车</option>
                        <option value="4">其他</option>
                      </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="name" class="col-sm-2 control-label">营业时间</label>
                  <div class="col-sm-10">
                    <textarea class="form-control" rows="3" v-model="rate"></textarea>
                  </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">点击量</label>
                    <div class="col-sm-10">
                        <input type="number" v-model="weight" name="name" class="form-control" placeholder="初始点击量">
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">商户电话</label>
                    <div class="col-sm-10">
                        <input type="phone " v-model="phone"  name="phone" class="form-control"  placeholder="商户电话">
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">详情长图</label>
                    <div class="col-sm-5">
                         <input type="file" ref="info" class="col-sm-8">
                        <button type="button" v-on:click="uploadInfo" class="col-sm-4">上传</button>
                    </div>
                    <div class="col-sm-5">
                        <img v-bind:src="info" alt="IMAGE HERE">
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">商户logo</label>
                    <div class="col-sm-5">
                         <input type="file" ref="imageLogo" class="col-sm-8">
                        <button type="button" v-on:click="uploadLogo" class="col-sm-4">上传</button>
                    </div>
                    <div class="col-sm-5">
                        <img v-bind:src="logo" alt="IMAGE HERE">
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">商户微信</label>
                    <div class="col-sm-5">
                         <input type="file" ref="imageWechat" class="col-sm-8" >
                        <button type="button" v-on:click="uploadWechat" class="col-sm-4">上传</button>
                    </div>
                    <div class="col-sm-5">
                        <img v-bind:src="wechat" alt="IMAGE HERE">
                    </div>
                </div>
              </div>

              <!-- /.box-body -->
              <div class="box-footer">
                <button type="button" class="btn btn-info pull-right" style="line-height:unset;" @click="submit">创建</button>
              </div>
              <!-- /.box-footer -->
            </form>
        </div>
        <div class="col-md-1"></div>
@endsection

@section('custom-javascript')
<script>
var createStore = new Vue({
    el: '#createStore',
    data:{
      src:"",
      ROOT_PATH:ROOT_PATH,
      name:"",
      address:"",
      detail:"",
      type:"",
      rate:"",
      phone:"",
      logo:"",
      wechat:"",
      weight:"",
      info:""
    }, 
    methods : {
      uploadLogo: function(e) {
        e.preventDefault();
        var files = this.$refs.imageLogo.files;
        console.log(files);
        var data = new FormData();
        var that = this;
        data.append('image', files[0]);
        //  data.append('_method', 'PUT');

        $.ajax({
          url: '{{url("/admin/stores/upload")}}',
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
           that.logo = result;
        });
      },
      uploadWechat:function(e){
        e.preventDefault();
        var files = this.$refs.imageWechat.files;
        console.log(files);
        var data = new FormData();
        var that = this;
        data.append('image', files[0]);
        //  data.append('_method', 'PUT');
    
        $.ajax({
          url: '{{url("/admin/stores/upload")}}',
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
           that.wechat = result;
        });
      },
      uploadInfo: function(e) {
        e.preventDefault();
        var files = this.$refs.info.files;
        console.log(files);
        var data = new FormData();
        var that = this;
        data.append('image', files[0]);
        //  data.append('_method', 'PUT');

        $.ajax({
          url: '{{url("/admin/stores/upload")}}',
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
           that.info = result;
        });
      },
      submit: function(){
          console.log("submit", this.$data);
        var that = this;
        var data = new FormData();
        data.append('name', this.name);
        data.append('address', this.address);
        data.append('detail', this.detail);
        data.append('type', this.type);
        data.append('rate', this.rate);
        data.append('phone', this.phone);
        data.append('logo', this.logo);
        data.append('wechat', this.wechat);
        data.append('weight', this.weight);
        data.append('info', this.info);
        $.ajax({
          url: '{{url("/admin/stores")}}',
          method: "POST",
          data: data,
          headers:{
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
	        processData: false,
          contentType: false
        }).done(function(result) {
           window.location.href = '{{url("/admin/stores/")}}' + '/'+ result
           
        });
      }
    }
});
</script>
@endsection
