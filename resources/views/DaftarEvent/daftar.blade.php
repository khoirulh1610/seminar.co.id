<!DOCTYPE html>
<html lang="en">
<head>
	<title>KOMI DAFTAR</title>
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
	@if(isset($_GET['message']))
		<div class="contact1 text-center">
			<div class="alert alert-success" role="alert">
				<?=$_GET['message'];?>
			</div>
			<div class="contact1 text-center">
				<a href="{{url('absen')}}" class="alert alert-danger">KEMBALI</a>
			</div>
		</div>
	@else
	<div class="contact1">
		<div class="container-contact1 text-center row">
			<div class="col-12 col-lg-4 d-none d-lg-block contact1--pic js-tilt" data-tilt>
				<img src="{{url('ass_absen/images/img-01.png')}}" alt="IMG">
			</div>

			@if ($data === null)
			<form class="col-12 col-lg-8 contact1--form validate-form" action="{{url('daftar')}}">
				@if (session()->has('warning'))
					<div class="alert alert-warning" role="alert">
						{{ session()->get('warning') }}
					</div>
				@endif
				<span class="contact1-form-title">Masukan Nomor Wa</span>
				<input type="text" class="form-control bg-light shadow" name="phone">
				
				<div class="text-center pt-2 mt-4">
					<button class="btn btn-sm btn-success">Lanjutkan</button>
				</div>
				<br>
				<strong>*Apabila tidak bisa mendaftar silahkan hubungi 6287711993838 atau klik <a href="https://wa.me/6287711993838" >disini</a></strong>
			</form>		
			@else
			<form class="col-12 col-lg-8 contact1--form validate-form" action="{{url('daftar')}}" method="post">
				@if (session()->has('success'))
					<div class="alert alert-success" role="alert">
						{{ session()->get('success') }}
					</div>
				@endif
				@error('*')
					<div class="alert alert-danger" role="alert">
						{{ $message }}
					</div>
				@enderror
				@csrf
				<span class="contact1-form-title">
					DAFTAR {{$event->event_title ?? 'ONLINE KOMI'}}					
				</span>
				<input type="hidden" name="reg_absen" value="1">
				<input type="hidden" name="kode_event" value="{{$event->kode_event}}">	

				<div id="data" class="row">
					<div class="wrap-input1 col-12 validate-input">
						{{-- <label for="">Nama</label> --}}
						<input class="input1 form-control text-center" type="text" name="nama" id="nama" placeholder="Nama Lengkap" value="{{ $data->nama ?? '' }}">
						<span class="shadow-input1"></span>
					</div>
					<div class="wrap-input1 col-12 col-lg-6 validate-input" data-validate = "Nomor Whtsapp Wajib diisi">					
						{{-- <label for="">Sapaan</label> --}}
						<select name="sapaan" id="sapaan" class="input1 form-control" required data-value="{{ $data->sapaan ?? '' }}">							
							<option value="">Sapaan</option>
							<option value="Bu">Bu</option>
							<option value="Pak">Pak</option>
							<option value="Mas">Mas</option>
							<option value="Mbak">Mbak</option>
							<option value="Kak">Kak</option>
						</select>
						<span class="shadow-input1"></span>
					</div>		
					<div class="wrap-input1 col-12 col-lg-6 validate-input">
						{{-- <label for="">Nama Panggilan</label> --}}
						<input class="input1 form-control text-center" type="text" name="panggilan" id="panggilan" placeholder="Nama Panggilan"  value="{{ $data->panggilan ?? '' }}">
						<span class="shadow-input1"></span>
					</div>
					<div class="wrap-input1 col-12 col-lg-6 validate-input">					
						{{-- <label for="jkel">Jenis Kelamin</label> --}}
						<select name="jkel" id="jkel" class="input1 form-control" required data-value="{{ $data->gender ?? old('jkel') }}">
							<option selected disabled>Jenis Kelamin</option>
							<option value="Laki-laki">Laki-laki</option>
							<option value="Perempuan">Perempuan</option>
						</select>
						<span class="shadow-input1"></span>
					</div>
					<div class="wrap-input1 col-12 col-lg-6 validate-input" data-validate = "Nomor Whtsapp Wajib diisi">	
						{{-- <label for="">Nomor HP (Terdaftar Whatsapp)</label>				 --}}
						<input class="input1 form-control text-center" type="text" name="phone" readonly id="phone" placeholder="Nomor HP (Terdaftar Whatsapp" value="{{ $data->phone ?? '' }}" required>
						<span class="shadow-input1"></span>
					</div>									
					<div class="wrap-input1 col-12 col-lg-6 validate-input">					
						<input class="input1 form-control text-center" type="email" name="email" readonly id="email" placeholder="Email" value="{{ $data->email ?? '' }}" required>
						<span class="shadow-input1"></span>
					</div>								
					{{-- <div class="wrap-input1 col-12 col-lg-6 validate-input">					
						<input class="input1 form-control text-center" type="no_ktp" name="no_ktp" id="no_ktp" placeholder="Nomor KTP" required value={{ old('no_ktp') }}>
						<span class="shadow-input1"></span>
					</div> --}}
					<div class="wrap-input1 col-12 col-lg-6 validate-input">					
						<input class="input1 form-control text-center" type="text" name="profesi" id="profesi" placeholder="Profesi / Pekerjaan" value="{{ $data->profesi ?? '' }}" required>
						<span class="shadow-input1"></span>
					</div>

					<div class="wrap-input1 col-12 col-lg-6 validate-input">						
						<select name="prov" id="prov_id" class="form-control input1" required data-value="{{ $data->provinsi ?? '' }}">
							<option disabled selected>Provinsi</option>
							@foreach ($provinsi as $item)
							<option value="{{ $item->name }}">{{ $item->name }}</option>
							@endforeach
						</select>
						<span class="shadow-input1"></span>
					</div>
					<div class="wrap-input1 col-12 col-lg-6 validate-input">
						<select name="kota" id="kota_id" class="form-control input1" required data-value="{{ $data->kota ?? '' }}">
							<option disabled selected>Kota / Kabupaten</option>
							@foreach ($kota as $item)
								<option value="{{ $item->full_name }}">{{ $item->full_name }}</option>
							@endforeach
						</select>
						<span class="shadow-input1"></span>
					</div>
					<div class="wrap-input1 col-12 validate-input">
						<textarea name="alamat" class="form-control input1" id="alamat" placeholder="Alamat" required cols="30" rows="10">{{ old('alamat') }}</textarea>
						<span class="shadow-input1"></span>
					</div>

					<div class="col-12 text-left">
						<h6 class="mb-2 font-weight-bold">Tanggal Lahir</h6>
					</div>
					<div class="wrap-input1 col-4 validate-input">					
						{{-- <label for="jkel">Tanggal</label> --}}
						<select name="tgl" id="jkel" class="input1 form-control form-select" required data-value="{{ $data->b_tanggal ?? '' }}">							
							<option selected disabled>Pilih Tanggal</option>
							@for ($i = 1; $i <= 31; $i++)
							<option value="{{ $i }}">{{ $i }}</option>
							@endfor
						</select>
						<span class="shadow-input1"></span>
					</div>

					<div class="wrap-input1 col-4 validate-input">					
						{{-- <label for="jkel">Tanggal</label> --}}
						<select name="bln" id="jkel" class="input1 form-control" required data-value="{{ $data->b_bulan ?? '' }}">							
							<option selected disabled>Bulan</option>
							@for ($i = 1; $i <= 12; $i++)
							<option value="{{ $i }}">{{ $i }}</option>
							@endfor
						</select>
						<span class="shadow-input1"></span>
					</div>
					
					<div class="wrap-input1 col-4 validate-input">					
						{{-- <label for="jkel">Tanggal</label> --}}
						<select name="thn" id="" class="form-control" required>
							<option selected disabled>Tahun</option>
							<?php
							for ($i = 12; $i <= 100; $i++) {
								echo '<option value='.(Date('Y') - $i).'>'.(Date('Y') - $i).'</option>';
							}
							?>
						</select>
						{{-- <select name="thn" id="jkel" class="input1 form-control" required data-value="{{ $data->b_tahun ?? '' }}">							
							<option selected disabled>Tahun</option>
							@for ($i = 1945; $i <= 2022; $i++)
							<option value="{{ $i }}">{{ $i }}</option>
							@endfor
						</select> --}}
						<span class="shadow-input1"></span>
					</div>
				</div>

				@if($produk=='maxwin')
				<div class="row text-left pl-2">
					<div class="col-12">
						<h6 class="mb-2 font-weight-bold">APA YANG ANDA INGINKAN DARI PROGRAM MAXWIN :</h6>
					</div>
					@foreach ($list as $l)
					<div class="col-11">
						<div class="form-check">
							<input type="checkbox" name="list[]" value="{{ $l->value }}" class="form-check-input" id="list{{ $loop->iteration }}">
							<label class="form-check-label" for="list{{ $loop->iteration }}">{{ $l->value }}</label>
						</div>
					</div>
					@endforeach
					
				</div>
						<BR>
				<div class="row text-left pl-2">
					<div class="col-12">
						<h6 style="background-color:rgb(58, 5, 5);" class="mb-2 font-weight-bold">WAJIB DIBACA</h6>
						<strong>Program Maxwin bukan organisasi sosial yang memberikan sumbangan cuma-cuma.</strong><br>
						<strong>Maxwin akan memberikan hibah property dengan syarat anda TELAH mengerjakan program yang diberikan oleh Maxwin</strong>
						<h6 style="background-color:rgb(66, 13, 13);" class="mb-2 font-weight-bold">WAJIB DIBACA</h6>
					</div>
				</div>
				@endif
				@if ($produk=='tp')
					<div class="col-sm-12 text-left">
						<h6 class="mb-2 font-weight-bold">Pilihan Paket</h6>
						<div class="form-check">
							<input type="radio" name="paket" value="PLATINUM" class="form-check-input" id="paket_paltinum">
							<label class="form-check-label" for="paket_paltinum">INVESTASI PLATINUM Rp 25,000,000 (Promo Rp. 9.998.000)</label>
							<div class="p-4">
								<p><i class="fa fa-check-square"></i> DISKON KHUSUS 5 PENDAFTAR HARI INI & BONUS DAHSYAT PROMO PAKET GOLD HANYA Rp 9,998,000,-!!</p>
								<p><i class="fa fa-check-square"></i> Mentoring selama 6 bulan, anda boleh mentoring exclusive tanya jawab & bisa langsung praktek lapangan!</p>
								<p><i class="fa fa-check-square"></i> 80++ Paket lengkap dokumen surat perjanjian properti senilai Rp. 58,850,000,-</p>
								<p><i class="fa fa-check-square"></i> Diskusi masuk group khusus GOLD exclusive diskusi Whatsapp & Networking setelah Workshop</p>
								<p><i class="fa fa-check-square"></i> Masuk komunitas ternak properti se-Indonesia</p>
								<p><i class="fa fa-check-square"></i> Coaching Private One By One</p>
								<p><i class="fa fa-check-square"></i> Pendampingan Survey & kordinasi Properti 2 Hari 1 Malam (* Diluar akomodasi)</p>
								<p><i class="fa fa-check-square"></i> Mendapatkan record zoom selama 6 bulan</p>
							</div>
						</div>
						<div class="form-check">
							<input type="radio" name="paket" value="GOLD" class="form-check-input" id="jkel1">
							<label class="form-check-label" for="jkel1">INVESTASI GOLD Rp 9,898,000 (Promo Rp. 4.898.000)</label>
							<div class="p-4">
								<p><i class="fa fa-check-square"></i> DISKON KHUSUS 5 PENDAFTAR HARI INI & BONUS DAHSYAT PROMO PAKET GOLD HANYA Rp 4,898,000,-!!</p>
								<p><i class="fa fa-check-square"></i> Mentoring selama 6 bulan, anda boleh mentoring exclusive tanya jawab & bisa langsung praktek lapangan!</p>
								<p><i class="fa fa-check-square"></i> 80++ Paket lengkap dokumen surat perjanjian properti senilai Rp. 58,850,000,-</p>
								<p><i class="fa fa-check-square"></i> Diskusi masuk group khusus GOLD exclusive diskusi Whatsapp & Networking setelah Workshop</p>
								<p><i class="fa fa-check-square"></i> Masuk komunitas ternak properti se-Indonesia</p>
							</div>
						</div>
						<div class="form-check">
							<input type="radio" name="paket" value="SILVER" class="form-check-input" id="jkel2">
							<label class="form-check-label" for="jkel2">PROMO SILVER HANYA Rp 1,250,000,-</label>
							<ul class="m-4 pt-0">
								<p><i class="fa fa-check-square"></i> Mentoring selama 1 bulan, anda boleh mentoring exclusive tanya jawab & bisa langsung praktek lapangan!</p>
								<p><i class="fa fa-check-square"></i> Bonus 3 surat perjanjian Dokumen Properti, Pembelian lahan bertahap, Kaveling, Surat Kuasa Menjual Senilai Rp 1,500,000,-</p>
							</ul>
						</div>
						<div class="form-check d-none">
							<input type="radio" name="paket" value="REKAMAN" class="form-check-input" id="jkel2">
							<label class="form-check-label" for="jkel2">REKAMAN WEBINAR Rp. 197.000-</label>							
						</div>
					</div>
				@endif
				<div class="container-contact1-form-btn mt-2">
					<button class="contact1-form-btn">
						<span>
							Submit
						</span>
					</button>					
				</div>


			</form>
			@endif
			
		</div>
	</div>
	@endif



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
$('#prov_id').change(function(){
	$.ajax({
		"url" : "{{asset('kabupaten')}}",
		"data" : {id:this.value,type:'option'},
		"type" : "get",
		"success":function(data){                
			$('#kota_id').html(data);
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

	<script>
		$('select').each((index, el) => {
			if(el.dataset.value) {
				el.value = el.dataset.value
			}
		})
	</script>

	<!-- maksimal select -->

	<script>

$('input[type=checkbox]').on('change', function (e) {
    if ($('input[type=checkbox]:checked').length > 2) {
        $(this).prop('checked', false);
        alert("Maksimal 2 Pilihan");
    }
});

	</script>

</body>
</html>
