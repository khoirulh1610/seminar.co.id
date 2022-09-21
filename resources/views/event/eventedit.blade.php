@extends('layouts.index')

@section('main')
    <div class="content-body">
        <div class="container-fluid">
            <div class="col-xl-12 col-lg-12">
                <form action="{{ url('event/save') }}" method="post" autocomplete="off" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header pb-0">
                            <h4 class="card-title">Edit Data Event</h4>
                            <div class="form-group d-flex">
                                <a href="{{ url('/event') }}"
                                    class="btn btn-danger btn-rounded btn-sm float-right m-1">Cancel</a>&emsp;
                                <button type="submit"
                                    class="btn btn-success btn-rounded btn-sm float-right m-1">Simpan</button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="profile-tab">
                                <div class="custom-tab-1">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item"><a href="#data-event" data-toggle="tab"
                                                class="nav-link mr-0 active show">Data Event</a>
                                        </li>
                                        <li class="nav-item"><a href="#cw-pendaftaran" data-toggle="tab"
                                                class="nav-link mr-0">CW Pendaftaran</a>
                                        </li>
                                        <li class="nav-item"><a href="#cw-pembayaran" data-toggle="tab"
                                                class="nav-link mr-0">CW Pembayaran</a>
                                        </li>
                                        <li class="nav-item"><a href="#cw-absen" data-toggle="tab" class="nav-link mr-0">CW
                                                Absen</a>
                                        </li>
                                        <li class="nav-item"><a href="#cw-medsos" data-toggle="tab" class="nav-link mr-0">CW
                                                Media Sosial</a>
                                        </li>
                                        <li class="nav-item"><a href="#cw-email" data-toggle="tab" class="nav-link mr-0">CW
                                                Email</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" style="color: black">
                                        <div id="data-event" class="tab-pane fade active show">
                                            <div class="my-post-content pt-5 ml-3">
                                                <div class="basic-form">
                                                    <div class="form-row">
                                                        <input type="hidden" name="id" value="{{ $event->id }}"
                                                            class="form-control">
                                                        <div class="form-group col-md-6">
                                                            <label>Nama Event</label>
                                                            <input type="text" class="form-control" name="nama"
                                                                id="nama" placeholder="Seminar.co.id"
                                                                value="{{ $event->event_title }}">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Subdomain</label>
                                                            <input type="text" class="form-control" name="sub_domain"
                                                                id="sub_domain" value="{{ $event->sub_domain }}"
                                                                placeholder="https://xyz.seminar.co.id => xyz">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Flayer Event</label>
                                                            <input type="file" class="form-control" name="flayer"
                                                                id="flayer" placeholder="Password"
                                                                value="{{ $event->flayer }}">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Narasumber</label>
                                                            <input type="text" class="form-control" name="narasumber"
                                                                id="narasumber" placeholder="nama narasumber"
                                                                value="{{ $event->narasumber }}">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Tema</label>
                                                            <input type="text" class="form-control" name="tema"
                                                                id="tema" placeholder="Tema Event"
                                                                value="{{ $event->tema }}">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Link Zoom</label>
                                                            <input type="text" class="form-control" name="link_zoom"
                                                                id="link_zoom" placeholder="Link Zoom"
                                                                value="{{ $event->link_zoom }}"">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>Zoom</label>
                                                            <select name="zoom_id" id="zoom_id" class="form-control">
                                                                <option value="">--</option>
                                                                @foreach ($zoom_id as $z)
                                                                    <option value="{{ $z->id }}"
                                                                        {{ $z->id == $event->zoom_id ? 'selected' : '' }}>
                                                                        {{ $z->name }} || {{ $z->email }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>Meeting ID</label>
                                                            <input type="number" name="meet_id" id="meet_id"
                                                                class="form-control" value="{{ $event->meeting_id }}">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>Produk</label>
                                                            <select name="produk" id="produk" class="form-control">
                                                                <option value="">--</option>
                                                                @foreach ($produk_id as $pr)
                                                                    <option value="{{ $pr->name }}"
                                                                        {{ $pr->name == $event->produk ? 'selected' : '' }}>
                                                                        {{ $pr->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>Harga Registrasi</label>
                                                            <input type="number" name="harga" id="harga"
                                                                class="form-control" value="{{ $event->harga }}">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="">Layanan Notifikasi</label><br>
                                                            <select name="notif" id="notif" class="form-control"
                                                                required>
                                                                <option value="">--</option>
                                                                @foreach ($notif as $n)
                                                                    <option value="{{ $n->id }}"
                                                                        {{ $n->id == $event->device_id ? 'selected' : '' }}>
                                                                        {{ $n->id }} - {{ $n->phone }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>Tipe Seminar</label>
                                                            <select name="type" class="form-control">
                                                                @foreach ($type as $tp)
                                                                    <option value="berbayar"
                                                                        {{ $tp->type == $event->type ? 'selected' : '' }}>
                                                                        Berbayar</option>
                                                                    <option value="gratis"
                                                                        {{ $tp->type == $event->type ? 'selected' : '' }}>
                                                                        Gratis</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            <label>Status Event</label>
                                                            <select name="status" id="" class="form-control">
                                                                <option value="1"
                                                                    {{ $event->status == '1' ? 'selected' : '' }}>Available
                                                                </option>
                                                                <option value="0"
                                                                    {{ $event->status == '0' ? 'selected' : '' }}>Closed
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-9">
                                                            <label>Lokasi Event</label>
                                                            <input type="text" name="lokasi" class="form-control"
                                                                value="{{ $event->lokasi }}">
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label>Detail Event</label>
                                                            <textarea type="text" name="event_detail" class="form-control" style="height:300px">{{ $event->event_detail }}</textarea>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>Tanggal Event</label>
                                                            <input type="text" name="tanggal" id=""
                                                                class="form-control date-format1"
                                                                value="{{ $event->tgl_event }}">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>Open Register</label>
                                                            <input type="text" id="" name="open"
                                                                class="form-control date-format1"
                                                                value="{{ $event->open_register }}">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>Close Register</label>
                                                            <input type="text" id="date-format2" name="close"
                                                                class="form-control"
                                                                value="{{ $event->close_register }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="cw-pendaftaran" class="tab-pane fade">
                                            <div class="my-post-content pt-5 ml-3">
                                                <div class="basic-form">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-12">
                                                            <label>Copywriting Pendaftaran 1</label>
                                                            <textarea type="text" class="form-control" name="pendaftaran" id="pendaftaran" style="height:300px;">{{ $event->cw_register }}</textarea>
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label>Copywriting Pendaftaran 2</label>
                                                            <textarea type="text" class="form-control" name="pendaftaran2" style="height:300px;">{{ $event->cw_register2 }}</textarea>
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label>Copywriting Konfirmasi Pendaftaran untuk Referral</label>
                                                            <textarea type="text" class="form-control" name="pendaftaran_ref" style="height:300px;">{{ $event->cw_referral }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="cw-pembayaran" class="tab-pane fade">
                                            <div class="my-post-content pt-5 ml-3">
                                                <div class="basic-form">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-12">
                                                            <label>Copywriting Konfirmasi Pembayaran</label>
                                                            <textarea type="text" class="form-control" name="pembayaran" id="pembayaran" style="height:300px;">{{ $event->cw_payment }}</textarea>
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label>Copywriting Pembayaran untuk Referral</label>
                                                            <textarea type="text" class="form-control" name="pembayaran_ref" style="height:300px;">{{ $event->cw_payment_ref }}</textarea>
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label>Copywriting Tagihan Pembayaran</label>
                                                            <textarea type="text" class="form-control" name="tagihan" style="height:300px;">{{ $event->cw_tagihan }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="cw-absen" class="tab-pane fade">
                                            <div class="my-post-content pt-5 ml-3">
                                                <div class="basic-form">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-12">
                                                            <label>Copywriting Absen Seminar</label>
                                                            <textarea type="text" class="form-control" name="absen" style="height:300px;">{{ $event->cw_absen }}</textarea>
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label>Copywriting Absen Seminar untuk Referral</label>
                                                            <textarea type="text" class="form-control" name="absen_ref" style="height:300px;">{{ $event->cw_absen_ref }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="cw-medsos" class="tab-pane fade">
                                            <div class="my-post-content pt-5 ml-3">
                                                <div class="basic-form">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-12">
                                                            <div class="d-flex justify-content-between">
                                                                <label>Copywriting Facebook</label>
                                                                <div class="ml-auto">
                                                                    <input type="file" name="flayer_fb"
                                                                        accept="image/*"
                                                                        class="form-control form-control-file">
                                                                </div>
                                                            </div>
                                                            <textarea type="text" class="form-control" name="cw_fb" rows="3"
                                                                placeholder="Copy Writing untuk Facebook masih kosong">{{ $event->cw_fb }}</textarea>
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <div class="d-flex justify-content-between">
                                                                <label>Copywriting Instagram</label>
                                                                <div class="ml-auto">
                                                                    <input type="file" name="flayer_ig"
                                                                        accept="image/*"
                                                                        class="form-control form-control-file">
                                                                </div>
                                                            </div>
                                                            <textarea type="text" class="form-control" name="cw_ig" rows="3"
                                                                placeholder="Copy Writing untuk Instagram masih kosong">{{ $event->cw_ig }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="cw-email" class="tab-pane fade">
                                            <div class="my-post-content pt-5 ml-3">
                                                <div class="basic-form">
                                                    <div class="form-group col-md-12">
                                                        <label>Copywriting Konfirmasi Pendaftaran</label>
                                                        <textarea type="text" class="form-control" name="pendaftaran_email" id="editor" placeholder="">{{ $event->cw_email_register }}</textarea>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label>Copywriting Konfirmasi Pembayaran</label>
                                                        <textarea type="text" class="form-control" name="pembayaran_email" id="editor2" placeholder="">{{ $event->cw_email_payment }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
        CKEDITOR.replace('editor');
        CKEDITOR.replace('editor2');

        // MAterial Date picker
        $('.date-format1').bootstrapMaterialDatePicker({
            format: 'YYYY-MM-DD HH:mm:ss'
        });
        $('.date-format1').bootstrapMaterialDatePicker({
            format: 'YYYY-MM-DD HH:mm:ss'
        });
        $('#date-format2').bootstrapMaterialDatePicker({
            format: 'YYYY-MM-DD  HH:mm:ss'
        });
    </script>
@endsection
