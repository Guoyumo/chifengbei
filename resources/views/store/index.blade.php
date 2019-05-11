@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">商家列表</h3>
              <a class="btn-sm btn-info" href="{{ url('admin/stores/create') }}" role="button">新增商家</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>商户</th>
                  <th>电话</th>                
                  <th>操作</th>
                </tr>
                @foreach ($stores as $index=>$store)
                <tr>
                  <td>{{$index + 1}}.</td>
                  <td>{{$store->name}}</td>
                  <td>{{$store->phone}}</td> 
                  <td>
                    <a href="{{url('admin/stores/'.$store->id)}}">
                        编辑
                    </a>

                    <form action="{{url('admin/stores/'.$store->id)}}" method="POST" style="display: inline-block;")">
                      {{ csrf_field() }}
                      {{ method_field('DELETE') }}

                      <button type="submit" class="mdl-button mdl-js-button mdl-button--icon">
                          删除
                      </button>
                    </form>
                  </td>
                </tr>
                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
            <div class="col-md-12" style="text-align:center;">
              {{ $stores->links() }}
            </div>
            
          </div>
          <!-- /.box -->
        </div>
    </div>
@endsection
