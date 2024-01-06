@extends('layouts.template')

@section('content')
    <form action="{{ route('user.update', $user['id']) }}" method="post" >
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
        <div class="mb-3 row">
            <label for="name" class="col-sm-2 col-form-label">Nama : </label>
            <div class="col-sm-10">
                <input type="text" name="name" id="name" class="form-control" value="{{ $user['name'] }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="email" class="col-sm-2 col-form-label">Email : </label>
            <div class="col-sm-10">
                <input type="text" name="email" id="email" class="form-control" value="{{ $user['email'] }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="role" class="col-sm-2 col-form-label">Role : </label>
            <div class="col-sm-10">
               <select name="role" id="role" class="form-select">
                    <option selected disabled hidden>Pilih</option>
                    <option value="admin" {{ $user['role'] == 'administrator' ? 'selected' : '' }}>administrator</option>
                    <option value="ps" {{ $user['role'] == 'ps' ? 'selected' : '' }}>Pembimbing Siswa</option>
               </select>
            </div>
        </div>
        <button type="submit" style="background-color: #9BB8CD; color: white;" class="btn mt-3">Ubah Data</button>
    </form>
@endsection