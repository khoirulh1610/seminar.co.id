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
    <link href="{{url('asset/vendor/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">
    <link href="{{url('asset/vendor/toastr/css/toastr.min.css')}}" rel="stylesheet">
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
        @media screen (max-width: var(--breakpoint-md)) {
            body {
                overflow: hidden !important;
            }
        }
    </style>

</head>

<body class="vw-100 vh-100">
    <section>
        <div class="text-center mt-2 py-2 sec-t">
            <h3 class="text-muted mb-0">{{ $event->tema }}</h3>
            <h4 class="text-muted">{{ $event->event_title }}</h4>
        </div>

        <div class="row justify-content-between sec-b">
            <div class="col-12 col-lg-4 d-flex justify-content-center align-items-center flex-column">
                <div class="row">
                    <div class="col-12 order-3 order-lg-1">
                        <div class="input-group mb-3 input-primary w-75 mx-auto">
                            <input type="text" id="phone" autofocus placeholder="Nomor Hendphone" class="form-control" aria-describedby="button-addon1">
                            <button class="btn btn-primary" type="button" id="button-addon2">Insert</button>
                        </div>
                    </div>
                    <div class="col-12 order-2">
                        <div id="qr-reader" class="mx-auto shadow-sm mb-4" style="width: 400px; height: 350px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-8 h-100">
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
    {{-- <script src="{{url('asset/vendor/moment/moment.min.js')}}"></script> --}}

	{{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> 
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> --}}
    
    <script src="{{ url('asset/vendor/sweetalert2/dist/sweetalert2.min.js') }}"></script>
    <script src="{{ url('asset/vendor/toastr/js/toastr.min.js') }}"></script>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    {{-- <script src="{{url('asset/js/plugins-init/datatables.init.js')}}"></script> --}}
    <script src="{{url('asset/js/custom.min.js')}}"></script>
	<script src="{{url('asset/js/deznav-init.js')}}"></script>

    <script>

        const inputPhone = document.getElementById('phone');
        const tbodyAbsen = document.getElementById('tbody-absen');
        const sfxFail = new Audio("{{ asset('fail.mp3') }}");
        const sfxBeep = new Audio("{{ asset('beep.mp3') }}");

        $('body').on('keyup', function(e) {            
            
            if (e.keyCode == 13) {
                let phone = $('#phone').val();
                insert(phone)
            } else if(e.key >= 0 && e.key <= 9) {                
                if ($('#phone').is(':focus')) {
                    console.log('Lagi Fokus nih');;
                }else{
                    inputPhone.value += e.key
                }
            }
        });
        document.body.addEventListener('keyup', function (e){
        })
        $('#button-addon2').on('click', function(event) {
            let phone = $('#phone').val();
            insert(phone)
        });
        
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
                url : 'https://seminar.co.id/event/{{ $event->kode_event }}/absen',
                type : 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    id:id
                },
                success:function(data){
                    console.log(data);
                    if (typeof data === 'object') {
                        if (data.status === 'sudah-absen') {
                            duplicateInsert(data.phone)
                        } else if (data.status === 'tidak-ada') {
                            failInsert(data.phone)
                        }else{
                            console.log('error mas');
                        }
                    } else {                        
                        insertHtml(data) 
                    }
                },
                error: function (request, status, error) {
                    alert(request.responseText);
                }
            })
        }

        function duplicateInsert(phone) {
            sfxBeep.play()
            toastr.warning(`Nomor ${phone} Sudah terdaftar`, "<strong>Sudah ada</strong>", {
                positionClass: "toast-top-right",
                timeOut: 3000,
                closeButton: !0,
                newestOnTop: true,
                progressBar: true,
                preventDuplicates: false,
                showDuration: "300" ,
                hideDuration: "200",
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut",
                tapToDismiss: false
            })
            inputPhone.value = '';
        }

        function failInsert(phone) {
            sfxFail.play()
            toastr.error(`Nomor ${phone} Tidak terdaftar`, "<strong>Tidak Ada</strong>", {
                positionClass: "toast-top-right",
                timeOut: 4000,
                closeButton: !0,
                newestOnTop: true,
                progressBar: true,
                preventDuplicates: false,
                showDuration: "300" ,
                hideDuration: "200",
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut",
                tapToDismiss: false
            })
            inputPhone.value = '';
        }

        function insertHtml(htmlTbody) {
            inputPhone.value = '';
            tbodyAbsen.innerHTML = htmlTbody;
            toastr.info(` masuk`, "<strong>Berhasil Absen!</strong>", {
                positionClass: "toast-top-right",
                timeOut: 3000,
                closeButton: !0,
                newestOnTop: true,
                progressBar: true,
                preventDuplicates: false,
                showDuration: "300" ,
                hideDuration: "200",
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut",
                tapToDismiss: true
            })
            sfxBeep.play()
        }
        
        setInterval(() => {
            $.ajax({
                url : 'https://seminar.o.id/event/{{$event->kode_event}}/absensi',
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
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            })
            .then((result) => {
                if (result.value) {
                    $.ajax({
                        url : 'https://seminar.co.id/event/{{$event->kode_event}}/absen/'+id,
                        type : 'post',
                        data: {
                            _token: "{{ csrf_token() }}",
                            _method: "delete",
                            id: id
                        },
                        success:function(data){
                            $('#tbody-absen').html(data);
                            Swal.fire('Deleted!', `Berhasil dihapus dari absen`, 'success');
                        }
                    })                        
                }
            })
        }
    </script>
</body>
</html>
