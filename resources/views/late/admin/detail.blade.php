@extends('layouts.template')

@section('content')
    @if (Session::get('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif
    @if (Session::get('deleted'))
        <div class="alert alert-warning">
            {{ Session::get('deleted') }}</div>
    @endif
    <div class="main">
        <h3 class="text-data" style="margin: 25px 50px 5px 50px;">Detail Data Keterlambatan</h3>
        <ul class="nav" style="margin-left: 35px;  ">
            <li class="nav-item">
                <a class="nav-link " href="{{ URL('/dashboard') }}"  style="color:#93BFCF;">Home /</a>
            </li>
            <li class="nav-item nav-underline">
                <a class="nav-link" href="{{ route('admin.late.index') }}"  style="color:#93BFCF;">Data Keterlambatan /</a>
            </li>
            <li class="nav-item nav-underline">
                <a class="nav-link " href="{{ route('admin.late.rekap') }}"  style="color:#93BFCF;"> Rekapitulasi Data /</a>

            </li>
            <li class="nav-item nav-underline">
                <a class="nav-link" href="#" style="color:#6096B4;"> Detail Data</a>
            </li>
        </ul>
        <div class="row row-cols-1 row-cols-md-3 g-4" style="margin: 0px 35px;">
            @php $no = 1; @endphp
            @foreach ($lates as $late)
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="text-body-secondary">Keterlambatan Ke {{ $no++ }}</h5>
                            <p class="card-text">{{ $late->date_time_late }} <br><span>{{ $late->information }}</span></p>
                        </div>
                        <img src="{{ asset('storage/' . $late['bukti']) }}" class="card-img-top" alt="Bukti">
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

