@extends('layouts.template')

@section('content')
    <form action="{{ route('rayon.store') }}" method="post">
        @csrf

        @if (Session::get('success'))
            <div class="alert alert-success"> {{ Session::get('success') }}</div>
        @endif

        <div class="main">
            <h3 class="text-data" style="margin: 25px 50px 5px 50px;">Data Rayon</h3>
            <ul class="nav" style="margin-left: 35px;  ">
                <li class="nav-item">
                    <a class="nav-link" href="{{ URL('/dashboard')}}" style="color:#93BFCF;" >Home /</a>
                </li>
                <li class="nav-item nav-underline">
                    <a class="nav-link" href="{{ route('rayon.index') }}" style="color:#93BFCF;">Data Rayon </a>
                </li>
                <li class="nav-item nav-underline">
                    <a class="nav-link" href="#" style="color:#6096B4;"> / Tambah Data</a>
                </li>
            </ul>

            @csrf
            <div class="card p-5" style="margin: 10px 50px ">
                <div class="mb-3 row">
                    <label for="rayon" class="col-form-label @error('rayon') is-invalid @enderror">Rayon :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="rayon" name="rayon"
                            value="{{ old('rayon') }}">
                        @error('rayon')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 row">
                        <label for="name" class="col-form-label">Pembimbing Siswa :</label>
                        <div class="col-sm-10">
                            <select name="name" id="name" class="form-select" aria-label="Default select example">
                                <option selected hidden disabled>Pilih</option>
                                @foreach ($rayon as $item)
                                    <option value="{{ $item['name'] }}">{{ $item['name'] }}</option>
                                @endforeach
                            </select>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror


                            <button type="submit" style="background-color: #9BB8CD; color: white;" class="btn mt-3">Kirim
                                Data</button>
                            @error('type')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>



    </form>
    </div>

@endsection
