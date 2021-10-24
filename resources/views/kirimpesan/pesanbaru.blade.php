@extends('layouts.index')

@section('main')
<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Whatsapp</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Kirim Pesan</a></li>
            </ol>
        </div>
        <div class="row">
          
        <form action="{{url('/kirimpesan/save')}}" method="post" enctype="multipart/form-data">
        <div class="col-12" >
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Buat Pesan Baru</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                @csrf
                                <label for="">Server Whatsapp</label>
                                <select name="device_id" id="device_id" class="form-control" required>
                                    @foreach($devices as $d)
                                        <option value="{{$d->id}}">{{$d->id.' | '.($d->phone ?? '-').' | '.($d->status ?? 'Offline')}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-6" >
                                <label for="">Target</label>
                                <select name="target" id="target" class="form-control" style="color:black">
                                    <option value="Upload">Upload From Excel</option>        
                                    <option value="manual">Input Manual</option>                                        
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-6 d-none" id="div_data_target">
                                <label for="">Masukkan No WHatsapp</label>
                                <input type="text" name="data_target" class="form-control" placeholder="085123456,08123456,089123456">
                            </div>
                            <div class="col-sm-12 col-md-6 d-none" id="div_upload">
                                <label for="">File</label> [<small class="text-danger"> <a href="{{url('template_kirim_seminar.xlsx')}}">Download Template Disini</a> </small>]
                                <input type="file" name="file" class="form-control" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <label for="">Message</label> 
                                <Textarea class="form-control" name="message" rows="5" style="color:black"></Textarea>
                                <!-- <code> <button class="btn btn-xs btn-info">[#template]</button> </code> -->
                            </div>
                            <div class="col-sm-12 col-md-12">                                
                                <label for="">Fitur tambahan</label>
                                <select name="addf" id="addf" class="form-control">.
                                        <option value="text">--</option>
                                        <option value="image">Lampiran Image</option>
                                        <option value="link" disabled>Button Link</option>
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-12 d-none" id="msg_img">
                                <label for="">Image (Optional)</label> 
                                <input type="file" name="lampiran" class="form-control" accept="image/*">
                            </div>
                            <div class="col-sm-12 col-md-12 d-none" id="msg_link">
                                <label for="" class="text-red">Link (Optional)</label> 
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="">Link 1</label>
                                        <input type="text" class="form-control" placeholder="https://facebook.com">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="">Title 1</label>
                                        <input type="text" class="form-control" placeholder="facebook">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="">Link 2</label>
                                        <input type="text" class="form-control" placeholder="https://facebook.com">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="">Title 2</label>
                                        <input type="text" class="form-control" placeholder="facebook">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="">Link 3</label>
                                        <input type="text" class="form-control" placeholder="https://facebook.com">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="">Title 3</label>
                                        <input type="text" class="form-control" placeholder="facebook">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-12">
                                <label for="" class="text-red">Interval</label> 
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="">Min</label>
                                        <input type="number" name="min" value="5" class="form-control">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="">Max</label>
                                        <input type="number" name="max" value="20" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <label for="">Petunjuk</label> 
                                <ul>Gunakan [nama_paramater] untuk memanggil parameter sesuai judul file Excel</ul>
                            </div>
                            <div class="col-sm-12 col-md-12 p-1">
                                
                                <button class="btn btn-warning">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>


@endsection

@section('js')
<script>
    switch_target("Upload");
    switch_fet("");
    $('#target').on('change', function(evt, data) {
        switch_target(this.value);
    });
    $('#addf').on('change', function(evt, data) {
        switch_fet(this.value);
    });

    function switch_target(val) {
        if(val=="manual"){
            $('#div_data_target').removeClass("d-none").show();
            $('#div_upload').hide();
        }else{
            $('#div_data_target').hide()
            $('#div_upload').removeClass("d-none").show();
        }
    }

    function switch_fet(val) {
        if(val==""){
            $('#msg_img').hide();
            $('#msg_link').hide();
        }else if(val=="image"){
            $('#msg_link').hide();
            $('#msg_img').removeClass("d-none").show();
        }else{
            $('#msg_link').removeClass("d-none").show();
            $('#msg_img').hide();
        }
    }
</script>
@endsection