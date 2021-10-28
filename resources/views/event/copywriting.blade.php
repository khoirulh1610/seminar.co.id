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
                    <h3 class="text-black" style="font-size:20px">
                        Undangan <span style="color:red">ISA Conference</span><br>
                        Bagikan undangan dibawah ini ke rekan-rekan anda </h3>
                        <button class="btn btn-info btn-rounded" onclick="copy()"><i class="icon ni ni-edit"></i> Salin Undangan</button>
                        <a class="btn btn-success btn-rounded" href="">Share</a><br><br>
                    <textarea name="copywriting" id="copywriting" class="form-control" rows="25" disabled>{{!!$cw!!}}</textarea>
                    </div><br>
                <!-- </div><br> -->
                <!-- <div class="row justify-content-center"> -->
                    <div class="col-lg-6 text-center">
                    <h3 class="text-black" style="font-size:20px">
                        Undangan <span style="color:red">Seminar Google Map Marketing</span><br>
                        Bagikan undangan dibawah ini ke rekan-rekan anda </h3>
                        <button class="btn btn-info btn-rounded" onclick="copy2()"><i class="icon ni ni-edit"></i> Salin Undangan</button>
                        <a class="btn btn-success btn-rounded" href="">Share</a><br><br>
                    <textarea name="copywriting2" id="copywriting2" class="form-control " rows="25" disabled>{{!!$cw2!!}}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('js')
<script>

function copy() { 
    var copyTextarea = document.getElementById("copywriting");
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
