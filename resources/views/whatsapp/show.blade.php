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
                                                <td> <span id="_phone"> {{$device->phone}}</span> </td>
                                            </tr>
                                            <tr>
                                                <td class="m-b-15">Nama Whatsapp</td>
                                                <td>:</td>
                                                <td> <span id="_nama"> {{$device->nama}}</span> </td>
                                            </tr>
                                            <tr>
                                                <td colspan=3> <a href="{{url('device/get-group')}}/?id={{$device->id}}" target="grp" class="btn btn-sm btn-warning"> List Groups </a></td>
                                            </tr>
                                        </table>
                                        <div class="shopping-cart mt-3">
                                            <a class="btn btn-success btn-xs btn-rounded m-1" href="javascript:void(0)" onclick="start()" id="_start"><i class="fa fa-play mr-2"></i>Start</a>
                                            <a class="btn btn-info btn-xs btn-rounded m-1" href="javascript:void(0)" onclick="reset()"><i class="fa fa-refresh mr-2"></i>Restart</a>
                                            <a class="btn btn-danger btn-xs btn-rounded " href="javascript:void(0)" onclick="logout()"><i class="fa fa-sign-out mr-2"></i>Logout</a>
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
    // var id = '{{$device->id}}';
    // var scanmode    = true;
	// function start() {
    //     $.ajax({
    //         "url" : "{{url('device/start')}}",
    //         "data" : {id:id},
    //         "success" : function (resp) {
    //             // console.log(resp);
    //             resp = JSON.parse(resp);
    //             if(resp.qrcode){
    //                 let qr = '<img src="'+resp.qrcode+'" alt="" srcset="">';                    
    //                 $("#qr").html(qr);                                        
    //             }
    //         }
    //     })
    // }

    // function reset() {
    //     $.ajax({
    //         "url" : "{{url('reset')}}/"+id,
    //         "data" : {},
    //         "success" : function (resp) {
    //             console.log(resp);
    //             loadQr();
    //         }
    //     })
    // }
    
    // function logout() {
    //     $.ajax({
    //         "url" : "{{url('logout')}}/"+id,
    //         "data" : {},
    //         "success" : function (resp) {
    //             console.log(resp);
    //             location.reload();
    //         }
    //     })
    // }

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
    //                     $("#_phone").html(resp.data.id);
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
            url:"{{url('device/scanqr')}}",
            data: {id:'{{ $device->id }}'},
            success:function(json){
                let scan = JSON.parse(json)
                console.log(scan);
                if(scan.qrcode){
                    $('#qrcode').attr('src',scan.qrcode);
                }else{
                    $('#qrcode').attr('src',scan.pic);
                    $("#_nama").html(scan.data.name);
                    $("#_phone").html(scan.data.id);
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