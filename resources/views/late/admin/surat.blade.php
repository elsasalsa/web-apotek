<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Pernyataan</title>
</head>
<style>
    .surat {
        margin: 80px 300px;
    }

    .judul {
        font-size: 20px;
    }

    .data {
        margin-top: 50px;
    }

    .isi {
        margin-top: 50px;
    }

    .tanda {
        position: center;
        margin: 30px 300px;
    }

    .waktu {
        float: right;
        margin: 20px 300px;
    }

    .tanda .right {
        float: right;
        clear: right;
        margin-top: 80px;
    }

    .tanda .right-o {
        float: right;
        clear: right;
    }

    .tanda .left {
        margin-top: 80px;
        float: left;
        clear: left;
    }

    .tanda tr {
        display: flex;
        justify-content: space-between;
    }
</style>

<body>
    <div class="surat">
        <center>
            <p class="judul"><b>SURAT PERNYATAAN <br> TIDAK AKAN DATANG TERLAMBAT KE SEKOLAH</b></p>
        </center>
        <div class="data">
            {{-- @if($lates instanceof \Illuminate\Database\Eloquent\Collection && $lates->isNotEmpty())
                @foreach($lates as $late)
                    <p>
                        NIS     : {{ optional($late->student)->nis }} <br>
                        Nama    : {{ optional($late->student)->name }} <br>
                        Rombel  : {{ optional(json_decode($late->student->rombel))->rombel ?? 'N/A' }} <br>
                        Rayon   : {{ optional(json_decode($late->student->rayon))->rayon ?? 'N/A' }} 
                    </p>
                    <br>
                @endforeach
            @else
                <p>
                    NIS     : {{ optional($lates->student)->nis }} <br>
                    Nama    : {{ optional($lates->student)->name }} <br>
                    Rombel  : {{ optional(json_decode($lates->student->rombel))->rombel ?? 'N/A' }} <br>
                    Rayon   : {{ optional(json_decode($lates->student->rayon))->rayon ?? 'N/A' }} 
                </p>
                <br>
            @endif --}}

            <p>
                @php
                $countBeforeUnique = $lateRecords->count();
                $uniqueStudent = $lateRecords->first()->student;
                @endphp
                Nis : {{ $uniqueStudent->nis }}<br>
                Nama : {{ $uniqueStudent->name }}<br>
                Rombel : {{ $uniqueStudent->rombel->rombel }}<br>
                Rayon : {{ $uniqueStudent->rayon->rayon }}<br>

            </p>
        </div>
        
                        


        <div class="isi">
            <p>Dengan ini menyatakan bahwa saya telah melakukan pelanggaran tata tertib sekolah, yaitu terlambat datang
                ke
                sekolah sebanyak <b>3 Kali</b> yang mana hal tersebut teramsuk kedalam pelanggaran kedisiplinan. Saya
                berjanji tidak akan terlambat datang ke sekolah lagi. Apabila saya terlambat datang ke sekolah lagi saya
                siap diberi sanksi sesuai dengan peraturan sekolah.</p>
            <p>Demikian surat pernyataan terlambat ini saya buat dengan penuh penyesalan.</p>
        </div>
    </div>
    <p class="waktu">Bogor, 24 November 2023</p>
    <div class="tanda">

        <table>
            <tr>
                <p class="left">Peserta Didik,</p>
                <p class="right-o">Orang Tua/Wali Peserta Didik,</p>
            </tr>
            <tr>
                <p class="left">( UI )</p>
                <p class="right">(....................)</p>
            </tr>
            <tr>
                <p class="left">Pembimbing Siswa,</p>
                <p class="right">Kesiswaan,</p>
            </tr>
            <tr>
                <p class="left">( PS )</p>
                <p class="right">(..................)</p>
            </tr>
        </table>
    </div>
</body>

</html>
