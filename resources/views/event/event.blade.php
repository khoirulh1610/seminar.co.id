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
                                    <p class="price">IDR {{number_format($ev->harga)}}</p>
                                    <p class="review-text">({{$ev->seminar->where('status',1)->count('id')}} Payment) / ({{$ev->seminar->count('id')}} Registrant)</p>
                                    <p>Status : 
                                        @if($ev->status)
                                        <span class="item"> Available <i class="fa fa-check-circle text-success"></i></span>
                                        @else
                                        <span class="item"> Closed <i class="fa fa-check-circle text-danger"></i></span>
                                        @endif
                                    </p>
                                    <p>Event code: <span class="item">{{$ev->kode_event}}</span> </p>
                                    <p>Brand: <span class="item">{{$ev->brand}}</span></p>
                                    <p>Peserta : ({{$ev->seminar->where('status',1)->count('id')}} Payment) / ({{$ev->seminar->count('id')}} Registrant)</p>
                                    <br>
                                    <center><button type="button" class="btn btn-info btn-sm btn-rounded" data-toggle="collapse" data-target="#demo">Detail Seminar</button>
                                    @if(Auth::user()->role_id<=2)
                                        <a href="{{url('event/edit/'.$ev->id)}}" class="btn btn-sm btn-success btn-rounded">Edit</a>
                                    @endif</center>
                                    <div id="demo" class="collapse text-content">{!!nl2br($ev->event_detail)!!}</div>
                                    <!-- <div class="comment-review star-rating text-right"> -->
                                        <!-- <ul>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star-half-empty"></i></li>
                                            <li><i class="fa fa-star-half-empty"></i></li>
                                        </ul> -->
                                        <!-- <span class="review-text"></span>
                                    </div> -->
                                    
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