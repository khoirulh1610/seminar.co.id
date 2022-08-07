<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <title>Seminar Pemodalan 3T</title>
    <meta name="author" content="tansh">
    <meta name="description" content="Full Day Developer Property Elite MasterClass Dapatkan Permodalan Tanpa Pengembalian, Tanpa Jaminan, Tanpa Riba ITS TIME TO LEVERAGE 10X YOUR ASSET &amp; PROFIT SAATNYA ANDA BERHASIL DENGAN STRATEGI &amp; SKEMA BISNIS DEVELOPER PROPERTY 4.O BERSAMA KAMI Transformasi Bisnis dan Kehidupan Anda Dimulai dari Sini !!!">
    <meta property="og:description" content="Full Day Developer Property Elite MasterClass Dapatkan Permodalan Tanpa Pengembalian, Tanpa Jaminan, Tanpa Riba ITS TIME TO LEVERAGE 10X YOUR ASSET &amp; PROFIT SAATNYA ANDA BERHASIL DENGAN STRATEGI &amp; SKEMA BISNIS DEVELOPER PROPERTY 4.O BERSAMA KAMI Transformasi Bisnis dan Kehidupan Anda Dimulai dari Sini !!!">
    <meta property="og:image" content="https://developer40.com/wp-content/uploads/2022/05/Untitled-1.png">
    <meta name="keywords"
        content="webinar, event, promotion, marketing, coach, feminine, agency, business">

    <!-- FAVICON FILES -->
    <link href="assets_dev4.0/images/icons/apple-touch-icon-144-precomposed.png" rel="apple-touch-icon" sizes="144x144">
    <link href="assets_dev4.0/images/icons/apple-touch-icon-120-precomposed.png" rel="apple-touch-icon" sizes="120x120">
    <link href="assets_dev4.0/images/icons/apple-touch-icon-76-precomposed.png" rel="apple-touch-icon" sizes="76x76">
    <link href="assets_dev4.0/images/icons/favicon.png" rel="shortcut icon">

    <!-- CSS FILES -->
    <link rel="stylesheet" href="assets_dev4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets_dev4.0/fonts/iconfonts.css">
    <link rel="stylesheet" href="assets_dev4.0/css/plugins.css">
    <link rel="stylesheet" href="assets_dev4.0/css/style.css">
    <link rel="stylesheet" href="assets_dev4.0/css/responsive.css">
    <link rel="stylesheet" href="assets_dev4.0/css/color.css">
</head>

<body>
    <div id="dtr-wrapper" class="clearfix">

        <!-- preloader starts -->
        <div class="dtr-preloader">
            <div class="dtr-preloader-inner">
                <div class="dtr-loader">Loading...</div>
            </div>
        </div>

        <div class="dtr-responsive-header fixed-top">
            <div class="container">
                <div class="d-flex align-items-center justify-content-between">

                    <!-- small devices logo -->
                    <!-- <div class="dtr-responsive-header-left"> 
                      <a class="dtr-logo" href="index.html">
                        <img src="assets_dev4.0/images/seminarIDlogo.png" width="50" alt="logo">
                      </a> 
                    </div> -->
                    <!-- small devices logo ends -->

                    <!-- contact info starts -->
                    <div class="dtr-responsive-header-right ml-auto">
                        <p class="text-size-md font-weight-medium line-height-null dtr-mb-0">{{ $event->tema }}</p>
                        <p class="dtr-mb-0">+62 877-1199-3838</p>
                    </div>
                    <!-- contact info ends -->

                </div>
            </div>
        </div>
        
        <header id="dtr-header-global" class="fixed-top">
            <div class="container">
                <div class="d-flex align-items-center justify-content-between">

                    <!-- header left starts -->
                    <div class="dtr-header-left">

                        <!-- logo 
                    <a class="logo-default dtr-scroll-link" href="#home"><img src="assets_dev4.0/images/logo-light.png" alt="logo"></a>

             
                    <a class="logo-alt dtr-scroll-link" href="#home"><img src="assets_dev4.0/images/logo-dark.png" alt="logo"></a>
               logo on scroll ends -->

                    </div>
                    <!-- header left ends -->

                    <!-- header right starts -->
                    <div class="dtr-header-right ml-auto color-white">
                        <p class="text-size-md font-weight-medium line-height-null dtr-mb-0 color-dark-on-scoll">
                            {{ $event->tema }}</p>
                        <p class="dtr-mb-0 color-on-scoll">+62 877-1199-3838</p>
                    </div>
                    <!-- header right ends -->

                </div>
            </div>
        </header>
        
        <div id="dtr-main-content">

            <section id="home" class="dtr-section dtr-hero-section-bg dtr-hero-section-top-padding">

                <!-- overlay -->
                <div class="dtr-overlay dtr-overlay-dark-blue"></div>

                <!-- content on overlay -->
                <div class="dtr-pb-20 dtr-overlay-content">
                    <div class="container">

                        <!--===== row 1 starts =====-->
                        <div class="row row d-flex align-items-center">

                            <!-- column 1 starts -->
                            <div class="col-12 col-md-6">
                                <p class="text-uppercase color-white-muted">{{ $event->tema }}</p>
                                <h1 class="color-white">{{ $event->event_title }}</h1>

                                <!--== nested row starts ==-->
                                <div class="row d-flex justify-content-between dtr-mt-50">
                                    <!-- icon box 1 -->
                                    <div class="dtr-icon-box color-white">
                                        <div class="dtr-icon-box-icon"><i class="icon-calendar-alt"></i></div>
                                        <div class="dtr-icon-box-text">
                                            <span>{{ $event->tgl_event->isoFormat('LL') }}</span>
                                            <span class="subtext color-white-muted">
                                                {{ $event->tgl_event->dayName }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- icon box 2 -->
                                    <div class="dtr-icon-box color-white">
                                        <div class="dtr-icon-box-icon"><i class="icon-clock"></i></div>
                                        <div class="dtr-icon-box-text"><span>19:30 WIB</span><span
                                                class="subtext color-white-muted">Waktu Indonesia Bagian Barat</span></div>
                                    </div>

                                    <div class="dtr-icon-box color-white">
                                        @if ($event->jenis_seminar === 'offline')
                                        <div class="dtr-icon-box-icon">
                                            <i class="icon-map"></i>
                                        </div>
                                        <div class="dtr-icon-box-text">
                                            <span>Lokasi</span>
                                            <span class="subtext color-white-muted">{{ $event->lokasi }}</span>
                                        </div>
                                        @else
                                        <div class="dtr-icon-box-icon">
                                            <i class="icon-camera"></i>
                                        </div>
                                        <div class="dtr-icon-box-text">
                                            <span>Online </span>
                                            <span class="subtext color-white-muted">{{ $event->lokasi }}</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <!--== nested row ends ==-->


                            </div>

                            <!-- column 1 ends -->

                            <!-- column 2 starts -->
                            <div class="col-12 col-md-6"> <img src="assets_dev4.0/images/banner.jpg" alt="image"> </div>
                            <!-- full width cta button -->
                            <div class="col-12"> <a href="#fomedaftar"
                                    class="dtr-btn btn-cta w-100 btn-green dtr-mt-20 wow fadeInUp"
                                    data-wow-delay="0.2s">Register Now</a> </div>
                            <!-- button ends -->
                            <!-- <div class="col-12 col-md-6">
                            <div class="dtr-pl-40 dtr-sm-pl-0">
                                
                                <div class="dtr-box">
                                    <div class="dtr-box-header text-center bg-blue color-white">
                                        <h3>Don't Miss The Webinar</h3>
                                    </div>
                                    <div class="dtr-box-content bg-white">
                                  
                                        <div class="dtr-form">
                                            <form id="registerform" method="post" action="php/register-form.php">
                                                <fieldset>
                                                    <p class="dtr-form-field form-control">
                                                        <input name="name"  type="text" placeholder="Name">
                                                    </p>
                                                    <p class="dtr-form-field form-control">
                                                        <input name="email"  class="required email" type="text" placeholder="Work Email">
                                                    </p>
                                                    <p class="dtr-form-field form-control">
                                                        <input name="phone"  class="required phone" type="text" placeholder="Phone">
                                                    </p>
                                                    <p class="dtr-form-field form-control">
                                                        <input name="company"  type="text" placeholder="Company">
                                                    </p>
                                                    <p class="antispam">Leave this empty: <br />
                                                        <input name="url" />
                                                    </p>
                                                    <p>
                                                        <button class="dtr-btn w-100 btn-green" type="submit">Send Message</button>
                                                    </p>
                                                    <div id="registerresult"></div>
                                                </fieldset>
                                            </form>
                                        </div>
                                       
                                        <p class="text-size-xs dtr-mt-10">We may communicate with you regarding this webinar and our services. Your information is protected by Waybinar’s Privacy Policy.</p>
                                    </div>
                                </div>
                              

                            </div>
                        </div> -->
                            <!-- column 2 ends -->


                        </div>
                        <!--===== row 1 ends =====-->

                    </div>
                </div>
            </section>

            <section id="about" class="dtr-section dtr-py-10">
                <div class="container">

                    <!--===== row 1 starts =====-->
                    <div class="row">

                        <!-- full column 1 starts -->
                        <div class="col-12 text-center">
                            <h2>SAATNYA ANDA BERHASIL DENGAN STRATEGI & SKEMA BISNIS DEVELOPER PROPERTY 4.O BERSAMA KAMI
                            </h2>
                            <p class="text-size-md font-weight-medium">BISNIS DEVELOPER PROPERTY SANGAT CEPAT BERUBAH,
                                JANGAN MENYESAL KALAU ANDA MASIH PAKAI STRATEGI LAMA.</p>
                            <h3 class="color-blue dtr-mt-50">Apakah Anda Developer Property yang mengalami keadaan di
                                bawah?
                                Silahkan check list masalah Anda</h3>
                        </div>
                        <!-- full column 1 ends -->

                        <!-- full column 2 starts -->
                        <div class="col-12 col-md-10 offset-md-1">
                            <ul class="dtr-icon-list text-size-md font-weight-bold">
                                <li>
                                    <h6><i class="icon-check-circle2"></i>Apakah anda developer property yang Kesulitan
                                        Dana Pembangunan ?</h6>
                                </li>
                                <li>
                                    <h6><i class="icon-check-circle2"></i>Apakah Project Anda terkendala Skema Bank ?
                                    </h6>
                                </li>
                                <li>
                                    <h6><i class="icon-check-circle2"></i>Apa anda merasa ada yang salah dengan
                                        Management Bisnis Anda ?</h6>
                                </li>
                                <li>
                                    <h6><i class="icon-check-circle2"></i>Sudah kesana-kemari tapi tak kunjung berhasil
                                        menarik Investor ?</h6>
                                </li>
                                <li>
                                    <h6><i class="icon-check-circle2"></i>Apa anda merasa ingin Take Over saja bisnis
                                        Anda saat ini ?</h6>
                                </li>
                                <li>
                                    <h6><i class="icon-check-circle2"></i>Apa anda merasa kesulitan dan bingung
                                        bagaimana mengembangkan bisnis anda ?</h6>
                                </li>
                                <li>
                                    <h6><i class="icon-check-circle2"></i>Menghadapi tantangan perang harga dimana-mana
                                        ?</h6>
                                </li>
                                <li>
                                    <h6><i class="icon-check-circle2"></i>Sulit Bersaing dengan kompetitor anda ?</h6>
                                </li>
                                <li>
                                    <h6><i class="icon-check-circle2"></i>Bisnis jalan di tempat karena kesulitan
                                        mendapatkan customer ?</h6>
                                </li>
                            </ul>
                            </ul>
                        </div>
                        <!-- full column 2 ends -->

                    </div>
                    <!--===== row 1 ends =====-->

                </div>
            </section>
            <section class="dtr-py">
                <div class="container">

                    <!--== row 1 starts ==-->
                    <div class="row d-flex align-items-center">

                        <!-- column 1 starts -->
                        <div class="col-12 col-md-6">
                            <p class="dtr-text-sep text-uppercase dtr-mb-0">Gabung sekarang juga !!</p>
                            <h2 class="dtr-mb-5 color-blue dtr-mb-30">Manfaat yang akan Anda dapatkan !</h2>
                            <p>Di sini Anda akan mendapatkan Permodalan Tanpa Pengembalian, Tanpa Jaminan, Tanpa Riba
                                dan Tingkatkan aset serta Profit anda 10x Lipat dengan Strategi dan Skema Baru yang
                                ampuh bersama kami di Tahun ini!</p>
                            <p></p>

                            <!-- social starts -->
                            <div class="d-flex align-items-center dtr-mt-30">
                                <p class="text-uppercase dtr-pr-20 dtr-mb-0">Amankan Kursi Sekarang</p>
                                <div class="dtr-team-social dtr-social-circle dtr-social-grey">
                                    <ul>
                                        

                                    </ul>
                                </div>
                            </div>
                            <!-- social ends -->

                        </div>
                        <!-- column 1 ends -->

                        <!-- column 2 starts -->
                        <div class="col-12 col-md-6 small-device-space"> <img src="assets_dev4.0/images/gambar1.png"
                                alt="image"> </div>
                        <!-- column 2 ends -->

                    </div>
                    <!--== row 1 ends ==-->

                </div>
            </section>
            <section class="dtr-section dtr-mt position-relative">
                <p class="dtr-big-outline-text">2021</p>
                <div class="container">
                    <h2 class="dtr-xl-heading">The Speakers</h2>
                    <div class="row align-items-center ">
                        <div class="col-12 col-md-3 offset-md-4">
                            <img src="assets_dev4.0/images/profil.png" alt="image" width="400">
                        </div>
                        <div class="col-12 col-md-5 small-device-space">
                        
                        </div>
                    </div>
                </div>
            </section>
            <section class="dtr-section dtr-pt dtr-pb">
                <div class="container">
                    <h2 class="text-center">What You WILL LEARN</h2>
                    <div class="row dtr-mt-40">
                        <div class="col-12 col-md-4 dtr-feature dtr-feature-top dtr-feature-circle-icon text-center">
                            <div class="dtr-feature-img bg-dark"><i class="icon-cloud1"></i></div>
                            <h4 class="dtr-feature-heading">Goal & Direction </h4>
                            <p>Mempunyai pondasi bisnis yang kuat, karena memiliki strategi yang tepat, nilai tambah
                                yang sesuai dengan market yang dituju, business model yang benar dan financial
                                projection yang benar.</p>
                        </div>
                        <div class="col-12 col-md-4 dtr-feature dtr-feature-top dtr-feature-circle-icon text-center">
                            <div class="dtr-feature-img bg-dark"><i class="icon-anchor1"></i></div>
                            <h4 class="dtr-feature-heading">Effective Sales Performance</h4>
                            <p>Mampu meningkatkan potensi penjualan dan juga keuntungan, karena telah memiliki puluhan
                                strategi praktis yang dapat langsung di terapkan dibisnis anda.</p>
                        </div>
                        <div class="col-12 col-md-4 dtr-feature dtr-feature-top dtr-feature-circle-icon text-center">
                            <div class="dtr-feature-img bg-dark"><i class="icon-layers"></i></div>
                            <h4 class="dtr-feature-heading">Financial Happiness</h4>
                            <p>Memiliki format Laporan keuangan khusus untuk pebisnis sehingga anda memperoleh banyak
                                informasi penting yang dapat digunakan untuk pengambilan keputusan bisnis yang lebih
                                akurat.</p>
                        </div>
                    </div>
                    <div class="row dtr-mt-40">
                        <div class="col-12 col-md-4 dtr-feature dtr-feature-top dtr-feature-circle-icon text-center">
                            <div class="dtr-feature-img bg-dark"><i class="icon-thumbs-up"></i></div>
                            <h4 class="dtr-feature-heading">Super Team</h4>
                            <p>Menciptakan super Team yang berkualitas dan mampu membantu anda mencapai target dan mimpi
                                yang anda harapkan.</p>
                        </div>
                        <div class="col-12 col-md-4 dtr-feature dtr-feature-top dtr-feature-circle-icon text-center">
                            <div class="dtr-feature-img bg-dark"><i class="icon-suitcase"></i></div>
                            <h4 class="dtr-feature-heading">Unlimited Marketing & Digital</h4>
                            <p>Memiliki Strategi Marketing yang ampuh dan mampu meraih potensi yang ada, untuk
                                mengantisipasi perubahan perilaku masyarakat atas situasi dan kondisi serta perkembangan
                                dunia digital yang sangat pesat.</p>
                        </div>
                    </div>
                </div>
            </section>
            <section class="dtr-section dtr-pt dtr-pb">
                <div class="container">
                    <h2 class="text-center">What you WILL GET !</h2>
                    <div class="row dtr-mt-40">
                        <div class="col-12 col-md-6">
                            <h4 class="color-blue"><i class="icon-check-circle2 dtr-mr-15"></i>Kami akan Membantu
                                Membenahi Managemen Bisnis Anda</h4>

                            <div class="spacer-30"></div>
                            <h4 class="color-blue"><i class="icon-check-circle2 dtr-mr-15"></i>Kesempatan Mendapatkan
                                Pendanaan Sampai dengan 5X RAB Project</h4>

                        </div>
                        <div class="col-12 col-md-6">
                            <h4 class="color-blue"><i class="icon-check-circle2 dtr-mr-15"></i>Kami akan Memberikan
                                Skema Penjualan Project yang lebih cepat</h4>

                            <div class="spacer-30"></div>
                            <h4 class="color-blue"><i class="icon-check-circle2 dtr-mr-15"></i>Menjadikan Developer Anda
                                Naik Level dengan Goal Ending masuk ke IPO</h4>

                        </div>
                        <div class="col-12 col-md-6">
                            <h4 class="color-blue"><i class="icon-check-circle2 dtr-mr-15"></i>Membangun Mesin Uang Anda
                                dengan Konversi yang Sangat Tinggi</h4>

                            <div class="spacer-30"></div>
                            <h4 class="color-blue"><i class="icon-check-circle2 dtr-mr-15"></i>Membangun Penawaran yang
                                Sulit ditolak oleh Pembeli Anda</h4>

                        </div>
                        <div class="col-12 col-md-6">
                            <h4 class="color-blue"><i class="icon-check-circle2 dtr-mr-15"></i>Profit maksimal dengan
                                Membangun Value Leader (Bukan Sekedar Laris Jualan)</h4>

                            <div class="spacer-30"></div>
                            <h4 class="color-blue"><i class="icon-check-circle2 dtr-mr-15"></i>Melawan Perang Harga dan
                                Menangkan Persaingan dengan Kompetitor Anda</h4>

                        </div>
                        <div class="col-12 col-md-6">
                            <h4 class="color-blue"><i class="icon-check-circle2 dtr-mr-15"></i>Materi Tentang Business
                                Hack yang Praktis dan Teruji</h4>

                            <div class="spacer-30"></div>
                            <h4 class="color-blue"><i class="icon-check-circle2 dtr-mr-15"></i>Memperkuat Pondasi Bisnis
                                Developer property anda karena memiliki Value yang Jelas</h4>

                        </div>
                    </div>
                </div>
            </section>
            <section class="dtr-py bg-dark-blue color-white py-5">
                <div class="container py-5 my-3">
                    <!--== row 1 starts ==-->
                    <div class="row">
                        <div class="col-12">
                            <h2 class="text-center text-warning">Ingin Mendapatkan PENDANAAN INVESTOR</h2>
                            <h3 class="font-weight-light text-center">TANPA PENGEMBALIAN, TANPA JAMINAN & TANPA RIBA
                                <br> Persiapkan dari SEKARANG
                            </h3>
                            <!-- <h2 class="text-center">Total INVESTASI</h2> -->
                        </div>
                        <!-- <div class="col-6">
                            <img src="https://developer40.com/wp-content/uploads/2022/05/PRICE-1-1024x522.png" alt="">
                        </div>
                        <div class="col-6">
                            <img src="https://developer40.com/wp-content/uploads/2022/05/PRICE-2-1024x522.png" alt="">
                        </div> -->
                    </div>
                    <!--== row 1 ends ==-->
                </div>
            </section>
        </div>

        <section class="dtr-section position-relative dtr-py-20" id="fomedaftar">
            {{-- <div class="bg-yellow row container justify-content-center mx-auto gap-4">
                <div class="border col-5 bg- text-center py-3">
                    <ul class="dtr-countdown countdown1 mx-auto text-center">
                        <li> <span class="count-number days">00</span> </li>
                        <li class="countdown-seperator">:</li>
                        <li> <span class="count-number hours">00</span> </li>
                        <li class="countdown-seperator">:</li>
                        <li> <span class="count-number minutes">00</span> </li>
                        <li class="countdown-seperator">:</li>
                        <li> <span class="count-number seconds">00</span> </li>
                    </ul>
                    <p class="text-uppercase color-grey">Balikpapan, 24 Mei 2022</p>
                </div>
                <div class="px-1"></div>
                <div class="border col-5 bg- text-center py-3">
                    <ul class="dtr-countdown countdown2 mx-auto text-center">
                        <li> <span class="count-number days">00</span> </li>
                        <li class="countdown-seperator">:</li>
                        <li> <span class="count-number hours">00</span> </li>
                        <li class="countdown-seperator">:</li>
                        <li> <span class="count-number minutes">00</span> </li>
                        <li class="countdown-seperator">:</li>
                        <li> <span class="count-number seconds">00</span> </li>
                    </ul>
                    <p class="text-uppercase color-grey">Makasar, 26 Mei 2022</p>
                </div>
            </div> --}}
            

            <div class="mt-5 p-3 dtr-py">

            <div class="container">

                <!--== row 1 starts ==-->
                <div class="row d-flex align-items-center">

                    <!-- column 1 starts -->
                    <div class="col-12 col-md-6">

                        @if(session()->has('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session()->get('success') }}
                            </div>
                        @endif
                        @if(session()->has('message'))
                            <div class="alert alert-warning" role="alert">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        @error('*')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                        <!-- form starts -->
                        <strong>Refferal: {{ $pengundang_nama }}</strong>
                        <div class="dtr-form">
                            <form method="post" action="{{asset('seminar-register')}}" method="post">
                                @csrf
                                <input type="hidden" class="form-control" name="kode_event" value="{{$event->kode_event}}">
                                <input type="hidden" class="form-control" name="kode_event" value="{{$event->kode_event}}">
                                <input type="hidden" name="ref" class="form-control" readonly value="<?= $pengundang_phone ?? $_GET['ref'] ?? null; ?>">	
                                <fieldset>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail4">Sapaan</label>
                                            <select class="dtr-form-field form-control" id="sapaan" name="sapaan" required>
                                                <option value="">Sapaan</option>
                                                <option>Pak</option>
                                                <option>Bu</option>
                                                <option>Mas</option>
                                                <option>Mbak</option>
                                                <option>Bro</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputPassword4">Nama Panggilan</label>
                                            <input type="text" class="dtr-form-field form-control" id="panggilan" name="panggilan" placeholder="Nama"
                                                required>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="name">Nama</label>
                                            <input type="text" class="dtr-form-field form-control"  name="nama"  id="name" placeholder="Nama"
                                                required>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="Profesi">Profesi</label>
                                            <input type="text" class="dtr-form-field form-control" id="profesi" placeholder="Profesi"
                                                required  name="profesi">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="jkel">Jenis Kelamin</label>
                                            <select name="jkel" id="jkel" class="input1 form-control" required data-value="{{ old('jkel') }}">
                                                <option selected disabled>Pilih Jenis Kelamin</option>
                                                <option value="Laki-laki">Laki-laki</option>
                                                <option value="Perempuan">Perempuan</option>
                                            </select>
                                        </div>
                                    </div>

                                    {{-- <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="jabatan">Jabatan</label>
                                            <select class="dtr-form-field form-control" id="jabatan" required>
                                                <option>Owner</option>
                                                <option>Direktr</option>
                                                <option>Karyawan</option>
                                                <option>Lain - Lain</option>

                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="usaha">Bidang Usaha</label>
                                            <select class="dtr-form-field form-control" id="usaha" required>
                                                <option>Kuliner</option>
                                                <option>Properti</option>
                                                <option>Tour Trevel</option>
                                                <option>Toko</option>
                                                <option>Online Shope</option>
                                                <option>Pendidikan</option>
                                                <option>ASN </option>
                                                <option>TNI</option>
                                                <option>Polri</option>
                                                <option>Petani/Nelayan</option>
                                                <option>Pelajar/Mahasiswa </option>
                                                <option>MLM</option>
                                                <option>Lain - Lain</option>
                                            </select>
                                        </div>
                                    </div> --}}

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="email">Email</label>
                                            <input type="email" class="dtr-form-field form-control" id="email" name="email"
                                                placeholder="demo@gmail.com" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="phone">Masukan Nomer Whatsapp</label>
                                            <input type="text" class="dtr-form-field form-control" id="phone" name="phone"
                                                placeholder="Masukan Nomer Whatsapp" required>
                                        </div>
                                    </div>


                                    <div class="form-row">
                                        <div class="col-md-3 mb-3">
                                            <label for="tgl">Tanggal</label>
                                            <select class="dtr-form-field form-control" id="tgl" name="tgl" required>
                                                <option>--</option>
                                                <option>01</option>
                                                <option>02</option>
                                                <option>03</option>
                                                <option>04</option>
                                                <option>05</option>
                                                <option>06</option>
                                                <option>07</option>
                                                <option>08</option>
                                                <option>09</option>
                                                <option>10</option>
                                                <option>11</option>
                                                <option>12</option>
                                                <option>13</option>
                                                <option>14</option>
                                                <option>15</option>
                                                <option>06</option>
                                                <option>17</option>
                                                <option>18</option>
                                                <option>19</option>
                                                <option>20</option>
                                                <option>21</option>
                                                <option>22</option>
                                                <option>23</option>
                                                <option>24</option>
                                                <option>25</option>
                                                <option>26</option>
                                                <option>27</option>
                                                <option>28</option>
                                                <option>29</option>
                                                <option>30</option>
                                                <option>31</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="bulan">Bulan</label>
                                            <select class="dtr-form-field form-control" id="bulan" name="bln" required>
                                                <option>--</option>
                                                <option>01</option>
                                                <option>02</option>
                                                <option>03</option>
                                                <option>04</option>
                                                <option>05</option>
                                                <option>06</option>
                                                <option>07</option>
                                                <option>08</option>
                                                <option>09</option>
                                                <option>10</option>
                                                <option>11</option>
                                                <option>12</option>
                                            </select>

                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="tahun">Tahun</label>
                                            <input type="number" class="dtr-form-field form-control" name="thn" id="tahun" placeholder="----"
                                                required>
                                        </div>
                                    </div>


                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="provinsi">Provinsi</label>
                                            <select class="dtr-form-field form-control" name="prov" id="prov_id" required data-value="{{ $data->provinsi ?? '' }}" >
                                                <option disabled selected>Provinsi</option>
                                                <?php
                                                $provinsi =   file_get_contents("./data/provinsi.json");
                                                $provinsi = json_decode($provinsi);
                                                foreach ($provinsi as $r) {
                                                  echo '<option value="' . $r->id . '">' . $r->name . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="kota">Kabupaten/Kota</label>
                                            <select class="dtr-form-field form-control" name="kota" id="kota" required>
                                                <option>--</option>

                                            </select>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="alamat">Alamat</label>
                                            <textarea name="alamat" class="field form-control" height="200px" id="alamat" placeholder="Alamat" required >{{ old('alamat') }}</textarea>
                                        </div>
                                    </div>


                                    <p>
                                        <button class="btn w-100 btn-green" type="submit">DAFTAR</button>
                                    </p>
                                    <div id="registerresult"></div>
                                </fieldset>
                            </form>
                        </div>
                        <!-- form ends -->

                        <h4 class="text-size-xm dtr-mt-10" align="justify" >Acara ini GRATIS, cukup dibayar dengan kemauan dan keseriusan Anda untuk mengikuti seminar ini.</h4>
                        

                    </div>
                    <!-- column 1 ends -->

                    <!-- column 2 starts -->
                    <!-- <div class="col-12 col-md-6 small-device-space"> 
                        <img src="https://developer40.com/wp-content/uploads/2022/05/SAATNYA-1024x748.png" alt="image">
                    
                    </div> -->
                    <!-- column 2 ends -->

                </div>
                <!--== row 1 ends ==-->

                </div>
                
            </div>
        </section>



        <footer id="dtr-footer">
            <div class="pb-0 mb-0" style="background-color: rgb(117, 49, 49)">
                <div class="row flex-column align-items-center pb-5 pt-2 w-100 mb-5">
                    <!-- <div class="text-center mb-5 col-4 text-center mb-3">
                        <h3 class="text-white">Masih Ada Pertanyaan Seputar</h3>
                        <img src="https://developer40.com/wp-content/uploads/2022/05/Untitled-1-300x88.png" alt="image">
                    </div>
                    <div class="col-4 text-center mt-4">
                        <a href="https://wa.me/6281257798412?text=Saya%20Mau%20Daftar%20EXCLUSIVE%20WORKSHOP%20Developer%20Property%204.0%20EarlyBird"
                            class="btn btn-lg btn-warning">
                            Hubungi Bantuan via WhatsApp
                        </a>
                     
                    </div> -->
                    <div class="row">
                        <div class="col-12 text-center">                            
                            <img src="https://developer40.com/wp-content/uploads/2022/05/Untitled-1-300x88.png" alt="image"><br>                        
                        </div>
                    </div>
                    
                </div>
                <div class="container-fluid bg-dark text-white text-center py-1 ">
                    <p>© EXCLUSIVE WORKSHOP PEMODALAN 3T. By <a class="text-white" href="https://mediasaranadigitalindo.com/">SEMINAR.CO.ID</a></p>
                </div>
            </div>
            <!--== footer main ends ==-->

        </footer>

    </div>

    <!-- JS FILES -->
    <script src="assets_dev4.0/js/jquery.min.js"></script>
    <script src="assets_dev4.0/js/bootstrap.min.js"></script>
    <script src="assets_dev4.0/js/plugins.js"></script>
    <script src="assets_dev4.0/js/slick.min.js"></script>
    <script src="assets_dev4.0/js/custom.js"></script>
    <script>
        $('#prov_id').change(function(){
            $.ajax({
                "url" : "{{ asset('kabupaten') }}",
                "data" : {
                    id: this.value,
                    type:'option'
                },
                "type" : "get",
                "success":function(data){      
                    $('#kota').html(data);
                }
            })
        });
        
    </script>
</body>

</html>
