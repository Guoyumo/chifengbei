@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">{{trans('admin.qr_code_list')}}</h3>
              <a class="btn-sm btn-info" href="{{ url('admin/qRcodes/create') }}" role="button">{{trans('admin.create_qr_code')}}</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Name</th>
                  <th>Type</th>
                  <th>Created Time</th>
                  <th>Action</th>
                </tr>
                @foreach ($qrcodes as $index=>$qrcode)
                <tr>
                  <td>{{$qrcode->id}}.</td>
                  <td>{{$qrcode->name}}</td>
                  <td>{{$qrcode->type}}</td>
                  <td>{{$qrcode->created_at}}</td>
                  <td>
                    <a href="{{url('admin/qRcodes/'.$qrcode->id)}}">
                        <i class="fa fa-book fa-2x"></i>
                    </a>
                    <a href="{{url('admin/qRcodes/'.$qrcode->id.'/edit')}}">
                        <i class="fa fa-edit  fa-2x"></i>
                    </a>
                    <a href="{{url('admin/qRcodes/'.$qrcode->id.'/download')}}">
                        <i class="fa fa-cloud-download fa-2x"></i>
                    </a>

                    <form action="{{url('admin/qRcodes/'.$qrcode->id)}}" method="POST" style="display: inline-block;" onsubmit="return confirm('{{trans('common.are_you_sure')}}')">
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
              {{ $qrcodes->links() }}
            </div>
            
          </div>
          <!-- /.box -->
        </div>
    </div>
@endsection
