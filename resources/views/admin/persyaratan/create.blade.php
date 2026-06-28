@extends('adminlte::page')

@section('title', 'Tambah Persyaratan')

@section('content_header')
    <h1><i class="fas fa-plus mr-2"></i> Tambah Persyaratan Baru</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Isi Data Persyaratan</h3>
                    </div>
                    <form action="{{ route('admin.persyaratan.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="layanan">Nama Layanan <span class="text-danger">*</span></label>
                                <input type="text" 
                                       name="layanan" 
                                       id="layanan"
                                       class="form-control @error('layanan') is-invalid @enderror"
                                       value="{{ old('layanan') }}"
                                       placeholder="Contoh: Kartu Keluarga, KTP, dll"
                                       required>
                                @error('layanan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="deskripsi_syarat">Teks Persyaratan <span class="text-danger">*</span></label>
                                <textarea name="deskripsi_syarat" 
                                          id="deskripsi_syarat"
                                          class="form-control @error('deskripsi_syarat') is-invalid @enderror"
                                          rows="8"
                                          placeholder="Tuliskan daftar persyaratan di sini (gunakan enter / baris baru untuk memisahkan):&#10;1. Kartu Keluarga (KK)&#10;2. Akta Kelahiran&#10;3. ..."
                                          required>{{ old('deskripsi_syarat') }}</textarea>
                                @error('deskripsi_syarat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    Tekan Enter untuk membuat baris baru. Setiap baris baru akan langsung ditampilkan sebagai poin/baris terpisah di form pengguna.
                                </small>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save mr-1"></i> Simpan
                            </button>
                            <a href="{{ route('admin.persyaratan.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left mr-1"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
