@extends('layouts.admin')

@section('content')
    <!-- <div class="row" id="createQRcode">
        <div class="col-md-8">           
            <form action="{{url('admin/qrcodes')}}" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name">{{trans('admin.qr_code_name')}}</label>
                    <input type="text"  name="name" class="form-control" id="name" placeholder="{{trans('admin.qr_code_name')}}">
                </div>
                <div class="form-group">
                    <label for="qr_code_type">{{trans('admin.qr_code_name')}}</label>
                    <select class="form-control" name="type" v-model="type" id="qr_code_type">
                        <option value="content">content</option>
                        <option value="image">image</option>
                        <option value="news">article</option>
                    </select>
                </div>
                <div class="form-group " v-if="showContent">
                    <label for="qr_code_type">{{trans('admin.media_id')}}</label>
                    <textarea class="form-control" rows="3" id="reply_content" name="media_id"></textarea>
                </div>
                <div class="form-group " v-if="showImage">
                    <label v-for="image in imageList">
                        <input type="radio" name="media_id" :value="image.media_id">@{{image.name}}
                    </label>
                </div>
                <div class="form-group " v-if="showArticle">
                    <label v-for="article in articleList">
                        <input type="radio" name="media_id" :value="article.media_id">@{{article.content[0].title}}
                    </label>
                </div>
                <h6>Center alignment</h6>
                <b-pagination align="center" :total-rows="100" v-model="articleCurrentPage" :per-page="10">
                </b-pagination>
                <br>

                <button type="submit" class="btn btn-default">Submit</button>
            </form>
       
        </div>
    </div> -->

    <div class="col-md-1"></div>
    <div class="box box-success col-md-10" id="createQRcode">
            <div class="box-header with-border">
              <h3 class="box-title">{{trans('admin.create_qr_code')}}</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="{{url('admin/qRcodes')}}" method="post" @submit="checkForm">
            {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                    <label for="name" :style="{color:colorName}" class="col-sm-2 control-label">{{trans('admin.qr_code_name')}}</label>
                    <div class="col-sm-10">
                        <input type="text"  v-model="name" name="name" class="form-control" id="name" placeholder="{{trans('admin.qr_code_name_place_holder')}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="qr_code_type"  class="col-sm-2 control-label">{{trans('admin.qr_code_type')}}</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="type" v-model="type" id="qr_code_type">
                            <option value="content">content</option>
                            <option value="image">image</option>
                            <option value="news">news</option>
                        </select>
                    </div>
                </div>

                <div class="form-group " style="max-height: 500px; overflow-y: scroll;">
                    <label for="qr_code_type" class="col-sm-2 control-label">{{trans('admin.media_id')}}</label>
                    <div class="col-sm-10" v-if="showContent">
                        <textarea class="form-control" rows="3" id="reply_content" name="media_id"></textarea>
                    </div>
                    <div class="radio" v-if="showImage" v-for="image in imageList" v-show="!(image.name == 'CropImage')">
                        <div class="col-sm-2" v-if="!(image.name == 'CropImage')"></div>
                        <div class="col-sm-10" v-if="!(image.name == 'CropImage')">
                        <label>
                            <input type="radio" name="media_id" :value="image.media_id">
                            @{{image.name}}
                        </label>
                        </div>
                    </div>
                    <div class="radio" v-if="showArticle" v-for="article in articleList">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10">
                            <labe>
                                <input type="radio" name="media_id" :value="article.media_id">@{{article.content[0].title}} 
                            </label>
                        </div>
                    </div>
                </div>

              </div>
              <div class="col-md-12 text-center">
              <b-pagination align="right" :total-rows="{{$image_count}}" v-if="showImage" v-model="imageCurrentPage" :per-page="20">
              </b-pagination> 
              <b-pagination align="right" :total-rows="{{$news_count}}" v-if="showArticle" v-model="articleCurrentPage" :per-page="20">
              </b-pagination>
              </div>
              <div style="display:none;">
                @{{paginateImage}}   @{{paginateNews}} 
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-info pull-right" style="line-height:unset;">{{trans('admin.create')}}</button>
              </div>
              <!-- /.box-footer -->
            </form>
        </div>
        <div class="col-md-1"></div>
@endsection

@section('custom-javascript')
<script>

    var createQRcode = new Vue({
        el: '#createQRcode',
        data:{
            name:'',
            type:'content',
            showContent:true,
            showImage:false,
            showArticle:false,
            ROOT_PATH:ROOT_PATH,
            articleCurrentPage:1,
            imageCurrentPage:1,
            articleList:[],
            imageList:[],
            image_count:1,
            colorName:'#222'
        }, 
        methods : {
            submit:function(){
                console.log(this.type);
            },
            getMaterialList:function(){
                if(this.type == 'content'){
                    this.showImage = false;
                    this.showContent = true;
                    this.showArticle = false;
                }
                
                if(this.type == 'image'){
                    this.showImage = true;
                    this.showContent = false;
                    this.showArticle = false;
                }
                if(this.type == 'news'){
                    this.showImage = false;
                    this.showContent = false;
                    this.showArticle = true;
                }
            },
            checkForm: function(e){

                if(this.name.length <= 37 && this.name.length > 0){
                    return true
                }
                this.colorName='#f00'
                e.preventDefault();
            }
        },
        watch:{
            type:'getMaterialList',
        },
        mounted:function(){
            console.log('{{$image_count}}');
        },
        computed:{
           paginateImage :function(){
               var that = this;
               var formData = new FormData();
                formData.append('type','image');
                formData.append('count',this.imageCurrentPage);
                $.ajax({
                    url: '{{url("getMaterialList")}}',
                    method: "POST",
                    data: formData,
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    processData: false,
                    contentType: false
                }).done(function(result) {
                    that.imageList = result;
                });
                return this.imageCurrentPage;
           },
           paginateNews :function(){
                var that = this;
                var formData = new FormData();
                formData.append('type','news');
                formData.append('count',this.articleCurrentPage);
                $.ajax({
                    url: '{{url("getMaterialList")}}',
                    method: "POST",
                    data: formData,
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    processData: false,
                    contentType: false
                }).done(function(result) {
                    that.articleList = result;
                });
                return this.articleCurrentPage;

           }
        }
    });
</script>
@endsection
