@extends('layouts.template')

@section('content')
    <form action="{{ route('admin.late.update', $late['id']) }}" method="post">
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
            <h3 class="text-data" style="margin: 25px 50px 5px 50px;">Data Keterlambatan</h3>
            <ul class="nav" style="margin-left: 35px;  ">
                <li class="nav-item">
                    <a class="nav-link" href="{{ URL('/dashboard') }}" style="color:#93BFCF;">Home /</a>
                </li>
                <li class="nav-item nav-underline">
                    <a class="nav-link" href="{{ route('admin.late.index') }}" style="color:#93BFCF;">Data Keterlambatan
                    </a>
                </li>
                <li class="nav-item nav-underline">
                    <a class="nav-link" href="#" style="color:#6096B4;"> / Edit Data</a>
                </li>
            </ul>
            <div class="card p-5" style="margin: 0px 50px;">
                <div class="mb-3 row">
                    <label for="name" class="col-sm-2 col-form-label @error('name') is-invalid @enderror">Nama :</label>
                    <div class="col-sm-10">
                        <select name="student_id" id="name" class="form-select">
                            <option selected hidden disabled>Pilih</option>
                            @foreach ($students as $student)
                                <option value="{{ $student['id'] }}" @if ($student['id'] == $late['student_id']) selected @endif>
                                    {{ $student['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <div class="mb-3 row">
                    <label for="date_time_late"
                        class="col-sm-2 col-form-label @error('date_time_late') is-invalid @enderror">Tanggal : </label>
                    <div class="col-sm-10">
                        <input type="datetime-local" class="form-control" id="date_time_late" name="date_time_late"
                            value="{{ $late['date_time_late'] }}">
                        @error('date_time_late')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="information"
                        class="col-sm-2 col-form-label @error('information') is-invalid @enderror">Informasi:</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="information" name="information">{{ $late['information'] }}</textarea>
                        @error('information')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="bukti" class="col-sm-2 col-form-label @error('bukti') is-invalid @enderror">Bukti
                        :</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" id="bukti" name="bukti">
                        @if ($late['bukti'])
                            <img src="{{ asset('storage/' . $late['bukti']) }}" alt="Bukti"
                                style="width:15%; margin-top:5px;">
                        @endif

                        @error('bukti')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                <button type="submit" style="background-color: #9BB8CD; color: white;" class="btn">Edit Data</button>
    </form>
@endsection
