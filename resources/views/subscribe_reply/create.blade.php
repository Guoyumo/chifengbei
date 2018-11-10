@extends('layouts.admin')

@section('content')
    <div class="col-md-1"></div>
    <div class="box box-success col-md-10" id="createSubscribeReply">
            <div class="box-header with-border">
              <h3 class="box-title">{{trans('admin.create_subscribe_reply')}}</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="{{url('admin/subscribeReplys')}}" method="post" @submit="checkForm">
            {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                    <label for="name" :style="{color:colorName}" class="col-sm-2 control-label">{{trans('admin.subscribe_reply_name')}} *</label>
                    <div class="col-sm-10">
                        <input type="text"  v-model="name" name="name" class="form-control" id="name" placeholder="{{trans('admin.subscribe_reply_name')}}">
                    </div>
                </div>

                <div class="form-group " style="max-height: 500px; overflow-y: scroll;">
                    <label for="auto_reply_content_type" :style="{color:colorContent}" class="col-sm-2 control-label">{{trans('admin.subscribe_reply_content')}} *</label>
                    <div class="col-sm-10">
                        <textarea v-model="content" class="form-control" rows="3" id="content" name="content" placeholder="{{trans('admin.subscribe_reply_content')}}"></textarea>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                            Add Link
                        </button>
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
        el: '#createSubscribeReply',
        data:{
            name: '',
            content: '',
            colorName:'#222',
            colorContent:'#222',
            linkUrl:'',
            linkText:'',
            showAddLinkButton: false
        }, 
        methods : {
            submit: function () {
                console.log(this.type);
            },
            checkForm:function(e){
                if(this.name && this.content){
                    return true;
                }
                this.errors = [];
                if(!this.name){
                    this.errors.push("Name required.")
                    this.colorName='#f00'
                    this.colorContent = this.content ? '#222' : '#f00'
                }
                if(!this.content){
                    this.errors.push("Content required.")
                    this.colorContent='#f00'
                    this.colorName = this.name ? '#222' : '#f00'
                }
                e.preventDefault();
            },
            insertLink: function() {
                if(!this.linkUrl){
                    return
                }
                let insertContent = "<a href='" + this.linkUrl + "'>" + this.linkText + "</a>"
                this.content = this.content + insertContent
            },
        },
        watch:{

        },
        mounted:function(){

        },
        computed:{
        }
    });
</script>
@endsection
