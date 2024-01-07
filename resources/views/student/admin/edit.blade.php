@extends('layouts.template')

@section('content')
    <form action="{{ route('admin.student.update', $student['id']) }}" method="post" class="card p-5">
        @csrf
        @method('PATCH')

        @if ($errors->any())
            <ul class="alert alert-danger p-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
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
                    <a class="nav-link" href="#" style="color:#6096B4;"> / Edit Data</a>
                </li>
            </ul>

        <div class="card p-5" style="margin: 20px;">
            <div class="mb-3 row" >
                <label for="nis" class="col-sm-2 col-form-label">Nis : </label>
                <div class="col-sm-10">
                    <input type="text" id="nis" name="nis" class="form-control" value="{{ $student['nis'] }}">
                </div>
            </div>
            <div class="mb-3 row" >
                <label for="name" class="col-sm-2 col-form-label">Nama : </label>
                <div class="col-sm-10">
                    <input type="text" id="name" name="name" class="form-control" value="{{ $student['name'] }}">
                </div>
            </div>
            <div class="mb-3 row" >
                <label for="rombel" class="col-sm-2 col-form-label">Rombel : </label>
                <div class="col-sm-10">
                    <select name="rombel" id="rombel" class="form-control">
                        <option selected hidden disabled>Pilih</option>
                        @foreach ($rombels as $item)              
                            <option value="{{ $item['rombel'] }}">{{ $item['rombel'] }}</option>
                        @endforeach
                    </select>
            </div>
        </div>
            <div class="mb-3 row" >
                <label for="rayon" class="col-sm-2 col-form-label">Rayon : </label>
                <div class="col-sm-10">
                    <select name="rayon" id="rayon" class="form-control">
                        <option selected hidden disabled>Pilih</option>
                        @foreach ($rayons as $item)              
                            <option value="{{ $item['rayon'] }}">{{ $item['rayon'] }}</option>
                        @endforeach
                    </select>
            </div>
            
            
            
            <button type="submit"  style="background-color: #9BB8CD; color: white;" class="btn mt-3">Edit Data</button>
        </form>
@endsection