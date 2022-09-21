<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>RANGKING</title>
  </head>
  <body>
	<div class="col-sm-12 text-center">
		<h1>Rangking Undangan {{ $event->event_title }}</h1>
		<h5>Tanggal Seminar : {{ Date('d/m/Y H:i',strtotime($event->tgl_event)) }}</h5>
		<h5>Tanggal Update : {{ Date('d/m/Y H:i') }}</h5>
		<h5>Total Undangan : {{ $j ?? 0 }}</h5>
	</div>
    
	<table class="table table-striped">
	  <thead>
		<tr>
		  <th scope="col">No</th>
		  <th scope="col">Nama</th>
		  <th scope="col">Kota</th>
		  <th scope="col">No WA / Ref</th>
		  <th scope="col">Jumlah</th>		  
		</tr>
	  </thead>
	  <tbody>
		<?php $no=1; ?>
		@foreach ($data as $r)
		@php
			$cek = DB::table('users')->where('id', $r->ref)->first();
			if(!$cek){
				$cek = DB::table('seminars')->where('phone', $r->ref)->first();
			}
			if(!$cek){
				$cek = DB::table('users')->where('kode_ref', $r->ref)->first();
			}			
			$nama = $cek->name ?? $cek->nama ?? '-';;	
			$phone = $cek->phone ?? $cek->phone ?? '-';;	
			$phone = substr($phone, 0, -2) . 'xx';			
		@endphp
		@if($nama!=='-' && $no <=10)
		<tr>
		  <th scope="row">{{ $no++ }}</th>
		  <td>{{ strtoupper($nama) ?? '' }}</td>
		  <td>{{ $cek->kota ?? '' }}</td>
		  <td>{{ $phone ?? '' }}</td>
		  <td>{{ $r->j }}</td>
		</tr>
		@endif
		@endforeach
	  </tbody>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>