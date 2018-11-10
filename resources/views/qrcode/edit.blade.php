@extends('layouts.admin')

@section('content')
    <div class="col-md-1"></div>
    <div class="box box-success col-md-10" id="createQRcode">
            <div class="box-header with-border">
              <h3 class="box-title">{{trans('admin.edit_qr_code')}}</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="{{url('admin/qRcodes/'.$qrcode->id)}}" method="post">
            {{ method_field('PUT') }}
            {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">{{trans('admin.qr_code_name')}}</label>
                    <div class="col-sm-10">
                        <input type="text" readonly="readonly" v-model="name" name="name" class="form-control" id="name" placeholder="{{$qrcode->name}}">
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
                        <textarea v-html="media_id" class="form-control" rows="3" id="reply_content" name="media_id"></textarea>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                            Add Link
                        </button>
                    </div>
                    <div class="radio" v-if="showImage" v-for="image in imageList" v-show="!(image.name == 'CropImage')">
                        <div class="col-sm-2" v-if="!(image.name == 'CropImage')"></div>
                        <div class="col-sm-10" v-if="!(image.name == 'CropImage')">
                        <label>
                            <input type="radio" v-model="media_id" name="media_id" :value="image.media_id">
                            @{{image.name}}
                        </label>
                        </div>
                    </div>
                    <div class="radio" v-if="showArticle" v-for="article in articleList">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10">
                            <labe>
                                <input type="radio" v-model="media_id" name="media_id" :value="article.media_id">@{{article.content[0].title}}
                            </label>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Add Link</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <label for="name"  class="col-sm-2 control-label">URL</label>
                                    <input class="link_url form-control"  v-model="linkUrl" placeholder="Please add the url here(http://www.example.com)"/>
                                    <label for="name"  class="col-sm-2 control-label">Text</label>
                                    <input class="link_text form-control" v-model="linkText"  placeholder="Please add the text here(Good morning!)"/>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button"  v-on:click="insertLink" class="btn btn-primary" data-dismiss="modal">Save</button>
                                </div>
                            </div>
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
        el: '#createQRcode',
        data:{
            name:'{{$qrcode->name}}',
            type:'{{$qrcode->type}}',
            media_id:'{{$qrcode->media_id}}',
            showContent:true,
            showImage:false,
            showArticle:false,
            ROOT_PATH:ROOT_PATH,
            articleCurrentPage:1,
            imageCurrentPage:1,
            articleList:[],
            imageList:[],
            image_count:1,
            linkUrl:'',
            linkText:'',
            showAddLinkButton: false
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
                    this.media_id = ''
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
                console.log(this.media_id)
            },
            initMaterialList:function(){
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
            insertLink: function() {
                if(!this.linkUrl){
                    return
                }
                let insertContent = "<a href='" + this.linkUrl + "'>" + this.linkText + "</a>"
                this.media_id = this.media_id + insertContent
            },
        },
        watch:{
            type:'getMaterialList'
        },
        mounted:function(){
            console.log('{{$image_count}}');
            this.initMaterialList()
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
