@extends('layouts.template')

@section('content')
    @if (Session::get('success'))
        <div class="alert alert-success">{{Session::get('success')}}</div>
    @endif
    @if(Session::get('deleted'))
        <div class="alert alert-warning">
        {{Session::get('deleted')}}</div>
    @endif
    <div class="main">
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
            <div class="d-flex justify-content-start mb-3">
                <a class="btn btn-primary" style="margin-bottom: 20px;" href="{{ route('admin.late.create') }}">Tambah Data</a>
                <a class="btn btn-success" style="margin-left:10px; margin-bottom: 20px;" href="{{ route('admin.late.export')}}">Export Data</a>
            </div>
        <ul class="nav nav-tabs" >
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="">Data Keseluruhan</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('admin.late.rekap')}}">Rekapitulasi Keterlambatan</a>
            </li>
          </ul>

        
        <div class="card" style="background-color: white; padding:20px; margin-top:20px;">
            <div class="d-flex mb-3 justify-content-end">
                <form action="{{ route('admin.late.index') }}" style="" method="GET" >
                  <input type="text" name="query" placeholder="Cari...">
                  <button type="submit" class="btn btn-info" ><ion-icon name="search-outline"></ion-icon></button>
                  <a href="{{ route('admin.late.index') }}" class="btn btn-secondary"><ion-icon name="refresh-outline"></ion-icon></a>  
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
            {{-- <th>Bukti</th> --}}
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1; @endphp
        @foreach ($lates as $item)
        <tr>
            <td>{{$no++}}</td>
            <td>{{ $item['student']['nis'] }}</td>
            <td>{{ $item['student']['name'] }}</td>
            <td>{{ $item['date_time_late'] }}</td>
            <td>{{ $item['information'] }}</td>
            {{-- <td>{{ DB::table('lates')->where('student_id', $item['student']['id'])->count() }}</td> --}}
            {{-- <td>{{ $item['bukti'] }}</td> --}}
            <td class="d-flex">
                <a href="{{ route('admin.late.edit', $item['id']) }}" class="btn btn-primary me-2">Edit</a>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#edit-stock">
                    Hapus
                  </button>
            </td>
        </tr>
        <div class="modal" tabindex="-1" id="edit-stock">
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
                  <form action="{{ route('admin.late.delete', $item['id']) }}" method="post">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger">Hapus</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
</div>
</div>
{{--memunculkan pagination--}}
@endsection