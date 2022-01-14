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
    <link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet">
	<link href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons')}}" rel="stylesheet">
	<link href="{{url('asset/vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet">
    <link href="{{url('asset/css/style.css')}}" rel="stylesheet">
    <!-- Daterange picker -->
    <link href="{{url('asset/vendor/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">
	<link href="//fonts.googleapis.com/icon?family=Material+Icons" type="text/css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <style>
        .bg-ticket {
            background: linear-gradient(
        16deg, rgba(5,2,61,1) 0%, rgb(18 18 183) 35%, rgb(19 189 223) 100%);
        }
    </style>

</head>

<body style="background: #333">
    <div class="row vh-100 justify-content-center align-items-center">
        <div class="col-11 col-md-5 col-lg-4" style="margin-top: -100px; max-width: 380px">
            <div class="bg-ticket text-white rounded-sm shadow-sm border mx-auto">
                <div class="p-3 text-end">
                    <h2 class="w-100 text-white mb-0">{{ $event->tema }}</h2>
                    <div class="w-100">{{ $event->event_title }}</div>
                </div>
                <div class="d-flex justify-content-center flex-column align-items-center">
                    <div class="w-100 text-center">{{ $peserta->nama }}</div>
                    <div class="bg-white rounded-sm p-2">
                        {{ $qrcode }}
                    </div>
                </div>
                <div class="p-3">
                    <h3 class="text-white-50">{{ $event->tgl_event->format('M d, Y | hA') }}</h3>
                    <div class="w-100 d-flex justify-content-between">
                        <small>harga: @if ($event->harga == 0) GRATIS @else @rupiah($event->harga) @endif</small>
                        <small>#{{ str_replace(['08', '628'], '', $peserta->phone) }} </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{url('asset/vendor/global/global.min.js')}}"></script>
    <!-- momment js is must -->
    <script src="{{url('asset/vendor/moment/moment.min.js')}}"></script>

	<!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <script src="{{url('asset/js/plugins-init/datatables.init.js')}}"></script>
    <script src="{{url('asset/js/custom.min.js')}}"></script>
	<script src="{{url('asset/js/deznav-init.js')}}"></script>

</body>
</html>
