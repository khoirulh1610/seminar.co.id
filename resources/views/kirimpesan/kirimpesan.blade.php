@extends('layouts.index')

@section('main')
<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
    <div class="container-fluid">
        <!-- row -->
        <div class="row">    
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Data Kirim Pesan</h4>
                        <div class="form-group">
                            <a href="{{url('kirimpesan/baru')}}" class="btn btn-xs btn-success btn-rounded m-1">Buat Pesan</a>    
                            <a class="btn btn-xs btn-rounded btn-danger m-1">Delete</a>                     
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">                            
                            <table id="example1" class="table table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Phone</th>                                        
                                        <th>Pesan</th>
                                        <th>Tgl Dibuat</th>
                                        <th>status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($kirimpesan as $e)
                                    <tr>
                                        <td >{{$loop->iteration}}</td>
                                        <td >{{$e->phone}}</td>                                        
                                        <td> 
                                            <a class="btn btn-xs btn-default" data-toggle="collapse" href="#col_{{$e->id}}" role="button" aria-expanded="false" aria-controls="collapseExample">Show Message</a>
                                            <div class="collapse" id="col_{{$e->id}}">
                                                <div class="card card-body">
                                                    {!!nl2br($e->message)!!}
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{$e->created_at}}</td>
                                        <td>
                                            @if($e->status==0)
                                            <a href="javascript:void()" class="badge badge-rounded badge-warning">Preview</a> 
                                            @elseif($e->status==1)
                                            <a href="javascript:void()" class="badge badge-rounded badge-info">Pending</a> 
                                            @elseif($e->status==2)
                                            <a href="javascript:void()" class="badge badge-rounded badge-success">Terkirim</a> 
                                            @else
                                            <a href="javascript:void()" class="badge badge-rounded badge-danger">Gagal</a> 
                                            @endif
                                        </td>
                                        <td >
                                            <a href="{{url('event/resend/'.$e->id)}}" class="btn btn-sm btn-info btn-rounded"><i class="fa fa-pen"></i></a>
                                            <a href="{{url('event/hapus/'.$e->id)}}" class="btn btn-sm btn-danger btn-rounded"><i class="fa fa-trash"></i></a>
                                        </td>									
                                    </tr>
                                    @endforeach		
                                </tbody>                                
                            </table>
                        </div>
                        <div class="col-sm-12">
                            {{ $kirimpesan->render("pagination::bootstrap-4") }}
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
@endsection

@section('js')

@endsection