<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>{{ $event->event_title ?? 'seminar.co.id' }}</title>


	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i%7CPoppins:300,400,500,600,700"
		rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Archivo:400,500,600,700|Oswald:200,300,400,500,600,700"
		rel="stylesheet">

	<!-- Bootstrap -->
	<link href="/assets_bigevent/assets/css/bootstrap.min.css" rel="stylesheet">

	<!-- Font-Awesome -->
	<link href="/assets_bigevent/assets/css/font-awesome.min.css" rel="stylesheet">

	<!-- Flat icon -->
	<link href="/assets_bigevent/assets/flaticon/flaticon.css" rel="stylesheet">

	<!-- Swiper -->
	<link href="/assets_bigevent/assets/css/swiper.min.css" rel="stylesheet">

	<!-- Lightcase -->
	<link href="/assets_bigevent/assets/css/lightcase.css" rel="stylesheet">

	<!-- quick-view -->
	<link href="/assets_bigevent/assets/css/quick-view.css" rel="stylesheet">

	<!-- nstSlider -->
	<link href="/assets_bigevent/assets/css/jquery.nstSlider.css" rel="stylesheet">

	<!-- flexslider -->
	<link href="/assets_bigevent/assets/css/flexslider.css" rel="stylesheet">

	<!-- banner-bg -->
	<link href="/assets_bigevent/assets/css/banner-bg.css" rel="stylesheet">

	<!-- Style -->
	<link href="/assets_bigevent/assets/css/style.css" rel="stylesheet">
	<link href="/assets_bigevent/assets/css/header.css" rel="stylesheet">
	<link href="/assets_bigevent/assets/css/index-9.css" rel="stylesheet">

	<!-- Responsive -->
	<link href="/assets_bigevent/assets/css/responsive.css" rel="stylesheet">


</head>

<body class="home-fashion">
	<!-- header start here-->
	<header class="style-3">
		<div class="menu-fixed bgc-2">
			<nav class="navbar navbar-expand-lg">
				<div class="container">
					{{-- <a class="navbar-brand" href="index.html"><img src="/assets_bigevent/images/logo.png" alt="logo" class="img-responsive"></a> --}}
					<span class="navbar-brand" style="font-size: 25pt;color:white;font-weight: 900">SEMINAR.CO.ID</span>
					<button class="navbar-toggler" type="button" data-bs-toggle="collapse"
						data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
						aria-expanded="false" aria-label="Toggle navigation">
						<i class="fa fa-bars"></i>
					</button>
					<div class="collapse navbar-collapse" id="navbarSupportedContent">
						<div class="main-menu">
							<div class="menu-left">
								<ul>
									<li>
										<a href="#">Home</a>										
									</li>
									<li>
										<a href="#">About</a>										
									</li>
									
									<li>
										<a href="#">Schedule</a>										
									</li>
									<li>
										<a href="#">Galery</a>										
									</li>
								</ul>
							</div>
							<div class="menu-right">
								<ul class="header-cart-ticket-option">									
									<li><a href="#" onclick="daftar()" class="menu-button">Daftar Sekarang</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</nav>
		</div>
	</header>
	<!-- header end here -->

	<section class="banner banner-11">
		<div class="container">
			<div class="row">
				<div class="banner-flex">
					<div class="left-content">
						<div class="mb-4 md-0"> &nbsp;</div>						
						<ul id="countdown" class="countdown">
							<li class="clock-item"><span class="count-number days">00</span>
								<p class="days_text count-text">Days</p>
							</li>

							<li class="clock-item"><span class="count-number hours">00</span>
								<p class="hours_text count-text">Hours</p>
							</li>

							<li class="clock-item"><span class="count-number minutes">00</span>
								<p class="minutes_text count-text">Min</p>
							</li>

							<li class="clock-item"><span class="count-number seconds">00</span>
								<p class="seconds_text count-text">Sec</p>
							</li>
						</ul>
						<h2 class="title1">{!!$event->event_title ?? ''!!}</h2>
						{{-- <h2 class="title2">concert for humanity</h2> --}}
						{{-- <h2 class="title3">hurry up!</h2> --}}
						<h4 class="title4">Hanya Tersedia <span>100 </span>seats</h4>
						<a href="#"  onclick="daftar()" class="custom-btn">Daftar Sekarang</a>
					</div>
					<div class="right-content">						
						<div class="d-none d-md-block d-lg-block"> <br> <br> <br></div>						
						<img class="img-responsive img-100" src="{{ $event->flayer ?? '/assets_bigevent/images/12-09-18/banner-img.png'}}" alt="banner image">
					</div>
				</div>
			</div>
		</div>
	</section>


	<section class="event-date-location-section">
		<div class="container">
			<div class="row">
				<div class="els-flex">
					<div class="els-heading">
						<h6>Support By:</h6>
						<span class="sponor-logo">
							{{-- <img src="/assets_bigevent/images/12-09-18/sponsor.png" alt="sponsor"> --}}
							<a href="https://seminar.co.id"><h3>SEMINAR.CO.ID</h3></a>
						</span>
					</div>
					<div class="els-content">
						<div class="els-content-item">
							<div class="els-icon">
								<img src="/assets_bigevent/images/12-09-18/time.png" alt="icon">
							</div>
							<div class="els-text">
								<h6>Event Date & Time</h6>
								<p>{{ date('d/m/Y H:i',strtotime($event->tgl_event))}}</p>
							</div>
						</div>

						<div class="els-content-item">
							<div class="els-icon">
								<img src="/assets_bigevent/images/12-09-18/location.png" alt="icon">
							</div>
							<div class="els-text">
								<h6>event location</h6>
								<p>{{ $event->lokasi }}</p>																
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>



	<section class="about-event-section padding-120">
		<div class="container">
			<div class="row">
				<div class="about-event-flex">
					<div class="about-event-left">
						<div class="about-event-item">
							<div class="aout-event-item-img">
								<img src="data:image/jpeg;base64,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" alt="icon image">
							</div>
							<div class="about-event-item-content">
								<h5>Apakah itu CRM ?</h5>
								<p>CRM Singkatan dari Customer Relationship Management atau suatu management hubungan dengan pelanggan
									Secara mudahnya dalam pemahamannya adalah bagaimana Anda bisa menjalin hubungan/ komunikasi dengan pelanggan2 Anda
								</p>
							</div>
						</div>

						<div class="about-event-item">
							<div class="aout-event-item-img">
								<img src="data:image/png;base64,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" alt="icon image">
							</div>
							<div class="about-event-item-content">
								<h5>100 Seats Available</h5>
								<p>Pastikan anda sudah mendapatkan tiket</p>
							</div>
						</div>

						<div class="about-event-item">
							<div class="aout-event-item-img">
								<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQFYpqlFLwyXmLXvI_688sSuM_x450VbFpz_A&usqp=CAU" alt="icon image">
							</div>
							<div class="about-event-item-content">
								<h5>KOMI (Komunitas Online Marketing Indonesia) </h5>
								<p><b>akan mengadakan Pelatihan Digital CRM Tujuannya:</b></p>
									<p>- Agar Anda bisa memahami arti pentingnya Digitalisasi</p>
									<p>- Faham CRM yang sesungguhnya dalam penerapannya</p>
									<p>- Solusi Terinonative memaintain Customer</p>
							</div>
						</div>

						<div class="about-event-item">
							<div class="aout-event-item-img">
								<img src="/assets_bigevent/images/12-09-18/about-event/04.jpg" alt="icon image">
							</div>
							<div class="about-event-item-content">
								<h5>Ilmu yang akan Anda dapatkan</h5>
								<p>- Belajar tata Kelola data pelanggan/ Customer</p>
								<p>- Memahami minat dan kemauan calon pelanggan</p>
								<p>- Cara menciptakan Repeat Order dengan mudah</p>
								<p>- Memaximalkan Fungsi CS</p>
								<p>- Memanfaatkan System Digital untuk Bisnis Anda</p>
								<p>- Memangkas Biaya Iklan</p>
								<p>- Memaximalkan Hasil Beriklan hingga akhirnya tanpa iklan bisnis tetap lariss</p>
							</div>
						</div>
					</div>

					<div class="about-event-right">
						<div class="section-heaer style2">
							{{-- <h4>APA ITU CRM ?</h4> --}}
							{{-- <h3>music concert for humanity 2021</h3> --}}
							{{-- <p>CRM Singkatan dari Customer Relationship Management atau suatu management hubungan dengan pelanggan
								Secara mudahnya dalam pemahamannya adalah bagaimana Anda bisa menjalin hubungan/ komunikasi dengan pelanggan2 Anda
								Bisnis apapun butuh relasi, pelanggan, consument, partner, Relasi, dan lainnya
								Naaaah sejauh mana Anda mengelola hubungan tersebut?
								Kalau tanpa terkelola dengan baik ini penyebab utama banyak para pebisnis sepi dan bangkrut
								</p> --}}
							{{-- <img src="/assets_bigevent/images/12-09-18/about-event/map-image.png" alt="map-image"> --}}
							<iframe width="560" height="315" src="https://www.youtube.com/embed/-w5j3Tl3ZbU" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>


	<section class="event-schedule-section schedules-18 padding-120 side-image">
		<div class="container">
			<div class="row">
				<div class="even-schedule-flex">
					<div class="section-heaer style2">
						<h4>Event Schedule</h4>
						<h3>Lets Take a Look at Line Up</h3>
						<img src="{{ $event->flayer ?? '/assets_bigevent/images/12-09-18/banner-img.png'}}" alt="">						
						<a href="#"  onclick="daftar()" class="custom-btn">Daftar Sekarang</a>
					</div>
					<div class="schedule-wrapper-flex">
						<div class="schedule-day">
							<h3>{{ date('d M Y',strtotime($event->tgl_event))}}</h3>
							<div class="schedule-item-list">
								<div class="schedule-item">
									<div class="schedule-image">
										<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/1c/Clock_09-00.svg/500px-Clock_09-00.svg.png" alt="image" style="width: 32px">
									</div>
									<div class="schedule-content">
										{{-- <p class="time">09:00 - 10:00</p> --}}
										<p onclick="document.getElementById('id01').style.display='block'"
											style="width:auto;">Pengelolaan Data Pelanggan</p>
										{{-- <p>John Smith, Hall 1, Bulding A</p> --}}
									</div>
								</div>

								<div class="schedule-item">
									<div class="schedule-image">
										<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9d/Clock_11-00.svg/1024px-Clock_11-00.svg.png" alt="image" style="width: 32px">
									</div>
									<div class="schedule-content">
										{{-- <p class="time">09am - 10am</p> --}}
										<p>Teknik Copycriting yang baik & benar</p>
										{{-- <p>John Smith, Hall 1, Bulding A</p> --}}
									</div>
								</div>
								<div class="schedule-item">
									<div class="schedule-image">
										<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/49/Clock_10-00.svg/500px-Clock_10-00.svg.png?20180125213321" alt="image"  style="width: 32px">
									</div>
									<div class="schedule-content">
										{{-- <p class="time">09am - 10am</p> --}}
										<p>Cara mendapatkan data prospek baru</p>
										{{-- <p>John Smith, Hall 1, Bulding A</p> --}}
									</div>
								</div>
								
								<div class="schedule-item">
									<div class="schedule-image">
										<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9d/Clock_11-00.svg/1024px-Clock_11-00.svg.png" alt="image" style="width: 32px">
									</div>
									<div class="schedule-content">
										{{-- <p class="time">09am - 10am</p> --}}
										<p>Memanfaatkan Whatsapp sebagai alat otomatis</p>
										{{-- <p>John Smith, Hall 1, Bulding A</p> --}}
									</div>
								</div>
								
							</div>
						</div>
						<div class="schedule-day d-none">
							<h3>24 Juli 2022</h3>
							<div class="schedule-item-list">
								<div class="schedule-item">
									<div class="schedule-image">
										<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/1c/Clock_09-00.svg/500px-Clock_09-00.svg.png" alt="image" style="width: 32px">
									</div>
									<div class="schedule-content">
										{{-- <p class="time">09am - 10am</p> --}}
										<p>Pola pengiriman Whatsapp yang benar</p>
										{{-- <p>John Smith, Hall 1, Bulding A</p> --}}
									</div>
								</div>

								<div class="schedule-item">
									<div class="schedule-image">
										<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/49/Clock_10-00.svg/500px-Clock_10-00.svg.png?20180125213321" alt="image"  style="width: 32px">
									</div>
									<div class="schedule-content">
										{{-- <p class="time">09am - 10am</p> --}}
										<p>Cara mendapatkan data prospek baru</p>
										{{-- <p>John Smith, Hall 1, Bulding A</p> --}}
									</div>
								</div>

								<div class="schedule-item">
									<div class="schedule-image">
										<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9d/Clock_11-00.svg/1024px-Clock_11-00.svg.png" alt="image" style="width: 32px">
									</div>
									<div class="schedule-content">
										{{-- <p class="time">09am - 10am</p> --}}
										<p>Memanfaatkan Whatsapp sebagai alat otomatis</p>
										{{-- <p>John Smith, Hall 1, Bulding A</p> --}}
									</div>
								</div>

								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>


	{{-- <section class="speaker-section speaker-10 padding-120">
		<div class="container">
			<div class="row">
				<div class="section-header style2">
					<h3>meet Our ROCKSTARS</h3>
					<p>Synergistica Visualize Competitive Action Ttems For Open Source Opportun Profession Develop
						Vertica Oportunities Rather Than</p>
				</div>
				<div class="section-wrapper row g-0">
					<div class="col-xs-6 col-md-6 col-lg-3">
						<div class="row">
							<div class="speaker-item">
								<div class="speaker-item">
									<div class="speaker-image">
										<a href="#" class="cata"><i class="fa fa-microphone" aria-hidden="true"></i></a>
										<div class="social-share-option">
											<i class="fa fa-share-alt" aria-hidden="true"></i>
											<ul class="social-media-list">
												<li><a href="#"><i class="fa fa-facebook"></i></a></li>
												<li><a href="#"><i class="fa fa-twitter"></i></a></li>
												<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
												<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
												<li><a href="#"><i class="fa fa-rss"></i></a></li>
											</ul>
										</div>
										<a href="#"><img src="/assets_bigevent/images/12-09-18/speaker/01.jpg" alt="speaker"></a>
										<div class="speaker-content">
											<h6 class="name"><a href="#">Robarto Smith</a></h6>
											<p class="designation">UI\UX Designer</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-xs-6 col-md-6 col-lg-3">
						<div class="row">
							<div class="speaker-item">
								<div class="speaker-item">
									<div class="speaker-image">
										<a href="#" class="cata"><i class="fa fa-microphone" aria-hidden="true"></i></a>
										<div class="social-share-option">
											<i class="fa fa-share-alt" aria-hidden="true"></i>
											<ul class="social-media-list">
												<li><a href="#"><i class="fa fa-facebook"></i></a></li>
												<li><a href="#"><i class="fa fa-twitter"></i></a></li>
												<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
												<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
												<li><a href="#"><i class="fa fa-rss"></i></a></li>
											</ul>
										</div>
										<a href="#"><img src="/assets_bigevent/images/12-09-18/speaker/03.jpg" alt="speaker"></a>
										<div class="speaker-content">
											<h6 class="name"><a href="#">Robarto Smith</a></h6>
											<p class="designation">UI\UX Designer</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-xs-6 col-md-6 col-lg-3">
						<div class="row">
							<div class="speaker-item">
								<div class="speaker-item">
									<div class="speaker-image">
										<a href="#" class="cata"><i class="fa fa-microphone" aria-hidden="true"></i></a>
										<div class="social-share-option">
											<i class="fa fa-share-alt" aria-hidden="true"></i>
											<ul class="social-media-list">
												<li><a href="#"><i class="fa fa-facebook"></i></a></li>
												<li><a href="#"><i class="fa fa-twitter"></i></a></li>
												<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
												<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
												<li><a href="#"><i class="fa fa-rss"></i></a></li>
											</ul>
										</div>
										<a href="#"><img src="/assets_bigevent/images/12-09-18/speaker/02.jpg" alt="speaker"></a>
										<div class="speaker-content">
											<h6 class="name"><a href="#">Robarto Smith</a></h6>
											<p class="designation">UI\UX Designer</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-xs-6 col-md-6 col-lg-3">
						<div class="row">
							<div class="speaker-item">
								<div class="speaker-item">
									<div class="speaker-image">
										<a href="#" class="cata"><i class="fa fa-microphone" aria-hidden="true"></i></a>
										<div class="social-share-option">
											<i class="fa fa-share-alt" aria-hidden="true"></i>
											<ul class="social-media-list">
												<li><a href="#"><i class="fa fa-facebook"></i></a></li>
												<li><a href="#"><i class="fa fa-twitter"></i></a></li>
												<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
												<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
												<li><a href="#"><i class="fa fa-rss"></i></a></li>
											</ul>
										</div>
										<a href="#"><img src="/assets_bigevent/images/12-09-18/speaker/04.jpg" alt="speaker"></a>
										<div class="speaker-content">
											<h6 class="name"><a href="#">Robarto Smith</a></h6>
											<p class="designation">UI\UX Designer</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-xs-6 col-md-6 col-lg-3">
						<div class="row">
							<div class="speaker-item">
								<div class="speaker-item">
									<div class="speaker-image">
										<a href="#" class="cata"><i class="fa fa-microphone" aria-hidden="true"></i></a>
										<div class="social-share-option">
											<i class="fa fa-share-alt" aria-hidden="true"></i>
											<ul class="social-media-list">
												<li><a href="#"><i class="fa fa-facebook"></i></a></li>
												<li><a href="#"><i class="fa fa-twitter"></i></a></li>
												<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
												<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
												<li><a href="#"><i class="fa fa-rss"></i></a></li>
											</ul>
										</div>
										<a href="#"><img src="/assets_bigevent/images/12-09-18/speaker/05.jpg" alt="speaker"></a>
										<div class="speaker-content">
											<h6 class="name"><a href="#">Robarto Smith</a></h6>
											<p class="designation">UI\UX Designer</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-xs-6 col-md-6 col-lg-3">
						<div class="row">
							<div class="speaker-item">
								<div class="speaker-item">
									<div class="speaker-image">
										<a href="#" class="cata"><i class="fa fa-microphone" aria-hidden="true"></i></a>
										<div class="social-share-option">
											<i class="fa fa-share-alt" aria-hidden="true"></i>
											<ul class="social-media-list">
												<li><a href="#"><i class="fa fa-facebook"></i></a></li>
												<li><a href="#"><i class="fa fa-twitter"></i></a></li>
												<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
												<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
												<li><a href="#"><i class="fa fa-rss"></i></a></li>
											</ul>
										</div>
										<a href="#"><img src="/assets_bigevent/images/12-09-18/speaker/06.jpg" alt="speaker"></a>
										<div class="speaker-content">
											<h6 class="name"><a href="#">Robarto Smith</a></h6>
											<p class="designation">UI\UX Designer</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-xs-6 col-md-6 col-lg-3">
						<div class="row">
							<div class="speaker-item">
								<div class="speaker-item">
									<div class="speaker-image">
										<a href="#" class="cata"><i class="fa fa-microphone" aria-hidden="true"></i></a>
										<div class="social-share-option">
											<i class="fa fa-share-alt" aria-hidden="true"></i>
											<ul class="social-media-list">
												<li><a href="#"><i class="fa fa-facebook"></i></a></li>
												<li><a href="#"><i class="fa fa-twitter"></i></a></li>
												<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
												<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
												<li><a href="#"><i class="fa fa-rss"></i></a></li>
											</ul>
										</div>
										<a href="#"><img src="/assets_bigevent/images/12-09-18/speaker/07.jpg" alt="speaker"></a>
										<div class="speaker-content">
											<h6 class="name"><a href="#">Robarto Smith</a></h6>
											<p class="designation">UI\UX Designer</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-xs-6 col-md-6 col-lg-3">
						<div class="row">
							<div class="speaker-item">
								<div class="speaker-item">
									<div class="speaker-images">
										<img src="/assets_bigevent/images/12-09-18/speaker/08.jpg" alt="speaker">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section> --}}


	{{-- <section class="pricing-section padding-120 side-image3">
		<div class="container">
			<div class="row">
				<div class="section-header style2">
					<h3>Ticket Information</h3>
					<p>Synergistica Visualize Competitive Action Ttems For Open Source Opportun Profession Develop
						Vertica Oportunities Rather Than</p>
				</div>
				<div class="section-wrapper row">
					<div class="col-lg-8">
						<div class="ticket-info-item-main">
							<div class="ticket-info-item onepass">
								<div class="ticket-info-head">
									<h3>One Day Pass</h3>
									<div class="price"><span>$</span>150.00</div>
								</div>
								<p class="desc-text">Economic Plan is Great For New Startup, Small Company Hocan Spent
									Small Budget For Their Business.</p>
								<div class="desc-area">
									<div class="info-list col-xs-12 col-md-8 col-lg-8">
										<ul class="col-xs-12 col-md-6 col-lg-6">
											<li><i class="fa fa-check-circle" aria-hidden="true"></i> 40 Videos to
												Upload</li>
											<li><i class="fa fa-check-circle" aria-hidden="true"></i> 15 contacts</li>
											<li><i class="fa fa-check-circle" aria-hidden="true"></i> 30 massages</li>
										</ul>
										<ul class="col-xs-12 col-md-6 col-lg-6">
											<li><i class="fa fa-check-circle" aria-hidden="true"></i> 100 Credit reports
											</li>
											<li><i class="fa fa-times-circle" aria-hidden="true"></i> Unlimited Support
											</li>
											<li><i class="fa fa-times-circle" aria-hidden="true"></i>7 days moneyback
											</li>
										</ul>
									</div>
									<div class="col-xs-12 col-md-4 col-lg-4">
										<a href="#" class="custom-btn">Buy Ticket</a>
									</div>

								</div>
							</div>
						</div>

						<div class="ticket-info-item-main">
							<div class="ticket-info-item twopass">
								<div class="ticket-info-head">
									<h3>One Day Pass</h3>
									<div class="price"><span>$</span>150.00</div>
								</div>
								<p class="desc-text">Economic Plan is Great For New Startup, Small Company Hocan Spent
									Small Budget For Their Business.</p>
								<div class="desc-area">
									<div class="info-list col-xs-12 col-md-8 col-lg-8">
										<ul class="col-xs-12 col-md-6 col-lg-6">
											<li><i class="fa fa-check-circle" aria-hidden="true"></i> 40 Videos to
												Upload</li>
											<li><i class="fa fa-check-circle" aria-hidden="true"></i> 15 contacts</li>
											<li><i class="fa fa-check-circle" aria-hidden="true"></i> 30 massages</li>
										</ul>
										<ul class="col-xs-12 col-md-6 col-lg-6">
											<li><i class="fa fa-check-circle" aria-hidden="true"></i> 100 Credit reports
											</li>
											<li><i class="fa fa-times-circle" aria-hidden="true"></i> Unlimited Support
											</li>
											<li><i class="fa fa-times-circle" aria-hidden="true"></i>7 days moneyback
											</li>
										</ul>
									</div>
									<div class="col-xs-12 col-md-4 col-lg-4">
										<a href="#" class="custom-btn">Buy Ticket</a>
									</div>

								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="ticket-info-item-main">
							<div class="ticket-info-item fullpass">
								<div class="ticket-info-head">
									<h3>One Day Pass</h3>
									<div class="price"><span>$</span>150.00</div>
								</div>
								<p class="desc-text">Economic Plan is Great For New Startup, Small Company Hocan Spent
									Small Budget For Their Business.</p>
								<div class="desc-area">
									<div class="info-list col-xs-12 col-md-8 col-lg-12">
										<ul class="col-xs-12 col-md-6 col-lg-12">
											<li><i class="fa fa-check-circle" aria-hidden="true"></i> 40 Videos to
												Upload</li>
											<li><i class="fa fa-check-circle" aria-hidden="true"></i> 15 contacts</li>
											<li><i class="fa fa-check-circle" aria-hidden="true"></i> 15gb Bandwidth
											</li>
											<li><i class="fa fa-check-circle" aria-hidden="true"></i> 30 massages</li>
											<li><i class="fa fa-check-circle" aria-hidden="true"></i> 30 Domains</li>
										</ul>
										<ul class="col-xs-12 col-md-6 col-lg-12">
											<li><i class="fa fa-check-circle" aria-hidden="true"></i> 100 Credit reports
											</li>
											<li><i class="fa fa-times-circle" aria-hidden="true"></i> Unlimited Support
											</li>
											<li><i class="fa fa-times-circle" aria-hidden="true"></i> Ticket Fascility
											</li>
											<li><i class="fa fa-times-circle" aria-hidden="true"></i>7 days moneyback
											</li>
										</ul>
									</div>
									<div class="col-xs-12 col-md-4 col-lg-12">
										<a href="#" class="custom-btn">Buy Ticket</a>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section> --}}



	<section class="multi-gallery-section style2 padding-120">
		<div class="container">
			<div class="row">
				<div class="section-header style2">
					<h3>Our Event Gallerys</h3>
					<p>...</p>
				</div>
				<div class="section-wrapper row">
					<div class="col-lg-4 col-md-6">
						<div class="gallery-item">
							<span></span>
							<div class="gallery-item-inner">
								<div class="gallery-thumb">
									<img src="/assets_bigevent/imgs/photo_2022-02-11_14-55-49.jpg" alt="image">
									<div class="gallery-thumb-ovarlay"></div>
									<a href="" class="gallery-icon">
										<i class="fa fa-camera" aria-hidden="true"></i>
									</a>
								</div>
								<div class="gallery-title">
									<h4>Seminar Jogjakarta</h4>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-6">
						<div class="gallery-item">
							<span></span>
							<div class="gallery-item-inner">
								<div class="gallery-thumb">
									<img src="/assets_bigevent/imgs/photo_2022-02-11_23-22-30.jpg" alt="image">
									<div class="gallery-thumb-ovarlay"></div>
									<a href="" class="gallery-icon">
										<i class="fa fa-camera" aria-hidden="true"></i>
									</a>
								</div>
								<div class="gallery-title">
									<h4>Seminar Semarang</h4>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-6">
						<div class="gallery-item">
							<span></span>
							<div class="gallery-item-inner">
								<div class="gallery-thumb">
									<img src="/assets_bigevent/imgs/photo_2022-01-19_17-09-19.jpg" alt="image">
									<div class="gallery-thumb-ovarlay"></div>
									<a href="" class="gallery-icon">
										<i class="fa fa-camera" aria-hidden="true"></i>
									</a>
								</div>
								<div class="gallery-title">
									<h4>Seminar Banyuwangi</h4>
								</div>
							</div>
						</div>
					</div>
					{{-- <div class="col-lg-4 col-md-6">
						<div class="gallery-item">
							<span></span>
							<div class="gallery-item-inner">
								<div class="gallery-thumb">
									<img src="/assets_bigevent/images/12-09-18/photo-gallery/image4.jpg" alt="image">
									<div class="gallery-thumb-ovarlay"></div>
									<a href="" class="gallery-icon">
										<i class="fa fa-camera" aria-hidden="true"></i>
									</a>
								</div>
								<div class="gallery-title">
									<h4>Wedding Ceremony 2021</h4>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-6">
						<div class="gallery-item">
							<span></span>
							<div class="gallery-item-inner">
								<div class="gallery-thumb">
									<img src="/assets_bigevent/images/12-09-18/photo-gallery/image5.jpg" alt="image">
									<div class="gallery-thumb-ovarlay"></div>
									<a href="" class="gallery-icon">
										<i class="fa fa-camera" aria-hidden="true"></i>
									</a>
								</div>
								<div class="gallery-title">
									<h4>Sports Conference 2021</h4>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-6">
						<div class="gallery-item">
							<span></span>
							<div class="gallery-item-inner">
								<div class="gallery-thumb">
									<img src="/assets_bigevent/images/12-09-18/photo-gallery/image6.jpg" alt="image">
									<div class="gallery-thumb-ovarlay"></div>
									<a href="" class="gallery-icon">
										<i class="fa fa-camera" aria-hidden="true"></i>
									</a>
								</div>
								<div class="gallery-title">
									<h4>Travel Conference 2021</h4>
								</div>
							</div>
						</div>
					</div> --}}
				</div>
			</div>
		</div>
	</section>



	<section class="home-blog home-blog-10 padding-120 side-image2" id="daftar">
		<div class="container">
			<div class="row">
				<div class="section-header style2">
					<h3>Form Registrasi</h3>
					<p>
						<?php if($pengundang_nama) {
							echo '<span> Ref : '.$pengundang_nama.'</span>';
						  }
						  ?>  
					</p>
				</div>

				<div class="section-wrapper row justify-content-center">
					<div class="col-lg-8" >
						<form method="post" action="{{asset('seminar-register')}}" autocomplete="off">
							@csrf
							<fieldset <?= ($buka_pendaftaran) ? '' : 'disabled' ?>>
								<input type="hidden" class="form-control" name="kode_event" value="{{$event->kode_event}}">
								<div class="row">
									<!-- <div class="col-sm-1"></div> -->
									<div class="col-lg-6">
									<img src="images/ISAWA04.png')}}" style="width:100%;border-radius:20px;text-align:left;" alt=""><br><br>
									</div>
									<div class="col-12">

									<div class="row">
										<div class="col-sm-12 col-md-12 d-none">
										<div class="wow fadeInUp" data-wow-duration="100ms">								  
											<label for="sapaan" style="color:black;">Hp Pengundang</label>
											<input type="text" name="ref" class="form-control" readonly value="<?= $pengundang_phone ?? $_GET['ref'] ?? null; ?>">								
										</div>
										<!--form-field end-->
										</div>
										<div class="col-sm-12 col-md-5">
										<div class="wow fadeInUp" data-wow-duration="100ms">
											<label for="sapaan" style="color:black;">Sapaan</label>
											<select type="text" name="sapaan" placeholder="Sapaan" class="form-control" required>
											<option value="Pak">Pak</option>
											<option value="Bu">Bu</option>
											<option value="Mas">Mas</option>
											<option value="Mbak">Mbak</option>
											<option value="Bro">Bro</option>
											</select>
										</div>
										<!--form-field end-->
										</div>
										<div class="col-sm-12 col-md-7">
										<div class="wow fadeInUp" data-wow-duration="200ms">
											<label for="Nama" style="color:black;">Nama Panggilan</label>
											<input type="text" name="panggilan" id="panggilan" placeholder="Masukkan Nama Panggilan" class="form-control _string" autocomplete="off" required>
										</div>
										<!--form-field end-->
										</div>
									</div>
									<div class="row">
										<div class="col-sm-12">
										<div class="wow fadeInUp" data-wow-duration="200ms">
											<br><label for="Nama" style="color:black;">Nama Lengkap</label><br>
											<input type="text" name="nama" placeholder="Masukkan Nama Anda" class="form-control _string" autocomplete="off" required>
										</div>
										<!--form-field end-->
										</div>
										<div class="col-sm-12">
										<div class="wow fadeInUp" data-wow-duration="200ms">
											<br><label for="profesi" style="color:black;">Profesi</label><br>
											<input type="text" name="profesi" placeholder="Perkerjaan / Bisnis anda" class="form-control _string" autocomplete="off">
										</div>
										<!--form-field end-->
										</div>
										@if ($event->produk=='maxwin')
											<div class="col-sm-12">
											<div class="wow fadeInUp" data-wow-duration="200ms">
												<br><label for="profesi" style="color:black;">Jabatan</label><br>
												<select type="text" name="jabatan" class="form-control form-select">
												<option value="Owner">Owner</option>
												<option value="Direktur">Direktur</option>
												<option value="Karyawan">Karyawan</option>
												<option value="Lain-lain">Lain-lain</option>                                      
												</select>
											</div>
											<!--form-field end-->
											</div>
											<div class="col-sm-12">
											<div class="wow fadeInUp" data-wow-duration="200ms">
												<br><label for="profesi" style="color:black;">Bidang usaha</label><br>
												<select type="text" name="bidang_usaha" class="form-control form-select">
												<option value="Kuliner">Kuliner</option>
												<option value="Property">Property</option>
												<option value="Tour Travel">Tour Travel</option>
												<option value="Toko">Toko</option>
												<option value="Tour Travel">Tour Travel</option>
												<option value="Online shop">Online shop</option>
												<option value="Pendidikan">Pendidikan</option>
												<option value="ASN">ASN</option>
												<option value="TNI">TNI</option>
												<option value="POLRI">POLRI</option>
												<option value="Petani/Nelayan">Petani/Nelayan</option>
												<option value="Pelajar/Mahasiswa">Pelajar/Mahasiswa</option>
												<option value="MLM">MLM</option>
												<option value="Lain-lain">Lain-lain</option>                                      
												</select>
											</div>
											<!--form-field end-->
											</div>
										@endif
									</div>
									<div class="row">
										<div class="col-sm-6">
										<div class="wow fadeInUp" data-wow-duration="200ms">
											<br><label for="email" style="color:black;">Email</label><br>
											<input type="email" name="email" placeholder="demo@gmail.com" class="form-control _email" autocomplete="off" required>
										</div>
										<!--form-field end-->
										</div>
										<div class="col-sm-6">
										<div class="wow fadeInUp" data-wow-duration="300ms">
											<br><label for="phone" style="color:black;">Nomor Whatsapp</label><br>
											<input type="text" name="phone" id="phone" placeholder="Masukkan Nomor Whatsapp" class="form-control" autocomplete="off" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');" required>
										</div>
										<!--form-field end-->
										</div>
									</div>
									<div class="row">
										<div class="col-12">
										<h6 style="color:black"><br><b> Tanggal Lahir </b></h6>
										<div class="row">
											<div class="col-3">
											<div class="wow fadeInUp" data-wow-duration="200ms">
												<label for="email" style="color:black;">Tanggal</label><br>
												<select name="tanggal" id="tanggal" class="form-control" required>
												<option value="">--</option>
												<?php
												for ($i = 1; $i <= 31; $i++) {
													$s  = sprintf("%02d", $i);
													echo  "<option value=" . $s . ">" . $s . "</option>";
												}
												?>
												</select>
											</div>
											<!--form-field end-->
											</div>
											<div class="col-3">
											<div class="wow fadeInUp" data-wow-duration="200ms">
												<label for="email" style="color:black;">Bulan</label><br>
												<select name="bulan" id="tanggal" class="form-control" required>
												<option value="">--</option>
												<?php
												for ($i = 1; $i <= 12; $i++) {
													$s  = sprintf("%02d", $i);
													echo  "<option value=" . $s . ">" . $s . "</option>";
												}
												?>
												</select>
											</div>
											<!--form-field end-->
											</div>
											<div class="col-6">
											<div class="wow fadeInUp" data-wow-duration="200ms">
												<label for="datepicker2">Tahun</label>
												<input type="number" class="form-control" name="tahun" id="tahun" placeholder="----" min="1945" max="2010" />
											</div>
											<!--form-field end-->
											</div>
										</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-12 col-md-6">
										<div class="wow fadeInUp" data-wow-duration="300ms">
											<br><label for="nama" style="color:black;">Provinsi</label>
											<select name="provinsi" id="provinsi" class="form-control" required>
											<option value="">--</option>
											<?php
											$provinsi =   file_get_contents("./data/provinsi.json");
											$provinsi = json_decode($provinsi);
											foreach ($provinsi as $r) {
												echo '<option value="' . $r->id . '">' . $r->name . '</option>';
											}
											?>
											</select>
										</div>
										<!--form-field end-->
										</div>
										<div class="col-sm-12 col-md-6">
										<div class="wow fadeInUp" data-wow-duration="300ms">
											<br><label for="nama" style="color:black;">Kota/Kabupaten</label>
											<select name="kota" id="kota" class="form-control" required>
											<option value="">--</option>
											</select>
										</div>
										<!--form-field end-->
										</div>
									</div>

									<div class="col-sm-12">
										<div class="form-field text-center mgt-40 wow fadeInUp m-2" data-wow-duration="300ms">
										<span class="text-primary">
											<!-- <p>Pastikan Email & No. Whatsapp Benar, Karena Link ZOOM & Bonus dikirim melalui Email & Whatsapp</p> -->
										</span>
										<button type="submit" class="btn btn-success mt-3">Daftar Sekarang <i class="fa fa-arrow-circle-right"></i></button><br><br>
										<center>
											<p>Butuh Bantuan ? <a href="{{$link}}" target="_blank"><i class="fa fa-whatsapp"></i> Klik disini</a></p>
										</center>
										</div>
									</div>
									</div>
								</div><br><br>
							</fieldset>
			   			</form>
					</div>

					
				</div>
			</div>
		</div>
	</section>


	{{-- <section class="sponsor-section padding-120">
		<div class="container">
			<div class="row">
				<div class="div col-lg-4">
					<div class="section-heaer style2">
						<h4>&lt;Event Sponsors/&gt;</h4>
						<h3>our event partner and sponsors logo</h3>
						<p>Synergistica Visualize Competitive Action Ttems For Open Source Opportun Profession Develop
							Vertica Oportunities Rather Than</p>
						<a href="#" class="custom-btn">See All Sponsor</a>
					</div>
				</div>
				<div class="col-lg-8">
					<div class="sponsors-wrapper">
						<div class="plutinam-sponsors">
							<div class="sponsor-item">
								<img src="/assets_bigevent/images/12-09-18/sponsor/01.png" alt="sponsor">
							</div>
						</div>

						<div class="gold-sponsors">
							<div class="sponsor-item">
								<img src="/assets_bigevent/images/12-09-18/sponsor/02.png" alt="sponsor">
							</div>
							<div class="sponsor-item">
								<img src="/assets_bigevent/images/12-09-18/sponsor/03.png" alt="sponsor">
							</div>
						</div>

						<div class="silver-sponsors">
							<div class="sponsor-item">
								<img src="/assets_bigevent/images/12-09-18/sponsor/04.png" alt="sponsor">
							</div>
							<div class="sponsor-item">
								<img src="/assets_bigevent/images/12-09-18/sponsor/05.png" alt="sponsor">
							</div>
							<div class="sponsor-item">
								<img src="/assets_bigevent/images/12-09-18/sponsor/06.png" alt="sponsor">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section> --}}


	<!-- Map start here -->
	{{-- <section class="home-map">
		<div id="home-map" class="map"></div>
	</section> --}}
	<!-- Map end here -->


	<!-- Newsletter Start here -->
	{{-- <section class="newsletter newsletter-seven">
		<div class="container">
			<p>Join Our Newsletter</p>
			<form action="/">
				<input type="email" name="email" placeholder="Enter your e-mail here">
				<input type="submit" name="submit" value="Subscribe now">
			</form>
		</div>
		<!-- container -->
	</section> --}}
	<!-- Newsletter End here -->


	<!-- Footer Start here -->
	<footer class="footer-six">
		<div class="overlay">
			<div class="container">
				<h2>EO SEMINAR</h2>
				{{-- <ul class="event-social">
					<li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
					<li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
					<li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
					<li><a href="#"><i class="fa fa-dribbble" aria-hidden="true"></i></a></li>
					<li><a href="#"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>
					<li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
				</ul> --}}
				<p>Copyright &copy;  <a href="https://seminar.co.id/">seminar.co.id</a>
				</p>
			</div>
		</div>
	</footer>
	<!-- Footer End here -->




	<!-- branch popup start here -->
	<div id="id01" class="modal">
		<form class="modal-content animate" action="/action_page.php">
			<div class="imgcontainer">
				<span onclick="document.getElementById('id01').style.display='none'" class="close"
					title="Close Modal">&times;</span>
				<img src="https://demos.codexcoder.com/big-event/wp-content/uploads/2021/03/04.jpg" alt="Avatar"
					class="avatar">
			</div>
			<div class="branch-form">
				<div class="branch-top">
					<p class="time">Time : 09am - 10am</p>
					<p class="location">Location : Dhaka, Bangladesh</p>
				</div>
				<div class="branch-content">
					<h4>Lets take a look at line up</h4>
					<p>Synergistica Visualize Competitive Action Ttems For Open Source Opportun Profession Develop
						Vertica Oportunities Rather Than</p>
				</div>
				<div class="branch-thumb">
					<img src="https://demos.codexcoder.com/big-event/annual-music/wp-content/uploads/sites/8/2021/09/01-1.jpg"
						alt="branch">
					<div class="per-info">
						<h6>Sheridan T. Lee</h6>
						<p class="designation">Lecturer</p>
					</div>
				</div>
			</div>
			<div class="branch-bottom" style="background-color:#f1f1f1">
				<button type="button"><a href="#">Buye Tickets</a></button>
				<ul class="speaker-social">
					<li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
					<li><a href="#"><i class="fa fa-dribbble" aria-hidden="true"></i></a></li>
					<li><a href="#"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>
				</ul>
			</div>
		</form>
	</div>
	<!-- branch popup start here -->



	<!-- jQuery -->
	<script src="/assets_bigevent/assets/js/jquery-3.1.1.min.js"></script>
	<script src="/assets_bigevent/assets/js/jquery-migrate-1.4.1.min.js"></script>

	<!-- Bootstrap -->
	<script src="/assets_bigevent/assets/js/bootstrap.min.js"></script>

	<!-- Coundown -->
	<script src="/assets_bigevent/assets/js/jquery.countdown.min.js"></script>

	<!--Swiper-->
	<script src="/assets_bigevent/assets/js/swiper.jquery.min.js"></script>

	<!--Masonry-->
	<script src="/assets_bigevent/assets/js/masonry.pkgd.min.js"></script>

	<!--Lightcase-->
	<script src="/assets_bigevent/assets/js/lightcase.js"></script>

	<!--modernizr-->
	<script src="/assets_bigevent/assets/js/modernizr.js"></script>

	<!--velocity-->
	<script src="/assets_bigevent/assets/js/velocity.min.js"></script>

	<!--quick-view-->
	<script src="/assets_bigevent/assets/js/quick-view.js"></script>

	<!--nstSlider-->
	<script src="/assets_bigevent/assets/js/jquery.nstSlider.js"></script>
	<script src="/assets_bigevent/assets/js/nstfunctions.js"></script>

	<!--flexslider-->
	<script src="/assets_bigevent/assets/js/flexslider-min.js"></script>
	<script src="/assets_bigevent/assets/js/flexfunctions.js"></script>

	<!--directional-->
	<script src="/assets_bigevent/assets/js/directional-hover.js"></script>
	<!-- parallax.js -->
	<script src="/assets_bigevent/assets/js/parallax.js"></script>
	<script src="/assets_bigevent/assets/js/theia-sticky-sidebar.js"></script>

	<!--easing-->
	<script src="/assets_bigevent/assets/js/jquery.easing.min.js"></script>



	<!-- Google Map -->
	{{-- <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAQlXnmyNPAeN3c3HNyWoUMqDk6bDF31Cg"></script> --}}

	<!-- Custom -->
	<script src="/assets_bigevent/assets/js/custom.js"></script>

	<script type="text/javascript">
		(function ($) {
			'use strict';
			//menu options
			var fixed_top = $(".menu-fixed");
			var fixed_top_two = $(".menu-two");
			var fixed_top_four = $(".menu-four");
			var fixed_top_five = $(".menu-five");
			var fixed_top_six = $(".menu-six");
			var fixed_top_seven = $(".menu-seven");

			$(window).on('scroll', function () {
				if ($(this).scrollTop() > 100) {
					fixed_top.addClass("animated fadeInDown");
				} else {
					fixed_top.removeClass("animated fadeInDown");
				}

				if ($(this).scrollTop() > 100) {
					fixed_top_two.addClass("menu-two-bg");
				} else {
					fixed_top_two.removeClass("menu-two-bg");
				}

				if ($(this).scrollTop() > 100) {
					fixed_top_four.addClass("menu-four-bg");
				} else {
					fixed_top_four.removeClass("menu-four-bg");
				}

				if ($(this).scrollTop() > 100) {
					fixed_top_five.addClass("menu-five-bg");
				} else {
					fixed_top_five.removeClass("menu-five-bg");
				}

				if ($(this).scrollTop() > 100) {
					fixed_top_six.addClass("menu-six-bg");
				} else {
					fixed_top_six.removeClass("menu-six-bg");
				}
				if ($(this).scrollTop() > 100) {
					fixed_top_seven.addClass("menu-seven-bg");
				} else {
					fixed_top_seven.removeClass("menu-seven-bg");
				}
			});

			//js code for mobile menu 
			$('.navbar-toggle').on('click', function (e) {
				$('body').toggleClass('open-mobile-menu')
			});
			$('.close').on('click', function (e) {
				$('body').removeClass('open-mobile-menu')
			});

			// $('.mobile-menu>ul>li>a,.mobile-menu ul.mobile-submenu>li>a').on('click', function (e) {
			//     var element = $(this).parent('li');
			//     if (element.hasClass('open')) {
			//         element.removeClass('open');
			//         element.find('li').removeClass('open');
			//         element.find('ul').slideUp(1500, "swing");
			//     } else {
			//         element.addClass('open');
			//         element.children('ul').slideDown(1500, "swing");
			//         element.siblings('li').children('ul').slideUp(1500, "swing");
			//         element.siblings('li').removeClass('open');
			//         element.siblings('li').find('li').removeClass('open');
			//         element.siblings('li').find('ul').slideUp(1500, "swing");
			//     }
			// });
			$("ul>li>ul").parent("li").addClass("menu-item-has-children");
			$('.main-menu ul li a').on('click', function (e) {
				if (parseInt($(window).width()) < 992) {
					var element = $(this).parent('li');
					if (element.hasClass('open')) {
						element.removeClass('open');
						element.find('li').removeClass('open');
						element.find('ul').slideUp(300, "swing");
					} else {
						element.addClass('open');
						element.children('ul').slideDown(300, "swing");
						element.siblings('li').children('ul').slideUp(300, "swing");
						element.siblings('li').removeClass('open');
						element.siblings('li').find('li').removeClass('open');
						element.siblings('li').find('ul').slideUp(300, "swing");
					}
				}
			})
			// drop down menu width overflow problem fix
			$('ul').parent('li').hover(function () {
				var menu = $(this).find("ul");
				var menupos = $(menu).offset();
				if (menupos.left + menu.width() > $(window).width()) {
				var newpos = -$(menu).width();
				menu.css({
					left: newpos
				});
				}
			});

			//jQuery for page scrolling feature - requires jQuery Easing plugin
			$('a.page-scroll').on('click', function (event) {
				var $anchor = $(this);
				$('html, body').stop().animate({
					scrollTop: $($anchor.attr('href')).offset().top
				}, 1500, 'easeInOutExpo');
				event.preventDefault();
			});



			$('#countdown').countdown({				
				date: "{{ date('m/d/Y h:i:s',strtotime($event->tgl_event))}}",
				offset: +2,
				day: 'Day',
				days: 'Days'
			},
			function () {
				// alert('Done!');
			});

			
			//counter up
			$('.counter').each(function () {
				var $this = $(this),
					countTo = $this.attr('data-count');
				$({
					countNum: $this.text()
				}).animate({
					countNum: countTo
				}, {
					duration: 2000,
					easing: 'linear',
					step: function () {
						$this.text(Math.floor(this.countNum));
					},
					complete: function () {
						$this.text(this.countNum);
						//alert('finished');
					}
				});
			});


			//Product list grid view
			var list = $("#list");
			var grid = $("#grid");
			list.on('click', function () {
				$('.product-item-grid').animate({
					opacity: 0
				}, function () {
					$('.grid').removeClass('grid-active');
					$('.list').addClass('list-active');
					$('.product-item-grid').attr('class', 'product-item-list shadow');
					$('.product-item-list').stop().animate({
						opacity: 1
					});
				});
			});

			grid.on('click', function () {
				$('.product-item-list').animate({
					opacity: 0
				}, function () {
					$('.list').removeClass('list-active');
					$('.grid').addClass('grid-active');
					$('.product-item-list').attr('class', 'product-item-grid shadow');
					$('.product-item-grid').stop().animate({
						opacity: 1
					});
				});
			});



			//lightcase
			$('a[data-rel^=lightcase]').lightcase();

			//directional-hover
			$(window).load(function () {
				$('.dh-container').directionalHover();
			});


			//masonery
			jQuery(window).load(function () {
				$('.grid').masonry({
					// set itemSelector so .grid-sizer is not used in layout
					itemSelector: '.grid-item',
					// use element for option
					columnWidth: '.grid-sizer',
					percentPosition: true
				})
			});


			//Sponsor one
			var swiper = new Swiper('.sponsor-slider-one', {
				slidesPerView: 3,
				spaceBetween: 30,
				autoplay: 2000,
				loop: true,
				breakpoints: {
					// when window width is <= 320px
					540: {
						slidesPerView: 1
					},
					// when window width is <= 480px
					640: {
						slidesPerView: 2
					}
				}
			});

			//Sponsor two
			var swiper = new Swiper('.sponsor-slider-two', {
				slidesPerView: 4,
				spaceBetween: 15,
				autoplay: 1500,
				loop: true,
				breakpoints: {
					// when window width is <= 320px
					540: {
						slidesPerView: 1
					},
					// when window width is <= 480px
					640: {
						slidesPerView: 2
					},
					// when window width is <= 767px
					767: {
						slidesPerView: 3
					}
				}
			});

			//Sponsor Three
			var swiper = new Swiper('.sponsor-slider-three', {
				slidesPerView: 5,
				spaceBetween: 15,
				autoplay: 1000,
				loop: true,
				breakpoints: {
					// when window width is <= 320px
					540: {
						slidesPerView: 1
					},
					// when window width is <= 480px
					640: {
						slidesPerView: 2
					},
					// when window width is <= 767px
					767: {
						slidesPerView: 4
					}
				}
			});

			//Sponsor Three
			var swiper = new Swiper('.testimonial-container', {
				slidesPerView: 1,
				spaceBetween: 30,
				autoplay: 3000,
				loop: true,
			});



			// fashion homepage
			var swiper = new Swiper('.fashion-hp-container', {
				direction: 'vertical',
				slidesPerView: 1,
				spaceBetween: 0,
				mousewheel: true,
				pagination: {
					el: '.swiper-pagination',
					clickable: true,
				},
			});



			$('.fb-plus').on('click', function (e) {
				$('.fashion-bottom-content').toggleClass('open')
			});


			// event schedule section start here
			$('.schedule-time').on('click', function (e) {
				if ($(this).next('.schedule-dropdown-element').css('display') != 'block') {
					$('.active1').slideUp(500).removeClass('active1');
					$('.schedule-time').removeClass('in');
					$(this).next('.schedule-dropdown-element').addClass('active1').slideDown(500);
					$(this).addClass('in');
				} else {
					$('.active1').slideUp(500).removeClass('active1');
					$(this).removeClass('in');
				}
			});


			$('.parallax-one').parallax({
				imageSrc: 'images/11-04-19/paralax2.png'
			});
			$('.parallax-two').parallax({
				imageSrc: 'images/11-04-19/paralax.png'
			});

			// sticky-widget
			$(document).ready(function () {
				$('section .container .sticky-widget').theiaStickySidebar();
			});

			// 1-12-2021
			// testimonial section start here
			var swiper = new Swiper('.testimonial-slider', {
				slidesPerView: 3,
				spaceBetween: 30,
				speed: 1200,
				autoplay: 3500,
				loop: true,
				breakpoints: {
					991: {
						slidesPerView: 3,
					},
					768: {
						slidesPerView: 2,
					},
					576: {
						slidesPerView: 1,
					}
				},
			});

		})(jQuery);
		$('#provinsi').change(function(){
		console.log(provinsi);
		$.ajax({
			"url" : "{{asset('kabupaten')}}",
			"data" : {id:this.value,type:'option'},
			"type" : "get",
			"success":function(data){                
				$('#kota').html(data);
			}
		})
		});

		$('#_provinsi').change(function(){
		console.log(provinsi);
		$.ajax({
			"url" : "{{asset('kabupaten')}}",
			"data" : {id:this.value,type:'option'},
			"type" : "get",
			"success":function(data){                
				$('#_kota').html(data);
			}
		})
		});

		var phone = document.getElementById("phone");
				phone.addEventListener('keyup', function(evt){                    
				phone.value = this.value.replace(/[^0-9,]/g,'');        
				}, false);   
		var _mstring = document.getElementById('panggilan');
		_mstring.addEventListener('keyup', function(evt){                    
			_mstring.value = this.value.replace(/[^a-zA-Z]/g,'');        
		}, false);   
		function daftar() {
			$(window).scrollTop($('#daftar').offset().top-20)
		}
	</script>
</body>

</html>