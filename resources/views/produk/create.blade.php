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
                    <form action="{{ url('produk/save') }}" method="post">
                        @csrf
                        <div class="card-header">
                            @if ($produk)
                                <h4 class="card-title">Edit Data Produk</h4>
                            @else
                                <h4 class="card-title">Tambah Data Produk</h4>
                            @endif
                            <div class="form-group">
                                <button type="submit" class="btn btn-sm btn-success btn-rounded m-1">Simpan</button>
                                <a type="button" href="{{ url('produk/') }}" class="btn btn-sm btn-rounded btn-danger m-1">Batal</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <input type="hidden" name="id" value="{{ $produk->id ?? '' }}" class="form-control">
                                <div class="col-6 mb-3">
                                    <label for="nama">Nama Produk</label>
                                    <input type="text" name="name" value="{{ $produk->name ?? '' }}" class="form-control" required>
                                </div>
                                <div class="col-6 mb-3">
                                    <label for="template">Template</label>
                                    <input type="text" name="template" value="{{ $produk->template ?? '' }}" class="form-control">
                                </div>
                                <div class="col-4">
                                    <label for="harga">Harga</label>
                                    <input type="text" name="harga" value="{{ $produk->harga ?? '' }}" class="form-control" required>
                                </div>
                                <div class="col-4">
                                    <label for="exp_produk">Tanggal Expired Referral</label>
                                    <input type="date" name="exp_referral" value="{{ $produk->exp_referral ?? '' }}" class="form-control" required>
                                </div>
                                <div class="col-4">
                                    <label for="komisi">Komisi</label>
                                    <input type="text" name="komisi" value="{{ $produk->komisi ?? '' }}" class="form-control">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>    

</script>
@endsection