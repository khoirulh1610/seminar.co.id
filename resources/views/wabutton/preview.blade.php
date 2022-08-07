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
                        <div class="col-6">
                            <h4 class="card-title">Preview Pesan</h4>
                        </div>
                        <div class="col-6">
                            <a href="{{url('button/batal')}}" class="btn btn-danger btn-sm btn-rounded m-1 float-right">Batal</a>
                            <a href="{{url('button/process')}}" class="btn btn-success btn-sm btn-rounded m-1 float-right">Process</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($preview as $pre)
                            <div class="col-xl-6">
                                <div class="card text-white bg-secondary">
                                    <div class="card-header">
                                        <h5 class="card-title text-white">Tujuan : {{$pre->phone}}</h5>
                                        <span>{{$pre->created_at}}</span>
                                    </div>
                                    <div class="card-body mb-0 pt-2">
                                        <div class="row">
                                            <div class="col-12">
                                                <span>{!!nl2br($pre->message)!!}</span>
                                            </div>
                                            <div class="col-4 mt-2">
                                                <span>{{ $pre->btn1 }}</span>
                                            </div>
                                            <div class="col-8 mt-2">
                                                <textarea class="form-control">{{ $pre->reply1 }}</textarea>
                                            </div>
                                            <div class="col-4 mt-2">
                                                <span>{{ $pre->btn2 }}</span>
                                            </div>
                                            <div class="col-8 mt-2">
                                                <textarea class="form-control">{{ $pre->reply2 }}</textarea>
                                            </div>
                                            <div class="col-4 mt-2">
                                                <span>{{ $pre->btn3 }}</span>
                                            </div>
                                            <div class="col-8 mt-2">
                                                <textarea class="form-control">{{ $pre->reply3 }}</textarea>
                                            </div>
                                        </div>
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