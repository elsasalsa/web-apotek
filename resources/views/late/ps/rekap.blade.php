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
                <a class="nav-link" href="{{ route('ps.late.index')}}">Data Keterlambatan </a>
            </li>
            <li class="nav-item nav-underline">
                <a class="nav-link" href="#"> / Rekapitulasi Data</a>
            </li>
      </ul>

        <div class="card p-5" style="margin:10px 40px;">
            
        <ul class="nav nav-tabs" >
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="{{ route('ps.late.index') }}">Data Keseluruhan</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="">Rekapitulasi Keterlambatan</a>
            </li>
          </ul>

        
        <div class="card" style="background-color: white; padding:20px; margin-top:20px;">
            <div class="d-flex mb-3 justify-content-end">
                <form action="{{ route('admin.late.rekap') }}" style="" method="GET" >
                  <input type="text" name="query" placeholder="Cari...">
                  <button type="submit" class="btn btn-info" ><ion-icon name="search-outline"></ion-icon></button>
                  <a href="{{ route('admin.late.rekap') }}" class="btn btn-secondary"><ion-icon name="refresh-outline"></ion-icon></a>  
              </form>
            </div>
    <table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Nis</th>
            <th>Nama</th>
            <th>Jumlah</th>
            <th></th>
            <th></th>
            {{-- <th>Bukti</th> --}}
            
        </tr>
    </thead>
    <tbody>
        @php $no = 1; @endphp
        @foreach ($lates as $item)
        <tr>
            <td>{{$no++}}</td>
            <td>{{ $item['student']['nis'] }}</td>
            <td>{{ $item['student']['name'] }}</td>
            <td>{{ DB::table('lates')->where('student_id', $item['student']['id'])->count() }}</td>
            <td><a href="{{ route('ps.late.detail')}}">Lihat</a></td>
            <td><a href="{{ route('ps.late.surat', ['id']) }}"><button class="btn btn-primary">Cek Surat Pernyataan</button></a></td>
            {{-- <td><img src="{{ $item['bukti'] }}" ><br></td> --}}
            
        </tr>
        @endforeach
    </tbody>
</table>
</div>
</div>
</div>
{{--memunculkan pagination--}}
@endsection