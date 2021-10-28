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
    <title>{{ENV('APP_NAME','')}}</title>
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
	<link href="{{url('asset/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons')}}" rel="stylesheet">
	<link href="{{url('asset/vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet">
    <link href="{{url('asset/css/style.css')}}" rel="stylesheet">
    <!-- Daterange picker -->
    <link href="{{url('asset/vendor/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">
	<link href="//fonts.googleapis.com/icon?family=Material+Icons" type="text/css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>


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
    <!--*******************
        Preloader end
    ********************-->


    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <a href="{{url('/')}}" class="brand-logo">
				<svg class="logo-abbr" width="66.5px" height="66.5px" xmlns="http://www.w3.org/2000/svg">
				<g>
					<path class="svg-logo-circle" fill-rule="evenodd" d="M32.999,66.000 C14.774,66.000 -0.000,51.225 -0.000,33.000 C-0.000,14.775 14.774,-0.000 32.999,-0.000 C51.225,-0.000 66.000,14.775 66.000,33.000 C66.000,51.225 51.225,66.000 32.999,66.000 Z" style="fill: rgb(220, 53, 69);"/>
				</g>
				<text style="fill: rgb(240, 236, 236); font-family: Arial, sans-serif; font-size: 2.2px; white-space: pre;" transform="matrix(24.352608, 9.17268, -6.999513, 18.58305, -2247.595459, -1306.554077)" x="99.427" y="23.422">S</text>
				</svg>
                    <!-- &nbsp;&nbsp;<h4 style="color:#DC3545;"><b> SEMINAR.CO.ID </b></h4> -->
				<svg class="brand-title" width="150px" height="29.5px" xmlns="http://www.w3.org/2000/svg">
					<text style="fill: rgb(220, 53, 69); font-family: Arial, sans-serif; font-size: 3px; white-space: pre;" x="4.648" y="11.225" transform="matrix(3.571264, 0, 0, 9.579959, -11.932273, -86.044098) " >SEMINAR.CO.ID</text>
				</svg>

            </a>
            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->

		<!--**********************************
            Chat box start
        ***********************************-->
			<!-- @include('layouts.chats'); -->
		<!--**********************************
            Chat box End
        ***********************************-->




        <!--**********************************
            Header start
        ***********************************-->
			@include('layouts.header')
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
            @include('layouts.menu')
        <!--**********************************
            Sidebar end
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
        	@yield('main')
        <!--**********************************
            Content body end
        ***********************************-->


        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
                <p>Copyright ©  <a href="http://mediasaranadigitalindo/" target="_blank">PT. MSD</a> 2021</p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->

        <!--**********************************
           Support ticket button start
        ***********************************-->

        <!--**********************************
           Support ticket button end
        ***********************************-->


    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->

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

	<script src="{{url('asset/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('asset/js/plugins-init/datatables.init.js')}}"></script>
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
