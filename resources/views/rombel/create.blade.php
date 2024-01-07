@extends('layouts.template')

@section('content')
    <form action="{{ route('rombel.store') }}" method="post">
        @csrf

        @if (Session::get('success'))
            <div class="alert alert-success"> {{ Session::get('success') }}</div>
        @endif

        <div class="main">
            <h3 class="text-data" style="margin: 25px 50px 5px 50px;">Data Rombel</h3>
            <ul class="nav" style="margin-left: 35px;  ">
                <li class="nav-item">
                    <a class="nav-link" href="{{ URL('/dashboard')}}" style="color:#93BFCF;" >Home /</a>
                </li>
                <li class="nav-item nav-underline">
                    <a class="nav-link" href="{{ route('rombel.index') }}" style="color:#93BFCF;">Data Rombel /</a>
                </li>
                <li class="nav-item nav-underline">
                    <a class="nav-link" href="#" style="color:#6096B4;"> Tambah Data</a>
                </li>
            </ul>

            <div class="card p-5" style="margin: 20px 50px;">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Rombel :</span>
                    <input type="text" id="rombel" name="rombel" class="form-control" placeholder="Masukkan Rombel"
                        aria-label="Rombel" aria-describedby="basic-addon1">
                </div>
                @error('rombel')
                    <div class="text-danger">{{ $message }}</div>
                @enderror


                {{-- <div class="mb-3 row" >
            <label for="rombel" class="col-sm-2 col-form-label">Rombel :</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="rombel" name="rombel">
            </div>
        </div> --}}

                <button type="submit" style="background-color: #9BB8CD; color: white;" class="btn mt-3">Tambah
                    Data</button>
    </form>
@endsection
