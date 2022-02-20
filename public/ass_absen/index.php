<!DOCTYPE html>
<html lang="en">
<head>
	<title>KOMI ABSEN</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
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
				<a href="http://wstol.seminar.co.id/absen" class="alert alert-danger">KEMBALI</a>
			</div>
		</div>
	<?php
	}else{
	?>
	<div class="contact1">
		<div class="container-contact1 text-center">
			<div class="contact1-pic js-tilt" data-tilt>
				<img src="images/img-01.png" alt="IMG">
			</div>

			<form class="contact1-form validate-form" action="save.php" method="post">
				<span class="contact1-form-title">
					ABSEN ONLINE KOMI					
				</span>

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
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/tilt/tilt.jquery.min.js"></script>
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
		url : 'https://seminar.co.id/api/absen?kode_event=WSTOL&id='+this.value,
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
