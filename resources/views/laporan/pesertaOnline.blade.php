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
                    <div class="card-header">
                        <h4 class="card-title">Semua Peserta</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example5" class="table display table-responsive-lg">
                                <thead>
                                    <tr>
                                        <th style="text-align:center">No</th>
                                        <th style="text-align:center">Kode Event</th>
                                        <th style="text-align:center">Nama</th>
                                        <th style="text-align:center">Nomor Handphone</th>
                                        <th style="text-align:center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($event as $us)
                                    <tr>
                                        <td style="text-align:center">{{ $loop->iteration }}</td>
                                        <td style="text-align:center">{{ $us->seminar->kode_event }}</td>
                                        <td style="text-align:center">{{ $us->seminar->nama }}</td>
                                        <td style="text-align:center">{{ $us->seminar->phone }} <br><small>{{ $us->seminar->email }}</small></td>
                                        <td style="text-align:center">
                                            <a href="{{url('semuaPeserta/remove/'.$us->seminar->id)}}" class="btn btn-xs btn-danger btn-rounded m-1"><i class="fa fa-trash">&nbsp;</i>Delete</a>
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