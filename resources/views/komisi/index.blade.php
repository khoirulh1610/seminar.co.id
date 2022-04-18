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
                        <h4 class="card-title">Data User</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example5" class="table display table-responsive-lg">
                                <thead>
                                    <tr>
                                        <th style="text-align:center">id</th>
                                        <th style="text-align:center">phone</th>
                                        <th style="text-align:center">ref</th>
                                        <th style="text-align:center">nama_ref</th>
                                        <th style="text-align:center">keterangan</th>
                                        <th style="text-align:center">komisi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($komisi as $us)
                                    <tr>
                                        <td style="text-align:center">{{ $us->id }}</td>
                                        <td style="text-align:center">{{ $us->phone }}</td>
                                        <td style="text-align:center">{{ $us->ref }}</td>
                                        <?php
                                        $cek = DB::table('seminars')->where('phone',$us->ref)->first();
                                        $name =$cek->nama;
                                        ?>
                                        <td style="text-align:center">{{ $name }}</td>
                                        <td style="text-align:center">{{ $us->keterangan }}</td>
                                        <td style="text-align:center">
                                            {{ $us->komisi }}
                                            
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