@extends('layouts.template')

@section('content')

    @if(Session::get('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif

    @if(Session::get('deleted'))
        <div class="alert alert-warning">{{ Session::get('deleted') }}</div>
    @endif

    <div class="main">
        <h3 class="text-data" style="margin: 25px 50px 5px 50px;">Data User</h3>
        <ul class="nav" style="margin-left: 35px; margin-bottom: 25px;">
            <li class="nav-item">
                <a class="nav-link disabled" href="#" aria-disabled="true">Home /</a>
            </li>
            <li class="nav-item nav-underline">
                <a class="nav-link" href="{{ route('user.index')}}">Data User</a>
            </li>
        </ul>

        <div class="card" style="background-color: white; padding:20px; margin: 20px 50px">
            <div class="d-flex mb-3" style="justify-content:space-between;">
                <form action="{{ route('user.index') }}" style="" method="GET">
                    <input type="text" name="query" placeholder="Cari...">
                    <button type="submit" class="btn btn-info"><ion-icon name="search-outline"></ion-icon></button>
                    <a href="{{ route('user.index') }}" class="btn btn-secondary"><ion-icon name="refresh-outline"></ion-icon></a>
                </form>
                <a class="btn btn-secondary" href="{{ route('user.create') }}">Tambah Pengguna</a>
            </div>

            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = $users->firstItem(); @endphp
                    @foreach ($users as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['email'] }}</td>
                            <td>{{ $item['role'] }}</td>
                            <td class="d-flex justify-content-center">
                                <a href="{{ route('user.edit', $item['id']) }}" class="btn btn-primary me-3">Edit</a>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#edit-stock-{{ $item->id }}">
                                    Hapus
                                </button>
                            </td>
                        </tr>

                        <!-- Modal -->
                        <div class="modal" tabindex="-1" id="edit-stock-{{ $item->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Yakin ingin menghapus data ini? </p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <form action="{{ route('user.delete', $item->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>

            {{-- <div class="d-flex justify-content-end">
              
              @if ($users->count())
                  {{$users->links()}}
              @endif
          </div> --}}
@endsection
