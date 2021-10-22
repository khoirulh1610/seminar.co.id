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
                        <h4 class="card-title">Preview Pesan</h4>
                        <a href="{{url('kirimpesan/process')}}" class="btn btn-success btn-sm btn-rounded m-1">Process</a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($preview as $pre)
                            <div class="col-xl-6">
                                <div class="card text-white bg-secondary">
                                    <div class="card-header">
                                        <h5 class="card-title text-white">Tujuan : {{$pre->phone}}</h5>
                                    </div>
                                    <div class="card-body mb-0">
                                        <p class="card-text">{{nl2br($pre->message)}}</a>
                                    </div>
                                    <div class="card-footer bg-transparent border-0 text-white">{{$pre->created_at}}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="d-flex justify-content-center">
                                {!!$preview->links()!!}
                            </div>
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