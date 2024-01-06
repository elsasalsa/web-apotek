@extends('layouts.template')

@section('content')
    <form action="{{ route('admin.late.update', $late['id']) }}" method="post" style="margin: 50px;" class="card p-5">
        @csrf
        @method('PATCH')

        @if ($errors->any())
            <ul class="alert alert-danger p-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
            
        <div class="mb-3 row" >
            <label for="name" class="col-sm-2 col-form-label @error('name') is-invalid @enderror">Nama : </label>
            <div class="col-sm-10">
                <select name="name" id="name" class="form-select">
                    <option selected hidden disabled>Pilih</option>
                    @foreach ($students as $item)              
                        <option value="{{ $item['name'] }}">{{ $item['name'] }}</option>
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
            <label for="information" class="col-sm-2 col-form-label @error('information') is-invalid @enderror">Informasi
                :</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="information" name="information"
                    value="{{ $late['information'] }}">
                @error('information')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="mb-3 row">
            <label for="bukti" class="col-sm-2 col-form-label @error('bukti') is-invalid @enderror">Bukti :</label>
            <div class="col-sm-10">
                <input type="file" class="form-control" id="bukti" name="bukti" value="{{ $late['bukti'] }}">
                @error('bukti')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
            
            <button type="submit"  style="background-color: #9BB8CD; color: white;" class="btn mt-3">Edit Data</button>
        </form>
@endsection