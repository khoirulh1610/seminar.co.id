@php
$index = ':index';
if (isset($no)) {
    $index = $no - 1;
}
@endphp
<div class="card rounded-4 card-ticket">
    <div class="card-body">
        <fieldset>
            <legend>Tiket {{ $no ?? ':no' }}</legend>
            <hr>
            <div class="row">
                <div class="form-group col-5">
                    <label class="form-control-label" for="sapaan-select">Sapaan</label>
                    <select class="form-select @error('sapaan') is-invalid @enderror"
                        name="ticket[{{ $index }}][sapaan]" id="sapaan-select">
                        @foreach (config('app.sapaan') as $sapaan)
                            <option value="{{ $sapaan }}">{{ $sapaan }}</option>
                        @endforeach
                    </select>
                    @error('sapaan')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-7">
                    <label class="form-control-label" for="panggilan-input">Panggilan</label>
                    <input type="text" id="panggilan-input"
                        class="form-control @error('panggilan') is-invalid @enderror"
                        name="ticket[{{ $index }}][panggilan]" value="{{ old('panggilan') }}" required
                        autocomplete="panggilan">
                    @error('panggilan')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-6">
                    <label class="form-control-label" for="nama-input">Nama Lengkap</label>
                    <input type="text" id="nama-input" class="form-control @error('nama') is-invalid @enderror"
                        name="ticket[{{ $index }}][nama]" value="{{ old('nama') }}" required
                        autocomplete="nama">
                    @error('nama')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-6">
                    <label class="form-control-label" for="prefisi-input">Profesi</label>
                    <input type="text" id="prefisi-input" class="form-control @error('prefisi') is-invalid @enderror"
                        name="ticket[{{ $index }}][profesi]" value="{{ old('prefisi') }}" required
                        autocomplete="prefisi">
                    @error('prefisi')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-control-label" for="email-input">Email</label>
                    <input type="email" id="email-input" class="form-control @error('email') is-invalid @enderror"
                        name="ticket[{{ $index }}][email]" value="{{ old('email') }}" required
                        autocomplete="email">
                    @error('email')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-control-label" for="phone-input">Nomor Whatsapp</label>
                    <input type="tel" id="phone-input" class="form-control @error('phone') is-invalid @enderror"
                        name="ticket[{{ $index }}][phone]" value="{{ old('phone') }}" required
                        autocomplete="phone">
                    @error('phone')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <strong>Tanggal Lahir</strong>
                </div>

                <div class="form-group col-4">
                    <label class="form-control-label" for="tgl-select">Tanggal</label>
                    <select class="form-select @error('tgl') is-invalid @enderror"
                        name="ticket[{{ $index }}][tgl]" id="tgl-select">
                        @foreach (range(1, 31) as $tgl)
                            <option value="{{ $tgl }}">{{ addZero($tgl, 2) }}</option>
                        @endforeach
                    </select>
                    @error('tgl')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-4">
                    <label class="form-control-label" for="bln-select">Bulan</label>
                    <select class="form-select @error('bln') is-invalid @enderror"
                        name="ticket[{{ $index }}][bln]" id="bln-select">
                        @foreach (range(1, 12) as $bln)
                            <option value="{{ $bln }}">{{ addZero($bln, 2) }}</option>
                        @endforeach
                    </select>
                    @error('bln')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-4">
                    <label class="form-control-label" for="thn-select">Tahun</label>
                    @php
                        $y = (int) now()
                            ->subYears(18)
                            ->format('Y');
                    @endphp
                    <select class="form-select @error('thn') is-invalid @enderror"
                        name="ticket[{{ $index }}][thn]" id="thn-select">
                        @foreach (array_reverse(range($y, $y - 65)) as $thn)
                            <option value="{{ $thn }}">{{ $thn }}</option>
                        @endforeach
                    </select>
                    @error('thn')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-6">
                    <label class="form-control-label" for="provinsi-select">Provinsi</label>
                    <select class="form-select @error('provinsi') is-invalid @enderror province-select"
                        name="ticket[{{ $index }}][provinsi]" data-index="{{ $index }}"
                        id="provinsi-select">
                        @foreach ($provinsi as $prov)
                            <option value="{{ $prov->name }}" data-id="{{ $prov->id }}">{{ $prov->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('provinsi')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-6">
                    <label class="form-control-label" for="kota-select">Kota/Kabupaten</label>
                    <select class="form-select @error('kota') is-invalid @enderror"
                        name="ticket[{{ $index }}][kota]" id="kota-select">
                        @foreach ([] as $kota)
                            <option value="{{ $kota }}">{{ $kota }}</option>
                        @endforeach
                    </select>
                    @error('kota')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </fieldset>
    </div>
</div>
