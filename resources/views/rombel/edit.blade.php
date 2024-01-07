@extends('layouts.template')

@section('content')
    <form action="{{ route('rombel.update', $rombel['id']) }}" method="post" >
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
            <h3 class="text-data" style="margin: 25px 50px 5px 50px;">Data Rombel</h3>
            <ul class="nav" style="margin-left: 35px;  ">
                <li class="nav-item">
                    <a class="nav-link" href="{{ URL('/dashboard')}}" style="color:#93BFCF;" >Home /</a>
                </li>
                <li class="nav-item nav-underline">
                    <a class="nav-link" href="{{ route('rombel.index') }}" style="color:#93BFCF;">Data Rombel </a>
                </li>
                <li class="nav-item nav-underline">
                    <a class="nav-link" href="#" style="color:#6096B4;"> / Edit Data Data</a>
                </li>
            </ul>

        <div class="card p-5" style="margin: 20px 50px;">
        <div class="mb-3 row">
            <label for="rombel" class="col-sm-2 col-form-label">Rombel :</label>
            <div class="col-sm-10">
                <input type="text" name="rombel" id="rombel" class="form-control" value="{{ $rombel['rombel'] }}">
            </div>
        </div>
        <button type="submit"  style="background-color: #9BB8CD; color: white;" class="btn mt-3">Ubah Data</button>
    </form>
@endsection