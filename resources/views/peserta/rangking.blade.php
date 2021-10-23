@extends('layouts.index')

@section('main')
<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Seminar</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Rangking</a></li>
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
                        <h4 class="card-title">Data Pengundang tertinggi</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="" class="table display table-responsive-lg">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Kode Event</th>
                                        <th>Pengundang</th>
                                        <th>phone</th>
                                        <th>Payment</th>
                                        <th class="text-right">Undangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($peserta as $p)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$p->kode_event}} <br><small> {{$p->tgl_seminar}} </small></td>
                                        <td>{{$p->user->nama ?? $p->pengundang->nama ?? ''}}</td>
                                        <td>{{$p->ref}}</td>                                        
                                        <td>{{$p->pay ?? 0}}</td>
                                        <td class="text-right">{{$p->peserta ?? 0}}</td>                                       					
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