@extends('layouts.template')

@section('content')
    <form action="{{ route('user.update', $user['id']) }}" method="post">
        @csrf
        @method('PATCH')

        @if ($errors->any())
            <ul class="alert alert-danger p-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <div class="card p-5" style="margin: 20px 50px;">
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><ion-icon name="person-outline"></ion-icon></span>
                <input type="text" id="name" name="name" class="form-control" value="{{ $user['name'] }}"
                    aria-label="name" placeholder="Masukkan Nama" aria-describedby="basic-addon1">
            </div>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror


            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><ion-icon name="mail-outline"></ion-icon></span>
                <input type="email" id="email" name="email" class="form-control" value="{{ $user['email'] }}"
                    aria-label="Email" placeholder="Masukkan Email" aria-describedby="basic-addon1">
            </div>
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror

            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Role :</span>
                <select name="role" id="role" class="form-select" aria-label="Default select example">
                    <option selected hidden disabled>Pilih</option>
                    <option value="admin" {{ $user['role'] == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="ps" {{ $user['role'] == 'ps' ? 'selected' : '' }}>Pembimbing Siswa</option>
                </select>
            </div>
            @error('role')
                <div class="text-danger">{{ $message }}</div>
            @enderror

            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><ion-icon name="lock-open-outline"></ion-icon></span>
                <input type="text" id="password" name="password" class="form-control" aria-label="password"
                    placeholder="Masukkan Password Baru" aria-describedby="basic-addon1">
            </div>
            @error('password')
                <div class="text-danger">{{ $message }}</div>
            @enderror

            <button type="submit" style="background-color: #9BB8CD; color: white;" class="btn mt-3">Ubah Data</button>
    </form>
@endsection
