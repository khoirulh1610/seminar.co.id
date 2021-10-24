@extends('layouts.index')

@section('main')
<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @if($event->count()==0)
            <h3>seminar.co.id</h3>
            <div class="row">
            <div class="col-12 col-md-3">
                <div class="card bg-primary">
                    <div class="card-body">
                        <div class="media align-items-center">
                            <span class="p-3 mr-3 feature-icon rounded">
                               <i class="fa fa-lg fa-users text-light"></i>
                            </span>
                            <div class="media-body text-right">
                                    <p class="fs-18 text-white mb-2">Referral Anda</p>
                                    <span class="fs-20 text-white font-w600">0</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card bg-info">
                    <div class="card-body">
                        <div class="media align-items-center">
                            <span class="p-3 mr-3 feature-icon rounded">
                            <i class="fa fa-lg fa-check-square text-white" aria-hidden="true"></i>
                            </span>
                            <div class="media-body text-right">
                                    <p class="fs-18 text-white mb-2">Peserta Appoved</p>
                                    <span class="fs-20 text-white font-w600">0</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card bg-warning">
                    <div class="card-body">
                        <div class="media align-items-center">
                            <span class="p-3 mr-3 feature-icon rounded">
                            <i class="fa fa-lg fa-user-circle text-white" aria-hidden="true"></i>
                            </span>
                            <div class="media-body text-right">
                                    <p class="fs-18 text-white mb-2">Peserta Payment</p>
                                    <span class="fs-20 text-white font-w100">0</span>   
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card bg-secondary">
                    <div class="card-body">
                        <div class="media align-items-center">
                            <span class="p-3 mr-3 feature-icon rounded">
                            <i class="fa fa-xl fa-credit-card text-white" aria-hidden="true"></i>
                            </span>
                            <div class="media-body text-right">
                            <p class="fs-18 text-white mb-2">Total Komisi</p>
                                <span class="fs-20 text-white font-w600">Rp. 0</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @foreach($event as $ev)        
        <h3>{{$ev->event_title}}</h3>
        <div class="row">
            <div class="col-12 col-md-3">
                <div class="card bg-primary">
                    <div class="card-body">
                        <div class="media align-items-center">
                            <span class="p-3 mr-3 feature-icon rounded">
                               <i class="fa fa-lg fa-users text-light"></i>
                            </span>
                            <div class="media-body text-right">
                                @if(Auth::user()->role_id<=2) 
                                    <p class="fs-18 text-white mb-2">Total Pendaftar</p>
                                    <span class="fs-20 text-white font-w600">{{$ev->kode_event}} : {{App\Models\Seminar::where('kode_event',$ev->kode_event)->count('id')}}</span>
                                @else
                                    <p class="fs-18 text-white mb-2">Referral Anda</p>
                                    <span class="fs-20 text-white font-w600">{{$seminar->where('kode_event',$ev->kode_event)->where('ref',Auth::user()->phone)->count()}}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card bg-info">
                    <div class="card-body">
                        <div class="media align-items-center">
                            <span class="p-3 mr-3 feature-icon rounded">
                            <i class="fa fa-lg fa-check-square text-white" aria-hidden="true"></i>
                            </span>
                            <div class="media-body text-right">
                                @if(Auth::user()->role_id<=2) 
                                    <p class="fs-18 text-white mb-2">Peserta Appoved</p>
                                    <span class="fs-20 text-white font-w600">{{$seminar->where('kode_event',$ev->kode_event)->where('status',1)->count()}}</span>
                                @else
                                    <p class="fs-18 text-white mb-2">Peserta Appoved</p>
                                    <span class="fs-20 text-white font-w600">{{$seminar->where('kode_event',$ev->kode_event)->where('ref',Auth::user()->phone)->where('status',1)->count()}}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card bg-warning">
                    <div class="card-body">
                        <div class="media align-items-center">
                            <span class="p-3 mr-3 feature-icon rounded">
                            <i class="fa fa-lg fa-user-circle text-white" aria-hidden="true"></i>
                            </span>
                            <div class="media-body text-right">
                                @if(Auth::user()->role_id<=2)    
                                    <p class="fs-18 text-white mb-2">Peserta Payment</p>
                                    <span class="fs-20 text-white font-w100">{{number_format($seminar->where('kode_event',$ev->kode_event)->where('status',1)->where('total','>',0)->count())}}</span>
                                @else
                                <p class="fs-18 text-white mb-2">Peserta Payment</p>
                                    <span class="fs-20 text-white font-w100">{{number_format($seminar->where('kode_event',$ev->kode_event)->where('ref',Auth::user()->phone)->where('status',1)->where('total','>',0)->count())}}</span>   
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card bg-secondary">
                    <div class="card-body">
                        <div class="media align-items-center">
                            <span class="p-3 mr-3 feature-icon rounded">
                            <i class="fa fa-xl fa-credit-card text-white" aria-hidden="true"></i>
                            </span>
                            <div class="media-body text-right">
                            @if(Auth::user()->role_id<=2)    
                                <p class="fs-18 text-white mb-2">Total Payment</p>
                                <span class="fs-20 text-white font-w600">RP. {{number_format($seminar->where('kode_event',$ev->kode_event)->where('status',1)->sum('total'))}}</span>
                            @else
                                <p class="fs-18 text-white mb-2">Total Komisi</p>
                                <span class="fs-20 text-white font-w600">RP. {{number_format($seminar->where('kode_event',$ev->kode_event)->where('ref',Auth::user()->phone)->where('status',1)->sum('fee_referral'))}}</span>
                            @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        
        <center>
            <button id="btn-nft-enable" onclick="startFCM()" class="btn btn-danger btn-xs btn-flat">Allow for Notification</button>
        </center>
    </div>
</div>
<!--**********************************
    Content body end
***********************************-->
@endsection

@section('js')

@endsection