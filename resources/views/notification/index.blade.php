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
                        <h4 class="card-title">Notifikasi</h4>
                        <a href="{{ url('/notifikasi/save') }}" class="btn btn-primary btn-sm btn-rounded">
                            <i class="fa fa-plus"></i>
                            Baru
                        </a>
                    </div>
                    <div class="card-body">
                        @if (session()->has('success'))
                            <div class="alert alert-success">
                                {{ session()->get('success') }}
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table id="example5" class="table display table-responsive-lg">
                                <thead>
                                    <tr>
                                        <th style="text-align:center">No</th>
                                        <th style="text-align:center">Nama</th>
                                        <th style="text-align:center">Device Server</th>
                                        <th style="text-align:center">Copywriting</th>
                                        <th style="text-align:center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($notifications as $notif)
                                    <tr>
                                        <td style="text-align:center">{{$loop->iteration}}</td>
                                        <td style="text-align:center">{{$notif->slug}}</td>
                                        <td style="text-align:center">{{$notif->device_id}}</td>
                                        <td style="text-align:center" class="text-truncate" title="{{ $notif->text }}">
                                            {{ Str::limit($notif->text, 40) }}
                                        </td>
                                        <td style="text-align:center">
                                            <div class="btn-group">
                                                <a href="{{ url("notifikasi/save/{$notif->id}") }}" class="btn btn-xs btn-info" style="border-radius: 10px 0 0 10px;"><i class="fa fa-list"></i>&nbsp; Edit</a>
                                                <form action="{{ url('notifikasi/'.$notif->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Jika Notifikasi ini masih digunakan, akan menyebabkan error saat pemanggilan notifikasi. Tetap Hapus?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-xs btn-danger" style="border-radius: 0 10px 10px 0;">
                                                        <i class="fa fa-trash"></i>&nbsp; Delete
                                                    </button>
                                                </form>
                                            </div>
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