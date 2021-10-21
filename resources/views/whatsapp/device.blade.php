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