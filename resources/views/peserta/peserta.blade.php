@extends('layouts.index')

@section('main')
<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Seminar</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Peserta</a></li>
            </ol>
        </div>
        <div class="row">
        <div class="col-sm-12">
            @if(Session::has('message'))
            <div class="alert alert-warning solid alert-dismissible fade show ">
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                <strong>Info!</strong> {{Session::get('message')}}
                <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                </button>
            </div>
            @endif
        </div>
        <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Data Peserta</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example5" class="table display table-responsive-lg">
                                <thead>
                                    <tr>
                                        <!-- <th style="text-align:center">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="checkAll" required="">
                                                <label class="custom-control-label" for="checkAll"></label>
                                            </div>
                                        </th> -->
                                        <th style="text-align:center">Kode Event</th>
                                        <th style="text-align:center">Pengundang</th>
                                        <th style="text-align:center">Nama</th>
                                        <th style="text-align:center">Phone</th>
                                        <th style="text-align:center">Tanggal Daftar</th>
                                        <th style="text-align:center">Harga</th>
                                        <th style="text-align:center">Status</th>
                                        @if(Auth::user()->role_id==1)
                                        <th style="text-align:center">Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($peserta as $p)
                                    <tr>
                                        <td style="text-align:center">{{$p->kode_event}} <br><small> {{$p->tgl_seminar}} </small></td>
                                        <td style="text-align:center">{{$p->pengundang->nama ?? ''}} <br> {{$p->pengundang->phone ?? ''}}</td>
                                        <td style="text-align:center">{{$p->nama}}</td>
                                        @if(Auth::user()->role_id==4)
                                        <td style="text-align:center"> ********{{substr($p->phone,-4)}} <br><small> xxxx{{substr(explode('@',$p->email)[0],-4)}}{{'@'.explode('@',$p->email)[1]}} </small></td>
                                        @elseif(Auth::user()->role_id==1 || Auth::user()->role_id==2 || Auth::user()->role_id==3)
                                        <td style="text-align:center">{{$p->phone}} <br> {{$p->email}}</td>
                                        @endif
                                        <!-- <td style="text-align:center"> {{$p->phone}} <br><small> {{$p->email}} </small></td> -->
                                        <td style="text-align:center">{{$p->created_at}}</td>
                                        <td style="text-align:center">Rp. {{number_format($p->total ?? 0,0)}}</td>
                                        <td style="text-align:center">
                                        @if($p->status==0)
                                            <span class="badge light badge-danger">Belum Lunas</span>
                                        @elseif($p->status==1)
                                                <span class="badge light badge-success align-center">Lunas</span>
                                            @if($p->type_bayar)             
                                                <br>                                   
                                                <i type="button" class="" data-container="body" data-toggle="popover" data-placement="top" data-content="{{$p->catatan}}" title="Catatan" style="font-size:8pt">{{$p->type_bayar}}</i>
                                            @endif
                                        @endif
                                        </td>
                                        @if(Auth::user()->role_id==1)
                                        <td style="text-align:center">
                                            @if($p->status==0)
                                            <button type="button" class="btn btn-success btn-xs btn-rounded" onclick="Approve({{$p->id}})"><em class="flaticon-381-edit"></em></button>                                            
                                            @endif
                                            <button type="button" class="btn btn-info btn-xs btn-rounded" onclick="ImportUser({{$p->id}},'{{$p->email}}')"><em class="flaticon-381-user-7"></em></button>
                                            <a class="btn btn-xs btn-danger btn-rounded" onclick="hapus()" href="{{ route('peserta.delete', $p->id) }}"><i class="fa fa-trash"></i></a>
                                        </td>						
                                        @endif						
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="basicModal">
    <div class="modal-dialog" role="document">
        <form action="{{url('peserta/approve/')}}" autocomplete="off" method="post">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-black" >Approve Peserta Manual</h5>
                    <input type="hidden" name="id" id="_id" value="" >
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body text-black">
                <div class="row">
                    <div class="col-sm-12">
                        <label for="">Total Bayar</label><br>
                        <input class="form-control" type="text" name="harga">
                    </div>
                    <div class="col-sm-12">
                        <label for="">Catatan</label><br>
                        <input class="form-control" type="text" name="catatan" placeholder="Alasan Approve Manual">
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Approve</button>
            </div>
        </div>
        </form>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="ModalImpUser">
    <div class="modal-dialog" role="document">
        <form action="{{url('peserta/importkeuser/')}}" autocomplete="off" method="post">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-black" >Import Data Ke User</h5>
                    <input type="hidden" name="id" id="import_id" value="" >
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body text-black">
                <div class="row">
                    <div class="col-sm-12">
                        <label for="">Email</label><br>
                        <input class="form-control" type="text" name="email" id="import_email" readonly>
                    </div>
                    <div class="col-sm-12">
                        <label for="">Password</label><br>
                        <input class="form-control" type="password" name="password" placeholder="Input Password" autocomplete="ogg">
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script>
    function Approve(_id) {
        $('#_id').val(_id);
        console.log(_id);
        $('#basicModal').modal('show');
    }

    function ImportUser(_id,_email) {
        $('#import_id').val(_id);
        $('#import_email').val(_email);
        $('#ModalImpUser').modal('show');
    }

  	function hapus() {
      if(!confirm("Are You Sure to delete this"))
      event.preventDefault();
  	}
 </script>
@endsection