<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $event->event_title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <style>
        .video-container {
            position: relative;
            padding-bottom: 56.25%;
            padding-top: 30px;
            height: 0;
            overflow: hidden;
        }

        .video-container iframe,
        .video-container object,
        .video-container embed {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
    </style>
</head>

<body class="d-flex flex-column align-content-center align-items-center justify-content-center">
    <section class="w-100 py-3 text-center">
        <img src="{{ url('komi.png') }}" alt="" style="width: 200px">
    </section>

    <section class="w-100 text-center py-5 px-2" style="background-color: rgba(255,198,89,0.85)">
        <div class="container mx-auto px-lg-5">
            <h2 class="fw-bolder px-lg-5 mb-5">
                "Temukan Cara Rahasia Digital Marketing dengan 3 Hari Pelatihan, Masa Depan Anda Bisa Berubah 180°"
            </h2>

            {{-- <p>(Profit invest bertahun-tahun bisa dikejer dalam hitungan bulan!)</p> --}}
            <img src="{{ $event->flayer }}" class="mt-5 img-fluid w-100" style="max-width: 800px">

            <div class="mt-5 mx-lg-5 py-3 px-lg-5" style="border-top: 1px dashed #999; border-bottom: 1px dashed #999;">
                <h2 class="text-danger fw-bold">
                    KELAS Digital Marketing CRM
                </h2>
                <h5 class="text-danger fw-bold">
                    SELAMA 3 HARI DI {{ strtoupper($event->lokasi) }}
                </h5>
                <h4 class="fw-bold">Tanggal Pendaftaran</h4>
                <p>
                    Tanggal {{ $event->open_register->isoFormat('LL') }} - {{ $event->close_register->isoFormat('LL') }}
                    <br>
                </p>

                <h5 class="mt-5">Harga Tiket</h5>
                <p>*Ajak Banyak Teman Makin Murah</p>
                <div class="row">
                    <div class="col-12 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4>1 Tiket</h4>
                                <h5 class="mb-0">Rp 4.999.000</h5>
                                <small>per orang</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4>2 Tiket</h4>
                                <span class="text-decoration-line-through">Rp 4.999.000</span>
                                <h5 class="mb-0">Rp 4.500.000</h5>
                                <small>per orang</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4>3+ Tiket</h4>
                                <span class="text-decoration-line-through">Rp 4.999.000</span>
                                <h5 class="mb-0">Rp 4.250.000</h5>
                                <small>per orang</small>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <a href="#ticket" class="btn btn-sm btn-danger rounded-pill fw-bold w-100 mt-5">Saya Mau Pesan Sekarang
                Juga!</a>
        </div>
    </section>



    <section class="text-bold container my-5 py-5">
        <div class="row justify-content-center">
            <div class="col-10">
                <div class="row justify-content-center">
                    <div class="col-12 text-center mb-5">
                        <h3>Gratis Aplikasi</h3>
                        <small>Dengan mengikuti Seminar ini anda akan mendapatkan 2 aplikasi ini secara gratis.</small>
                    </div>
                    <div class="col-4 text-center">
                        <a href="//quods.id">
                            <img src="https://quods.id/assets/depan/assets/images/logo-quods-hitam.png"
                                class="img-fluid">
                        </a>
                    </div>
                    <div class="col-4 text-center">
                        <a href="//qlat.web.id">
                            <img src="https://qlat.web.id/img/qlat.png" class="img-fluid" style="width: 80px">
                        </a>
                    </div>
                </div>
                <hr class="my-4">
                <div class="fw-bolder text-center">
                    <h4>Apa manfaat dari kelas ini untuk anda?</h4>
                </div>
                <ul class="fs-25">
                    <li>Anda akan paham Rahasia bermain dan memaximalkan Marketing dengan Whatshap untuk Bisnis Anda.
                    </li>
                    <li>Anda jadi mudah mencari pelanggan dengan aplikasi pencari data kami, Tentunya gratis untuk
                        seminar ini.
                    </li>
                    <li>Totalitas Branding.</li>
                    <li>Setelah ini pelanggan anda bisa kembali, dan kembali terus berlangganan ke anda (Repeat Order).
                    </li>
                    <li>Promosi Jauh lebih murah dan kapanpun anda mau.</li>
                </ul>
            </div>

            <div class="col-4 text-center mt-5">
                <a href="//wa.me/6287711993838" class="btn btn-success btn-lg">
                    Ada Pertanyaan? hubungi via Whatsapp
                    <img src="{{ url('whatsapp.png') }}" style="width: 30px">
                </a>
            </div>
        </div>
    </section>

    <section class="my-4 mt-4 container text-center">
        <div class="video-container mx-lg-5">
            <iframe src="https://www.youtube.com/embed/BGSgKDdh4vE"></iframe>
        </div>
    </section>

    <section class="mb-5 py-5 container bg-light" id="ticket">
        <form action="{{ url('seminar-multi-register') }}" method="POST">
            @csrf
            <input type="hidden" name="kode_event" value="{{ $event->kode_event }}">
            <input type="hidden" name="ref" readonly value="{{ $pengundang_phone ?? ($_GET['ref'] ?? null) }}">
            <div class="row justify-content-center">
                <div class="col-12 text-center mb-5">
                    <h1>Pesan Tiket</h1>
                </div>
                <hr>
                <div class="col-12 col-md-6">
                    <section id="form-ticket">
                        <div class="position-relative mt-3">
                            <span class="btn btn-primary btn-sm position-absolute disabled" type="button"
                                style="top: 15px; right: 15px; z-index: 10">Pembeli Tiket</span>
                            @include('DaftarEvent/templates/dcrm-event-form', [
                                'provinsi' => $provinsi,
                                'no' => 1,
                            ])
                        </div>
                    </section>
                    <div>
                        <button class="btn w-100 btn-primary mt-4" type="button" id="btn-add-ticket">Tambah</button>
                    </div>
                </div>
                <div class="col-12 col-md-4 mt-4">
                    <div class="position-sticky" style="top: 30px">
                        <div class="card">
                            <div class="card-body">
                                <h5>Total</h5>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <span style="font-weight: 600">Jumlah Ticket</span>
                                    <h6><span id="jml-ticket">0</span> ticket</h6>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span style="font-weight: 600">Harga Ticket</span>
                                    <div class="d-flex flex-column align-items-end">
                                        <small class="text-decoration-line-through" id="price-discount"
                                            style="display: none">
                                            Rp <span id="harga-second-ticket">0</span>
                                        </small>
                                        <h6>Rp <span id="harga-per-ticket">0</span></h6>
                                    </div>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <span style="font-weight: 600">Total Harga</span>
                                    <h5>Rp <span id="harga-ticket">0</span></h5>
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-sm w-100 mt-3 btn-primary">Pesan</button>
                    </div>
                </div>
            </div>
        </form>
    </section>

    <template id="tem-ticket">
        <div class="position-relative mt-3">
            <button class="btn btn-danger btn-sm position-absolute btn-remove-ticket" type="button"
                style="top: 15px; right: 15px; z-index: 10">Hapus</button>
            @include('DaftarEvent/templates/dcrm-event-form', ['provinsi' => $provinsi])
        </div>
    </template>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous">
    </script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'
        integrity='sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=='
        crossorigin='anonymous'></script>


    <script>
        (function() {
            const temTicket = $('#tem-ticket').get(0);
            const btnAdd = $('#btn-add-ticket');
            const form = $('#form-ticket');
            let no = 2;

            function addField() {
                const index = no - 1;
                let dom = temTicket.innerHTML.replaceAll(':index', index)
                dom = dom.replaceAll(':no', no)
                form.append(dom);
                no++;
            }

            form.on('click', '.btn-remove-ticket', function() {
                $(this).parent().remove();
                calc()
            });

            btnAdd.on('click', function(e) {
                e.preventDefault();
                addField()
                calc()
            });

            function calc() {
                const price = [4999000, 4500000, 4250000];
                const jmlTicket = parseInt(getJumlahTicket())
                const harga = price[Math.max(Math.min((jmlTicket - 1), 2), 0)]
                const total = harga * getJumlahTicket()

                if (harga !== price[0]) {
                    $('#price-discount').show()
                    $('#harga-second-ticket').text(addDots(price[0]))
                } else {
                    $('#price-discount').hide()
                }

                $('#jml-ticket').text(jmlTicket)
                $('#harga-per-ticket').text(addDots(harga))
                $('#harga-ticket').text(addDots(total))
            }

            form.on('click', '.province-select', function() {
                const dd = $(this).get(0);
                const index = dd.dataset.index;
                const id = dd.children[dd.selectedIndex].dataset.id
                name = `ticket[${index}][kota]`
                renderKabupaten(id, name)
            })

            function renderKabupaten(provinsi, name) {
                $.ajax({
                    url: "{{ url('api/kabupaten') }}",
                    method: 'GET',
                    data: {
                        id: provinsi,
                    },
                    success: function(data) {
                        const select = $(`select[name="${name}"]`);
                        select.empty();
                        data.forEach(function(item) {
                            select.append(
                                `<option value="${item.full_name}">${item.full_name}</option>`);
                        });
                    }
                });
            }

            function getJumlahTicket() {
                return $('.card-ticket').length
            }

            function addDots(num) {
                return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            calc()
        })()
    </script>



</body>

</html>
