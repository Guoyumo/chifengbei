@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">{{trans('admin.auto_reply_list')}}</h3>
              <a class="btn-sm btn-info" href="{{ url('admin/autoReplys/create') }}" role="button">{{trans('admin.create_auto_reply')}}</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Name</th>
                  <th>Key Words</th>
                  <th>Match Type</th>
                  <th>Reply Content</th>
                  <th>Created Time</th>
                  <th>Action</th>
                </tr>
                @foreach ($auto_replys as $index=>$auto_reply)
                <tr>
                  <td>{{$auto_reply->id}}.</td>
                  <td>{{$auto_reply->rule_name}}</td>
                  <td>{{$auto_reply->key_words}}</td>
                  <td>{{$auto_reply->match_type}}</td>
                  <td>{{$auto_reply->media_content}}</td>
                  <td>{{$auto_reply->created_at}}</td>
                  <td>
                    <a href="{{url('admin/autoReplys/'.$auto_reply->id)}}">
                        <i class="fa fa-book fa-2x"></i>
                    </a>
                    <a href="{{url('admin/autoReplys/'.$auto_reply->id.'/edit')}}">
                        <i class="fa fa-edit  fa-2x"></i>
                    </a>

                    <form action="{{url('admin/autoReplys/'.$auto_reply->id)}}" method="POST" style="display: inline-block;" onsubmit="return confirm('{{trans('common.are_you_sure')}}')">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        <button type="submit" class="no-border no-padding no-bg-color element_a_style">
                            <i class="fa fa-remove fa-2x"></i>
                        </button>
                    </form>
                  </td>
                </tr>
                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
            <div class="col-md-12" style="text-align:center;">
              {{ $auto_replys->links() }}
            </div>
            
          </div>
          <!-- /.box -->
        </div>
    </div>
@endsection
