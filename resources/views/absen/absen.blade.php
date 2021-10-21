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
                            <table id="example5" class="table display table-responsive-lg">
                                <thead>
                                    <tr>
                                        <!-- <th style="text-align:center">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="checkAll" required="">
                                                <label class="custom-control-label" for="checkAll"></label>
                                            </div>
                                        </th> -->
                                        <th style="text-align:center">Event Id</th>
                                        <th style="text-align:center">Nama</th>
                                        <!-- <th style="text-align:center">Phone</th> -->
                                        <th style="text-align:center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($absen as $abs)
                                    <tr>
                                        <!-- <td style="text-align:center">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheckBox2" required="">
                                                <label class="custom-control-label" for="customCheckBox2"></label>
                                            </div>
                                        </td> -->
                                        <td style="text-align:center">{{$abs->kode_event}}</td>
                                        <td style="text-align:center">{{$abs->nama}} <br><small>{{$abs->phone}}</small></td>
                                        <!-- <td style="text-align:center">{{$abs->phone}}</td> -->
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