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
                            <a href="" data-toggle="modal" data-target="#devicebaru" class="btn btn-info btn-rounded">Device Baru</a>
                        </div>
                    </div>
                    <div class="card-body">
                    <!-- Table -->
                    <div class="table-responsive">
                        <table id="example5" class="display table-responsive-lg">
                            <thead>
                                <tr>
                                    <th style="text-align:center">No</th>
                                    <th style="text-align:center">Device Key</th>
                                    <th style="text-align:center">Nomor Whatsapp</th>
                                    <th style="text-align:center">Server</th>
                                    <th style="text-align:center">Status</th>
                                    <th style="text-align:center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($device as $de)
                                <tr>
                                    <td style="text-align:center">{{$loop->iteration}}</td>
                                    <td style="text-align:center">{{$de->device_key}}</td>
                                    <td style="text-align:center">{{$de->phone}}</td>
                                    <td style="text-align:center;">{{$de->nama}}</td>
                                    <td style="text-align:center;">
                                    @if($de->status=='AUTHENTICATED')
                                        <span class="text-success">{{$de->status}}</span>
                                    @elseif($de->status=='NOT AUTHENTICATED')
                                        <span class="text-danger">{{$de->status}}</span>
                                    @endif
                                    </td>

                                    <td style="text-align:center">
                                        <a href="javascript:void(0)" onclick="send({{$de->id}})" class="btn btn-sm btn-warning btn-rounded"><i class="fa fa-paper-plane" aria-hidden="true"></i> Test</a>
                                        <a href="{{url('device/show?id='.$de->id)}}" class="btn btn-sm btn-success btn-rounded"><i class="fa fa-list">&nbsp;</i>view</a>                                       
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
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Device Baru</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for=""></label>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger light" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success btn-rounded">Save</button>
            </div>
        </div>
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