@extends('layouts.index')

@section('main')
<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
    <div class="container-fluid">
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
                                <div class="tab-content" style="text-align:center">                                
                                    <img src="" id="qrcode" alt="" srcset="" style="width: 300px">
                                </div><br>
                            </div>
                            <div class="col-xl-9 col-lg-6  col-md-6 col-xxl-7 col-sm-12">
                                <div class="product-detail-content">
                                    <!--Product details-->
                                    <h4></h4>
                                    
                                    <div class="new-arrival-content pr">
                                        <table class="table">
                                            <tr>
                                                <td class="m-b-15">Device</td>
                                                <td>:</td>
                                                <td> <span id="_device"> {{$device->id}} / {{$device->mode=='md' ? 'Multidevice' : 'Standart'}}</span> </td>
                                            </tr>
                                            <tr>
                                                <td class="m-b-15">Nomor Whatsapp</td>
                                                <td>:</td>
                                                <td> <span id="_phone"> {{$device->phone ?? ''}}</span> </td>
                                            </tr>
                                            <tr>
                                                <td class="m-b-15">Nama Whatsapp</td>
                                                <td>:</td>
                                                <td> <span id="_nama"> {{$device->name ?? ''}}</span> </td>
                                            </tr>
                                            <tr>
                                                <td colspan=3> </td>
                                            </tr>
                                        </table>
                                        <div class="shopping-cart mt-3">
                                            <a class="btn btn-success btn-xs btn-rounded m-1" href="{{ url('device/send/'.$device->id) }}" id="_start"><i class="fa fa-play mr-2"></i>Tes Kirim</a>
                                            <a class="btn btn-info btn-xs btn-rounded m-1" href="javascript:void(0)" onclick="restart()"><i class="fa fa-refresh mr-2"></i>Restart</a>
                                            <a class="btn btn-danger btn-xs btn-rounded m-1 " href="javascript:void(0)" onclick="logout()"><i class="fa fa-sign-out mr-2"></i>Logout</a>
                                            <a class="btn btn-xs btn-success btn-rounded" href="{{url('device/get-group')}}?id={{$device->id}}">
                                            <i class="fa fa-file-excel-o mr-2"></i>Export Group </a>
                                            {{-- <a class="btn btn-xs btn-warning btn-rounded mt-2 mr-2 {{ $device->status=='AUTHENTICATED' ? 'disabled' : '' }}" style="color: white" href="{{url('device/updateMode/'.$device->id)}}"><i class="fa fa-exchange-alt mr-2"></i> {{$device->mode=='md' ? 'Multidevice' : 'Standart'}} (Ganti Mode)</a> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
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
    var id          = '{{$device->id}}';
    var scanmode    = true;
	function start() {
        $.ajax({
            "url" : "{{url('device/start')}}",
            "data" : {id:id},
            "success" : function (resp) {
                resp = JSON.parse(resp);
                if(resp.qrcode){
                    let qr = '<img src="'+resp.qrcode+'" alt="" srcset="">';                    
                    $("#qr").html(qr);                                        
                }
            }
        })
    }

    function restart() {
        $.ajax({
            "url" : "{{url('device/start')}}/"+id,
            "data" : {},
            "success" : function (resp) {
                location.reload();
                getQrcode();
            }
        })
    }
    
    function logout() {
        $.ajax({
            "url" : "{{url('logout')}}/"+id,
            "data" : {},
            "success" : function (resp) {
                location.reload();
                console.log(resp);
            }
        })
    }

    // function loadQr() {            
    //     $.ajax({
    //         "url" : "{{url('device/scanqr')}}",
    //         "data" : {id:id},
    //         "success" : function (resp) {
    //             console.log(resp);
    //             resp = JSON.parse(resp);
    //             if(resp.qrcode){
    //                 let qr = '<img src="'+resp.qrcode+'">';                    
    //                 // console.log(qr);
    //                 $("#qr").html(qr);
    //                 setTimeout(() => {
    //                     loadQr();
    //                 }, 5000);
    //             }else{                    
    //                 if(resp.status=='AUTHENTICATED'){
    //                     $("#_nama").html(resp.data.name);
    //                     var phone = resp.data.id;
    //                     var split = phone.split(':');
    //                     var phone = split[0];
    //                     $("#_phone").html(phone);
    //                     $('#_start').html('<i class="fa fa-whatsapp mr-2"></i>AUTHENTICATED');
    //                     if(resp.profile_url){
    //                         console.log(resp.profile_url); 
    //                         $("#qr").html('<img src="'+resp.profile_url+'" style="width: 150px;border: 1px solid #ddd; border-radius: 4px;padding: 5px;">');
    //                     }
    //                 }
    //             }
    //         }
    //     })
    // }   
    // loadQr(); 

    function getQrcode() {
        $.ajax({
            url:"{{url('device/scanqr')}}/"+id,
            // data: {id:'{{ $device->id }}'},
            success:function(json){
                let scan = JSON.parse(json)
                console.log(scan);  
                if(scan.qrcode){
                    if(scan.qrcode == 'NOT AUTHENTICATED'){
                        var img = scan.pic || 'https://c.tenor.com/28DFFVtvNqYAAAAC/loading.gif'
                    }else{
                        var img = scan.qrcode || scan.pic || 'https://c.tenor.com/28DFFVtvNqYAAAAC/loading.gif'
                    }
                    $('#qrcode').attr('src',img);
                }else{
                    $("#_phone").html(scan?.phone ?? '');
                    $("#_nama").html(scan?.name ?? '');
                    $('#qrcode').attr('src',scan?.pic ?? 'https://c.tenor.com/28DFFVtvNqYAAAAC/loading.gif');

                    // var phone = scan.data.id;
                    // var split = phone.split(':');
                    // var phone = split[0];
                    
                }
            }
        });
    }
    getQrcode();
    setInterval(() => {
        getQrcode();
    }, 5000);

</script>

@endsection 