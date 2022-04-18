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
                                        @foreach ($us->seminar as $item)
                                        {{-- @dump($item) --}}
                                            @if ($item != null)
                                            <tr>
                                                <td style="text-align:center"></td>
                                                <td style="text-align:center">{{ $item->kode_event ?? '' }}</td>
                                                <td style="text-align:center">{{ $item->nama ?? '' }}</td>
                                                <td style="text-align:center">{{ $item->phone ?? '' }} <br><small>{{ $item->email ?? '' }}</small></td>
                                                <td style="text-align:center">
                                                </td>												
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
@endsection

@section('js')

@endsection