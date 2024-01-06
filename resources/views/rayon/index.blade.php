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
        <h3 class="rombel-text" style="margin: 30px 0 10px 50px;">Data Rayon</h3>
        <ul class="nav" style="margin-left: 35px;  ">
            <li class="nav-item">
                <a class="nav-link disabled" aria-disabled="true">Home /</a>
            </li>
            <li class="nav-item nav-underline">
                <a class="nav-link" href="">Data Rayon</a>
            </li>
        </ul>

        <div class="card" style="background-color: white; padding:20px; margin: 30px 50px">
            <div class="d-flex mb-3" style="justify-content:space-between; ">
                <form action="{{ route('rayon.index') }}" style="" method="GET">
                    <input type="text" name="query" placeholder="Cari...">
                    <button type="submit" class="btn btn-info"><ion-icon name="search-outline"></ion-icon></button>
                    <a href="{{ route('rayon.index') }}" class="btn btn-secondary"><ion-icon name="refresh-outline"></ion-icon></a>  
            
                </form>
                <a class="btn btn-secondary" style="" href="{{ route('rayon.create') }}">Tambah Data Rayon</a>
            </div>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Rayon</th>
                        <th>Pembimbing Siswa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($rayon as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item['rayon'] }}</td>
                            <td>{{ $item['user']['name'] }}</td>
                            <td class="d-flex">
                                <a href="{{ route('rayon.edit', $item['id']) }}" class="btn btn-primary me-2">Edit</a>
                                <form action="{{ route('rayon.delete', $item['id']) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{-- memunculkan pagination --}}
    <div class="d-flex justify-content-end">
        {{-- pagination dimunculin hanya jika dirayons nya ada / > 0 --}}
        {{-- @if ($rayon->count())
        {{$rayons->links()}}
    @endif --}}
    </div>
@endsection
