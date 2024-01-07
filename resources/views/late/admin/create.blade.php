@extends('layouts.template')

@section('content')
    <form action="{{ route('admin.late.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @if (Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif

        <div class="main">
            <h3 class="text-data" style="margin: 25px 50px 5px 50px;">Data Keterlambatan</h3>
            <ul class="nav" style="margin-left: 35px;  ">
                <li class="nav-item">
                    <a class="nav-link" href="{{ URL('/dashboard')}}" style="color:#93BFCF;" >Home /</a>
                </li>
                <li class="nav-item nav-underline">
                    <a class="nav-link" href="{{ route('admin.late.index') }}" style="color:#93BFCF;">Data Keterlambatan </a>
                </li>
                <li class="nav-item nav-underline">
                    <a class="nav-link" href="#"  style="color:#6096B4;"> / Tambah Data</a>
                </li>
            </ul>

            @csrf
            <div class="card p-5" style="margin: 5px 50px ">
                <div class="mb-3 row">
                    <label for="name" class="col-sm-2 col-form-label @error('name') is-invalid @enderror">Nama :
                    </label>
                    <div class="col-sm-10">
                        <select name="name" id="name" class="form-select">
                            <option selected hidden disabled>Pilih</option>
                            @foreach ($students as $item)
                                <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                            @endforeach
                        </select>
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="date_time_late" class="col-sm-2 col-form-label @error('date_time_late') is-invalid @enderror">Tanggal : </label>
                    <div class="col-sm-10">
                        <input type="datetime-local" class="form-control" id="date_time_late" name="date_time_late" value="{{ old('date_time_late') }}">
                        @error('date_time_late')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="information"
                        class="col-sm-2 col-form-label @error('information') is-invalid @enderror">Informasi
                        :</label>
                    <div class="col-sm-10">
                        <textarea type="text" class="form-control" id="information" name="information"
                            value="{{ old('information') }}"></textarea>
                            @error('information')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                </div>
                <div class="mb-3 row">
                    <label for="bukti" class="col-sm-2 col-form-label @error('bukti') is-invalid @enderror">Bukti
                        :</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" id="bukti" name="bukti"
                            value="{{ old('bukti') }}">
                        @error('bukti')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                </div>
                {{-- <video id="camera" width="640" height="480" autoplay></video>

        <script>
            Akses kamera saat halaman dimuat
            document.addEventListener('DOMContentLoaded', function () {
                navigator.mediaDevices.getUserMedia({ video: true })
                    .then(function (stream) {
                        var video = document.getElementById('camera');
                        video.srcObject = stream;
                    })
                    .catch(function (error) {
                        console.error('Error accessing camera:', error);
                    });
            });
        </script> --}}


                <button type="submit" style="background-color: #9BB8CD; color: white;" class="btn mt-2">Tambah Data</button>
    </form>

    <script>
        // Mendapatkan elemen input berdasarkan ID
        var dateTimeLateInput = document.getElementById('date_time_late');
    
        // Mendapatkan tanggal dan waktu saat ini
        var currentDateTime = new Date();
    
        // Mengonversi ke zona waktu WIB (UTC+7)
        currentDateTime.setHours(currentDateTime.getHours() + 7);
    
        // Format tanggal dan waktu dalam format yang sesuai dengan datetime-local
        var formattedDateTime = currentDateTime.toISOString().slice(0, 16);
    
        // Mengatur nilai input dengan tanggal dan waktu saat ini dalam zona waktu WIB
        dateTimeLateInput.value = formattedDateTime;
    </script>
    
@endsection
