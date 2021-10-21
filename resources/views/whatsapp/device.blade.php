@extends('layouts.index')

@section('main')
<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
    <div class="container-fluid">
        <!-- row -->
        @if($device_id)
        <div class="row">    
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Device</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-3 col-lg-6  col-md-6 col-xxl-5 ">
                                <!-- Tab panes -->
                                <div class="tab-content" id="qr">
                                    QRCode
                                </div>
                            </div>
                            <div class="col-xl-9 col-lg-6  col-md-6 col-xxl-7 col-sm-12">
                                <div class="product-detail-content">
                                    <!--Product details-->
                                    <h4></h4>
                                    @foreach($device->where('id',$device_id) as $dev)
                                    <div class="new-arrival-content pr">
                                        <h4 class="m-b-15">Device Key &emsp;&emsp;&emsp;&emsp;&nbsp;: {{$dev->device_key}}</h4>
                                        <h4 class="m-b-15">Nomor Whatsapp&nbsp;   : {{$dev->phone}}</h4>
                                        <h4 class="m-b-15">Server &emsp;&emsp;&emsp;&emsp;&emsp;&emsp; : {{$dev->nama}}</h4>
                                        <!--Quanatity End-->
                                        <div class="shopping-cart mt-3">
                                            <a class="btn btn-success btn-sm btn-rounded" href="javascript:void(0)" onclick="start()"><i class="fa fa-play mr-2"></i>Start</a>
                                            <a class="btn btn-info btn-sm btn-rounded" href="#"><i class="fa fa-refresh mr-2"></i>Restart</a>
                                            <a class="btn btn-danger btn-sm btn-rounded" href="#"><i class="fa fa-sign-out mr-2"></i>Logout</a>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @else

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
                                        <a href="" class="btn btn-sm btn-success btn-rounded"><i class="fa fa-play">&nbsp;</i>Start/Stop</a>
                                        <a href="" class="btn btn-sm btn-danger btn-rounded"><i class="fa fa-sign-out">&nbsp;</i>Logout</a>
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

        @endif

       
    </div>
</div>
@endsection

@section('js')

<script>
    var device_id = 1;
    var scanmode    = true;
	function start() {
        $.ajax({
            "url" : "{{url('device/start')}}",
            "data" : {id:device_id},
            "success" : function (resp) {
                console.log(resp);
                if(resp.qrcode){
                    $("#qr").html('<img src="'+resp.qrcode+'" alt="" srcset="">');
                }
            }
        })
    }
    function loadQr() {            
        $.get('/whatsapp/scan?id=', function( data ) {                   
            console.log(data.qrcode);
            if(dataqr != data.qrcode){
                dataqr = data.qrcode;
                $("#qr").html('<img src="'+data.qrcode+'" alt="" srcset="">');
                $("img").addClass("img-responsive");
            }
        });
    }   
</script>

@endsection 