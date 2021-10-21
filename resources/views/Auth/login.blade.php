<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="" />
	<meta name="author" content="" />
	<meta name="robots" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Jobie : Job Portal Admin Template" />
	<meta property="og:title" content="Jobie : Job Portal Admin Template" />
	<meta property="og:description" content="Jobie : Job Portal Admin Template" />
	<meta property="og:image" content="https://seminar.co.id/social-image.png" />
	<meta name="format-detection" content="telephone=no">
    <title>LOGIN EO SEMINAR</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="./asset/images/logoisa.png">
    <link href="./asset/css/style.css" rel="stylesheet">

</head>

<body class="h-100">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
									<div class="text-center mb-3">
										<a href="{{url('/login')}}"><img src="" style="width:30%" alt=""></a>
									</div>
                                    <h2 class="text-center text-white mb-4">EO SEMINAR</h2>
                                    <h4 class="text-center mb-4 text-white">Sign in your account</h4>
                                    <form action="{{url('/login')}}" method="POST" autocomplete="off">
                                        <div class="form-group">
                                            <label class="mb-1 text-white"><strong>Email</strong></label>
                                            <input type="email" name="email" id="email" class="form-control" placeholder="" >
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1 text-white"><strong>Password</strong></label>
                                            <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                                        </div>
                                        @csrf
                                        @if(session('errors'))
                                        <div class="example-alert mb-1">
                                            <div class="alert alert-danger alert-icon">
                                                <em class="icon ni ni-cross-circle"></em>
                                                Something it's wrong:
                                                <ul>
                                                @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                                @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        @endif

                                        @if (Session::has('success'))
                                        <div class="example-alert mb-1">
                                            <div class="alert alert-success alert-icon">
                                                <em class="icon ni ni-check-circle"></em> <strong>
                                                {{ Session::get('success') }}
                                            </div>
                                        </div>
                                        @endif
                                        
                                        @if (Session::has('error'))
                                        <div class="example-alert mb-1">
                                            <div class="alert alert-warning alert-icon">
                                                <em class="icon ni ni-check-circle"></em> <strong>
                                                {{ Session::get('error') }}
                                            </div>
                                        </div>
                                        @endif
                                        <div class="text-center">
                                            <button type="submit" class="btn bg-white text-primary btn-block">Sign in</button>
                                        </div>
                                        <div class="text-center" style="color:white"><br>
                                            <!-- Belum punya akun ? <a href="{{url('/register')}}" >DAFTAR</a> -->
                                        </div>
                                    </form>
                                    <div class="form-note-s2 text-center pt-4" style="color:white"> &copy; 2021 Copyright - EO SEMINAR </div>
                                    <div class="form-note-s2 text-center pt-4" style="color:white"> Support By <a href="http://mediasaranadigitalindo.com">PT. MSD</a> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="./asset/vendor/global/global.min.js"></script>
	<script src="./asset/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="./asset/js/custom.min.js"></script>
    <script src="./asset/js/deznav-init.js"></script>

</body>

</html>