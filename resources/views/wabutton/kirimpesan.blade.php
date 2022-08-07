@extends('layouts.index')

@section('main')
<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
    <div class="container-fluid">
        <!-- row -->
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Whatsapp</a></li>
                <li class="breadcrumb-item active"><a href="{{ url('button') }}">Pesan Button</a></li>
            </ol>
        </div>
        <div class="row">    
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Data Pesan Button</h4>
                        <div class="form-group">
                            <a href="{{url('button/baru')}}" class="btn btn-xs btn-success btn-rounded m-1">Buat Pesan</a>    
                            <a class="btn btn-xs btn-rounded btn-danger m-1" data-toggle="modal" data-target="#ModalDelete">Delete</a>                     
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
                                        <th>Report</th>
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
                                        <td>{{$e->report}}/{{$e->messageid}}</td>
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
                                            <!-- <a href="{{url('event/resend/'.$e->id)}}" class="btn btn-sm btn-info btn-rounded"><i class="fa fa-pen"></i></a> -->
                                            <a href="javascript:void(0)" onclick="send({{$e->id}})" class="btn btn-sm btn-info btn-rounded"><i class="fa fa-paper-plane"></i></a>
                                            <a href="{{url('button/remove?id='.$e->id)}}" onclick="return confirm('Are you sure, you want to delete it?')" class="btn btn-sm btn-danger btn-rounded"><i class="fa fa-trash"></i></a>
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

<form action="{{url('/button/remove')}}" method="post">
<div class="modal fade" id="ModalDelete">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Pesan</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    @csrf
                    <div class="col-12">
                        <label for="">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="semua">semua pesan</option>
                            <option value="0">Preview</option>
                            <option value="1">Pending</option>
                            <option value="2">Terkirim</option>
                            <option value="3">Gagal</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>
</form>
@endsection

@section('js')
<script>    
	function send(id) {
        $.ajax({
            "url" : "{{url('button/send')}}",
            "data" : {id:id},
            "success" : function (resp) {
                console.log(resp);
            }
        })
    }
</script>
@endsection