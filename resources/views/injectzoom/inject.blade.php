<style>
    #myProgress {
    width: 100%;
    background-color: #ddd;
    }

    #myBar {
    width: 10%;
    height: 30px;
    background-color: #04AA6D;
    text-align: center;
    line-height: 30px;
    color: white;
    }
</style>
<style>
    .play-icon::before {
        content: '🎬';
        position: absolute;
        right: 0;
        bottom: 5px;
        background: #fff;
        padding: 1px 5px;
        border-top-left-radius: 4px;
    }
    .popup-loading.show {
        transform: translateY(-80px);
    }
    .popup-loading {
        bottom: -80px;
        right: 10px;
        transition: 1s;
    }
</style>
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
                                <h4 class="card-title">Inject Data Zoom</h4>
                                <a href="{{ url('template/Format_Data_Inject.xlsx') }}">Download Contoh Upload Data</a>
                            </div>
                            <div class="col-6">
                                @if (Auth::user()->role_id == 1)
                                    <button data-toggle="modal" data-target="#modalUploadConfirm" class="btn btn-info btn-sm btn-rounded float-right mr-1">Upload Data</button>
                                    <button data-toggle="modal" data-target="#modalExport" class="btn btn-success btn-sm btn-rounded float-right mr-1">Export Data</button>
                                    <button data-toggle="modal" data-target="#ModalHapus" class="btn btn-danger btn-sm btn-rounded float-right mr-1">Hapus</button>
                                @endif
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
                            <table id="example1" class="table table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Kontak</th>
                                        <th class="text-center">Kota</th>
                                        <th class="text-center">Seminar</th>
                                        <th class="text-center">Link</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($peserta as $item)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $item->nama }}</td>
                                            <td class="text-center">{{ $item->email }} <br> {{ $item->phone }}</td>
                                            <td class="text-center">{{ $item->kota }}</td>
                                            <td class="text-center">{{ $item->event['event_title'] ?? ''}}</td>
                                            <td class="text-center">{{ $item->link_zoom ? 'Y' : '-' }}</td>
                                        </tr>
                                    @endforeach	
                                </tbody>                                
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Popup Loading Upload --}}
<div class="position-fixed popup-loading bg-white shadow border rounded-top overflow-hidden" style="z-index: 50" id="popup-loading-file">
    {{-- <div class="w-100 py-3 bg-light border-bottom px-2"></div> --}}
    <ul class="list-group list-group-flush" style="overflow-x: hidden; overflow-y: auto">
        <li class="list-group-item active">
            <div class="row">
                <div class="col-8">
                    <em class="icon ni ni-alert"></em>
                    <small>Jangan refresh halaman saat upload file sedang berlangsung</small> 
                </div>
                <div class="col-4 text-right">
                    <button class="btn btn-sm btn-danger m-0" onclick="cancelupload(this)">Batalkan</button>
                </div>
            </div>
        </li>
    </ul>
</div>

{{-- Modal Export Data --}}
<div class="modal fade" tabindex="-1" id="modalExport">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Export Data Inject</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
              <form action="{{ url('inject/export') }}" method="POST" enctype="multipart/form-data" class="text-center">
                @csrf
                <label for="">Pilih Event</label>
                <select class="form-control" name="event_id" id="event_id">
                    @foreach ($event as $item)
                        <option value="{{ $item->id }}">{{ $item->tgl_event }} || {{ $item->event_title }}</option>
                    @endforeach
                </select>
                <div class="w-100 center mt-4">
                  <button type="submit" class="btn btn-sm btn-success btn-rounded float-center mx-auto" type="button">Export Data</button>
                </div>
              </form>
            </div>
        </div>
    </div>
</div>

{{-- Modal Upload Data --}}
<div class="modal fade" tabindex="-1" id="modalUploadConfirm">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload File</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
              {{-- <form action="{{ url('file') }}" method="POST" enctype="multipart/form-data" class="text-center"> --}}
                {{-- @csrf --}}
                <label for="">Pilih Event</label>
                <select class="form-control" name="event_id" id="event_id">
                    @foreach ($event as $item)
                        <option value="{{ $item->id }}">{{ $item->tgl_event }} || {{ $item->event_title }}</option>
                    @endforeach
                </select>
                <label class="mt-4">Pilih file</label>
                <input id="btn-brows-file" name="files" class="form-control" placeholder="Browse File">
                <div class="row justify-content-center mb-2" id="preview-files"></div>
                <div class="w-100 center">
                  <button class="btn btn-success btn-rounded float-right mx-auto" type="button" onclick="startUpload()">Upload sekarang</button>
                </div>
              {{-- </form> --}}
            </div>
        </div>
    </div>
</div>

<!-- ModalHapus -->
<div class="modal fade" tabindex="-1" id="ModalHapus">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
              <form action="{{ url('inject/delete') }}" method="POST" enctype="multipart/form-data" class="text-center">
                @csrf
                <label for="">Pilih Event</label>
                <select class="form-control" name="event_id" id="event_id">
                    @foreach ($gInject as $item)
                        <option value="{{ $item->event_id }}">{{ $item->event_title }}</option>
                    @endforeach
                </select>                
                <div class="w-100 center p-2">
                  <button class="btn btn-danger btn-rounded float-right mx-auto" type="submit">Delete</button>
                </div>
              </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/resumablejs@1.1.0/resumable.min.js"></script>
<script>
    $('#example1').DataTable();

    let browseFile = $('#btn-brows-file');
    var event_id;
    let resumable = new Resumable({
        target: "{{ url('inject/upload') }}",
        query:{ _token:'{{ csrf_token() }}'} ,// CSRF token
        fileType: ['xlsx','xls'],
        chunkSize: 1*1024*1024, // default is 1*1024*1024, this should be less than your maximum limit in php.ini
        headers: {
            'Accept' : 'application/json'
        },
        testChunks: false,
        throttleProgressCallbacks: 1,
    });

    resumable.assignBrowse(browseFile[0]);

    resumable.on('fileAdded', function (file) { // trigger when file picked
        createSectionLoader(file.file)
        $('#popup-loading-file').addClass('show')
        startUpload()
    });

    resumable.on('fileProgress', function (file) { // trigger when file progress update
        var progressPercent = Math.floor(file.progress() * 100)
        console.log(progressPercent);
        // if (progressPercent == 100) {
        //     importProgress(file.file.uniqueIdentifier)
        // }

        updateProgress(file.file.uniqueIdentifier, progressPercent);
    });

    resumable.on('fileSuccess', function (file, response) { // trigger when file upload complete
        updateProgress(file.file.uniqueIdentifier, 100, true); // true = stop animation
        response = JSON.parse(response)
        console.log("uploaded", response);

        $.ajax({
            url: "{{ url('inject/data') }}",
            method: 'POST',
            data: {
                path: response.path,
                _token:'{{ csrf_token() }}',// CSRF token
                event_id: event_id
            }
        }).done(function(res){
            // console.log(res);
        })

        // reloadTable()
        updateProgress(file.file.uniqueIdentifier, 0, false); // false = stop animation
        // importProgress(file.file.uniqueIdentifier)
        getProgressInject(event_id, file.file.uniqueIdentifier)
        // finishProgress(file.file.uniqueIdentifier)
        resumable.removeFile(file)
    });

    resumable.on('fileError', function (file, response) { // trigger when there is any error
        alert('file uploading error.')
    });

    function getProgressInject(event_id, identifier){
        $.ajax({
            url: "{{ url('inject/progress') }}",
            method: 'POST',
            data: {
                event_id: event_id,
                _token:'{{ csrf_token() }}'// CSRF token
            }
        }).done(function(res){
            console.log(res);
            if (res.persentase == 100) {
                finishProgress(identifier)
            }else{
                updateProgress(identifier, res.persentase, false, 'Importing...')
                setTimeout(() => {
                    getProgressInject(event_id, identifier)
                }, 2000);
            }
        })
    }

    function startUpload() {
        $('#modalUploadConfirm').modal('hide')
        // showProgress();
        event_id    = $('#event_id').val();
        setTimeout(() => {
            resumable.upload() // start uploading.
        }, 1000);
    }   

    function cancelupload(btn) {
        if (confirm('Yakin ingin membatalkan pengunggahan')) {
            resumable.cancel()
            btn.innerText = 'Dibatalkan';
            setTimeout(() => {
                $('#popup-loading-file ul li.loader-item').remove();
                if(resumable.files.length == 0) {
                    $('#popup-loading-file').removeClass('show')
                }
                btn.innerText = 'Batalkan';
            }, 2000);
        }
    }

    window.onbeforeunload = function ()
    {
        return '';
    };

    function updateProgress(id, value, stop, message) {
        var loader = $(`#popup-loading-file ul li#${id}`)
        var vLoader = loader.get(0)
        if (message == undefined) {
            message = 'Uploading...'
        }
        if (stop != undefined) {
            if (stop) {
                vLoader.lastElementChild.firstElementChild.classList.remove('progress-bar-animated')
            }
        }
        vLoader.lastElementChild.firstElementChild.style.width = `${value}%` // move loader
        vLoader.firstElementChild.lastElementChild.lastElementChild.innerText = `${value}%`
        vLoader.firstElementChild.firstElementChild.lastElementChild.firstChild.innerText = message
    }

    function finishProgress(id) {
        var vLoader = $(`#popup-loading-file ul li#${id}`).get(0)
        var textState = vLoader.firstElementChild.firstElementChild.lastElementChild.firstChild
        textState.innerText = 'Finished';
        textState.className = 'text-success font-weight-bold';
        setTimeout(() => {
            var loader = vLoader.remove()
            if(resumable.files.length == 0) {
                $('#popup-loading-file').removeClass('show')
                location.reload();
            }
        }, 5000);
    }

    function importProgress(id) {
        var vLoader = $(`#popup-loading-file ul li#${id}`).get(0)
        var textState = vLoader.firstElementChild.firstElementChild.lastElementChild.firstChild
        textState.innerText = 'Importing...';
    }

    function parseFileSize(size) {
        var i = Math.floor( Math.log(size) / Math.log(1024) );
        return ( size / Math.pow(1024, i) ).toFixed(2) * 1 + ['B', 'kB', 'MB', 'GB', 'TB'][i];
    };

    function createSectionLoader(file) {
        var html = `<li class="list-group-item loader-item" id="${file.uniqueIdentifier}">
            <div class="d-flex justify-content-between">
                <div class="d-flex flex-column">
                    <span>${file.name}</span>
                    <span><small>Prepare</small><small> ${parseFileSize(file.size)}</small></span>
                </div>
                <div class="d-flex flex-column align-items-end">
                    <span></span>
                    <small>0%</small>
                </div>
            </div>
            <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
            </div>
        </li>`;
        $('#popup-loading-file ul').append(html);
    }
</script>
@endsection