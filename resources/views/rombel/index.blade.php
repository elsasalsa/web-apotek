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
        <h3 class="text-data" style="margin: 25px 50px 5px 50px;">Data Rombel</h3>
        <ul class="nav" style="margin-left: 35px;  ">
            <li class="nav-item">
                <a class="nav-link disabled" href="#" aria-disabled="true">Home /</a>
            </li>
            <li class="nav-item nav-underline">
                <a class="nav-link" href="{{ route('rombel.index')}}">Data Rombel </a>
            </li>
      </ul>


        <div class="card" style="display:flex; background-color: white; padding:40px; margin: 20px 50px">
            <div class="d-flex mb-3" style="justify-content:space-between;">
                <form action="{{ route('rombel.index') }}" style="" method="GET" >
                  <input type="text" name="query" placeholder="Cari...">
                  <button type="submit" class="btn btn-info" ><ion-icon name="search-outline"></ion-icon></button>
                  <a href="{{ route('rombel.index') }}" class="btn btn-secondary"><ion-icon name="refresh-outline"></ion-icon></a>  
              </form>
                <a class="btn btn-secondary" style="" href="{{ route('rombel.create') }}">Tambah Data</a>
            </div>
            <div class="d-flex justify-content-start mb-3">
                
            </div>
        
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Rombel</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($rombels as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item['rombel'] }}</td>
                            <td class="d-flex">
                                <a href="{{ route('rombel.edit', $item['id']) }}" class="btn btn-primary me-2">Edit</a>
                                <form action="{{ route('rombel.delete', $item['id']) }}" method="post">
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
        {{-- pagination dimunculin hanya jika dirombels nya ada / > 0 --}}
        {{-- @if ($rombels->count())
            {{ $rombels->links() }}
        @endif --}}
    </div>
@endsection
