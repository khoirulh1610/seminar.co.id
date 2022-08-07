<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tiket Seminar {{ $event->event_title }}</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400&display=swap" rel="stylesheet"> 
  <style>
    * {
      padding: 0;
      margin: 0;
      box-sizing: border-box;
      --size-qrcode: 292px;
      --w-card: 350px;
      font-family: 'Poppins', sans-serif;
      font-weight: 300;
    }
    html {
      background: #017649;
    }
    body {
      padding: 0;
      background: linear-gradient(0deg, rgb(1, 118, 73) 11%, rgb(1, 0, 5) 90%);
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background-repeat: no-repeat;
    }
    .wrraper {
      padding: 0;
      position: relative;
      margin-left: 55px;
    }
    .wrraper::before {
      content: '';
      background-image: url('{!! $qr !!}');
      position: absolute;
      left: 50%;
      transform: translateX(calc(var(--size-qrcode) / 2 * -1));
      top: 14%;
      width: var(--size-qrcode);
      height: var(--size-qrcode);
      background-repeat: no-repeat;
      border-radius: 18px;
      background-size: contain;
    }
    .wrraper .card {
      padding: 2px;
      position: absolute;
      top: 55%;
      left: 50%;
      width: var(--w-card);
      transform: translateX(calc(var(--w-card) / 2 * -1));
    }
    .wrraper .card {
      color: #fff;
    }
    h3 {
      font-weight: 400;
      margin-top: -5px;
    }
    .col {
      margin-bottom: 8px;
    }
    img.qr-map {
      width: 100px;
      background-color: #fff;
      margin-right: 10px;
    }
    .wrraper.belum-lunas::after {
      content: 'Belum Lunas';
      position: absolute;
      top: 32%;
      width: 100vh;
      background-color: rgb(240, 37, 37);
      transform: rotate(45deg);
      padding: 10px 20px;
      color: #fff;
      font-size: 36px;
      text-align: center;
      left: -140px;
    }
  </style>
</head>
<body>
  <div class="wrraper">
    <img class="ticket" src="/ticket/crm.png" alt="ticket">
    <div class="card">
      <div class="col">
        <small>Nama</small>
        <h3>{{ $peserta->nama }}</h3>
      </div>
      <div class="col">
        <small>Phone</small>
        <h3>{{ $peserta->phone }}</h3>
      </div>
      <div class="col">
        <small>Lokasi</small>
        <div style="display: flex;">
          <img class="qr-map" src="https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=https://goo.gl/maps/MPwVGBGrDYLq3VvR6" alt="">
          <div>
            <strong>{{ $event->lokasi }}</s>
            <small style="display: block; font-size: 12px; color: #fff; padding: 7px; background-color: rgba(10, 46, 2, .5);
            border-radius: 7px;">Jl. Adi Sucipto No.56B, Gatak, Gajahan, Kec. Colomadu, Kabupaten Karanganyar, Jawa Tengah 57176</small>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>