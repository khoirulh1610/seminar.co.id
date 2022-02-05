<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="seminar.co.id : Ticket Seminar" />
	<meta property="og:title" content="seminar.co.id : Ticket Seminar" />
	<meta property="og:description" content="seminar.co.id : Ticket Seminar" />
	<meta property="og:image" content="{{url('seminar.jpeg')}}" />
	<meta name="format-detection" content="telephone=no">
    <title>Event {{ $event->event_title }}</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{url('asset/images/favicon.png')}}">
	<link href="{{url('asset/vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet">
    <link href="{{url('asset/css/style.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <style>
        .bg-ticket {
            background: linear-gradient(16deg, rgba(5,2,61,1) 0%, rgb(18 18 183) 35%, rgb(19 189 223) 100%);
            position: relative !important;
            overflow: hidden;
        }
        .bg-ticket::before {
            content: 'Ticket';
            position: absolute;
            font-size: 70px;
            font-weight: 500px;
            color: rgba(255, 255, 255, 0.61);
            top: 10%;
            z-index: 1;
            right: -70px;
            transform: rotate(90deg)
        }
        .bg-ticket::after {
            content: 'Ticket';
            position: absolute;
            font-size: 80px;
            font-weight: 500px;
            color: rgba(255, 255, 255, 0.158);
            bottom: 9%;
            z-index: 1;
            left: -70px;
            transform: rotate(-90deg)
        }
    </style>

</head>

<body style="background: #333" class="vw-100 vh-100" style="overflow-x: hidden; overflow-y: auto">
    <div class="row justify-content-center align-items-center">
        <div class="col-11 col-md-5 col-lg-4 mt-4" style="max-width: 420px">
            @if ($peserta)
            <div class="bg-ticket text-white rounded-sm shadow-sm border mx-auto">
                <div class="p-3 text-end">
                    <h2 class="w-100 text-white mb-0">{{ strtoupper($event->tema) }}</h2>
                    <div class="w-100">{{ $event->event_title }}</div>
                </div>
                <div class="d-flex justify-content-center flex-column align-items-center">
                    <div class="w-100 text-center d-none">{{ $peserta->nama }}</div>
                    <div class="bg-white rounded-sm p-2" style="max-width: 300px; z-index: 3">
                        {{ $qrcode }}
                    </div>
                </div>
                <div class="px-3 pb-1 pt-3">
                    <h3 class="text-white-50">{{ $event->tgl_event->format('M d, Y') }} | {{ $event->jadwal }}</h3>
                    <div class="w-100 d-flex justify-content-between">
                        <small>BIAYA : @if ($event->harga == 0) GRATIS @else @rupiah($event->harga) @endif</small>
                        <small>#{{ $peserta->phone }}#</small>
                    </div>
                    <div class="text-center mt-4 border-bottom pb-3">
                        <small class="text-dark">
                            <i class="flaticon-381-location-2"></i>
                            {{ strtoupper($event->lokasi) }}
                        </small>
                    </div>
                    <table class="table table-borderless mx-auto table-sm text-dark">
                        <tbody>
                            <tr>
                                <td>Nama</td>
                                <td>:</td>
                                <td>{{ $peserta->nama }}</td>
                            </tr>
                            <tr>
                                <td>Nomor</td>
                                <td>:</td>
                                <td>{{ $peserta->phone }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td>{{ $peserta->email }}</td>
                            </tr>
                            <tr>
                                <td>Profesi</td>
                                <td>:</td>
                                <td>{{ $peserta->profesi }}</td>
                            </tr>
                            <tr>
                                <td>Kota</td>
                                <td>:</td>
                                <td>{{ $peserta->kota }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @else
                <div class="text-center">
                    <i class="fa fa-warning" style="font-size: 70px"></i>
                </div>
                <h2 class="text-white-50 text-center mt-3">Tiket Tidak Ada</h2>
                <small>Anda belum terdaftar di seminar {{ $event->event_title }}</small>
            @endif
        </div>
    </div>

    <script src="{{url('asset/js/custom.min.js')}}"></script>
	<script src="{{url('asset/js/deznav-init.js')}}"></script>
</body>
</html>
