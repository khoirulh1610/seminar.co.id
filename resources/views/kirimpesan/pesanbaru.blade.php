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
                        <button type="submit" class="btn btn-rounded btn-sm btn-warning" style="color: white">Submit</button>
                    </div>
                    <div class="card-body">
                        <div class="row" style="color: black">
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
                                <label for="">Metode Input Nomor</label>
                                <select name="target" id="target" class="form-control" style="color:black">
                                    <option value="Upload">Upload From Excel</option>        
                                    <option value="Manual">Input Manual</option>                                        
                                    <option value="Seminar">Data Seminar</option>        
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-6 d-none mt-3" id="div_data_target">
                                <label for="">Masukkan No Whatsapp</label>
                                <input type="text" name="data_target" class="form-control" placeholder="085123456,08123456,089123456">
                            </div>
                            <div class="col-sm-12 col-md-6 d-none mt-3" id="div_upload">
                                <label for="">Data Upload File</label> [<small class="text-danger"> <a href="{{url('template_kirim_seminar.xlsx')}}">Download Template Disini</a> </small>]
                                <input type="file" name="file" class="form-control" addf>    
                            </div>

                            @if (Auth::user()->role_id == '1')
                            <div class="col-12 d-none mt-3" id="div_data_seminar">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">Seminar</label>
                                        <select name="kode_event" class="form-control" id="">
                                            @foreach ($event as $item)
                                                <option value="{{ $item->kode_event }}">{{ $item->event_title }} || {{ date('Y-m-d', strtotime($item->tgl_event)) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Target Kirim</label>
                                        <select name="target_kirim" class="form-control" id="">
                                            <option value="Semua Peserta">Semua Peserta</option>
                                            <option value="Sudah Absen">Sudah Absen</option>
                                            <option value="Belum Absen">Belum Absen</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="col-lg-12 mt-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label for="message">Message 1</label>
                                    <div>
                                        <input type="file" class="form-control" name="lampiran1" accept="image/jpeg, image/png"
                                            data-file-max-size="200">
                                    </div>
                                </div>
                                <textarea name="message1" id="message1" rows="3" class="form-control" style="overflow-y:scroll;"
                                    autocomplete="off">{{ old('message1') ?? ($log->message1 ?? '') }}</textarea>
                            </div>
                            <div class="col-lg-12 mt-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label for="message">Message 2</label>
                                    <div>
                                        <input type="file" class="form-control" name="lampiran2" accept="image/jpeg, image/png"
                                            data-file-max-size="200">
                                    </div>
                                </div>
                                <textarea name="message2" id="message2" rows="3" class="form-control" style="overflow-y:scroll;"
                                    autocomplete="off">{{ old('message2') ?? ($log->message2 ?? '') }}</textarea>
                            </div>

                            <div class="col-sm-12 col-md-12 mt-3">
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
                            <div class="col-sm-12 col-md-12 mt-3">
                                <label for="">Petunjuk</label> 
                                <ul>Gunakan [nama_paramater] untuk memanggil parameter sesuai judul file Excel</ul>
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
        if(val=="Manual"){
            $('#div_data_target').removeClass("d-none").show();
            $('#div_upload').hide();
            $('#div_data_seminar').hide();
        }else if(val=="Upload"){
            $('#div_data_target').hide()
            $('#div_upload').removeClass("d-none").show();
            $('#div_data_seminar').hide()
        }else if(val=="Seminar"){
            $('#div_data_target').hide()
            $('#div_upload').hide()
            $('#div_data_seminar').removeClass("d-none").show()
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
