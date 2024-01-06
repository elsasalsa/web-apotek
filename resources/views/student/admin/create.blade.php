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
                    <a class="nav-link disabled" href="#" aria-disabled="true">Home /</a>
                </li>
                <li class="nav-item nav-underline">
                    <a class="nav-link" href="{{ route('admin.student.index') }}">Data Siswa </a>
                </li>
                <li class="nav-item nav-underline">
                    <a class="nav-link" href="{{ route('admin.student.create') }}"> / Tambah Data</a>
                </li>
            </ul>

            <div class="card p-5" style="margin: 10px 50px;">
                <div class="mb-3 row">
                    <label for="nis" class="col-sm-2 col-form-label">Nis : </label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nis" name="nis">
                    </div>
                    @error('nis')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 row">
                    <label for="name" class="col-sm-2 col-form-label">Nama : </label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 row">
                    <label for="rombel" class="col-sm-2 col-form-label">Rombel : </label>
                    <div class="col-sm-10">
                        <select name="rombel" id="rombel" class="form-select">
                            <option selected hidden disabled>Pilih</option>
                            @foreach ($rombels as $item)
                                <option value="{{ $item['rombel'] }}">{{ $item['rombel'] }}</option>
                            @endforeach
                        </select>
                        @error('rombel')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="rayon" class="col-sm-2 col-form-label">Rayon : </label>
                    <div class="col-sm-10">
                        <select name="rayon" id="rayon" class="form-select">
                            <option selected hidden disabled>Pilih</option>
                            @foreach ($rayons as $item)
                                <option value="{{ $item['rayon'] }}">{{ $item['rayon'] }}</option>
                            @endforeach
                        </select>
                        @error('rayon')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>



                    <button type="submit" style="background-color: #9BB8CD; color: white;" class="btn mt-4">Tambah
                        Data</button>
    </form>
@endsection
