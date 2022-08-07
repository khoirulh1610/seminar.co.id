@extends('layouts.index')

@section('main')
<div class="content-body">
    <div class="container-fluid">
        <!-- row -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Data Produk</h4>
                        <div class="form-group">
                            <a href="{{url('produk/baru')}}" class="btn btn-xs btn-success btn-rounded m-1">Tambah Produk</a>
                            {{-- <a class="btn btn-xs btn-rounded btn-danger m-1" data-toggle="modal" data-target="#ModalDelete">Delete</a> --}}
                        </div>
                    </div>
                    @if (session()->has('created'))
                        <div class="alert alert-success">
                            {{ session()->get('created') }}
                        </div>
                    @endif
                    @if (session()->has('remove'))
                        <div class="alert alert-warning">
                            {{ session()->get('remove') }}
                        </div>
                    @endif
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">User</th>
                                        <th class="text-center">Nama Produk</th>
                                        <th class="text-center">Nama Template</th>
                                        <th class="text-center">Harga</th>
                                        <th class="text-center">Tanggal Expired</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($produk as $item)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $item->user->nama }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->template }}</td>
                                            <td class="text-center">{{ $item->harga }}</td>
                                            <td class="text-center">{{ $item->exp_referral }}</td>
                                            <td class="text-center">
                                                <a href="{{ url('produk/edit/'.$item->id) }}" class="btn btn-info btn-sm btn-rounded"><i class="fa fa-pen"></i></a>
                                                <a href="{{ url('produk/hapus/'.$item->id) }}" class="btn btn-danger btn-sm btn-rounded delete-confirm"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-12">

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
$('.delete-confirm').on('click', function (event) {
    event.preventDefault();
    const url = $(this).attr('href');
    Swal.fire({
        title: 'Ingin Menghapus Data?',
        text: "Data akan terhapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Berhasil!',
                text: 'Data anda berhasil dihapus!.',
                icon: 'success',
                confirmButtonText: 'Ok!'
            }).then(function(value) {
                if (value) {
                    window.location.href = url;
                }
            });
        }
    })
})
</script>
@endsection