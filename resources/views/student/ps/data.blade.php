@extends('layouts.template')

@section('content')
    @if (Session::get('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif

    @if (Session::get('deleted'))
        <div class="alert alert-warning">{{ Session::get('deleted') }}</div>
    @endif
    <div class="main">
        <h3 class="rombel-text" style="margin: 30px 0 0px 50px;">Data Siswa</h3>
        <ul class="nav" style="margin: 15px 35px;  ">
            <li class="nav-item">
                <a class="nav-link disabled" aria-disabled="true">Home /</a>
            </li>
            <li class="nav-item nav-underline">
                <a class="nav-link" href="">Data Siswa</a>
            </li>
        </ul>

        <div class="card" style="display:flex; background-color: white; padding:40px; margin: 30px 50px">
            <div class="d-flex mb-3" style="justify-content:space-between; ">
                <form action="{{ route('ps.student.data') }}" style="" method="GET">
                    <input type="text" name="query" placeholder="Cari...">
                    <button type="submit" class="btn btn-info"><ion-icon name="search-outline"></ion-icon></button>
                    <a href="{{ route('ps.student.data') }}" class="btn btn-secondary"><ion-icon
                            name="refresh-outline"></ion-icon></a>
                </form>

            </div>
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nis</th>
                        <th>Nama</th>
                        <th>Rombel</th>
                        <th>Rayon</th>

                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($students as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item['nis'] }}</td>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['rombel'] ? $item['rombel']['rombel'] : 'N/A' }}</td>
                            <td>{{ $item['rayon'] ? $item['rayon']['rayon'] : 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- <div class="d-flex justify-content-end">
        
        @if ($students->count())
            {{ $students->links() }}
        @endif
    </div> --}}
        @endsection
