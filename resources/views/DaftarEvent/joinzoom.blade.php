<!DOCTYPE html>
<html lang="en">
<head>
	<title>KOMI DAFTAR</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="{{url('ass_absen/images/icons/favicon.ico')}}"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
	<style>
    body::before {
      content: attr(data-text);
      position: absolute;
      top: 50%;
      left: 50%;
      font-size: 13rem;
      transform: translate(-50%, -50%);
      color: #eeeded;
      letter-spacing: 10px;
    }
  </style>
</head>
<body class="bg-light" data-text="{{ $event->event_title }}">

  <div class="container py-4">
    <div class="row justify-content-center align-items-center align-content-center" style="min-height: 100vh">
      <div class="col-12 col-sm-7 col-md-6 col-lg-5 text-center">
        <h2 class="text-primary text-center mb-2">
          <strong>{{ $event->event_title }}</strong>
        </h2>
        <h5 class="text-muted mb-4">Bergabung Ke Zoom</h5>
        <div class="card shadow overflow-hidden" style="
          border-radius: 10px; 
          /* box-shadow: 0 5px 10px grey */
          ">
          <img src="{{ $event->flayer }}" class="img-fluid mb-0" alt="flayer">
          <div class="card-body text-center my-0 pt-0 text-muted">
            <h1 class="mb-0 mt-1" id="count">
              <span id="hour">00</span>:<span id="minute">00</span>:<span id="second">00</span>
            </h1>
            <small class="d-block" style="margin-top: -5px" id="text">akan dimulai beberapa saat lagi</small>
            <hr>
            <a href="{{ $seminar->join_zoom }}" id="btn-join" style="font-size: 16px" @class(['btn btn-lg btn-primary py-2 w-100', 'disabled' => true])>Gabung Zoom</a>
          </div>
        </div>
      </div>
    </div>
  </div>


	{{-- <script src="{{url('ass_absen/vendor/bootstrap/js/popper.js')}}"></script> --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
  <script>
    var timer;
    function countDown(date) {
      var now = new Date();
      // now sub 5 second
      // now.setSeconds(now.getSeconds() - 5);
      var event = new Date(date);
      var time = event - now;
      var hour = Math.floor(time / 3600000);
      var minute = Math.floor((time % 3600000) / 60000);
      var second = Math.floor((time % 3600000 % 60000) / 1000);
      if (time < 0) {
        clearInterval(timer);
        hour = 0;
        minute = 0;
        second = 0;
        document.getElementById('btn-join').classList.remove('disabled');
        document.getElementById('text').innerText = 'Silahkan Bergabung ke Zoom';
        return 0;
      }
      document.getElementById('hour').innerHTML = parseTime(hour);
      document.getElementById('minute').innerHTML = parseTime(minute);
      document.getElementById('second').innerHTML = parseTime(second);
    }

    function parseTime(time) {
      if (time < 10) {
        return '0' + time;
      } else {
        return time;
      }
    }

    function countdown(date) {
      var date = new Date(date);
      timer = setInterval(function() {
        countDown(date);
      }, 1000);
    }

    countdown('2022-05-27 15:30:00');
  </script>
</body>
</html>
