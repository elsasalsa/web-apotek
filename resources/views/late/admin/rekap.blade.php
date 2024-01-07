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
        <h3 class="text-data" style="margin: 25px 50px 5px 50px;">Data Keterlambatan</h3>
        <ul class="nav" style="margin-left: 35px;  ">
            <li class="nav-item">
                <a class="nav-link" href="{{ URL('/dashboard')}}" style="color:#93BFCF;" >Home /</a>
            </li>
            <li class="nav-item nav-underline">
                <a class="nav-link" href="{{ route('admin.late.index') }}" style="color:#93BFCF;">Data Keterlambatan /</a>
            </li>
            <li class="nav-item nav-underline">
                <a class="nav-link" href="#" style="color:#6096B4;"> Rekapitulasi Data</a>
            </li>
        </ul>

        <div class="card p-5" style="margin:10px 40px;">
            <div class="d-flex justify-content-start mb-3">
                <a class="btn btn-primary" style="margin-bottom: 10px;" href="{{ route('admin.late.create') }}">Tambah
                    Data</a>
                <a class="btn btn-success" style="margin-left:10px; margin-bottom: 10px;"
                    href="{{ route('admin.late.export') }}">Export Data</a>
            </div>

            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ route('admin.late.index') }}">Data Keseluruhan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="">Rekapitulasi Keterlambatan</a>
                </li>
            </ul>


            <div class="card" style="background-color: white; padding:20px; margin-top:20px;">
                <div class="d-flex mb-3 justify-content-end">
                    <form action="{{ route('admin.late.rekap') }}" style="" method="GET">
                        <input type="text" name="query" placeholder="Cari...">
                        <button type="submit" class="btn btn-info"><ion-icon name="search-outline"></ion-icon></button>
                        <a href="{{ route('admin.late.rekap') }}" class="btn btn-secondary"><ion-icon
                                name="refresh-outline"></ion-icon></a>
                    </form>
                </div>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nis</th>
                            <th>Nama</th>
                            <th>Jumlah</th>
                            <th>Detail</th>
                            <th>Surat</th>
                            {{-- <th>Bukti</th> --}}

                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach ($lates as $item)
                            @php
                                $jumlahKeterlambatan = DB::table('lates')
                                    ->where('student_id', $item['student']['id'])
                                    ->count();
                            @endphp
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $item['student']['nis'] }}</td>
                                <td>{{ $item['student']['name'] }}</td>
                                <td>{{ $jumlahKeterlambatan }}</td>
                                <td><a href="{{ route('admin.late.detail', ['id' => $item['student']['id']]) }}">Lihat</a>
                                </td>
                                <td>
                                    @if ($jumlahKeterlambatan >= 3)
                                        <a href="{{ route('admin.late.print', ['id' => $item['student']['id']]) }}">
                                            <button class="btn btn-primary">Cek Surat Pernyataan</button>
                                        </a>
                                    @endif
                                </td>
                                {{-- <td><img src="{{ $item['bukti'] }}" ><br></td> --}}
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- memunculkan pagination --}}
@endsection
