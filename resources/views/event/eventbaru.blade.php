@extends('layouts.index')

@section('main')
<div class="content-body">
    <div class="container-fluid">
        <div class="col-xl-12 col-lg-12">
            <form action="{{url('event/save')}}" method="post" autocomplete="off" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Data Event Baru</h4>
                        <div class="form-group">
                            <a href="{{url('/event')}}" class="btn btn-danger btn-rounded float-right m-1">Cancel</a>&emsp;
                            <button type="submit" class="btn btn-success btn-rounded float-right m-1">Simpan</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <div class="form-row" style="color:black">
                                <div class="form-group col-md-6">
                                    <label>Nama Event</label>
                                    <input type="text" class="form-control" name="nama" id="nama" placeholder="Seminar.co.id">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Flayer Event</label>
                                    <input type="file" class="form-control" name="flayer" id="flayer" placeholder="Password">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Narasumber</label>
                                    <input type="text" class="form-control" name="narasumber" id="narasumber" placeholder="nama narasumber">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Tema</label>
                                    <input type="text" class="form-control" name="tema" id="tema" placeholder="Tema Event">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Harga Registrasi</label>
                                    <input type="number" name="harga" id="harga" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Layanan Notifikasi</label><br>
                                    <select name="notif" id="notif" class="form-control">
                                        <option value="">--</option>
                                        @foreach($notif as $n)
                                        <option value="{{$n->device_key}}">{{$n->service}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Tipe Seminar</label>
                                    <select name="type" class="form-control">
                                        <option value="berbayar">Berbayar</option>
                                        <option value="gratis">Gratis</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="select-mitra">Mitra Id</label><br>
                                    <input type="text" name="mitra_id" list="select-mitra" class="form-control custom-select">
                                    <datalist id="select-mitra">
                                        @foreach($user as $us)
                                        <option value="{{$us->id}}">{{$us->nama}}</option>
                                        @endforeach
                                    </datalist>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Komisi Mitra</label>
                                    <input type="number" name="komisi_mitra" class="form-control">
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Lokasi Event</label>
                                    <input type="text" name="lokasi" class="form-control">
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Detail Event</label>
                                    <textarea type="text" name="event_detail" class="form-control"></textarea>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Tanggal Event</label>
                                    <input type="text" name="tanggal" id="mdate" class="form-control" placeholder="2021-12-13 19:00">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Open Register</label>
                                    <input type="text" id="date-format1" name="open" class="form-control" placeholder="2021-11-11 00:00">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Close Register</label>
                                    <input type="text" id="date-format2" name="close" class="form-control" placeholder="2021-12-12 00:00">
                                </div>
                                <div class="form-group col-md-12">
                                    <h5><b> Copywriting Whatsapp </b></h5>
                                    <label>Copywriting Pendaftaran 1</label>
                                    <textarea type="text" class="form-control" name="pendaftaran" id="pendaftaran" style="height:300px;"></textarea>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Copywriting Pendaftaran 2</label>
                                    <textarea type="text" class="form-control" name="pendaftaran2" style="height:300px;"></textarea>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Copywriting Konfirmasi Pendaftaran untuk Referral</label>
                                    <textarea type="text" class="form-control" name="pendaftaran_ref" style="height:300px;"></textarea>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Copywriting Konfirmasi Pembayaran</label>
                                    <textarea type="text" class="form-control" name="pembayaran" id="pembayaran" style="height:300px;"></textarea>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Copywriting Pembayaran untuk Referral</label>
                                    <textarea type="text" class="form-control" name="pembayaran_ref" style="height:300px;"></textarea>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Copywriting Absen Seminar</label>
                                    <textarea type="text" class="form-control" name="absen" style="height:300px;"></textarea>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Copywriting Absen Seminar untuk Referral</label>
                                    <textarea type="text" class="form-control" name="absen_ref" style="height:300px;"></textarea>
                                </div><br>
                                <div class="form-group col-md-12">
                                    <h5><b> Copywriting Email </b></h5>
                                    <label>Copywriting konfirmasi pendaftaran</label>
                                    <textarea type="text" class="form-control" name="pendaftaran_email" id="editor" placeholder=""></textarea>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Copywriting konfirmasi pembayaran</label>
                                    <textarea type="text" class="form-control" name="pembayaran_email" id="editor2" placeholder=""></textarea>
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

    CKEDITOR.replace('editor');
    CKEDITOR.replace('editor2');

    $(document).ready(function () {
        //change selectboxes to selectize mode to be searchable
        $("#select").select2();
    });
</script>

@endsection