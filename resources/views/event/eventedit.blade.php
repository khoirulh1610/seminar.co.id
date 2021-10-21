@extends('layouts.index')

@section('main')
<div class="content-body">
    <div class="container-fluid">
        <div class="col-xl-12 col-lg-12">
            <form action="{{url('event/save')}}" method="post" autocomplete="off" enctype="multipart/form-data">
                        @csrf
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Data Event</h4>
                    <div class="form-group">
                        <a href="{{url('/event')}}" class="btn btn-danger btn-rounded float-right m-1">Cancel</a>&emsp;
                        <button type="submit" class="btn btn-success btn-rounded float-right m-1">Simpan</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                    <input type="hidden" name="id" id="id" value="{{$event->id}}">
                        <div class="form-row" style="color:black">
                            <div class="form-group col-md-6">
                                <label >Nama Event</label>
                                <input type="text" class="form-control" name="nama" id="nama" placeholder="Seminar.co.id" value="{{$event->event_title}}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Flayer Event</label>
                                <input type="file" class="form-control" name="flayer" id="flayer" placeholder="Password" value="{{$event->flayer}}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Narasumber</label>
                                <input type="text" class="form-control" name="narasumber" id="narasumber" placeholder="nama narasumber" value="{{$event->narasumber}}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Tema</label>
                                <input type="text" class="form-control" name="tema" id="tema" placeholder="Tema Event" value="{{$event->tema}}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Harga Registrasi</label>
                                <input type="text" name="harga" id="harga" class="form-control" value="{{$event->harga}}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Layanan Notifikasi</label><br>
                                <select name="notif" id="notif" class="form-control">
                                    <option value="">--</option>
                                    @foreach($notif as $n)
                                        <option value="{{$n->device_key }}">{{$n->service}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Tanggal Event</label>
                                <input type="date" name="tanggal" id="mdate" class="form-control" value="{{$event->tgl_event}}">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Open Register</label>
                                <input type="text" id="date-format1" name="open" class="form-control" value="{{$event->open_register}}">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Close Register</label>
                                <input type="text" id="date-format2" name="close" class="form-control" value="{{$event->close_register}}">
                            </div>
                            <div class="form-group col-md-12">
                                <h5><b> Copywriting Whatsapp </b></h5>
                                <label>Copywriting konfirmasi pendaftaran</label>
                                <textarea type="text" class="form-control" name="pendaftaran" id="pendaftaran" style="height:300px;">{{$event->cw_register}}</textarea>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Copywriting konfirmasi pembayaran</label>
                                <textarea type="text" class="form-control" name="pembayaran" id="pembayaran" style="height:300px;">{{$event->cw_payment}}</textarea>
                            </div><br>
                            <div class="form-group col-md-12">
                                <br><h5><b> Copywriting Email </b></h5>
                                <label>Copywriting konfirmasi pendaftaran</label>
                                <textarea type="text" class="form-control" name="pendaftaran2" id="editor" placeholder="">{{$event->cw_email_register}}</textarea>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Copywriting konfirmasi pembayaran</label>
                                <textarea type="text" class="form-control" name="pembayaran2" id="editor2" placeholder="">{{$event->cw_email_payment}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
        
@endsection

@section('js')

<script type="text/javascript">

    CKEDITOR.replace( 'editor' );
    CKEDITOR.replace( 'editor2' );

    // MAterial Date picker
    $('#mdate').bootstrapMaterialDatePicker({
        weekStart: 0,
        time: false
    });
    $('#date-format1').bootstrapMaterialDatePicker({
        format: 'YYYY-MM-DD - HH:mm'
    });
    $('#date-format2').bootstrapMaterialDatePicker({
        format: 'YYYY-MM-DD - HH:mm'
    });

</script>


@endsection