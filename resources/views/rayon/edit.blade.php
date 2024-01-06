@extends('layouts.template')

@section('content')
    <form action="{{ route('rayon.update', $rayon['id']) }}" method="post" style="margin: 50px;">
        @csrf
        @method('PATCH')

        @if ($errors->any())
            <ul class="alert alert-danger p-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
            
        <div class="mb-3 row">
            <div class="card p-5">
    
            <label for="rayon" class="form-label @error('rayon') is-invalid @enderror">Rayon :</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="rayon" name="rayon" value="{{ $rayon['rayon'] }}">
              @error('rayon')
              <div class="text-danger">{{ $message }}</div>
              @enderror
            </div>
          
          <div class="mb-3 row">
            <label for="name" class="form-label">Pembimbing Siswa :</label>
            <div class="col-sm-10">
                <select name="name" id="name" class="form-control">
                    <option selected hidden disabled>Pilih</option>
                    @foreach ($rayons as $item)              
                        <option value="{{ $item['name'] }}">{{ $item['name'] }}</option>
                    @endforeach
                </select>
            
            <button type="submit" style="background-color: #9BB8CD; color: white;" class="btn mt-3">Edit Data</button>
        </form>
@endsection