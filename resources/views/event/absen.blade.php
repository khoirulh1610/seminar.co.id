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
        :root {
            --sec-t: 150px
        }
        .sec-t {
            height: var(--sec-t);
        }
        .sec-b {
            height: calc(100vh - var(--sec-t));
        }
    </style>

</head>

<body class="vw-100 vh-100 overflow-hidden">
    <section>
        <div class="text-center mt-2 py-2 sec-t">
            <h3 class="text-muted mb-0">{{ $event->tema }}</h3>
            <h4 class="text-muted">{{ $event->event_title }}</h4>
        </div>

        <div class="row justify-content-center sec-b">
            <div class="col-12 col-md-4 d-flex justify-content-center align-items-center flex-column">
                <div class="input-group mb-3 input-primary w-75 mx-auto">
                    <input type="text" id="phone" autofocus placeholder="Nomor Hendphone" class="form-control" aria-describedby="button-addon1">
                    <button class="btn btn-primary" type="button" id="button-addon2">Insert</button>
                </div>
                <div id="qr-reader" class="mx-auto shadow-sm mb-4" style="width: 400px; height: 350px;"></div>
            </div>
            <div class="col-12 col-md-8 h-100">
                {{-- Table --}}
                <div class="bg-white p-1 rounded-top h-100 border shadow-sm position-relative" style="overflow-y: auto; overflow-x: hidden;">
                    <table class="table table-sm">
                        <thead class="position-sticky table-light shadow-sm" style="top: 0; z-index: 5;">
                            <tr>
                                <th>No.</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Masuk</th>
                                <th scope="col">Opsi</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-absen">
                            @include('event.tbody-absen')
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

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

    <script>

        $('#phone').on('keydown', function(event) {
            // Enter insert data
            if (event.keyCode == 13) {
                let phone = $('#phone').val();
                insert(phone)
                $('#phone').val('');
                return false;
            }
        });
        $('#button-addon2').on('click', function(event) {
            let phone = $('#phone').val();
            insert(phone)
        });
        const inputPhone = document.getElementById('phone');
        const tbodyAbsen = document.getElementById('tbody-absen');
        const sfxFail = new Audio("{{ asset('fail.mp3') }}");
        const sfxBeep = new Audio("{{ asset('beep.mp3') }}");
        
        var html5QrcodeScanner = new Html5QrcodeScanner("qr-reader", { 
            fps: 20, 
            qrbox: {
                width: 250, 
                height: 250
            } 
        });
        $(document).ready(function() {
            html5QrcodeScanner.render(onScanSuccess);
        })

        function onScanFailure(error) {
            console.warn(`Code scan error = ${error}`);
            sfxFail.play()
        }
        function onScanSuccess(decodedText) {
            insert(decodedText)
        }
        
        function insert(id) {
            $.ajax({
                url : '{{ url("/event/{$event->kode_event}/absen") }}',
                type : 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    id:id
                },
                success:function(data){
                    data 
                    ? insertHtml(data) 
                    : sfxFail.play()
                }
            })
        }

        function insertHtml(htmlTbody) {
            tbodyAbsen.innerHTML = htmlTbody;
            sfxBeep.play()
        }
        
        setInterval(() => {
            $.ajax({
                url : '{{ url("/event/{$event->kode_event}/absensi") }}',
                type : 'get',
                success:function(data){
                    $('#tbody-absen').html(data);
                }
            })
        }, 1000 * 6);//detik

        function ShowDelete(id) {
            Swal
            .fire({
                title: 'Apakah anda Yakin ?',
                text: "Data yang tekah dihapus tidak dapat dikembalikan !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            })
            .then((result) => {
                if (result.isConfirmed) {
                    $.get('/seminar/offline/delete?id='+id,function(data) {
                        Swal.fire(
                        'Deleted!',
                        data.msg,
                        'success'
                        );
                        load();
                    });  
                        
                }
                
            })
        }
    </script>
</body>
</html>
