<div class="deznav">
    <div class="deznav-scroll">
        <ul class="metismenu" id="menu">
            @if(Auth::id() !== 15057)
            <li>
                <a class="ai-icon" href="{{url('/')}}" aria-expanded="false">
                    <i class="flaticon-381-networking"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li>
                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-television"></i>
                    <span class="nav-text">Seminar New</span>
                </a>
                <ul aria-expanded="false">
                    <li>
                        @foreach ($data_seminar as $jenis_seminar => $seminar)
                        <a class="has-arrow ai-icon active" href="javascript:void()" aria-expanded="false">
                            <span class="nav-text">Seminar {{ $jenis_seminar }}</span>
                        </a>
                        <ul aria-expanded="false">
                            <li>
                                <a class="has-arrow ai-icod-none" href="javascript:void()" aria-expanded="false">
                                    <span class="nav-text">Seminar Aktif</span>
                                </a>
                                <ul aria-expanded="false">
                                    @foreach ($seminar->where('tgl_event', '>=', Carbon\Carbon::now()) as $item) {{-- Seminar Menu Item --}}
                                        <li>
                                            <a class="has-arrow ai-icod-none" href="javascript:void()" aria-expanded="false">
                                                <span class="nav-text">{{$item->event_title}}</span>
                                            </a>
                                            <ul aria-expanded="false">
                                                @if(Auth::user()->role_id<=4) 
                                                    <li>
                                                        <a href="{{ url("peserta/{$item->kode_event}") }}">
                                                            Peserta {{$item->event_title}}
                                                        </a>
                                                    </li>
                                                @endif
                                                <li>
                                                    <a href="{{ url("seminar/rangking/{$item->kode_event}") }}">
                                                        Rangking {{$item->event_title}}
                                                    </a>
                                                </li>
                                                @if(Auth::user()->role_id<=2) 
                                                <li>
                                                    <a href="{{ url("absen/{$item->kode_event}") }}">
                                                        Absen {{$item->event_title}}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ url("sertifikat/{$item->kode_event}") }}">
                                                        Sertifikat {{$item->event_title}}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ url("cw/{$item->kode_event}") }}">
                                                        CopyWriting {{$item->event_title}}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ url("seminar/komisi/{$item->kode_event}") }}">
                                                        Komisi {{$item->event_title}}
                                                    </a>
                                                </li>
                                                @endif
                                            </ul>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                            <li>
                                <a class="has-arrow ai-icod-none" href="javascript:void()" aria-expanded="false">
                                    <span class="nav-text">Seminar Tidak Aktif</span>
                                </a>
                                <ul aria-expanded="false">
                                    @foreach ($seminar->where('tgl_event', '<', Carbon\Carbon::now()) as $item) {{-- Seminar Menu Item --}}
                                        <li>
                                            <a class="has-arrow ai-icod-none" href="javascript:void()" aria-expanded="false">
                                                <span class="nav-text">{{$item->event_title}}</span>
                                            </a>
                                            <ul aria-expanded="false">
                                                @if(Auth::user()->role_id<=4) 
                                                    <li>
                                                        <a href="{{ url("peserta/{$item->kode_event}") }}">
                                                            Peserta {{$item->event_title}}
                                                        </a>
                                                    </li>
                                                @endif
                                                <li>
                                                    <a href="{{ url("seminar/rangking/{$item->kode_event}") }}">
                                                        Rangking {{$item->event_title}}
                                                    </a>
                                                </li>
                                                @if(Auth::user()->role_id<=2) 
                                                <li>
                                                    <a href="{{ url("absen/{$item->kode_event}") }}">
                                                        Absen {{$item->event_title}}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ url("sertifikat/{$item->kode_event}") }}">
                                                        Sertifikat {{$item->event_title}}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ url("cw/{$item->kode_event}") }}">
                                                        CopyWriting {{$item->event_title}}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ url("seminar/komisi/{$item->kode_event}") }}">
                                                        Komisi {{$item->event_title}}
                                                    </a>
                                                </li>
                                                @endif
                                            </ul>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                        @endforeach
                    </li>
                </ul>
            </li>
            <li>
                <a class="has-arrow ai-icod-none" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-controls-3"></i>
                    <span class="nav-text">Event</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{url('event')}}">Event Aktif</a></li>
                    <li><a href="{{url('event')}}/?status=0">Event Nonaktif</a></li>
                    @if(Auth::user()->role_id==1)
                    <li><a href="{{url('event/baru')}}">Event Baru</a></li>
                    @endif
                </ul>
            </li>
            @endif
            @if(Auth::user()->role_id==1)
            <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-user"></i>
                    <span class="nav-text">Users</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{url('users')}}">All</a></li>
                </ul>
            </li>
            @endif
            @if(Auth::user()->role_id==1)
            <li>
                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-book"></i>
                    <span class="nav-text">Laporan</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ url('semuaPeserta') }}">Semua Peserta</a></li>
                    <li><a href="{{ url('pesertaOffline') }}">Peserta Seminar Offline</a></li>
                    <li><a href="{{ url('pesertaOnline') }}">Peserta Seminar Online</a></li>
                    <li><a href="{{ url('laporan/maxwin') }}">Maxwin</a></li>
                    <li><a href="{{ url('laporan/cek/lfw') }}">LifeForWin</a></li>
                    <li><a href="{{ url('inject/zoom') }}">Inject Peserta Zoom</a></li>
                </ul>
            </li>
            @endif
            @if (Auth::user()->role_id <= 2) 
            <li>
                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="fab fa-whatsapp"></i>
                    <span class="nav-text">Whatsapp</span>
                </a>
                <ul aria-expanded="false">
                    <li><a class="has-arrow ai-icod-none" href="javascript:void()" aria-expanded="false">
                            <span class="nav-text">Pesan Text</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{url('/kirimpesan')}}">Data</a></li>
                            <li><a href="{{url('/kirimpesan/preview')}}">Preview</a></li>
                        </ul>
                    </li>
                    @if (Auth::user()->role_id==1)
                    <li><a class="has-arrow ai-icod-none" href="javascript:void()" aria-expanded="false">
                            <span class="nav-text">Pesan Button (On Develop)</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{url('/button')}}">Data</a></li>
                            <li><a href="{{url('/button/preview')}}">Preview</a></li>
                        </ul>
                    </li>
                    @endif
                    <!-- <li><a href="#">Grab Group</a></li> -->
                    <li><a href="{{url('/device/device')}}">Device</a></li>
                </ul>
            </li>
            @endif
            @if(Auth::user()->role_id==1)
            <li>
                <a href="{{ url('produk') }}" aria-expanded="false">
                    <i class="flaticon-381-book"></i>
                    <span class="nav-text">Produk</span>
                </a>
            </li>
            <li>
                <a href="{{ url('dashboardbeta') }}" aria-expanded="false">
                    <i class="flaticon-381-book"></i>
                    <span class="nav-text">Dahsboard Beta</span>
                </a>
            </li>
            @endif
        </ul>
        <div class="copyright">
            <p><strong>seminar.co.id</strong> © 2021</p>
            <p>by MSD</p>
        </div>
    </div>
</div>