@extends('layouts.index')

@section('main')
<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
    <div class="container-fluid">
        <!-- row -->
        <div class="row">    
            <div class="col-12">
                <div class="card">                    
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="" class="table-export table display table-responsive-lg">
                                <thead>
                                    <tr>                                        
                                        <th style="text-align:center">Sapaan</th>
                                        <th style="text-align:center">Panggilan</th>
                                        <th style="text-align:center">Nama</th>
                                        <th style="text-align:center">Phone</th>
                                        <th style="text-align:center">Kota</th>
                                        <th style="text-align:center">Profesi</th>                                        
                                        <th style="text-align:center">Tgl Lahir</th>
                                        <th style="text-align:center">Absen</th>
                                        <th style="text-align:center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($absen as $abs)
                                    <tr>
                                        <td style="text-align:center">{{$abs->sapaan}}</td>
                                        <td style="text-align:center">{{$abs->panggilan}}</td>
                                        <td style="text-align:center">{{$abs->nama}}</td>
                                        <td style="text-align:center">{{$abs->phone}}</td>
                                        <td style="text-align:center">{{$abs->kota}}</td>
                                        <td style="text-align:center">{{$abs->profesi}}</td>
                                        <td style="text-align:center">{{$abs->b_tanggal}}/{{$abs->b_bulan}}{{$abs->b_tahun ? '/'.$abs->b_tahun : ''}}</td>
                                        <td style="text-align:center">{{$abs->masuk}}</td>
                                        <td style="text-align:center">
                                            <a href="" class="btn btn-sm btn-info btn-rounded"><em class="flaticon-381-edit"></em></a>
                                            <a href="" class="btn btn-sm btn-danger btn-rounded"><em class="flaticon-381-trash"></em></a>
                                            <!-- <div class="dropdown ml-auto text-center">
                                                <div class="btn-link" data-toggle="dropdown">
                                                    <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg>
                                                </div>
                                                <div class="dropdown-menu dropdown-menu-center">
                                                    <a class="dropdown-item" href="#">Accept Patient</a>
                                                    <a class="dropdown-item" href="#">Reject Order</a>
                                                    <a class="dropdown-item" href="#">View Details</a>
                                                </div>
                                            </div> -->
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
    </div>
</div>
@endsection

@section('js')

@endsection