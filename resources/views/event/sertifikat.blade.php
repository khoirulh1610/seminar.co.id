@extends('layouts.index')

@section('main')
<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Seminar</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Sertifikat</a></li>
            </ol>
        </div>

        @if(Auth::user()->brand=='ISA')
        <form action="" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-9 text-center">
                        <img src="{{url('assets/images/sertifsgm.png')}}" style="width:100%" alt="" class="img-fluid">
                    </div>
                    <div class="col-3 text-center">
                        <p class="mt-5"><i>Klik tombol <b>Download</b> dibawah untuk mendownload sertifikat ISA Conference</i></p>
                        <a href="{{url('/sertifikat-download/'.Auth::user()->id)}}" class="btn btn-success btn-rounded">Download</a>
                    </div>
                </div>
            </div>
        </div>
        </form>
        @elseif(Auth::user()->brand=='SGM')
        <form action="" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-9 text-center">
                        <img src="{{url('assets/images/sertifsgm.png')}}" style="width:100%" alt="" class="img-fluid">
                    </div>
                    <div class="col-3 text-center">
                        <p class="mt-5"><i>Klik tombol <b>Download</b> dibawah untuk mendownload sertifikat Seminar Google Map Marketing</i></p>
                        <a href="{{url('/sertifikat-download/'.Auth::user()->id)}}" class="btn btn-success btn-rounded">Download</a>
                    </div>
                </div>
            </div>
        </div>
        </form>
        @endif

    </div>
</div>
@endsection


@section('js')
<script>


 </script>
 @endsection
