@extends('layouts.index')

@section('main')
<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Seminar</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">CopyWriting</a></li>
            </ol>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row justify-content-center">
                  <div class="col-lg-6 text-center">
                    <h4 class="text-black" style="font-size:20px">
                      Undangan <span style="color:red">{{ $event->event_title }}</span><br>
                      Bagikan undangan dibawah ini ke rekan-rekan anda 
                    </h4>
                    <div class="form-group">
                      <div class="btn-group btn-group-sm">
                        <button class="btn btn-info" onclick="copy('copywriting')">
                          <i class="icon ni ni-edit"></i> Salin
                        </button>
                        <a class="btn btn-success" href="">Share</a>
                      </div>
                      <textarea name="copywriting" id="copywriting" class="form-control" rows="25" disabled>
                        {!! $event->cw_register2 !!}
                      </textarea>
                    </div>
                  </div>
                  <div class="col-lg-6 text-center">
                    <h3 class="text-black" style="font-size:20px">
                      Flayer <span style="color:red">{!! $event->cw_register2 !!}</span><br>
                      Bagikan flayer dibawah ini ke rekan-rekan anda 
                    </h3>
                    <button class="btn btn-info btn-rounded" onclick="copy2()">
                      <i class="icon ni ni-edit"></i> Salin Undangan
                    </button>
                    <a class="btn btn-success btn-rounded" href="">Share</a>
                    <br><br>
                    <textarea name="copywriting2" id="copywriting2" class="form-control " rows="25" disabled>{!!$cw2!!}</textarea>
                  </div>

                  <div class="col-lg-6 text-center mt-3">
                    <div class="card overflow-hidden border shadow">
                      <img src="{{ $event->flayer_fb ?? 'https://via.placeholder.com/100?text=Tidak ADA' }}" alt="flayer facebook" class="img-fluid">
                      <div class="card-body p-0">
                        <h3>Copywriting Facebook</h3>
                        <div class="btn-group rounded-">
                          <div class="btn btn-sm btn-success">share</div>
                          <div class="btn btn-sm btn-info" onclick="copy('cw_fb')"> 
                            Salin CW
                          </div>
                        </div>
                        <textarea class="form-control text-dark" id="cw_fb" rows="5">{{ $event->cw_fb }}</textarea>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6 text-center mt-3">
                    <div class="card overflow-hidden border shadow">
                      <img src="{{ $event->flayer_ig ?? 'https://via.placeholder.com/100?text=Tidak ADA' }}" alt="flayer facebook" class="img-fluid">
                      <div class="card-body p-0">
                        <h3>Copywriting Instagram</h3>
                        <div class="btn-group rounded-">
                          <div class="btn btn-sm btn-success">share</div>
                          <div class="btn btn-sm btn-info" onclick="copy('cw_ig')"> 
                            Salin CW
                          </div>
                        </div>
                        <textarea class="form-control text-dark" id="cw_ig" rows="5">{{ $event->cw_ig }}</textarea>
                      </div>
                    </div>
                  </div>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('js')
<script>

function copy(id_textarea) { 
    var copyTextarea = document.getElementById(id_textarea);
    copyTextarea.focus();
    copyTextarea.select();
    try {
      var successful = document.execCommand('copy');
      var msg = successful ? 'successful' : 'unsuccessful';
      if(msg=='successful'){
        alert('Text berhasil disalin')
      }
    } catch (err) {
      console.log('Oops, unable to copy');
    }
  // });
}

function copy2() { 
    var copyTextarea = document.getElementById("copywriting2");
    copyTextarea.focus();
    copyTextarea.select();
    try {
      var successful = document.execCommand('copy');
      var msg = successful ? 'successful' : 'unsuccessful';
      if(msg=='successful'){
        alert('Text berhasil disalin')
      }
    } catch (err) {
      console.log('Oops, unable to copy');
    }
  // });
}

</script>
@endsection
