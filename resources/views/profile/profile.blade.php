@extends('layouts.index')

@section('main')

<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">

        <div class="row">
            <div class="col-3"></div>
            <div class="col-12 d-block d-sm-none"><br><br> </div>
            <div class="col-xl-6 col-xxl-6 col-lg-12">
                <div class="row">
                    <div class="col-xl-12 col-lg-6">
                        <div class="card  flex-lg-column flex-md-row ">
                            <div class="card-body card-body  text-center border-bottom profile-bx">
                                <h3 >Profile</h3>
                                <div class="profile-image mb-4" style="width:100%">
                                    @if (Auth::user()->foto_profile)
                                        <img src="{{Auth::user()->foto_profile}}" style="width:20%" class="rounded-circle" alt="">
                                    @else
                                        <img src="https://hmsai.geografi.ugm.ac.id/wp-content/uploads/sites/228/2021/08/profile.jpg" style="width:25%" class="rounded-circle" alt="">
                                    @endif
                                </div>

                                <h4 class="fs-22 text-black mb-1">{{Auth::user()->nama}}</h4>
                                <p class="mb-4">{{Auth::user()->role->description}}</p>
                                <!-- <div class="row">
                                    <div class="col-6">
                                        <div class="border rounded p-2">
                                            <h4 class="fs-22 text-black font-w600">{{Auth::user()->kode_ref ?? Auth::user()->phone}}</h4>
                                            <span class="text-black">Kode Referal</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="border rounded p-2">
                                            <h4 class="fs-22 text-black font-w600">{{Auth::user()->brand}}</h4>
                                            <span class="text-black">Brand</span>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                            <div class="card-body  activity-card">
                                <div class="d-flex mb-3 align-items-center">
                                    <a class="contact-icon mr-3" href="#"><i class="fab fa-whatsapp" aria-hidden="true"></i></a>
                                    <span class="text-black">{{Auth::user()->phone}}</span>
                                </div>
                                <div class="d-flex mb-3 align-items-center">
                                    <a class="contact-icon mr-3" href="#"><i class="far fa-envelope"></i></a>
                                    <span class="text-black">{{Auth::user()->email}}</span>
                                </div>
                                <div class="d-flex mb-3 align-items-center">
                                    <a class="contact-icon mr-3" href="#"><i class="fa fa-dollar"></i></a>
                                    <span class="text-black">{{Auth::user()->bank}} - {{Auth::user()->rek_bank}}</span>
                                </div>
                                <div class="d-flex mb-3 align-items-center">
                                    <a class="contact-icon mr-3" href="#"><i class="far fa-building"></i></a>
                                    <span class="text-black">{{Auth::user()->kota}} - {{Auth::user()->provinsi}}</span>
                                </div>

                                <div class="d-flex mb-3 align-items-center">
                                    <a class="contact-icon mr-3" href="#"><i class="fas fa-birthday-cake"></i></a>
                                    <span class="text-black">{{Auth::user()->b_tanggal}} - {{Auth::user()->b_bulan}} - {{Auth::user()->b_tahun}}</span>
                                </div>
                                {{-- @foreach($brand as $b)
                                <div class="d-flex mb-3 align-items-center" style="color:black">
                                    <img src="{{$b->icon}}" alt="" class="contact-icon mr-3" style="width:3%">
                                    <!-- <img href="{{$b->icon}}" class="contact-icon mr-3"></a> -->
                                    <label for="">{{$b->brand}} :
                                    <a href="{{$b->link}}?ref={{Auth::user()->kode_ref ?? Auth::user()->phone}}">{{$b->link}}?ref={{Auth::user()->kode_ref ?? Auth::user()->phone}}</a> </label>
                                </div>
                                @endforeach <br><br> --}}
                                <center> <a href="{{url('profile/edit')}}" class="btn btn-sm btn-info btn-rounded">Edit Profile</a></center>
                            </div>
                        </div>
                    </div>
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
