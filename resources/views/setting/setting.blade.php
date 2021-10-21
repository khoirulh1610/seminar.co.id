@extends('layout.index')

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
                    <div class="card-header">
                        <h4 class="card-title">Pengaturan</h4>
                        <a href="{{url('setting/baru')}}" class="btn btn-rounded btn-success">Layanan Baru</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example5" class="display table-responsive-lg">
                                <thead>
                                    <tr>
                                        <th style="text-align:center">No</th>
                                        <th style="text-align:center">Device</th>
                                        <th style="text-align:center">Nama Layanan</th>
                                        <th style="text-align:center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($notif as $n)
                                    <tr>
                                        <td style="text-align:center">{{$loop->iteration}}</td>
                                        <td>{{$n->device_key}}</td>
                                        <td>{{$n->service}}</td>
                                        <td style="text-align:center">
                                            <a href="" class="btn btn-xs btn-info btn-rounded"><em class="flaticon-381-edit"></em></a>
                                            <a href="" class="btn btn-xs btn-danger btn-rounded"><em class="flaticon-381-trash"></em></a>
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
@endsection

@section('js')

@endsection