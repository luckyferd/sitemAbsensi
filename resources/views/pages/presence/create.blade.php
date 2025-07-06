@extends('layouts.main')
@section('content')
<div class="container my-4">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h4 class="card-title">
                        Tambah Kegiatan</h4>

                </div>
                
                <div class="col text-end">
                    <a href="{{route('presence.index')}}" class="btn btn-primary">
                        Kembali</a>
                    
                </div>
            </div>
           
            </div>

        <div class="card-body">
            <form action="{{route('presence.store')}}" method="post">
            @csrf
          <div class="mb-3">
            <label for="nama_kegiatan">Nama Kegiatan</label>
                <input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan" placeholder="Masukkan Nama Kegiatan" value="{{ old('nama_kegiatan') }}" required>
            @error('nama_kegiatan')
            <div class="alert alert-danger mt-2">
                {{ $message }}
                
            @enderror
          </div>
          <div class="mb-3">
            <label for="tgl_kegiatan">Tanggal Kegiatan</label>
                <input type="date" class="form-control" id="tgl_kegiatan" name="tgl_kegiatan" placeholder="Masukkan tgl Kegiatan" value="{{ old('tgl_kegiatan') }}" required>
                @error('tgl_kegiatan')
                <div class="alert alert-danger mt-2">
                    {{ $message }}
                    
                @enderror

          </div>
          <div class="mb-3">
            <label for="waktu_mulai">Waktu Mulai</label>
                <input type="time" class="form-control" id="waktu_mulai" name="waktu_mulai" placeholder="Masukkan tgl Kegiatan" value="{{ old('waktu_mulai') }}" required>
                @error('waktu_mulai')
                <div class="alert alert-danger mt-2">
                    {{ $message }}
                    
                @enderror

          </div>
          <button type="submit" class="btn btn-primary">
            Simpan
          </button>
        </form>
        </div>
    </div>
</div>
@endsection