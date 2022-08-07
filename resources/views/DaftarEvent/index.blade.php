<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="{{ $event->event_title ?? '' }}">
  <meta name="keywords" content="{{ $event->event_title ?? '' }}">
  <meta name="author" content="pixelstrap">  
  <link rel="icon" href="{{asset('sub_assets/images/favicon.png')}}" type="image/x-icon">
  <link rel="shortcut icon" href="{{asset('sub_assets/images/favicon.png')}}" type="image/x-icon">
  <title>KOMI - REGISTRASI</title>
  <!-- Google font-->
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
  <!-- Font Awesome-->
  <link rel="stylesheet" type="text/css" href="{{asset('sub_assets/css/fontawesome.css')}}">
  <!-- ico-font-->
  <link rel="stylesheet" type="text/css" href="{{asset('sub_assets/css/icofont.css')}}">
  <!-- Themify icon-->
  <link rel="stylesheet" type="text/css" href="{{asset('sub_assets/css/themify.css')}}">
  <!-- Flag icon-->
  <link rel="stylesheet" type="text/css" href="{{asset('sub_assets/css/flag-icon.css')}}">
  <!-- Feather icon-->
  <link rel="stylesheet" type="text/css" href="{{asset('sub_assets/css/feather-icon.css')}}">
  <!-- Plugins css start-->
  <link rel="stylesheet" type="text/css" href="{{asset('sub_assets/css/animate.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('sub_assets/css/owlcarousel.css')}}">
  <!-- Plugins css Ends-->
  <!-- Bootstrap css-->
  <link rel="stylesheet" type="text/css" href="{{asset('sub_assets/css/bootstrap.css')}}">
  <!-- App css-->
  <link rel="stylesheet" type="text/css" href="{{asset('sub_assets/css/style.css')}}">
  <link id="color" rel="stylesheet" href="{{asset('sub_assets/css/color-1.css')}}" media="screen">
  <!-- Responsive css-->
  <link rel="stylesheet" type="text/css" href="{{asset('sub_assets/css/responsive.css')}}">
</head>

<body class="landing-wrraper">
  <!-- tap on top starts-->
  <div class="tap-top"><i data-feather="chevrons-up"></i></div>
  <!-- tap on tap ends-->
  <!-- page-wrapper Start-->
  <div class="page-wrapper landing-page">
    <!-- Page Body Start-->
    <div class="page-body-wrapper">
      <!-- header start-->
      <header class="landing-header">
        <div class="custom-container">
          <div class="row">
            <div class="col-12">
              <nav class="navbar navbar-light p-0" id="navbar-example2"><a class="navbar-brand" href="javascript:void(0)">
                  <img class="img-fluid" src="https://mediasaranadigitalindo.com/assets/images/logo/msd.svg" style="width: 36px;" alt=""></a>

                <div class="buy-block"><a class="btn-landing" href="#reg">Daftar</a>
                  <div class="toggle-menu"><i class="fa fa-bars"></i></div>
                </div>
              </nav>
            </div>
          </div>
        </div>
      </header>
      <!-- header end-->

      <section class="landing-home section-pb-space h-auto" id="home"><img class="img-fluid bg-img-cover" src="{{asset('sub_assets/images/landing/landing-home/home-bg2.jpg')}}" alt="">
        <div class="custom-container" style="z-index: 1;">
          <div class="row">
            <div class="col-12 col-lg-6">
              <div class="landing-home-contain w-100">
                <div>
                  <div class="landing-logo"><img class="img-fluid" src="https://mediasaranadigitalindo.com/assets/images/logo/msd.svg" style="width: 60px;" alt=""></div>
                  <!-- <h6>Workshop</h6>
                  <h2>2022 <span>belum punya</span> toko online <span>sendiri?</span></h2>                  
                  <p class="mb-0"><i class="fa fa-check" aria-hidden="true"></i> Cara mempunyai toko online tanpa ribet </p>
                  <p class="mb-0"><i class="fa fa-check" aria-hidden="true"></i> Berjualan tanpa saling perang harga </p>
                  <p class="mb-0"><i class="fa fa-check" aria-hidden="true"></i> Cara mengelola data pelanggan agar tidak berpaling ke toko lain </p>
                  <p class="mb-0"><i class="fa fa-check" aria-hidden="true"></i> Bimbingan </p>
                  <p class="mb-0"><i class="fa fa-check" aria-hidden="true"></i> Komunitas </p> -->
                  {!!$event->event_detail ?? ''!!}
                  <div class="col-12 m-2">
                    <a class="btn-landing btn-lg" href="#reg" >Daftar</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-6">
              <div class="position-relative">
                <img class="img-parten bottom-parten" src=".{{asset('sub_assets/images/landing/landing-home/home-position/img-parten.png')}}" alt="" style="left: -30px;bottom: -20px; top: auto; height: 90px;">
                <br><br><br><br><br><br>
                <img class="img5 img-fluid h-auto m-2" src="{{$event->flayer ?? ''}}" alt="" style="border: 5px solid #e6edef; border-radius: 15px;">
              </div>
            </div>
          </div>
        </div>
        <div class="position-block" style="z-index: 2;">
          <div class="circle1 opicity3"></div>
          <div class="star"><i class="fa fa-asterisk"></i></div>
          <div class="star star1"><i class="fa fa-asterisk"></i></div>
          <div class="star star2 opicity3"><i class="fa fa-asterisk"></i></div>
          <div class="star star3"> <i class="fa fa-times"></i></div>
          <div class="star star4 opicity3"><i class="fa fa-times"></i></div>
          <div class="star star5 opicity3"> <i class="fa fa-times"></i></div>
        </div>
      </section>

      <!--       
      <section class="demo-section section-py-space" id="Applications">
        <div class="title">
          <h2></h2>
        </div>
        <div class="custom-container">
          <div class="row demo-block align-items-center">
            <div class="col-lg-6 col-sm-12 wow fadeIn">
              <div>
                <h2>2022 <span>belum punya toko online sendiri?</span></h2>
                <div class="d-xs-none d-sm-none d-md-none d-lg-block">
                  <h5>Ikuti Workshop Toko Online Workshop online Via Zoom</h5>
                  <p><i class="fa fa-check" aria-hidden="true"></i> Cara mempunyai toko online tanpa ribet </p>
                  <p><i class="fa fa-check" aria-hidden="true"></i> Berjualan tanpa saling perang harga </p>
                  <p><i class="fa fa-check" aria-hidden="true"></i> Cara mengelola data pelanggan agar tidak berpaling ke toko lain </p>
                  <p><i class="fa fa-check" aria-hidden="true"></i> Bimbingan </p>
                  <p><i class="fa fa-check" aria-hidden="true"></i> Komunitas </p>
                  <a class="btn-landing btn-lg" href="#" target="_blank">Daftar Gratis</a>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-sm-12 wow fadeIn">
              <div class="demo-box"><a href="#" target="">
                  <div class="img-wrraper"><img class="img-fluid" src="./wstol3.png')}}" alt=""></div>
                  <div class="demo-detail">
                    <div class="demo-title">
                      <h3></h3>
                    </div>
                  </div>
                </a></div>
            </div>
          </div>
        </div>
      </section> -->


      <section class="demo-section section-py-space" id="Applications">
        @if (session()->has('warning'))
            <div class="alert alert-warning">
                {{ session()->get('warning') }}
            </div>
        @endif
        <div class="title text-center">
          <h2>Registrasi</h2>
          <?php if($pengundang_nama) {
            echo '<span> Ref : '.$pengundang_nama.'</span>';
          }
          ?>                    
        </div>
        <div class="custom-container" id="reg">
          <div class="row d-flex justify-content-center">
            <div class="col-lg-6 col-sm-12 wow fadeIn">
              <div>
                <div class="register-sec-details">
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
                                    <select name="tahun" id="" class="form-control">
                                        <option value="">--</option>
                                        <?php
                                        for ($i = 12; $i <= 100; $i++) {
                                            echo '<option value='.(Date('Y') - $i).'>'.(Date('Y') - $i).'</option>';
                                        }
                                        ?>
                                    </select>
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
                <!--register-sec-details end-->
              </div>
            </div>

          </div>
        </div>
      </section>

      <!--footer start-->
      <section class="landing-footer section-py-space light-bg" id="footer">
        <div class="custom-container">
          <div class="row">
            <div class="col-12">

            </div>
          </div>
        </div>
      </section>
      <div class="sub-footer">
        <div class="custom-container">
          <div class="row">
            <div class="col-md-6 col-sm-2">
              <div class="footer-contain"><img class="img-fluid" src="https://mediasaranadigitalindo.com/assets/images/logo/msd.svg"  style="width: 40px;" alt=""></div>
            </div>
            <div class="col-md-6 col-sm-10">
              <div class="footer-contain">
                <p class="mb-0">Copyright 2021-22 © MSD </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--footer end-->
    </div>
  </div>

<div class="modal fade" id="modalregister" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">INFORMASI!!!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="color: rgb(34, 9, 2)">
          <?php
          $subject = \Session::get('message') ?? '';
          $styles = array ( '*' => 'strong', '_' => 'i', '~' => 'strike');
          $message = preg_replace_callback('/(?<!\w)([*~_])(.+?)\1(?!\w)/',
          function($m) use($styles) { 
              return '<'. $styles[$m[1]]. '>'. $m[2]. '</'. $styles[$m[1]]. '>';
          },$subject);
          
          $message = preg_replace_callback('/(?<!\w)([*~_])(.+?)\1(?!\w)/',
          function($m) use($styles) { 
              return '<'. $styles[$m[1]]. '>'. $m[2]. '</'. $styles[$m[1]]. '>';
          },$message);
          
          echo  nl2br($message);          
          ?>        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>        
      </div>
    </div>
  </div>
</div>


  <!-- latest jquery-->
  <script src="{{asset('sub_assets/js/jquery-3.5.1.min.js')}}"></script>
  <!-- feather icon js-->
  <script src="{{asset('sub_assets/js/icons/feather-icon/feather.min.js')}}"></script>
  <script src="{{asset('sub_assets/js/icons/feather-icon/feather-icon.js')}}"></script>
  <!-- Sidebar jquery-->
  <!-- <script src="{{asset('sub_assets/js/sidebar-menu.js')}}"></script> -->
  <script src="{{asset('sub_assets/js/config.js')}}"></script>
  <!-- Bootstrap js-->
  <script src="{{asset('sub_assets/js/bootstrap/popper.min.js')}}"></script>
  <script src="{{asset('sub_assets/js/bootstrap/bootstrap.min.js')}}"></script>
  <!-- Plugins JS start-->
  <script src="{{asset('sub_assets/js/owlcarousel/owl.carousel.js')}}"></script>
  <script src="{{asset('sub_assets/js/owlcarousel/owl-custom.js')}}"></script>
  <script src="{{asset('sub_assets/js/landing_sticky.js')}}"></script>
  <script src="{{asset('sub_assets/js/landing.js')}}"></script>
  <script src="{{asset('sub_assets/js/jarallax_libs/libs.min.js')}}"></script>
  <!-- Plugins JS Ends-->
  <!-- Theme js-->
  <script src="{{asset('sub_assets/js/script.js')}}"></script>
  <!-- login js-->
  <!-- Plugin used-->

  <script>
  $(function() {

$('a.page-scroll[href*="#"]:not([href="#"])').on('click', function () {
    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
        var target = $(this.hash);
        target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
        if (target.length) {
            $('html, body').animate({
                scrollTop: (target.offset().top -60)
            }, 1200, "easeInOutExpo");
            return false;
        }
    }
});

});

let status = "{{Session::get('status') ?? false}}";    
let pengundang_phone = "<?=$pengundang_phone ?? $_GET['ref'] ?? false;?>";

if(status){
    $('#modalregister').modal('show');   
    setTimeout(() => {
      window.location.replace('index.php');
    }, 30000);          
}else{
    $('#bigbonusmdl').modal('show');
}

if(pengundang_phone==false){
    $('#modalref').modal('show');        
}

$('#bigbonusmdl').on('click' , function() { 
  $('#bigbonusmdl').modal('hide');
});

setTimeout(() => {
    $('#bigbonusmdl').modal('hide');
}, 60000);

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

</script>  


</body>

</html>