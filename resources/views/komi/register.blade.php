<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="" />
	<meta name="author" content="" />
	<meta name="robots" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="seminar.co.id : Portal Event Terlengkap" />
	<meta property="og:title" content="seminar.co.id : Portal Event Terlengkap" />
	<meta property="og:description" content="seminar.co.id : Portal Event Terlengkap" />
	<meta property="og:image" content="{{url('seminar.jpeg')}}" />
	<meta name="format-detection" content="telephone=no">
    <title>SEMINAR.CO.ID</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('/asset/images/logoisa.png') }}">
    <link href="{{ url('/asset/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href="{{ url('/asset/css/style.css') }}" rel="stylesheet">

</head>

<body class="h-100">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        @if (session()->has('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session()->get('success') }}
                            </div>
                        @endif
                        @if (session()->has('warning'))
                            <div class="alert alert-warning" role="alert">
                                {{ session()->get('warning') }}
                            </div>
                        @endif
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <h4 class="text-center mb-4 text-white">Register Member KOMI</h4>
                                    <form action="{{ route('komi') }}" method="POST" autocomplete="off">
                                        @csrf
                                        <div class="form-group">
                                            <label class="form-control-label text-white" for="phone-input">Nomor HP <small>(Yang terdaftar)</small></label>
                                            <input type="call" id="phone-input" class="form-control" required autocomplete="phone" placeholder="Masukan nomor HP">
                                        </div>

                                        <div class="text-center">
                                            <button type="button" id="check-btn" class="btn bg-white text-primary btn-block">Check</button>
                                            <br>
                                        </div>

                                        <div id="user-data">
                                            <div class="d-flex flex-column mb-3 bg-white p-3 rounded-xl">
                                                {{-- <p class="mb-0">Masukan nomor yang terdafatar</p> --}}
                                                <button type="button" disabled class="btn btn-primary btn-sm rounded-xl btn-block mt-2 mb-0">Register</button>
                                            </div>
                                        </div>

                                        
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js' integrity='sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==' crossorigin='anonymous'></script>
    <script>
        const phoneInput = document.getElementById('phone-input');
        const checkBtn = document.getElementById('check-btn');
            
        checkBtn.addEventListener('click', function() {
            const phone = phoneInput.value;
            console.log(phone);
            if (phone.length === 0) {
                alert('Nomor HP tidak boleh kosong');
                return;
            }
            if (phone.length < 10) {
                alert('Nomor HP minimal 10 digit');
                return;
            }
            if (phone.length > 20) {
                alert('Nomor HP maksimal 14 digit');
                return;
            }
            const url = `{{ route('getkomi') }}?phone=${phone}`;
            $.ajax({
                url,
                success: (data) => {
                    $('#user-data').html(``);
                    if (data.status == 'success') {
                        $('#user-data').html(`
                        <div class="d-flex flex-column mb-3 bg-white p-3 rounded-xl">
                            <input type="hidden" name="phone" value="${data.data.phone}">
                            <h4 class="mb-0">${data.data.nama}</h4>
                            <p class="mb-0">${data.data.email}</p>
                            <button type="submit" class="btn btn-primary btn-sm rounded-xl btn-block mt-2 mb-0">Register</button>
                        </div>
                        `);
                    } else {
                        $('#user-data').html(`
                        <div class="d-flex flex-column mb-3 bg-white p-3 rounded-xl">
                            <p class="mb-0">Nomor Tidak Terdaftar</p>
                            <button type="button" disabled class="btn btn-primary btn-sm rounded-xl btn-block mt-2 mb-0">Register</button>
                        </div>
                        `);
                    }
                },
                error: (err) => {
                    alert('ERROR: ' + err.responseJSON.message);
                }
            })
        });

        function renderUser(nama, email) {
            
        }

    </script>        
</body>
</html>