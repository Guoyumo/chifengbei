@extends('layouts.admin')

@section('content')
    <div class="col-md-1"></div>
    <div class="box box-success col-md-10" id="createQRcode">
            <div class="box-header with-border">
              <h3 class="box-title">编辑二维码</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="{{url('admin/qRcodes/'.$qrcode->id)}}" method="post">
            {{ method_field('PUT') }}
            {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">二维码名称</label>
                    <div class="col-sm-10">
                        <input type="text" v-model="name" name="name" class="form-control" id="name" placeholder="{{$qrcode->name}}">
                    </div>
                </div>
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
