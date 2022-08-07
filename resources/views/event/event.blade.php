@extends('layouts.index')

@section('main')
<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Event</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Data</a></li>
            </ol>
        </div>
        <div class="row">
            @foreach($event as $ev)
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row m-b-30">
                            <div class="col-md-5 col-lg-12">
                                <div class="new-arrival-product mb-4 mb-lg-4 mb-md-0">
                                    <div class="new-arrivals-img-contnent">
                                        <br><img class="img-fluid" src="{{$ev->flayer ?? url('asset/images/product/7.jpg')}}" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-12">
                                <div class="new-arrival-content position-relative">
                                    <h4><a href="#">{{$ev->event_title}}</a></h4>
                                    @if($ev->harga>0)
                                        <p class="price">IDR {{number_format($ev->harga)}}</p>
                                        <p class="review-text">({{$ev->seminar->where('status',1)->count('id')}} Payment) / ({{$ev->seminar->count('id')}} Registrant)</p>
                                    @else
                                        <p class="price">GRATIS</p>
                                        <p class="review-text">{{number_format($ev->seminar->count('id'))}} Registrant</p>
                                    @endif
                                    <p>Status : 
                                        @if($ev->status == '1')
                                        <span class="item"> Available <i class="fa fa-check-circle text-success"></i></span>
                                        @else
                                        <span class="item"> Closed <i class="fa fa-check-circle text-danger"></i></span>
                                        @endif
                                    </p>
                                    <p>Link Referral : <span class="item">{{ 'https://'.$ev->sub_domain.'.seminar.co.id?ref='.Auth::user()->phone }} </span></p>
                                    <p>Tanggal : <span class="item">{{ $ev->tgl_event }}</span> </p>
                                    @if (Auth::user()->role_id == '1')
                                        <p>Sub domain : <span class="item">{{ $ev->sub_domain }}</span> </p>
                                        <p>Event code: <span class="item">{{$ev->kode_event}}</span> </p>
                                        <p>Brand: <span class="item">{{$ev->brand}}</span></p>
                                        <p>Peserta : 
                                            @if(Auth::user()->role_id <= 2)
                                                ({{$ev->seminar->where('status',1)->count('id')}} Payment) / 
                                            @endif
                                            ({{$ev->seminar->count('id')}} Registrant)</p>
                                        <br>
                                    @endif
                                    <center><button type="button" class="btn btn-info btn-sm btn-rounded" data-toggle="collapse" data-target="#demo{{ $ev->id }}">Detail Seminar</button>
                                    @if(Auth::user()->role_id<=2)
                                        <a href="{{ route('event.absen', ['event' => $ev->kode_event]) }}" class="btn btn-primary btn-rounded btn-sm">Absen</a>
                                        <a href="{{url('event/edit/'.$ev->id)}}" class="btn btn-sm btn-success btn-rounded">Edit</a>
                                    @endif
                                    </center>
                                    <div id="demo{{ $ev->id }}" class="collapse text-content">{!!nl2br($ev->event_detail)!!}</div>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach            
        </div>
    </div>
</div>
@endsection