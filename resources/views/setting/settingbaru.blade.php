@extends('layout.index')
@section('main')
<div class="content-body">
    <div class="container-fluid">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Layanan Baru</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <form action="{{url('setting/save')}}" method="post" autocomplete="off" enctype="multipart/form-data">
                        @csrf
                            <div class="form-row" style="color:black">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Api</h4>
                                        </div>
                                        <!-- <div class="card-body"> -->
                                            <div class="basic-form">
                                                <form action="#">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Pilih Device</button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" href="#">Action</a>
                                                                <a class="dropdown-item" href="#">Another action</a>
                                                                <a class="dropdown-item" href="#">Something else here</a>
                                                                <div role="separator" class="dropdown-divider"></div>
                                                                <a class="dropdown-item" href="#">Separated link</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        <!-- </div> -->
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
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
    $('#datetimepicker').datetimepicker({
        format: 'yyyy-mm-dd hh:ii'
    });
</script>

@endsection