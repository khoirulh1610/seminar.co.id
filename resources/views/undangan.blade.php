@extends('layouts.index')

@section('main')
<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        <h3>Undangan</h3>
        <div class="row">
            <div class="col-12 col-md-3">
                <div class="card bg-primary">
                    <div class="card-body">
                        <div class="media align-items-center">
                            <span class="p-3 mr-3 feature-icon rounded">
                            <i class="fa fa-lg fa-users text-light"></i>
                            </span>
                            <div class="media-body text-right">
                                @if (Auth::user()->role_id==1)                                                                            
                                    <p class="fs-18 text-white mb-2">Total Pendaftar</p>
                                    <span class="fs-20 text-white font-w600">{{ $seminar->where('message','<>','SEMINAR MR')->count('id')}}</span>
                                @else
                                    <p class="fs-18 text-white mb-2">Referral Anda</p>
                                    <span class="fs-20 text-white font-w600">{{$seminar->where('ref',Auth::user()->phone)->count()}}</span>
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
                                @if(Auth::user()->role_id==1)
                                    <p class="fs-18 text-white mb-2">Peserta Hadir</p>
                                    <span class="fs-20 text-white font-w600">{{$absen->count()}}</span>
                                @else
                                    <p class="fs-18 text-white mb-2">Peserta Hadir</p>
                                    <span class="fs-20 text-white font-w600">{{$seminar->whereIn('seminar_id',$absen)->count()}}</span>
                                    {{-- <span class="fs-20 text-white font-w600">{{$seminar->where('ref',Auth::user()->phone)->where('status',1)->count()}}</span> --}}
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
                                    <p class="fs-18 text-white mb-2">Komisi</p>
                                    <span class="fs-20 text-white font-w600">Rp. {{number_format($komisi->sum('komisi'))}}</span> <br>
                                    <span class="fs-20 text-white font-w600">Rp. 0</span>
                                @else
                                <p class="fs-18 text-white mb-2">Komisi</p>
                                    <span class="fs-20 text-white font-w600">Rp. {{number_format($seminar->where('ref',Auth::user()->phone)->where('status',1)->where('total','>',0)->count())}}</span>   <br>
                                    <span class="fs-20 text-white font-w600">Rp. 0</span>
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
                                <p class="fs-18 text-white mb-2">Komisi Mitra</p>
                                <span class="fs-20 text-white font-w600">Rp. {{number_format($komisi_mitra->sum('komisi_mitra'))}}</span> <br>
                                <span class="fs-20 text-white font-w600">Rp. 0</span>
                            @else
                                <p class="fs-18 text-white mb-2">Komisi Total</p>
                                <span class="fs-20 text-white font-w600">Rp. {{number_format($seminar->where('ref',Auth::user()->phone)->where('status',1)->sum('fee_referral'))}}</span> <br>
                                <span class="fs-20 text-white font-w600">Rp. 0</span>
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
                                        <th>User</th>                                        
                                        <th>Tanggal daftar</th>
                                        <th>Komisi</th>
                                        <th>Status</th>
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($event as $e)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <strong>{{ $user->nama }}</strong>
                                                <small style="font-size: 11px" class="text-muted">{{ $user->email }}</small>
                                            </div>
                                        </td>
                                        <td>{{ $user->tgl_daftar }}</td>
                                        <td>{{ $user->komisi }}</td>
                                        <td>{{ $user->status }}</td>
                                    </tr>
                                    @endforeach		
                                </tbody>                                
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <center>
            <button id="btn-nft-enable" onclick="startFCM()" class="btn btn-danger btn-xs btn-flat">Tampilkan Notifikasi</button>
        </center>
    </div>
</div>
<!--**********************************
    Content body end
***********************************-->
@endsection

@section('js')

@endsection