<div class="deznav">
    <div class="deznav-scroll">
        <ul class="metismenu" id="menu">
            <li><a class="ai-icon" href="{{url('/')}}" aria-expanded="false">
                    <i class="flaticon-381-networking"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li><a class="has-arrow ai-icon active" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-television"></i>
                    <span class="nav-text">Seminar</span>
                </a>
                <ul aria-expanded="false">

                    <?php
                     $event = App\Models\Event::where('status',1)->get();
                     foreach ($event as $e) {
                     ?>

                     <li><a class="has-arrow ai-icod-none" href="javascript:void()" aria-expanded="false">
                        <span class="nav-text">{{$e->event_title}}</span>
                     </a>
                        <ul aria-expanded="false">
                            @if(Auth::user()->role_id<=4)
                            <li><a href="{{url('peserta/'.$e->kode_event)}}">Peserta {{$e->event_title}}</a></li>
                            @endif
                            <li><a href="{{url('seminar/rangking/'.$e->kode_event)}}">Rangking {{$e->event_title}}</a></li>
                            @if(Auth::user()->role_id<=2)
                            <li><a href="{{url('absen/'.$e->kode_event)}}">Absen {{$e->event_title}}</a></li>
                            <li><a href="{{url('sertifikat/'.$e->kode_event)}}">Sertifikat {{$e->event_title}}</a></li>
                            <li><a href="{{url('cw/'.$e->kode_event)}}">CopyWriting {{$e->event_title}}</a></li>
                            <li><a href="{{url('seminar/komisi/'.$e->kode_event)}}">Komisi {{$e->event_title}}</a></li>
                            @endif
                        </ul>
                     </li>
                    <?php } ?>
                </ul>
            </li>
            <li><a class="has-arrow ai-icod-none" href="javascript:void()" aria-expanded="false">
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
            @if(Auth::user()->role_id<=3)
            <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="fab fa-whatsapp"></i>
                    <span class="nav-text">Whatsapp</span>
                </a>
                <ul aria-expanded="false">
                <li><a class="has-arrow ai-icod-none" href="javascript:void()" aria-expanded="false">
                         <span class="nav-text">Pesan</span>
                     </a>
                        <ul aria-expanded="false">
                            <li><a href="{{url('/kirimpesan')}}">Data</a></li>
                            <li><a href="{{url('/kirimpesan/preview')}}">Preview</a></li>
                        </ul>
                     </li>

                    <!-- <li><a href="#">Grab Group</a></li> -->
                    <li><a href="{{url('/device/device')}}">Device</a></li>
                </ul>
            </li>
            @endif
        </ul>

        <div class="copyright">
            <p><strong>seminar.co.id</strong> © 2021</p>
            <p>by MSD</p>
        </div>
    </div>
</div>
