

<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>SEMINAR.CO.ID</title>
    <!-- Favicon icon -->
	<link rel="icon" type="image/png" sizes="16x16" href="{{url('asset/images/favicon.png')}}">
    <link href="{{url('asset/css/style.css')}}" rel="stylesheet">
    
</head>
</head>

<body class="h-100">    
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-5">
                    <div class="form-input-content text-center error-page">
                        <h1 class="error-text font-weight-bold">                        
							@yield('code')
						</h1>
						
                        <h4><i class="fa fa-times-circle text-danger"></i> @yield('message')</h4>
						<h6>Hubungi Admin untuk bantuan di <a href="https://wa.me/6281228060666?text=saya+mengalami+kendala+di+webseminar+mohon+dibantu">https://wa.me/6281228060666</a></h6>
                        
						<p>{{ $exception->getMessage()}}</p> 
						<div>
                            <a class="btn btn-primary" href="{{ $_SERVER['HTTP_REFERER'] ?? '/'}}">Back to Home</a>
                        </div>	
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<!--**********************************
	Scripts
***********************************-->
<!-- Required vendors -->
<script src="{{url('asset/vendor/global/global.min.js')}}"></script>
<script src="{{url('asset/vendor/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
<script src="{{url('asset/js/custom.min.js')}}"></script>
<script src="{{url('asset/js/deznav-init.js')}}"></script>
</html>