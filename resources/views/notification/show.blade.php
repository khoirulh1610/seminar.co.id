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
                        <h4 class="card-title">Notifikasi {!! $notification ? "Update: <small>{$notification->slug}</small>" : 'Baru' !!}</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('notifikasi') }}" method="POST">
                            @csrf
                            
                            <div class="row justify-content-between">
                                <div class="form-group">
                                    <label class="form-control-label" for="device-select">Device Server</label>
                                    <select class="form-select @error('device') is-invalid @enderror" name="device" id="device-select">
                                    @foreach ([3,4] as $device)
                                        <option value="{{ $device }}" {{ ($notifcation->device_id ?? old('device')) == $device }}>{{ $device }}</option>
                                    @endforeach
                                    </select>
                                    @error('device')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <button class="btn btn-primary" type="submit">Simpan</button>
                                </div>
                            </div>

                            @if($notification)
                                <input type="hidden" value="{{ $notification->slug }}" name="name">
                            @else
                            <div class="form-group">
                                <label class="form-control-label" for="name-input">Nama <small>(tidak bisa diupdate)</small></label>
                                <input type="text" id="name-input" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            @endif



                            <div class="form-group">
                                <label class="form-control-label" for="text-input">Copywriting</label>
                                <textarea id="text-input" spellcheck="false" class="form-control @error('text') is-invalid @enderror" name="text" required rows="10" cols="8">{{ $notification->text ?? old('text') }}</textarea>
                                @error('text')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')

@endsection