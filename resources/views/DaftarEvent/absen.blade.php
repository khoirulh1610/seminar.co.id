<!DOCTYPE html>
<html lang="en">
<head>
	<title>KOMI ABSEN</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="{{url('ass_absen/images/icons/favicon.ico')}}"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{url('ass_absen/vendor/bootstrap/css/bootstrap.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{url('ass_absen/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{url('ass_absen/vendor/animate/animate.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{url('ass_absen/vendor/css-hamburgers/hamburgers.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{url('ass_absen/vendor/select2/select2.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{url('ass_absen/css/util.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('ass_absen/css/main.css')}}">
<!--===============================================================================================-->
</head>
<body>

<?php

// echo '<h1>MOHON MAAF ABSEN TELAH DITUTUP</h1>';
// exit;
?>
	<?php

	if(isset($_GET['message'])){
	?>		
		<div class="contact1 text-center">
			<div class="alert alert-success" role="alert">
				<?=$_GET['message'];?>
			</div>
			<div class="contact1 text-center">
				<a href="{{url('absen')}}" class="alert alert-danger">KEMBALI</a>
			</div>
		</div>
	<?php
	}else{
	?>
	<div class="contact1">
		<div class="container-contact1 text-center">
			<div class="contact1-pic js-tilt" data-tilt>
				<img src="{{url('ass_absen/images/img-01.png')}}" alt="IMG">
			</div>

			<form class="contact1-form validate-form" action="{{url('absen-save')}}" method="post">
				@csrf
				<span class="contact1-form-title">
					ABSEN {{$event->event_title ?? 'ONLINE KOMI'}}					
				</span>
				<input type="hidden" name="kode_event" value="{{$event->kode_event}}">
				<div class="wrap-input1 validate-input" data-validate = "Nomor Whtsapp Wajib diisi">					
					<input class="input1 text-center" type="text" name="id" id="id" placeholder="Nomor WA / Email">
					<span class="shadow-input1"></span>
				</div>
				<input type="hidden" type="text" name="phone" id="phone" readonly>
				<div id="data" class="d-none">
					<div class="wrap-input1 validate-input">
						<input class="input1 text-center" type="text" name="nama" id="nama" readonly>
						<span class="shadow-input1"></span>
					</div>
					<div class="wrap-input1 validate-input">
						<input class="input1 text-center" type="text" name="email" id="email" readonly>
						<span class="shadow-input1"></span>
					</div>
					<div class="wrap-input1 validate-input">
						<input class="input1 text-center" type="text" name="kota" id="kota" readonly>
						<span class="shadow-input1"></span>
					</div>
				</div>
				<div class="container-contact1-form-btn">
					<button class="contact1-form-btn">
						<span>
							Submit
						</span>
					</button>
					<br>
					<div class="row m-1">
						<a href="https://wa.me/6287711993838?&text=hadir" target="absen" class="contact1-form-btn" style="background-color: coral;"> Absen Lewat Whatsapp</a>
					</div>
				</div>
			</form>
		</div>
	</div>
	<?php } ?>



<!--===============================================================================================-->
	<script src="{{url('ass_absen/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{url('ass_absen/vendor/bootstrap/js/popper.js')}}"></script>
	<script src="{{url('ass_absen/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{url('ass_absen/vendor/select2/select2.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{url('ass_absen/vendor/tilt/tilt.jquery.min.js')}}"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
<script>
$('#id').on('keyup',function(a,b){
	if (this.value.length <= 10) {
		return false;
	}
	$.ajax({
		url : 'https://seminar.co.id/api/absen?kode_event&id='+this.value,
		success: function(d){
			console.log(d);
			if(d.status){
				$('#data').removeClass('d-none');
				$('#data').addClass('d-block');
				$('#nama').val(d.data.nama);
				$('#phone').val(d.data.phone);
				$('#id').val(d.data.phone);
				$('#kota').val(d.data.kota);
				$('#email').val(d.data.email);
			}else{
				$('#data').removeClass('d-block');
				$('#data').addClass('d-none');
			}
		}
	})
});
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-23581568-13');
</script>

<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>
