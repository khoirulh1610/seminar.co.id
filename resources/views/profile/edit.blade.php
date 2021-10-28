@extends('layouts.index')

@section('main')

<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-2"></div>
            <div class="col-xl-9 col-xxl-8 col-lg-12">
                <div class="row">
                    <form action="{{url('/profile/save')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="col-xl-12">
                        <div class="card profile-card">
                            <div class="card-header flex-wrap border-0 pb-0">
                                <h3 class="fs-24 text-black font-w600 mr-auto mb-2 pr-3">Edit Profile</h3>
                                <div class="d-sm-flex d-block">
                                    <a href="{{url('profile')}}" class="btn btn-dark light btn-rounded mr-3 mb-2">Cancel</a>
                                    <button class="btn btn-primary btn-rounded mb-2" type="submit">Save Changes</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="mb-5">
                                    <div class="title mb-4"><span class="fs-18 text-black font-w600">Generals</span></div>
                                    <div class="row">
                                        <input type="hidden" name="id" id="id" value="{{$edit->id}}">
                                        <div class="col-xl-4 col-sm-6">
                                            <div class="form-group">
                                                <label>Sapaan</label>
                                                <select name="sapaan" id="sapaan" class="form-control">
                                                    <option value="Pak" {{$edit->sapaan== 'Pak' ? 'selected' : ''}}>Pak</option>
                                                    <option value="Bu" {{$edit->sapaan== 'Bu' ? 'selected' : ''}}>Bu</option>
                                                    <option value="Mas" {{$edit->sapaan== 'Mas' ? 'selected' : ''}}>Mas</option>
                                                    <option value="Mbak" {{$edit->sapaan== 'Mbak' ? 'selected' : ''}}>Mbak</option>
                                                    <option value="Bro" {{$edit->sapaan== 'Bro' ? 'selected' : ''}}>Bro</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-sm-6">
                                            <div class="form-group">
                                                <label>Panggilan</label>
                                                <input type="text" class="form-control" name="panggilan" value="{{$edit->panggilan}}" placeholder="Panggilan">
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-sm-6">
                                            <div class="form-group">
                                                <label>Nama</label>
                                                <input type="text" class="form-control" name="nama" value="{{$edit->nama}}" placeholder="Last name">
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-sm-6">
                                            <div class="form-group">
                                                <label>Bank</label>
                                                <input type="text" class="form-control" name="bank" value="{{$edit->bank}}" placeholder="BCA / MANDIRI / BRI">
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-sm-6">
                                            <div class="form-group">
                                                <label>Rek Bank</label>
                                                <input type="text" class="form-control" name="rek_bank" value="{{$edit->rek_bank}}" placeholder="123123123">
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-sm-6">
                                            <div class="form-group">
                                                <label>Brand</label>
                                                <select name="brand" id="brand" class="form-control" {{Auth::user()->role_id<=2 ? '' : 'disabled'}}>
                                                    @foreach($brand as $br)
                                                    <option value="{{$br->brand}}" {{$edit->brand==$br->brand ? 'selected' : ''}}>{{$br->brand}}</option>
                                                    @endforeach
                                                </select>
                                                <!-- <input type="text" class="form-control" name="brand" value="{{$edit->brand}}" placeholder="Type here"> -->
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-sm-6">
                                            <div class="form-group">
                                                <label>Kode Referal</label>
                                                @if(Auth::user()->role_id==1)
                                                    <input type="text" class="form-control" name="referal" value="{{$edit->kode_ref ?? $edit->phone}}" placeholder="kode referral">
                                                @else
                                                    <input type="text" class="form-control" name="referal" value="{{$edit->kode_ref ?? $edit->phone}}" placeholder="kode" readonly>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-sm-6">
                                            <div class="form-group">
                                                <label>Whatsapp</label>
                                                <!-- <div class="input-group input-icon mb-3"> -->
                                                    <!-- <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon2"><i class="fab fa-whatsapp" aria-hidden="true"></i></span>
                                                    </div> -->
                                                    @if(Auth::user()->role_id==1)
                                                        <input type="text" name="phone" class="form-control" value="{{$edit->phone}}" placeholder="Phone no.">
                                                    @else
                                                        <input type="text" name="phone" class="form-control" value="{{$edit->phone}}" placeholder="Phone no." readonly>
                                                    @endif
                                                <!-- </div> -->
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-sm-6">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <!-- <div class="input-group input-icon mb-3"> -->
                                                    <!-- <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon3"><i class="las la-envelope"></i></span>
                                                    </div> -->
                                                    @if(Auth::user()->role_id==1)
                                                    <input type="text" name="email" class="form-control" value="{{$edit->email}}" placeholder="Enter email">
                                                    @else
                                                    <input type="text" name="email" class="form-control" value="{{$edit->email}}" placeholder="Enter email" readonly>
                                                    @endif
                                                <!-- </div> -->
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-sm-6">
                                            <div class="form-group">
                                                <label>Level User</label>
                                                @if(Auth::user()->role_id==1)
                                                <select name="role_id" id="role_id" class="form-control">
                                                    <?php
                                                    $role = App\Models\Role::get();
                                                    foreach ($role as $r) {
                                                        echo '<option value="'.$r->id.'" '.($r->id==$edit->role_id ? "selected" : "" ).'>'.$r->name.'</option>';
                                                    }
                                                    ?>
                                                </select>
                                                @else
                                                    <input type="text" name="role_id" class="form-control" value="{{$edit->role->name}}" readonly>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-sm-6">
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input type="password" class="form-control" name="password" value="" id="">
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-sm-6">
                                            <div class="form-group">
                                                <label>Masukkan Link Foto Profil</label>
                                                <input type="text" class="form-control" name="link" value="{{$edit->foto_profile}}" id="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--**********************************
    Content body end
***********************************-->

@endsection

@section('js')

@endsection
