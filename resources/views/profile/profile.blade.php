@extends('layouts.index')

@section('main')

<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">

        <div class="row">
            <!-- <div class="col-xl-9 col-xxl-8 col-lg-12">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card profile-card">
                            <div class="card-header flex-wrap border-0 pb-0">
                                <h3 class="fs-24 text-black font-w600 mr-auto mb-2 pr-3">Edit Profile</h3>
                                <div class="d-sm-flex d-block">
                                    <div class="d-flex mr-5 align-items-center mb-2">
                                        <div class="custom-control custom-switch toggle-switch text-right">
                                            <input type="checkbox" class="custom-control-input" id="customSwitch1">
                                            <label class="custom-control-label" for="customSwitch1">Available for hire?</label>
                                        </div>
                                    </div>
                                    <a href="#" class="btn btn-dark light btn-rounded mr-3 mb-2">Cancel</a>
                                    <a class="btn btn-primary btn-rounded mb-2" href="#">Save Changes</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="mb-5">
                                        <div class="title mb-4"><span class="fs-18 text-black font-w600">Generals</span></div>
                                        <div class="row">
                                            <div class="col-xl-4 col-sm-6">
                                                <div class="form-group">
                                                    <label>First Name</label>
                                                    <input type="text" class="form-control" placeholder="Enter name">
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-6">
                                                <div class="form-group">
                                                    <label>Middle Name</label>
                                                    <input type="text" class="form-control" placeholder="Type here">
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-6">
                                                <div class="form-group">
                                                    <label>Last Name</label>
                                                    <input type="text" class="form-control" placeholder="Last name">
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-6">
                                                <div class="form-group">
                                                    <label>Username</label>
                                                    <input type="text" class="form-control" placeholder="User name">
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-6">
                                                <div class="form-group">
                                                    <label>Password</label>
                                                    <input type="password" class="form-control" placeholder="Enter password">
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-6">
                                                <div class="form-group">
                                                    <label>Re-Type Password</label>
                                                    <input type="password" class="form-control" placeholder="Enter password">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-5">
                                        <div class="title mb-4"><span class="fs-18 text-black font-w600">CONTACT</span></div>
                                        <div class="row">
                                            <div class="col-xl-4 col-sm-6">
                                                <div class="form-group">
                                                    <label>MobilePhone</label>
                                                    <div class="input-group input-icon mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1"><i class="fa fa-phone" aria-hidden="true"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control" placeholder="Phone no.">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-6">
                                                <div class="form-group">
                                                    <label>Whatsapp</label>
                                                    <div class="input-group input-icon mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon2"><i class="fa fa-whatsapp" aria-hidden="true"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control" placeholder="Phone no.">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-6">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <div class="input-group input-icon mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="las la-envelope"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control" placeholder="Enter email">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-6">
                                                <div class="form-group">
                                                    <label>Address</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" placeholder="Enter adress">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-6">
                                                <div class="form-group">
                                                    <label>City</label>
                                                    <select class="form-control">
                                                        <option>London</option>
                                                        <option>United State</option>
                                                        <option>United Kingdom</option>
                                                        <option>Germany</option>
                                                        <option>Netherland</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-6">
                                                <div class="form-group">
                                                    <label>Country</label>
                                                    <select class="form-control">
                                                        <option>England</option>
                                                        <option>United State</option>
                                                        <option>United Kingdom</option>
                                                        <option>Germany</option>
                                                        <option>Netherland</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-5">
                                        <div class="title mb-4"><span class="fs-18 text-black font-w600">About me</span></div>
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="form-group">
                                                    <label>Tell About You</label>
                                                    <textarea class="form-control" rows="6">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum que laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta su
                                                    </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="title mb-4"><span class="fs-18 text-black font-w600">Skils</span></div>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="media mb-4">
                                                    <span class="text-primary progress-icon mr-3">78%</span>
                                                    <div class="media-body">
                                                        <p class="font-w500">Programming</p>
                                                        <div class="progress skill-progress" style="height:10px;">
                                                            <div class="progress-bar bg-primary progress-animated" style="width: 78%; height:10px;" role="progressbar">
                                                                <span class="sr-only">78% Complete</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="media mb-4">
                                                    <span class="text-primary progress-icon mr-3">65%</span>
                                                    <div class="media-body">
                                                        <p class="font-w500">Prototyping</p>
                                                        <div class="progress skill-progress" style="height:10px;">
                                                            <div class="progress-bar bg-primary progress-animated" style="width: 65%; height:10px;" role="progressbar">
                                                                <span class="sr-only">65% Complete</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="media mb-4">
                                                    <span class="text-primary progress-icon mr-3">89%</span>
                                                    <div class="media-body">
                                                        <p class="font-w500">UI Design</p>
                                                        <div class="progress skill-progress" style="height:10px;">
                                                            <div class="progress-bar bg-primary progress-animated" style="width: 89%; height:10px;" role="progressbar">
                                                                <span class="sr-only">89% Complete</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="media mb-4">
                                                    <span class="text-primary progress-icon mr-3">94%</span>
                                                    <div class="media-body">
                                                        <p class="font-w500">Researching</p>
                                                        <div class="progress skill-progress" style="height:10px;">
                                                            <div class="progress-bar bg-primary progress-animated" style="width: 94%; height:10px;" role="progressbar">
                                                                <span class="sr-only">94% Complete</span>
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
            </div> -->

            <div class="col-4"></div>
            <div class="col-12 d-block d-sm-none"><br><br> </div>
            <div class="col-xl-3 col-xxl-4 col-lg-12">
                <div class="row">
                    <div class="col-xl-12 col-lg-6">
                    @foreach($profile as $pro)
                        <div class="card  flex-lg-column flex-md-row ">
                            <div class="card-body card-body  text-center border-bottom profile-bx">
                                <h3 >Profile</h3>
                                <div class="profile-image mb-4">
                                    <img src="{{Auth::user()->foto_profile}}" style="" class="rounded-circle" alt="">
                                </div>

                                <h4 class="fs-22 text-black mb-1">{{$pro->nama}}</h4>
                                <p class="mb-4">{{Auth::user()->role->description}}</p>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="border rounded p-2">
                                            <h4 class="fs-22 text-black font-w600">{{$pro->kode_ref ?? $pro->phone}}</h4>
                                            <span class="text-black">Kode Referal</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="border rounded p-2">
                                            <h4 class="fs-22 text-black font-w600">{{$pro->brand}}</h4>
                                            <span class="text-black">Brand</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body  activity-card">
                                <div class="d-flex mb-3 align-items-center">
                                    <a class="contact-icon mr-3" href="#"><i class="fab fa-whatsapp" aria-hidden="true"></i></a>
                                    <span class="text-black">{{$pro->phone}}</span>
                                </div>
                                <div class="d-flex mb-3 align-items-center">
                                    <a class="contact-icon mr-3" href="#"><i class="far fa-envelope"></i></a>
                                    <span class="text-black">{{$pro->email}}</span>
                                </div>
                                <div class="d-flex mb-3 align-items-center">
                                    <a class="contact-icon mr-3" href="#"><i class="fa fa-dollar"></i></a>
                                    <span class="text-black">{{$pro->bank}} - {{$pro->rek_bank}}</span>
                                </div>
                                <div class="d-flex mb-3 align-items-center">
                                    <a class="contact-icon mr-3" href="#"><i class="far fa-building"></i></a>
                                    <span class="text-black">{{$pro->kota}} - {{$pro->provinsi}}</span>
                                </div>
                                <div class="d-flex mb-3 align-items-center">
                                    <a class="contact-icon mr-3" href="#"><i class="fas fa-birthday-cake"></i></a>
                                    <span class="text-black">{{$pro->b_tanggal}} - {{$pro->b_bulan}} - {{$pro->b_tahun}}</span>
                                </div>
                                <center> <a href="{{url('profile/edit')}}" class="btn btn-sm btn-info btn-rounded">Edit Profile</a></center>
                            </div>
                        </div>
                    </div>
                    @endforeach
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
