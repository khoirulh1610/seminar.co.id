<!DOCTYPE html>
<html lang="en">
<head>
	<title></title>
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

	<div class="contact1">
		<div class="container-contact1 text-center row">
			<div class="col-12 col-lg-4 d-none d-lg-block contact1--pic js-tilt" data-tilt>
				<img src="{{url('ass_absen/images/img-01.png')}}" alt="IMG">
			</div>

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
						<input class="input1 form-control text-center" type="text" name="nama" id="nama" placeholder="Nama Lengkap" value="">
						<span class="shadow-input1"></span>
					</div>
					<div class="wrap-input1 col-12 col-lg-6 validate-input" data-validate = "Nomor Whtsapp Wajib diisi">					
						{{-- <label for="">Sapaan</label> --}}
						<select name="sapaan" id="sapaan" class="input1 form-control" required >							
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
						<input class="input1 form-control text-center" type="text" name="panggilan" id="panggilan" placeholder="Nama Panggilan"  value="">
						<span class="shadow-input1"></span>
					</div>
					<div class="wrap-input1 col-12 col-lg-6 validate-input">					
						{{-- <label for="jkel">Jenis Kelamin</label> --}}
						<select name="jkel" id="jkel" class="input1 form-control" required>
							<option selected disabled>Jenis Kelamin</option>
							<option value="Laki-laki">Laki-laki</option>
							<option value="Perempuan">Perempuan</option>
						</select>
						<span class="shadow-input1"></span>
					</div>
					<div class="wrap-input1 col-12 col-lg-6 validate-input" data-validate = "Nomor Whtsapp Wajib diisi">	
						{{-- <label for="">Nomor HP (Terdaftar Whatsapp)</label>				 --}}
						<input class="input1 form-control text-center" type="text" name="phone"  id="phone" placeholder="Nomor HP (Terdaftar Whatsapp" value="" required>
						<span class="shadow-input1"></span>
					</div>									
					<div class="wrap-input1 col-12 col-lg-6 validate-input">					
						<input class="input1 form-control text-center" type="email" name="email"  id="email" placeholder="Email" value="" required>
						<span class="shadow-input1"></span>
					</div>								
					{{-- <div class="wrap-input1 col-12 col-lg-6 validate-input">					
						<input class="input1 form-control text-center" type="no_ktp" name="no_ktp" id="no_ktp" placeholder="Nomor KTP" required >
						<span class="shadow-input1"></span>
					</div> --}}
					<div class="wrap-input1 col-12 col-lg-6 validate-input">					
						<input class="input1 form-control text-center" type="text" name="profesi" id="profesi" placeholder="Profesi / Pekerjaan" required>
						<span class="shadow-input1"></span>
					</div>

					<div class="wrap-input1 col-12 col-lg-6 validate-input">						
						<select name="prov" id="prov_id" class="form-control input1" required data-value="{{ $data->provinsi ?? '' }}">
							<option selected>Provinsi</option>
                                  <?php
                                  $provinsi =   file_get_contents("./data/provinsi.json");
                                  $provinsi = json_decode($provinsi);
                                  foreach ($provinsi as $r) {
                                    echo '<option value="' . $r->id . '">' . $r->name . '</option>';
                                  }
                                  ?>
						</select>
						<span class="shadow-input1"></span>
					</div>
					<div class="wrap-input1 col-12 col-lg-6 validate-input">
						<select name="kota" id="kota_id" class="form-control input1" data-value="{{ $data->kota ?? '' }}">
							<option selected>Kota / Kabupaten</option>
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
						<select name="tgl" id="jkel" class="input1 form-control form-select" required >							
							<option selected disabled>Pilih Tanggal</option>
							@for ($i = 1; $i <= 31; $i++)
							<option value="{{ $i }}">{{ $i }}</option>
							@endfor
						</select>
						<span class="shadow-input1"></span>
					</div>

					<div class="wrap-input1 col-4 validate-input">					
						{{-- <label for="jkel">Tanggal</label> --}}
						<select name="bln" id="jkel" class="input1 form-control" required >							
							<option selected disabled>Bulan</option>
							@for ($i = 1; $i <= 12; $i++)
							<option value="{{ $i }}">{{ $i }}</option>
							@endfor
						</select>
						<span class="shadow-input1"></span>
					</div>
					
					<div class="wrap-input1 col-4 validate-input">					
						{{-- <label for="jkel">Tanggal</label> --}}
						<select name="thn" id="jkel" class="input1 form-control" required >							
							<option selected disabled>Tahun</option>
							@for ($i = 1945; $i <= 2022; $i++)
							<option value="{{ $i }}">{{ $i }}</option>
							@endfor
						</select>
						<span class="shadow-input1"></span>
					</div>
				</div>


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
				<div class="row text-left pl-2">
					<div class="col-12">
						<h6 style="background-color:red;" class="mb-2 font-weight-bold">WAJIB DIBACA</h6>
						<strong>Program Maxwin bukan organisasi sosial yang memberikan sumbangan cuma-cuma.</strong><br>
						<strong>Maxwin akan memberikan hibah property dengan syarat anda TELAH mengerjakan program yang diberikan oleh Maxwin</strong>
						<h6 style="background-color:red;" class="mb-2 font-weight-bold">WAJIB DIBACA</h6>
					</div>
				</div>
				<div class="container-contact1-form-btn mt-2">
					<button class="contact1-form-btn">
						<span>
							Submit
						</span>
					</button>					
				</div>
			</form>
		
			
		</div>
	</div>
	


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
