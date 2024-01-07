@extends('layouts.template')

@section('content')
    <div class="main">

        @if (Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        @if (Session::get('deleted'))
            <div class="alert alert-warning">
                {{ Session::get('deleted') }}</div>
        @endif

        <h3 class="text-data" style="margin: 25px 50px 5px 50px;">Data Keterlambatan</h3>
        <ul class="nav" style="margin-left: 35px;  ">
            <li class="nav-item">
                <a class="nav-link disabled" href="#" aria-disabled="true">Home /</a>
            </li>
            <li class="nav-item nav-underline">
                <a class="nav-link" href="#">Data Keterlambatan </a>
            </li>

        </ul>
        <div class="card p-5" style="margin:10px 50px;">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="">Data Keseluruhan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('ps.late.rekap') }}">Rekapitulasi Keterlambatan</a>
                </li>
            </ul>


            <div class="card d-flex" style="background-color: white; padding:20px; margin-top:20px;">
                <div class="d-flex mb-3 justify-content-start">
                    <a href="{{ route('ps.late.export') }}" ><button
                            class="btn btn-success">Export Excel</button></a>
                </div>

                <div class="d-flex mb-3 justify-content-end">
                    <form action="{{ route('ps.late.index') }}" style="" method="GET">
                        <input type="text" name="query" placeholder="Cari...">
                        <button type="submit" class="btn btn-info"><ion-icon name="search-outline"></ion-icon></button>
                        <a href="{{ route('ps.late.index') }}" class="btn btn-secondary"><ion-icon
                                name="refresh-outline"></ion-icon></a>
                    </form>
                </div>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nis</th>
                            <th>Nama</th>
                            <th>Tanggal</th>
                            <th>Informasi</th>

                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach ($lates as $item)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $item['student']['nis'] ?? 'N/A' }}</td>
                                <td>{{ $item['student']['name'] ?? 'N/A' }}</td>
                                <td>{{ $item['date_time_late'] }}</td>
                                <td>{{ $item['information'] }}</td>
                                {{-- <td>{{ DB::table('lates')->where('student_id', $item['student']['id'])->count() }}</td> --}}
                                {{-- <td>{{ $item['bukti'] }}</td> --}}
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- memunculkan pagination --}}
@endsection
