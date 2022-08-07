<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="" />
	<meta name="author" content="" />
	<meta name="robots" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="seminar.co.id : Portal Event Terlengkap" />
	<meta property="og:title" content="seminar.co.id : Portal Event Terlengkap" />
	<meta property="og:description" content="seminar.co.id : Portal Event Terlengkap" />
	<meta property="og:image" content="{{url('seminar.jpeg')}}" />
	<meta name="format-detection" content="telephone=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SEMINAR.CO.ID</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{url('asset/images/favicon.png')}}">
	<link href="{{url('asset/vendor/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">
    <!-- Clockpicker -->
    <link href="{{url('asset/vendor/clockpicker/css/bootstrap-clockpicker.min.css')}}" rel="stylesheet">
    <!-- asColorpicker -->
    <link href="{{url('asset/vendor/jquery-asColorPicker/css/asColorPicker.min.css')}}" rel="stylesheet">
    <!-- Material color picker -->
    <link href="{{url('asset/vendor/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet">
    <!-- Pick date -->
    <link rel="stylesheet" href="{{url('asset/vendor/pickadate/themes/default.css')}}">
    <link rel="stylesheet" href="{{url('asset/vendor/pickadate/themes/default.date.css')}}">
    <link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet">
	<link href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons')}}" rel="stylesheet">
	<link href="{{url('asset/vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet">
    <link href="{{url('asset/css/style.css')}}" rel="stylesheet">
    <!-- Daterange picker -->
    <link href="{{url('asset/vendor/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">
	{{-- <link href="//fonts.googleapis.com/icon?family=Material+Icons" Content-Type="text/css"> --}}
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

</head>

<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>




            <div class="body">
    <!-- <header>
      <nav class="navbar navbar-expand-md navbar center" style="background:black;">

        <a href="{{url('/')}}" class="brand-logo">
                <img src="{{ asset('logo_seminar.png') }}" alt="" srcset="" width="120px" height="120px" style="background-color: rgb(24, 24, 13)">
				{{-- <svg class="logo-abbr" width="100px" height="100px" xmlns="http://www.w3.org/2000/svg">
				<g>
					<path class="svg-logo-circle" fill-rule="evenodd" d="M32.999,66.000 C14.774,66.000 -0.000,51.225 -0.000,33.000 C-0.000,14.775 14.774,-0.000 32.999,-0.000 C51.225,-0.000 66.000,14.775 66.000,33.000 C66.000,51.225 51.225,66.000 32.999,66.000 Z" style="fill: rgb(220, 53, 69);"/>
				</g>
				<text style="fill: rgb(240, 236, 236); font-family: Arial, sans-serif; font-size: 2.2px; white-space: pre;" transform="matrix(24.352608, 9.17268, -6.999513, 18.58305, -2247.595459, -1306.554077)" x="99.427" y="23.422">S</text>
				</svg> --}}
                    <!-- &nbsp;&nbsp;<h4 style="color:#DC3545;"><b> SEMINAR.CO.ID </b></h4> -->
				{{-- <svg class="brand-title" width="150px" height="29.5px" xmlns="http://www.w3.org/2000/svg">
					<text style="fill: rgb(220, 53, 69); font-family: Arial, sans-serif; font-size: 3px; white-space: pre;" x="4.648" y="11.225" transform="matrix(3.571264, 0, 0, 9.579959, -11.932273, -86.044098) " >SEMINAR.CO.ID</text>
				</svg> --}}

            </a>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav mr-auto">

          </ul>
          <form class="form-inline mt-2 mt-md-0">
            <!-- <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search"> -->
            <!-- <a class="btn btn-outline-success my-2 my-sm-0" href="/login">Login</a> -->
          </form>
        </div>
      </nav>
    </header> 

<br><br>

<div>
    <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center" style="background-image: url('back.jpg');">
      <div class="col-md-5 p-lg-5 mx-auto my-5">
      <img src="{{ asset('logos.png') }}" alt="" srcset="" width="120px" height="120px" >
        <h1 style="color:white;">Seminar.co.id</h1>
        <p class="lead font-weight-normal" style="color:white;">Portal Event Terbaik dan Terlengkap</p>
        <a class="btn btn-outline-success my-2 my-sm-0" href="/login">Login</a>
        <!-- <a class="btn btn-outline-secondary" href="wa.me/">Daftar</a> -->

      </div>
      <div class="product-device shadow-sm d-none d-md-block"></div>
      <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
    </div>

</div>
<br>
<center>
<h1 style="color:black;">Sistem Manajemen Event</h1>
                </center><br>
<div class="container-fluid">
  <div class="row">
    <div class="col-sm">
    <div class="card">
    <div class="card-body">
    <i class="fa fa-lg fa-check-square text-black" aria-hidden="true"></i>
    <h4>
    Undangan secara Digital
                </h4>  
    </div>
      </div>
    </div>
    <div class="col-sm">

    <div class="card">
    <div class="card-body">
    <i class="fa fa-lg fa-check-square text-black" aria-hidden="true"></i>
    Pembuatan Landingpage dan pendaftaran event
      </div>
      </div>
    </div>
    <div class="col-sm">
    <div class="card">
    <div class="card-body">
    <i class="fa fa-lg fa-check-square text-black" aria-hidden="true"></i>
    Manajemen dan follow up Peserta event
      </div>
      </div>

    </div>

  </div>
</div>
<div class="container-fluid">
  <div class="row">

    <div class="col-sm">
    <div class="card">
    <div class="card-body">
    <i class="fa fa-lg fa-check-square text-black" aria-hidden="true"></i>
    Undangan event ter-affiliasi (Peserta bisa merefrensikan)
      </div>
      </div>

    </div>
    <div class="col-sm">
    <div class="card">
    <div class="card-body">
    <i class="fa fa-lg fa-check-square text-black" aria-hidden="true"></i>
    Ticketing System (Pengadaan Tiket event online dan offline secure digital)
      </div>
      </div>

    </div>
    <div class="col-sm">

    <div class="card">
    <div class="card-body">
    <i class="fa fa-lg fa-check-square text-black" aria-hidden="true"></i>
    Sertifikat DIgital 
      </div>
      </div>
    </div>
  </div>
</div>
<br>

            
                    <div class="container-fluid">
                        <!-- <div class="page-titles">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Event</a></li>
                                <li class="breadcrumb-item active"><a href="javascript:void(0)">Data</a></li>
                            </ol>
                        </div> -->
                        <div class="row">
                            @foreach($event as $ev)
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row m-b-30">
                                            <div class="col-md-5 col-lg-12">
                                                <div class="new-arrival-product mb-4 mb-lg-4 mb-md-0">
                                                    <div class="new-arrivals-img-contnent">
                                                        <br><img class="img-fluid" src="{{$ev->flayer ?? url('asset/images/product/7.jpg')}}" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-lg-12">
                                                <div class="new-arrival-content position-relative">
                                                    <h4><a href="#">{{$ev->event_title}}</a></h4>


                                                    </center>
                                                    <div id="demo{{ $ev->id }}" class="collapse text-content">{!!nl2br($ev->event_detail)!!}</div>                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach            
                        </div>
                    </div>
                </div>



        <div class="footer">
            <div class="copyright">
                <p>CP Hubungi : <a href="https://wa.me/6281215384432"> 6281215384432</a> </p> <p>Copyright ©  <a href="http://mediasaranadigitalindo.com/" target="_blank">PT. MSD</a> 2021</p>
            </div>
        </div>


    <script src="{{url('asset/vendor/global/global.min.js')}}"></script>
	<script src="{{url('asset/vendor/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>


    <script src="{{url('asset/vendor/highlightjs/highlight.pack.min.js')}}"></script>
    <!-- Circle progress -->

    <!-- Daterangepicker -->
    <!-- momment js is must -->
    <script src="{{url('asset/vendor/moment/moment.min.js')}}"></script>
    <script src="{{url('asset/vendor/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <!-- clockpicker -->
    <script src="{{url('asset/vendor/clockpicker/js/bootstrap-clockpicker.min.js')}}"></script>
    <!-- asColorPicker -->
    <script src="{{url('asset/vendor/jquery-asColor/jquery-asColor.min.js')}}"></script>
    <script src="{{url('asset/vendor/jquery-asGradient/jquery-asGradient.min.js')}}"></script>
    <script src="{{url('asset/vendor/jquery-asColorPicker/js/jquery-asColorPicker.min.js')}}"></script>
    <!-- Material color picker -->
    <script src="{{url('asset/vendor/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
    <!-- pickdate -->
    <script src="{{url('asset/vendor/pickadate/picker.js')}}"></script>
    <script src="{{url('asset/vendor/pickadate/picker.time.js')}}"></script>
    <script src="{{url('asset/vendor/pickadate/picker.date.js')}}"></script>



    <!-- Daterangepicker -->
    <script src="{{url('asset/js/plugins-init/bs-daterange-picker-init.js')}}"></script>
    <!-- Clockpicker init -->
    <script src="{{url('asset/js/plugins-init/clock-picker-init.js')}}"></script>
    <!-- asColorPicker init -->
    <script src="{{url('asset/js/plugins-init/jquery-asColorPicker.init.js')}}"></script>
    <!-- Material color picker init -->
    <script src="{{url('asset/js/plugins-init/material-date-picker-init.js')}}"></script>
    <!-- Pickdate -->
    <script src="{{url('asset/js/plugins-init/pickadate-init.js')}}"></script>

	<!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="{{url('asset/js/plugins-init/datatables.init.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.14/dist/sweetalert2.all.min.js"></script>
    <!-- pusher -->
    <!-- <script src="https://js.pusher.com/7.0/pusher.min.js"></script> -->
    <script src="{{url('asset/js/custom.min.js')}}"></script>
	<script src="{{url('asset/js/deznav-init.js')}}"></script>
    <!-- CK Editor -->
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

    @include('layouts.fcm')
    @yield('js')



</body>

</html>
