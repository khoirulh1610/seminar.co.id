@extends('layouts.index')

@section('main')
<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
    <div class="container-fluid">
        <!-- row -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        {{-- <div class="row"> --}}
                            <div class="col-6">
                                <h4 class="card-title">Daftar {{ $event->event_title }}</h4>
                            </div>
                            <div class="col-6">
                                <a href="{{ url('laporan/'.$event->sub_domain) }}@if($lunas_filter){{ $lunas_filter == 'sudah' ? '?lunas=belum' : '?lunas=sudah' }}@endif" class="btn btn-warning btn-sm btn-rounded float-right ml-1">
                                    @if($lunas_filter == 'sudah')
                                        Belum Lunas
                                    @else
                                        Sudah Lunas
                                    @endif
                                </a>
                                <form action="{{ url('laporan/'.$event->sub_domain.'/import-mutasi') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="file" class="d-none" required id="file-mutasi" name="file-mutasi" accept=".xlsx, .xls, .csv">
                                    <button class="btn btn-primary btn-sm btn-rounded float-right" type="button" onclick="this.previousElementSibling.click()">Import Mutasi</button>
                                </form>
                                {{-- @if (Auth::user()->role_id == 1) --}}
                                <a href="{{ url('exportEvent') }}" class="btn btn-success btn-sm btn-rounded float-right mr-1">Export Data</a>
                                {{-- @endif --}}
                            </div>
                        {{-- </div> --}}
                    </div>
                    <div class="card-body">
                        @if (session()->has('warning'))
                            <div class="alert alert-warning">{{ session()->get('warning') }}</div>
                        @endif
                        @if (session()->has('success'))
                            <div class="alert alert-success">{{ session()->get('success') }}</div>
                        @endif
                        <div class="table-responsive">
                            <table class="table display table-responsive-lg" id="trxusers">
                                <thead>
                                    <tr>
                                        <th style="text-align:center">No</th>
                                        <th style="text-align:center">Pengundang</th>
                                        <th style="text-align:center">Nama</th>
                                        <th style="text-align:center">Nomor dan Email</th>
                                        <th style="text-align:center">Daftar</th>
                                        <th style="text-align:center">Bayar</th>
                                        <th style="text-align:center">Notif</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach($data as $us)
                                    <tr>
                                        <td style="text-align:center">{{ $loop->iteration }}</td>
                                        <td class="text-center">
                                            {{ $us->user->nama ?? '' }} <br>
                                            <small>{{ $us->user->ref ?? '' }}</small>
                                        </td>
                                        <td style="text-align:center">
                                            <div>{{ $us->nama }}</div>
                                            <small class="d-block">{{ $us->sapaan }} {{ $us->panggilan }}</small>
                                        </td>
                                        <td style="text-align:center">
                                            {{ $us->phone }}<br>
                                            <small>{{ $us->email }}</small>
                                        </td>
                                        <td style="text-align:center">
                                            {{ $us->created_at }}<br>                                        
                                        </td>

                                        <td style="text-align:center">
                                            @rupiah($us->bayar)<br>
                                            @if ($us->lunas)
                                                {{ $us->lunas }}
                                            @else
                                                <small class="badge badge-danger">Belum Lunas</small>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ url('laporan/daftar/apply/'.$us->id) }}" class-confirm="btn-warning" 
                                            @if ($us->lunas) disabled @endif 
                                            class="btn btn-xs btn-success 
                                                @if ($us->lunas) disabled @else confirm @endif
                                            ">
                                            @if ($us->lunas) Sudah Lunas @else Apply @endif
                                            </a>

                                        </td>
                                        <td>
                                            @if ($us->lunas == null)
                                            <a href="/laporan/notif/ulang/{{$us->id}}" class="btn btn-sm btn-primary"> Kirim Ulang Notif </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/locales.min.js' integrity='sha512-wNDwA1wlxQc/93jt+u6+jc1jQ3wjkMp8fQfDL37Jn6fRiD+Q3+cNRui7sP9kb39e/0uUoBgzLoh2RXE/b7GjBQ==' crossorigin='anonymous'></script>
<script>
    moment.locale('id-ID') // set locale to indonesia

    function adaGakClassNya(arr, arrCari) {
        var clas = ''
        arr.forEach((c,i,arr) => {
            if(arrCari.includes(c)) {
                clas = c
                arr.length = 0
            }
        })
        return clas
    }
    let listClass = ['btn-primary', 'btn-success', 'btn-danger', 'btn-warning', 'btn-info'];

    $('.confirm').not('.confirmed').on('click', async function(event){
        event.preventDefault();
        await new Promise(resolve => setTimeout(resolve,150));
        let text = $(this).text()
        let arrClass = $(this).attr('class').split(' ')
        let className = adaGakClassNya(arrClass, listClass)
        $(this).toggleClass(`${className} ${$(this).attr('class-confirm')}`)
        $(this).text('Konfirmasi')
        $(this).addClass('confirmed')
        setTimeout(() => {
            $(this).text(text)
            $(this).removeClass('confirmed')
        }, 4000);
    })
    $('tbody').on('click', '.confirm.confirmed', function(){
        window.location.href = $(this).attr('href');
    })

    $('#file-mutasi').on('change', function() {
        $('#file-mutasi').get(0).parentElement.submit()
    })
    $('#trxusers').dataTable({
        // dom: 'Bfrtlip',
        // lengthMenu : [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]
        processing: true,
        serverSide: true,
        ajax: document.location.href,
        columns: [
            {
                data: 'id',
                name: 'id',
                render: function(data, type, rows, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
                orderable: false,
            },
            { 
                data: 'id', 
                name: 'id',
                render: function(data, type, rows, meta) {
                    return /*html*/`<span>${rows?.user?.nama}</span> 
                                    <br /> 
                                    <small>${rows?.user?.ref}</small>`;
                },
            },
            { 
                data: 'nama', 
                name: 'nama',
                render: function(data, type, rows, meta) {
                    return /*html*/`<div>${rows?.nama}</div>
                                    <small class="d-block">${rows?.sapaan} ${rows?.panggilan}</small>`;
                },
            },
            { 
                data: 'phone', 
                name: 'phone',
                render: function(data, type, rows, meta) {
                    return /*html*/`<div>${rows?.phone}</div>
                                    <small>${rows?.email}</small>`;
                },
            },
            { 
                data: 'created_at', 
                name: 'created_at',
                render: function(data, type, rows, meta) {
                    return /*html*/`<div>${moment(rows?.created_at).format('LLL')}</div>`;
                },
            },
            { 
                data: 'bayar', 
                name: 'bayar',
                render: function(data, type, rows, meta) {
                    return /*html*/`<div><sup>Rp</sup>${rupiah(rows?.bayar)}</div>`;
                },
            },
            { 
                data: 'lunas', 
                name: 'lunas',
                render: function(data, type, rows, meta) {
                    return /*html*/`<a href="{{ url('laporan/daftar/apply') }}/${rows.id}" class-confirm="btn-warning" ${(rows.lunas) ? 'disabled' : '' } class="btn btn-xs btn-success ${(rows.lunas) ? 'disabled' : 'confirm'}">${(rows.lunas) ? 'Sudah Lunas' : 'Apply'}</a>`;
                    return '';
                },
            },
            { 
                data: 'lunas', 
                name: 'lunas',
                render: function(data, type, rows, meta) {
                    if (rows.lunas == null) {
                        return /*html*/`<a href="/laporan/notif/ulang/${rows.id}" class="btn btn-sm btn-primary"> Kirim Ulang Notif </a>`;
                    } else {
                        return /*html*/`<span></span>`;
                    }
                },
            },
        ],

    });

    function rupiah(angka) {
        var rupiah = '';
        var angkarev = angka.toString().split('').reverse().join('');
        for (var i = 0; i < angkarev.length; i++) if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
        return rupiah.split('', rupiah.length - 1).reverse().join('');
    }
</script>
@endsection