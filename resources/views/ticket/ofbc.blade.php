<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ticket Seminar STP</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.0/css/bootstrap.min.css' integrity='sha512-XWTTruHZEYJsxV3W/lSXG1n3Q39YIWOstqvmFsdNEEQfHoZ6vm6E9GK2OrF6DSJSpIbRbi+Nn0WDPID9O7xB2Q==' crossorigin='anonymous'/>
    <style>
        .qrcode {
            z-index: 10; 
            width: 72.8%;
            top: 13%;
            border-radius: 25px;
            left: 50%;
            transform: translateX(-50%);
        }

        .name-card {
            bottom: 26%;
            left: 17%;
            right: 17%;
        }
    </style>
</head>
<body style="background-color: #2b3131;">
    <div class="d-flex p-2 w-100 min-vh-100 justify-content-center align-content-center align-items-center">
        <div class="card border rounded position-relative" style="max-width: 360px; max-height: 100vh">
            <img src="{{ $qr }}" class="position-absolute qrcode">
            <img src="{{ url('ticket/pt3.png') }}" alt="ticket background" class="img-fluid w-100">

            <div class="text-white p-2 rounded position-absolute name-card text-center">
                <div class="text-start">
                    <div class="d-flex flex-column mb-2">
                        <span style="margin-bottom: -4px">Nama</span>
                        <h5 class="fw-bold">{{ $peserta->nama }}</h5>
                    </div>
                    <div class="d-flex flex-column mb-2">
                        <span style="margin-bottom: -4px">Nomor</span>
                        <h5 class="fw-bold">{{ $peserta->phone }}</h5>
                    </div>
                </div>
                @if ($absen)
                <h2 class="mt-4">
                    <span class="badge text-bg-success">Sudah Absen</span>
                </h2>
                @endif
            </div>
        </div>
    </div>
</body>
</html>