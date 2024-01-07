{{--panggil file template --}}
@extends('layouts.template')

{{-- isi bagian yield --}}
@section('content')


<div class="jumbotron py-4 px-5">
    @if (Session::get('failed'))
        <div class="alert alert-danger"> {{ Session::get('failed')}} </div>
    @endif
    
    
</div>
<div class="main" >
<h3 class="dashboard text-black" style="margin: 0 50px 50px;">Selamat Datang {{ Auth::user()->name }} !</h3>
{{-- <ul class="nav" style="margin-left: 35px; margin-bottom: 25px; ">
  <li class="nav-item " >
    <a class="nav-link" aria-current="page" href="#">Home /</a>
  </li>
  <li class="nav-item nav-underline">
    <a class="nav-link" href="">Dashboard</a>
  </li>
</ul> --}}

@if (Auth::user()->role == 'admin')
<div class="row" style="margin: 10px 40px;">
    <!-- Peserta Didik Card -->
    <div class="col-md-6 mb-4">
      <div class="card shadow-lg">
        <div class="card-body">
          <h5 class="card-title">Peserta Didik</h5>
          <div class="card-bulet " style="display:flex;">
            <div class="card-text" style="  background-color: rgb(228, 214, 214); border-radius:100px; width:7%; height:15%;" ><center><ion-icon name="person-outline"></ion-icon></center></div>
            <p class="text-das" style="margin-left: 10px;"> {{ DB::table('students')->count() }}</p>
          </div>
          </div>
      </div>
    </div>
  
    <!-- Administrator Card -->
    <div class="col-md-3 mb-4">
      <div class="card shadow-lg">
        <div class="card-body">
          <h5 class="card-title" >Administrator</h5>
          <div class="card-bulet " style="display:flex;">
          <div class="card-text" style="  background-color: rgb(228, 214, 214); border-radius:100px; width:15%; height:15%;" ><center><ion-icon name="person-outline"></ion-icon></center></div>
          <p class="text-das" style="margin-left: 10px;"> {{ DB::table('users')->where('role', 'admin')->count() }}</p>
        </div>
        </div>
      </div>
    </div>
    
    
    <!-- Pembimbing Siswa Card -->
    <div class="col-md-3 mb-4">
      <div class="card shadow-lg">
        <div class="card-body">
          <h5 class="card-title">Pembimbing Siswa</h5>
          <div class="card-bulet " style="display:flex;">
            <div class="card-text" style="  background-color: rgb(228, 214, 214); border-radius:100px; width:15%; height:15%;" ><center><ion-icon name="person-outline"></ion-icon></center></div>
            <p class="text-das" style="margin-left: 10px;"> {{ DB::table('users')->where('role', 'ps')->count() }}</p>
          </div>
          </div>
        </div>
      </div>
   
  
    <!-- Rombel Card -->
    <div class="col-md-6 mb-4">
      <div class="card shadow-lg">
        <div class="card-body">
          <h5 class="card-title">Rombel</h5>
          <div class="card-bulet " style="display:flex;">
            <div class="card-text" style="  background-color: rgb(228, 214, 214); border-radius:100px; width:7%; height:25%;" ><center><ion-icon name="bookmarks-outline"></ion-icon></center></div>
            <p class="text-das" style="margin-left: 10px;"> {{ DB::table('rombels')->count() }}</p>
        </div>
      </div>
    </div>
    </div>
    
  
    <!-- Rayon Card -->
    <div class="col-md-6 mb-4">
      <div class="card shadow-lg">
        <div class="card-body">
          <h5 class="card-title">Rayon</h5>
          <div class="card-bulet " style="display:flex;">
            <div class="card-text" style="  background-color: rgb(228, 214, 214); border-radius:100px; width:7%; height:25%;" ><center><ion-icon name="bookmarks-outline"></ion-icon></center></div>
            <p class="text-das" style="margin-left: 10px;"> {{ DB::table('rayons')->count() }}</p>
        </div>
      </div>
    </div>
    </div>
    @endif

    @if (Auth::user()->role == 'ps')
    <div class="row" style="margin: 10px 40px;">
    <div class="col-md-6 mb-4">
      <div class="card shadow-lg">
        <div class="card-body">
          <h5 class="card-title"><b>Peserta Didik Rayon {{ $name_rayon }}</b></h5>
          <div class="card-bulet " style="display:flex;">
            <div class="card-text" style="  background-color: rgb(228, 214, 214); border-radius:100px; width:7%; height:15%;" ><center><ion-icon name="person-outline"></ion-icon></center></div>
            <p class="text-das" style="margin-left: 10px;">{{ $student }}</p>
          </div>
          </div>
      </div>
    </div>

    <div class="col-md-6 mb-4">
      <div class="card shadow-lg">
        <div class="card-body">
          <h5 class="card-title"><b>Keterlambatan  {{ $name_rayon }} Hari Ini </h5> ( {{ \Carbon\Carbon::now()->toDateString() }} )</b>
          <div class="card-bulet " style="display:flex; margin-top:8px;">
            <div class="card-text" style="  background-color: rgb(228, 214, 214); border-radius:100px; width:7%; height:25%;" ><center><ion-icon name="bookmarks-outline"></ion-icon></center></div>
            <p class="text-das" style="margin-left: 10px;">{{$todayLateCount}}</p>
        </div>
      </div>
    </div>
    </div>
    @endif

@endsection