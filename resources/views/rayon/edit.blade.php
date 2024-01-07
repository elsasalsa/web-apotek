@extends('layouts.template')

@section('content')
    <form action="{{ route('rayon.update', $rayon['id']) }}" method="post">
        @csrf
        @method('PATCH')

        @if ($errors->any())
            <ul class="alert alert-danger p-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <div class="main"  style="margin: 50px ;">
            <h3 class="text-data">Edit Data Rayon</h3>
            <ul class="nav" style="margin-left: -15px;">
                <li class="nav-item">
                    <a class="nav-link" href="{{ URL('/dashboard')}}" style="color:#93BFCF;" >Home /</a>
                </li>
                <li class="nav-item nav-underline">
                    <a class="nav-link" href="{{ route('rayon.index') }}" style="color:#93BFCF;">Data Rayon </a>
                </li>
                <li class="nav-item nav-underline">
                    <a class="nav-link" href="#" style="color:#6096B4;"> / Edit Data</a>
                </li>
            </ul>
            <div class="card p-5">
                <div class="mb-3 row">
                    <label for="rayon" class="form-label @error('rayon') is-invalid @enderror">Rayon :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="rayon" name="rayon"
                            value="{{ $rayon['rayon'] }}">
                        @error('rayon')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 row">
                        <label for="name" class="form-label">Pembimbing Siswa :</label>
                        <div class="col-sm-10">
                            <select name="name" id="name" class="form-select">
                                <option selected hidden disabled>Pilih</option>
                                @foreach ($rayons as $item)
                                    <option value="{{ $item['name'] }}">{{ $item['name'] }}</option>
                                @endforeach
                            </select>

                            <button type="submit" style="background-color: #9BB8CD; color: white;" class="btn mt-3">Edit
                                Data</button>
    </form>
@endsection
