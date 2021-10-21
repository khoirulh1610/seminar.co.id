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
                        <h4 class="card-title">Data Event</h4>
                        <a href="{{url('event/baru')}}" class="btn btn-success btn-rounded">Buat Event</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example5" class="display table-responsive-lg">
                                <thead>
                                    <tr>
                                        <!-- <th style="text-align:center">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="checkAll" required="">
                                                <label class="custom-control-label" for="checkAll"></label>
                                            </div>
                                        </th> -->
                                        <th style="text-align:center">Kode Event</th>
                                        <th style="text-align:center">Tanggal Event</th>
                                        <th style="text-align:center">Open Register</th>
                                        <th style="text-align:center">Close Register</th>
                                        <th style="text-align:center">Harga</th>
                                        <th style="text-align:center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($event as $e)
                                    <tr>
                                        <!-- <td style="text-align:center">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheckBox2" required="">
                                                <label class="custom-control-label" for="customCheckBox2"></label>
                                            </div>
                                        </td> -->
                                        <td style="text-align:center">{{$e->kode_event}}</td>
                                        <td style="text-align:center">{{$e->tgl_event}}</td>
                                        <td>{{$e->open_register}}</td>
                                        <td>{{$e->close_register}}</td>
                                        <td>Rp. {{number_format($e->harga ?? 0,0)}}</td>
                                        <td style="text-align:center">
                                            <a href="{{url('event/edit/'.$e->id)}}" class="btn btn-sm btn-info btn-rounded"><em class="flaticon-381-edit"></em></a>
                                            <a href="{{url('event/hapus/'.$e->id)}}" class="btn btn-sm btn-danger btn-rounded"><em class="flaticon-381-trash"></em></a>
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