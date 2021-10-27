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
                        <h4 class="card-title">Device</h4>
                        <div class="form-group">
                            @if(Auth::user()->role_id==1)
                            <a href="" data-toggle="modal" data-target="#devicebaru" class="btn btn-xs btn-info btn-rounded m-1">Device Baru</a>
                                @if(\Request()->all)
                                    <a href="{{url('/device/device')}}" class="btn btn-xs btn-info btn-rounded m-1">Hide Lainnya</a>
                                @else
                                    <a href="{{url('/device/device?all=Y')}}" class="btn btn-xs btn-info btn-rounded m-1">Tampilkan Semua</a>
                                @endif
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                    <!-- Table -->
                    <div class="table-responsive">
                        <table id="example5" class="display table-responsive-lg">
                            <thead>
                                <tr>
                                    <th style="text-align:center">No</th>
                                    <th style="text-align:center">Device</th>
                                    <th style="text-align:center">User</th>
                                    <th style="text-align:center">Nomor</th>
                                    <th style="text-align:center">Server</th>
                                    <th style="text-align:center">Pesan</th>
                                    <th style="text-align:center">Status</th>
                                    <th style="text-align:center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($device as $de)
                                <tr>
                                    <td style="text-align:center">{{$loop->iteration}}</td>
                                    <td style="text-align:center">{{$de->id}}/{{$de->device_key}}</td>
                                    <td style="text-align:center">{{$de->user->nama}}</td>
                                    <td style="text-align:center">{{$de->phone}}</td>
                                    <td style="text-align:center;">{{$de->nama}}</td>
                                    <td style="text-align:center;">{{$de->antrian->where('status',1)->count()}}/{{$de->antrian->count()}}</td>
                                    <td style="text-align:center;">
                                    @if($de->status=='AUTHENTICATED')
                                        <span class="text-success">{{$de->status}}</span>
                                    @elseif($de->status=='NOT AUTHENTICATED')
                                        <span class="text-danger">{{$de->status}}</span>
                                    @endif
                                    </td>

                                    <td style="text-align:center">
                                        <div class="dropdown ml-auto text-center">
                                            <div class="btn-link" data-toggle="dropdown">
                                                <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg>
                                            </div>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="javascript:void(0)" onclick="send({{$de->id}})" class="dropdown-item "><i class="fa fa-paper-plane" aria-hidden="true">&nbsp;</i> Test</a>
                                                <a href="{{url('device/show?id='.$de->id)}}" class="dropdown-item "><i class="fa fa-list">&nbsp;</i> View</a>
                                                <a href="{{url('device/export?id='.$de->id)}}" class="dropdown-item "><i class="fa fa-address-book">&nbsp;</i> Kontak</a>
                                                @if(Auth::user()->role_id==1)
                                                <a href="{{url('device/delete?id='.$de->id)}}" class="dropdown-item "><i class="fa fa-trash">&nbsp;</i> Delete</a>
                                                @endif
                                            </div>
                                        </div>

                                    </td>
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
<div class="modal fade" id="devicebaru">
    <div class="modal-dialog" role="document">
        <form action="{{url('/device/save')}}" method="post">
        @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Device Baru</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label for="" style="color:black">User</label>
                    <select name="user" id="" class="form-control">
                        <option value="">--</option>
                        @foreach($user as $ur)
                        <option value="{{$ur->id}}">{{$ur->nama}} - {{$ur->email}}</option>
                        @endforeach
                    </select>
                    <label for="" style="color:black">Brand</label>
                    <select name="brand" id="" class="form-control">
                        <option value="">--</option>
                        @foreach($brand as $br)
                        <option value="{{$br->brand}}">{{$br->brand}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light btn-rounded" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success btn-rounded">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')

<script>
	function send(id) {
        $.ajax({
            "url" : "{{url('send')}}/"+id,
            "data" : {phone:'{{Auth::user()->phone}}'},
            "success" : function (resp) {
                console.log(resp);
            }
        })
    }
</script>

@endsection
