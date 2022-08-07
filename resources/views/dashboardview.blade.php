<!-- row -->
<div class="container-fluid">
    <div class="d-flex justify-content-between">
        <h3>Dashboard</h3>     
        <div class="mb-3">
            @if (Auth::user()->role_id <= 2)
                <a href="{{ url('/undangan') }}" class="btn btn-primary btn-sm btn-small btn-rounded">Undangan saya</a>
            @endif
        </div> 
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3">
            <div class="card bg-primary">
                <div class="card-body">
                    <div class="media align-items-center">
                        <span class="p-3 feature-icon rounded">
                        <i class="fa fa-lg fa-users text-light"></i>
                        </span>
                        <div class="media-body text-right">
                            @if (Auth::user()->role_id==1)                                                                            
                                <p class="fs-18 text-white mb-2">Total Pendaftar</p>
                                <span class="fs-20 text-white font-w600">{{ $seminar->where('message','<>','SEMINAR MR')->count('id')}}</span>
                            @elseif(Auth::user()->role_id==2) 
                                <p class="fs-18 text-white mb-2">Total Pendaftar</p>
                                <span class="fs-20 text-white font-w600">{{ $seminar->count('id')}}</span>
                            @else
                                <p class="fs-18 text-white mb-2">Referral Anda</p>
                                <span class="fs-20 text-white font-w600">{{$seminar->count()}}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3">
            <div class="card bg-info">
                <div class="card-body">
                    <div class="media align-items-center">
                        <span class="p-3 mr-3 feature-icon rounded">
                        <i class="fa fa-lg fa-check-square text-white" aria-hidden="true"></i>
                        </span>
                        <div class="media-body text-right">
                            @if(Auth::user()->role_id==1)
                                <p class="fs-18 text-white mb-2">Peserta Hadir</p>
                                <span class="fs-20 text-white font-w600">{{$absen->count()}}</span>
                            @elseif(Auth::user()->role_id==2) 
                                <p class="fs-18 text-white mb-2">Peserta Hadir</p>
                                <span class="fs-20 text-white font-w600">{{$absen->count()}}</span>
                            @else
                                <p class="fs-18 text-white mb-2">Peserta Hadir</p>
                                <span class="fs-20 text-white font-w600">{{$absen->count()}}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3">
            <div class="card bg-warning">
                <div class="card-body">
                    <div class="media align-items-center">
                        <span class="p-3 mr-3 feature-icon rounded">
                        <i class="fa fa-lg fa-user-circle text-white" aria-hidden="true"></i>
                        </span>
                        <div class="media-body text-right">
                            @if(Auth::user()->role_id<=2)    
                                <p class="fs-18 text-white mb-2">Komisi</p>
                                <span class="fs-20 text-white font-w600">Rp. {{number_format($komisi->sum('komisi'))}}</span> <br>
                                {{-- <span class="fs-20 text-white font-w600">Rp. 0</span> --}}
                            @else
                            <p class="fs-18 text-white mb-2">Komisi</p>
                                <span class="fs-20 text-white font-w600">Rp. {{number_format($seminar->where('status',1)->where('total','>',0)->count() * 500)}}</span>   <br>
                                {{-- <span class="fs-20 text-white font-w600">Rp. {{number_format($absen->count() * 500)}}</span>   <br> --}}
                                {{-- <span class="fs-20 text-white font-w600">Rp. 0</span> --}}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3">
            <div class="card bg-secondary">
                <div class="card-body">
                    <div class="media align-items-center">
                        <span class="p-3 mr-3 feature-icon rounded">
                        <i class="fa fa-xl fa-credit-card text-white" aria-hidden="true"></i>
                        </span>
                        <div class="media-body text-right">
                        @if(Auth::user()->role_id<=2)    
                            <p class="fs-18 text-white mb-2">Komisi Mitra</p>
                            <span class="fs-20 text-white font-w600">Rp. {{number_format($komisi_mitra->sum('komisi_mitra'))}}</span> <br>
                            {{-- <span class="fs-20 text-white font-w600">Rp. 0</span> --}}
                        @else
                            <p class="fs-18 text-white mb-2">Komisi Total</p>
                            <span class="fs-20 text-white font-w600">Rp. {{number_format($seminar->where('ref',Auth::user()->phone)->where('status',1)->sum('fee_referral'))}}</span> <br>
                            {{-- <span class="fs-20 text-white font-w600">Rp. 0</span> --}}
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- row -->
    <div class="row">    
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    @if (Auth::user()->role_id <= 2)
                        <h4 class="card-title">Data Data Event</h4>
                    @else
                        <h4 class="card-title">Detail Data</h4>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">                            
                        <table id="example1" class="table table-hover table-sm">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Event Title</th>                                        
                                    <th>Jadwal Register</th>
                                    <th>Jadwal Seminar</th>
                                    <th>Narasumber</th>
                                    @if (Auth::user()->role_id <= 2)
                                        <th>Total Pendaftar</th>
                                        <th>Peserta Hadir</th>
                                        <th>Komisi</th>
                                        <th>Komisi Mitra</th>
                                    @else
                                        <th>Referral Anda</th>
                                        <th>Peserta Hadir</th>                                           
                                        <th>Total Komisi</th>
                                    @endif
                                    <th>Status</th>
                                    {{-- <th>Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($event as $e)
                                <tr>
                                    <td class="text-center">{{$loop->iteration}}</td>
                                    <td >{{$e->event_title}}</td>                                        
                                    <td class="text-center">
                                        <small>Open Register : </small> <br> {{ $e->open_register }}<br>
                                        <small>Close Register : </small> <br> {{ $e->close_register }}
                                    </td>
                                    <td class="text-center">{{ Date( 'd/m/Y',strtotime($e->tgl_event)) }}</td>
                                    <td class="text-center">{{ $e->narasumber }}</td>
                                    @if (Auth::user()->role_id == 1)
                                        <td class="text-center">{{App\Models\Seminar::where('kode_event',$e->kode_event)->where('message','<>','SEMINAR MR')->count('id')}} {{App\Models\Seminar::where('kode_event',$e->kode_event)->where('message','=','SEMINAR MR')->count() ? '| '.App\Models\Seminar::where('kode_event',$e->kode_event)->where('message','=','SEMINAR MR')->count('id') : '' }}</td>
                                        <td class="text-center">{{$absen->where('kode_event',$e->kode_event)->count()}}</td>
                                        <td class="text-right">Rp. {{number_format($seminar->where('kode_event',$e->kode_event)->where('status',1)->where('total','>',0)->count())}}</td>
                                        <td class="text-right">Rp. {{number_format($seminar->where('kode_event',$e->kode_event)->where('status',1)->sum('total'))}}</td>
                                    @elseif (Auth::user()->role_id == 2)
                                        <td class="text-center">{{App\Models\Seminar::where('kode_event',$e->kode_event)->count('id')}}</td>
                                        <td class="text-center">{{$absen->count()}}</td>
                                        {{-- <td class="text-right">Rp. {{number_format($seminar->where('kode_event',$e->kode_event)->where('status',1)->where('total','>',0)->count())}}</td> --}}
                                        <td class="text-right">Rp. {{number_format($seminar->where('kode_event',$e->kode_event)->where('status',1)->sum('total'))}}</td>
                                    @else
                                        <td class="text-center">{{$seminar->where('kode_event',$e->kode_event)->where('ref',Auth::user()->phone)->count()}}</td>
                                        <td class="text-center">{{$seminar->where('kode_event',$e->kode_event)->whereIn('seminar_id',$absen)->count()}}</td>
                                        {{-- <td class="text-right">Rp. {{number_format($seminar->where('kode_event',$e->kode_event)->where('ref',Auth::user()->phone)->where('status',1)->where('total','>',0)->count())}}</td> --}}
                                        <td class="text-right">Rp. {{number_format($seminar->where('kode_event',$e->kode_event)->where('ref',Auth::user()->phone)->where('status',1)->sum('fee_referral'))}}</td>
                                    @endif
                                    <td class="text-center">
                                        @if($e->open_register < Carbon\Carbon::now() && $e->close_register > Carbon\Carbon::now() )
                                            <a href="javascript:void()" class="badge badge-rounded badge-info">Proses</a> 
                                            @if(Auth::user()->role_id<=2)
                                                <a href="{{ url('event/'.$e->kode_event.'/absen') }}" class="badge badge-rounded badge-info">Absen</a> 
                                            @endif
                                        @else
                                            <a href="javascript:void()" class="badge badge-rounded badge-warning">SELESAI</a> 
                                        @endif
                                    </td>
                                </tr>
                                @endforeach		
                            </tbody>                                
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @if (Auth::user()->role_id <= 2)
        <center>
            <button id="btn-nft-enable" onclick="startFCM()" class="btn btn-danger btn-xs btn-flat">Tampilkan Notifikasi</button>
        </center>
    @endif
</div>