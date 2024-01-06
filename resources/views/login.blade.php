{{-- @extends('layouts.template') --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
     <!-- Compiled and minified CSS -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

     <!-- Compiled and minified JavaScript -->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
     <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
             
  <title>Login Page</title>
</head>
  <style>
    .semua {
      display: flex;
    }
    .sebelah {
      width: 50%;
      background-color: white;
      padding: 113px 0;
    }
    .form-ini{
      width: 60%;
      background-color: #A0C3D2;
      padding: 30px 70px;
    }
    .form-ini h3 {
      color: white;
      margin-bottom: 50px;
    }
    .form-ini form {
      border-radius: 10px;
    }
  </style>
  
<body>
  <div class="semua">
  <div class="sebelah">
    <center>
    <img src="{{ asset('img/orang.jpeg') }}" alt="">
  </center>
  </div>
  {{-- <div class="form-ini">
    <h1>Data Keterlambatan <br> SMK WIKRAMA BOGOR</h1>
    <form action="{{ route('login.auth') }}" class="card p-4" method="POST">
        @csrf
        
        @if ( Session::get('failed') )
            <div class="alert alert-danger mt-3">{{ Session::get('failed') }}</div>
        @endif
      <div class="mb-3">
        <label for="email" class="form-label col-form-label @error('email') is-invalid @enderror">Email address</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email Anda!" value="{{ old('email') }}">
        @error('email')
          <div class="text-danger">{{ $message }}</div>
          @enderror
      </div>
      <div class="mb-3">
        <label for="password" class="form-label col-form-label @error('password') is-invalid @enderror">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password Anda!" value="{{ old('password') }}">
        @error('password')
          <div class="text-danger">{{ $message }}</div>
          @enderror
      </div>
      <button type="submit" class="btn btn-primary">Sign in</button>
    </form>
  </div>
</div> --}}

<div class="form-ini">
  <h3>Data Keterlambatan <br> SMK WIKRAMA BOGOR</h3>
  <form action="{{ route('login.auth') }}" class="card p-4" method="POST">
      @csrf
      
      @if ( Session::get('failed') )
          <div class="alert alert-danger mt-3">{{ Session::get('failed') }}</div>
      @endif

<div class="row">
  <form class="col s12">
    <div class="row">
      <div class="input-field col s6">
        <i class="material-icons prefix">account_circle</i>
        <label for="icon_prefix">Masukkan Email Anda!</label>
        <input id="icon_prefix" class="validate" type="email"  id="email" name="email" value="{{ old('email') }}">
        @error('email')
          <div class="text-danger">{{ $message }}</div>
          @enderror
      </div>
      </div>
      <div class="row">
        <div class="input-field col s6">
          <i class="material-icons prefix">lock</i>
          <label for="lock">Masukkan Password Anda!</label>
          <input id="lock" class="validate" type="password" id="password" name="password"  value="{{ old('password') }}">
          @error('password')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

    
      <button type="submit" class="btn">Sign in</button>
      
  </form>
</div>
</div>
  
</body>
</html>
