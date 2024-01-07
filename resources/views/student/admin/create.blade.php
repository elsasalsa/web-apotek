@extends('layouts.template')

@section('content')
    <form action="{{ route('admin.student.store') }}" method="post">
        @csrf

        @if (Session::get('success'))
            <div class="alert alert-success"> {{ Session::get('success') }}</div>
        @endif


        <div class="main">
            <h3 class="text-data" style="margin: 25px 50px 5px 50px;">Data Siswa</h3>
            <ul class="nav" style="margin-left: 35px;  ">
                <li class="nav-item">
                    <a class="nav-link" href="{{ URL('/dashboard')}}" style="color:#93BFCF;" >Home /</a>
                </li>
                <li class="nav-item nav-underline">
                    <a class="nav-link" href="{{ route('admin.student.index') }}" style="color:#93BFCF;">Data Siswa </a>
                </li>
                <li class="nav-item nav-underline">
                    <a class="nav-link" href="#" style="color:#6096B4;"> / Tambah Data</a>
                </li>
            </ul>

            <div class="card" style="margin: 5px 50px; padding: 30px;">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Nis :</span>
                    <input type="number" id="nis" name="nis" class="form-control" placeholder="Masukkan Nis"
                        aria-label="nis" aria-describedby="basic-addon1">
                </div>
                @error('nis')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Nama :</span>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Masukkan name"
                        aria-label="name" aria-describedby="basic-addon1">
                </div>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Rombel :</span>
                    <select name="rombel" id="rombel" class="form-select" aria-label="Default select example">
                        <option selected hidden disabled>Pilih Rombel</option>
                        @foreach ($rombels as $item)
                            <option value="{{ $item['rombel'] }}">{{ $item['rombel'] }}</option>
                        @endforeach
                    </select>
                </div>
                @error('rombel')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Rayon :</span>
                    <select name="rayon" id="rayon" class="form-select" aria-label="Default select example">
                        <option selected hidden disabled>Pilih Rayon</option>
                        @foreach ($rayons as $item)
                            <option value="{{ $item['rayon'] }}">{{ $item['rayon'] }}</option>
                        @endforeach
                    </select>
                </div>
                @error('rayon')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

                <button type="submit" style="background-color: #9BB8CD; color: white;" class="btn mt-2">Tambah
                    Data</button>
    </form>
@endsection
