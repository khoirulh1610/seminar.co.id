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
                        <h4 class="card-title">Peserta Seminar Offline</h4>
                        {{-- <a href="{{ url('exportOnline') }}" class="btn btn-primary btn-sm btn-rounded">Export Data</a> --}}
                        <a class="btn btn-primary btn-sm btn-rounded" data-toggle="modal" data-target="#ModalExport">Export Data</a>
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
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;?>
                                    @foreach($event as $us)
                                        @foreach ($us->seminar as $item)
                                        {{-- @dump($item) --}}
                                            @if ($item != null)
                                            <tr>
                                                <td style="text-align:center">{{ $no++ }}</td>
                                                <td style="text-align:center">{{ $item->kode_event ?? '' }}</td>
                                                <td style="text-align:center">{{ $item->nama ?? '' }}</td>
                                                <td style="text-align:center">{{ $item->phone ?? '' }} <br><small>{{ $item->email ?? '' }}</small></td>										
                                            </tr>        
                                            @endif
                                        @endforeach
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

<form action="{{ url('exportOffline') }}" method="post">
    @csrf
    <div class="modal fade" id="ModalExport">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Export Seminar Offline</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <label for="">Pilih Seminar</label>
                            <select name="kode_event" id="kode_event" class="form-control">
                                @foreach ($event as $item)
                                    <option value="{{ $item->kode_event }}">{{ $item->event_title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-rounded light" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-rounded">Submit</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('js')

@endsection