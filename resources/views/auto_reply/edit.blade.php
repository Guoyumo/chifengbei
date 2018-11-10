@extends('layouts.admin')

@section('content')
    <div class="col-md-1"></div>
    <div class="box box-success col-md-10" id="createAutoReply">
            <div class="box-header with-border">
              <h3 class="box-title">{{trans('admin.edit_auto_reply')}}</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="{{url('admin/autoReplys/'.$auto_reply->id)}}" method="post" @submit="checkForm">
            {{ method_field('PUT') }}
            {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                    <label for="name" :style="{color:colorName}" class="col-sm-2 control-label">{{trans('admin.auto_reply_name')}} *</label>
                    <div class="col-sm-10">
                        <input type="text"  v-model="name" name="name" class="form-control" id="auto_reply_name"  placeholder="{{$auto_reply->rule_name}}">
                    </div>
                </div>
                  <div class="form-group">
                      <label for="key_words" :style="{color:colorKeywords}" class="col-sm-2 control-label">{{trans('admin.auto_reply_key_words')}} *</label>
                      <div class="col-sm-10">
                          <input type="text"  v-model="key_words" name="key_words" class="form-control" id="auto_reply_key_words" placeholder="{{$auto_reply->key_words}}">
                      </div>
                  </div>
                  <div class="form-group">
                      <label for="auto_reply_match_type"  class="col-sm-2 control-label">{{trans('admin.auto_reply_match_type')}}</label>
                      <div class="col-sm-10">
                          <select class="form-control" name="match_type" v-model="match_type" id="auto_reply_match_type">
                              <option value="full_match">Full Match</option>
                              <option value="half_match">Half Match</option>
                          </select>
                      </div>
                  </div>
                  <div class="form-group">
                      <label for="auto_reply_content_type"  class="col-sm-2 control-label">{{trans('admin.auto_reply_content_type')}}</label>
                      <div class="col-sm-10">
                          <select class="form-control" name="type" v-model="type" id="auto_reply_content_type">
                              <option value="text">Text</option>
                              <option value="image">image</option>
                              <option value="news">news</option>
                          </select>
                      </div>
                  </div>

                <div class="form-group " style="max-height: 400px; overflow-y: scroll;">
                    <label for="qr_code_type" :style="{color:colorContent}" class="col-sm-2 control-label">{{trans('admin.media_id')}}</label>
                    <div class="radio" v-if="!showContent"><label v-html="media_content"></label></div>
                    <div class="col-sm-10" v-if="showContent">
                        <textarea v-html="media_input" class="form-control" rows="3" id="reply_content" name="media_id" ></textarea>
                    </div>
                    <div class="radio" v-if="showImage" v-for="image in imageList" v-show="!(image.name == 'CropImage')">
                        <div class="col-sm-2" v-if="!(image.name == 'CropImage')"></div>
                        <div class="col-sm-10" v-if="!(image.name == 'CropImage')">
                        <label>
                            <input v-model="media_input" type="radio" name="media_id" :value="image.media_id">
                            @{{image.name}}
                        </label>
                        </div>
                    </div>
                    <div class="radio" v-if="showArticle" v-for="article in articleList">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10">
                            <labe>
                                <input v-model="media_input" type="radio" name="media_id" :value="article.media_id">@{{article.content[0].title}}
                            </label>
                        </div>
                    </div>
                    <input type="hidden" name="media_content" v-model="media_content">
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
                <button type="submit" class="btn btn-info pull-right" style="line-height:unset;">{{trans('admin.edit')}}</button>
              </div>
              <!-- /.box-footer -->
            </form>
        </div>
        <div class="col-md-1"></div>
@endsection

@section('custom-javascript')
<script>

    var createQRcode = new Vue({
        el: '#createAutoReply',
        data:{
            type:'{{$auto_reply->message_type}}',
            media_content: '{{$auto_reply->media_content}}',
            media_input: '{{$auto_reply->media_id}}',
            match_type:'{{$auto_reply->match_type}}',
            showContent:true,
            showImage:false,
            showArticle:false,
            ROOT_PATH:ROOT_PATH,
            articleCurrentPage:1,
            imageCurrentPage:1,
            articleList:[],
            imageList:[],
            image_count:1,
            name: '{{$auto_reply->rule_name}}',
            key_words:'{{$auto_reply->key_words}}',
            colorName:'#222',
            colorKeywords:'#222',
            colorContent:'#222'
        }, 
        methods : {
            submit:function(){
                console.log(this.type);
            },
            getMaterialList:function(){
                if(this.type == 'text'){
                    this.showImage = false;
                    this.showContent = true;
                    this.showArticle = false;
                    this.media_input = ''
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
            updateMediaContent:function(){
                var that = this, update = false
                $.each(this.articleList, function(key, value){
                    if(value.media_id == that.media_input){
                        that.media_content = value.content[0].title
                        update = true
                    }
                })
                $.each(this.imageList, function(key, value){
                    if(value.media_id == that.media_input){
                        that.media_content = value.name
                        update = true
                    }
                })
                if(!update){
                    this.media_content = that.media_input
                    update = true
                }

            },
            checkForm:function(e){
                if(this.name && this.key_words && this.media_input){
                    return true;
                }
                this.errors = [];
                if(!this.name){
                    this.errors.push("Name required.")
                    this.colorName='#f00'
                    this.colorContent = this.media_input ? '#222' : '#f00'
                    this.colorKeywords = this.key_words ? '#222' : '#f00'
                }
                if(!this.key_words) {
                    this.errors.push("Key words required.")
                    this.colorKeywords='#f00'
                    this.colorContent = this.media_input ? '#222' : '#f00'
                    this.colorName = this.name ? '#222' : '#f00'
                }
                if(!this.media_input) {
                    this.errors.push("Content required.")
                    this.colorContent='#f00'
                    this.colorName = this.name ? '#222' : '#f00'
                    this.colorKeywords = this.key_words ? '#222' : '#f00'
                }
                e.preventDefault();
            },
            initMaterialList:function(){
                if(this.type == 'text'){
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
        },
        watch:{
            type:'getMaterialList',
            media_input:'updateMediaContent'
        },
        mounted:function(){
            console.log('{{$image_count}}');
            this.initMaterialList();
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
                    console.log(that.articleList)
                });
                return this.articleCurrentPage;

           }
        }
    });
</script>
@endsection
