@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">{{trans('admin.auto_reply_detail')}}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tr>
                  <td>{{$auto_reply->rule_name}}</td>
                </tr>
                  <tr>
                      <td>{{$auto_reply->key_words}}</td>
                  </tr>
                <tr>
                    <td>{{$auto_reply->match_type}}</td>
                </tr>
                <tr>
                    <td>{{$auto_reply->created_at}}</td>
                </tr>
                <tr>
                    <td>
                        {{$auto_reply->message_type == 'text' ? $auto_reply->media_id : $auto_reply->media_content}}
                    </td>
                </tr>
              </table>
              <button type="button" class="btn btn-default btn-block"><a href="{{url('admin/autoReplys/'.$auto_reply->id.'/edit')}}">Edit</a></button>
            </div>
          </div>
          <!-- /.box -->
        </div>
        <div class="col-md-1"></div>
    </div>
@endsection
