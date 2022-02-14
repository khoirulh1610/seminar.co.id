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
                            <table id="" class="table display table-responsive-lg table-export">
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
                                        <th style="text-align:center">Sapaan</th>
                                        <th style="text-align:center">Nama</th>
                                        <th style="text-align:center">Panggilan</th>
                                        <th style="text-align:center">Phone</th>
                                        <th style="text-align:center">Kota</th>
                                        <th style="text-align:center">EMail</th>
                                        <th style="text-align:center">Tanggal Daftar</th>
                                        @if(Auth::user()->role_id==1 || Auth::user()->role_id==1 || Auth::user()->role_id==3)                                        
                                        <th style="text-align:center">Status</th>
                                        @endif
                                        @if(Auth::user()->role_id==1)                                            
                                            <th style="text-align:center">Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($peserta as $p)
                                    <tr>
                                        <td style="text-align:center">{{$p->kode_event}} <br><small> {{$p->tgl_seminar}} </small></td>
                                        <td style="text-align:center">{{$p->pengundang->nama ?? $p->user->nama ?? ''}} <br> {{$p->pengundang->phone ?? $p->user->phone ?? ''}}</td>
                                        <td style="text-align:center">{{$p->sapaan}}</td>
                                        <td style="text-align:center">{{$p->nama}}</td>
                                        <td style="text-align:center">{{$p->panggilan}}</td>
                                        @if(Auth::user()->role_id==4)
                                        <td style="text-align:center"> ********{{substr($p->phone,-4)}} <br><small> xxxx{{substr(explode('@',$p->email)[0],-4)}}{{'@'.explode('@',$p->email)[1]}} </small></td>
                                        @elseif(Auth::user()->role_id==1 || Auth::user()->role_id==2 || Auth::user()->role_id==3)
                                        <td style="text-align:center">{{$p->phone}}</td>
                                        @endif
                                        <td style="text-align:center">{{$p->kota}}</td>
                                        <td style="text-align:center"> {{$p->email}} </small></td>
                                        <td style="text-align:center">{{$p->created_at}}</td>
                                    @if(Auth::user()->role_id==1 || Auth::user()->role_id==2 || Auth::user()->role_id==3)    
                                        <td style="text-align:center">
                                            @if($p->total==0)
                                            GRATIS
                                            @else
                                                Rp. {{number_format($p->total ?? 0,0)}} <br>
                                                @if($p->status==0)
                                                    <span class="badge light badge-danger">Belum Lunas</span>
                                                @elseif($p->status==1)
                                                        <span class="badge light badge-success align-center">Lunas</span>
                                                    @if($p->type_bayar)             
                                                        <br>                                   
                                                        <i type="button" class="" data-container="body" data-toggle="popover" data-placement="top" data-content="{{$p->catatan}}" title="Catatan" style="font-size:8pt">{{$p->type_bayar}}</i>
                                                    @endif
                                                @endif
                                            @endif
                                        </td>
                                    @endif
                                        @if(Auth::user()->role_id==1)
                                        <td style="text-align:center">
                                            <a href="{{ url('peserta/resend-notif/'.$p->id) }}" class="btn btn-success btn-xs btn-rounded"> <i class="flaticon-381-share-2"></i> </a>                                            
                                            <button type="button" class="btn btn-success btn-xs btn-rounded" onclick="Edit({{$p->id}},'{{$p->nama}}','{{$p->sapaan}}','{{$p->email}}','{{$p->phone}}','{{$p->panggilan}}')"><em class="flaticon-381-edit"></em></button>                                            
                                            @if($p->status==0)
                                            <button type="button" class="btn btn-success btn-xs btn-rounded" onclick="Approve({{$p->id}})"><em class="flaticon-381-success"></em></button>                                            
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

                    <div class="col-sm-12">
                        <label for="">Level</label><br>
                        <select name="role_id" id="role_id" class="form-control">
                            <?php 
                            $role = App\Models\Role::orderBy('id','desc')->get();
                            foreach ($role as $r) {
                                echo '<option value="'.$r->id.'">'.$r->name.'</option>';
                            }
                            ?>
                        </select>
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

<!-- Modal -->
<div class="modal fade" id="EditModal">
    <div class="modal-dialog" role="document">
        <form action="{{url('peserta/save')}}" autocomplete="off" method="post">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-black" >Edit Peserta</h5>
                    <input type="hidden" name="id" id="_id" value="" >
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body text-black">
                <div class="row">
                    <div class="col-sm-12">
                        <label for="">Sapaan</label><br>
                        <input class="form-control" type="text" name="sapaan" id="_sapaan">
                    </div>
                    <div class="col-sm-12">
                        <label for="">Panggilan</label><br>
                        <input class="form-control" type="text" name="panggilan" id="_panggilan">
                    </div>
                    <div class="col-sm-12">
                        <label for="">Nama</label><br>
                        <input class="form-control" type="hidden" name="id" id="edit_id">
                        <input class="form-control" type="text" name="nama" id="_nama">
                    </div>
                    
                    <div class="col-sm-12">
                        <label for="">Email</label><br>
                        <input class="form-control" type="text" name="email" id="_email">
                    </div>
                    <div class="col-sm-12">
                        <label for="">Phone</label><br>
                        <input class="form-control" type="text" name="phone" id="_phone">
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

    function Edit(_id,nama,sapaan,email,phone,panggilan) {
        $('#edit_id').val(_id);
        $('#_nama').val(nama);
        $('#_sapaan').val(sapaan);
        $('#_email').val(email);
        $('#_phone').val(phone);
        $('#_panggilan').val(panggilan);
        console.log(_id);
        $('#EditModal').modal('show');
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