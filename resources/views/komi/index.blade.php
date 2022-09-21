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
                        <h4 class="card-title">Data Member Komi</h4>

                        <a href="{{ url('komi/member/export') }}" class="btn btn-sm btn-primary">
                            <i class="fa fa-file-excel"></i>
                            Export
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example5" class="table display table-responsive-lg">
                                <thead>
                                    <tr>
                                        <th style="text-align:center">#</th>
                                        <th style="text-align:center">Nama</th>
                                        <th style="text-align:center">Phone</th>
                                        <th style="text-align:center">Alamat</th>
                                        <th style="text-align:center">Nilai</th>
                                        <th style="text-align:center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($member as $us)
                                    <tr>
                                        <td style="text-align:center">{{$loop->iteration}}</td>
                                        <td style="text-align:center">{{$us->nama}}</td>
                                        <td style="text-align:center">{{$us->phone}} <br><small>{{$us->email}}</small></td>
                                        <td style="text-align:center">{{$us->provinsi}}, {{$us->kota}}</td>
                                        <td style="text-align:center">{{$us->nilai}}</td>
                                        <td style="text-align:center">
                                            @if ($us->approve == 'approved')
                                            <button type="button" disabled class="btn btn-xs btn-success btn-rounded m-1">
                                                Approved
                                            </button>
                                            @else
                                            {{-- <form action="" method="POST" class="d-inline" onsubmit="return confirm('yakin Approve member ini?')">
                                                @csrf --}}
                                                <button type="button" class="btn btn-xs btn-info btn-rounded m-1 btn-approve" data-toggle="modal" data-target="#approve" data-action="{{ url('komi/approve/'.$us->id) }}" data-bayar="{{ $us->nilai }}">
                                                    Approve
                                                </button>
                                            {{-- </form> --}}
                                            @endif
                                            {{-- <a href="{{url('user/delete/'.$us->id)}}" class="btn btn-xs btn-danger btn-rounded m-1"><i class="fa fa-trash">&nbsp;</i>Delete</a> --}}
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
  
    <!-- Modal -->
    <div class="modal fade" id="approve" tabindex="-1" aria-labelledby="approveLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <h5 class="modal-title" id="approveLabel">Approve Member</h5>
                    <form action="" method="POST" class="d-inline" id="form-aprove">
                        @csrf

                        <div class="form-group">
                            <label class="form-control-label" for="bayar-input">Nominal Bayar</label>
                            <input type="tel" id="bayar-input" class="form-control @error('bayar') is-invalid @enderror" name="bayar" value="{{ old('bayar') }}" required autocomplete="bayar">
                            @error('bayar')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-xs btn-info btn-rounded m-1">
                            Approve
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
  
    </div>
</div>
@endsection

@section('js')
<script>
    $('.table').on('click', '.btn-approve', function(e) {
        var btn = $(this)
        var url = btn.attr('data-action');
        var bayar = btn.attr('data-bayar')
        var form = $('#form-aprove');
        form.attr('action', url);
        $('#bayar-input').val(bayar);        
        console.log(url, bayar, btn);
        // alert(url);
    });
</script>
@endsection