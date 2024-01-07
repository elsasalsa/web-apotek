<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <title>Surat Pernyataan</title>
</head>
<style>
    .surat {
        margin: 10px 50px;
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


    .waktu {
        padding: 0;
        text-align: right;
        margin-right: 50px;
        margin-top: 70px;
    }
    .ortu{
        float: right;
        margin-right: 50px;
        margin-top: 20px;
        text-align: center;
    }

    .ttd-right {
        float: right;
        margin-right: 80px;
        margin-top: 20px;
        text-align: center;
    }

    .ttd-left {
        /* float: left; */
        margin-left: -200px;
        text-align: center;
    }
    .ttd-left-left {
        /* float: left; */
        margin-left: -225px;
        text-align: center;
    }
</style>

<body>

    <div class="surat">

        <center>
            <p class="judul"><b>SURAT PERNYATAAN <br> TIDAK AKAN DATANG TERLAMBAT KE SEKOLAH</b></p>
        </center>
        <div class="data">
            <p>Nis : {{ $student['nis'] }}</p>
            <p>Nama : {{ $student['name'] }}</p>
            <p>Rombel : {{ $rombel['rombel'] }}</p>
            <p>Rayon : {{ $rayon['rayon'] }}</p>
        </div>




        <div class="isi">

            <p>Dengan ini menyatakan bahwa saya telah melakukan pelanggaran tata tertib sekolah, yaitu terlambat datang
                ke
                sekolah sebanyak
                <b>
                    @php
                        $jumlahKeterlambatan = $lates->count();
                        echo $jumlahKeterlambatan;
                    @endphp
                    kali
                </b>
                yang mana hal tersebut termasuk kedalam pelanggaran kedisiplinan. Saya
                berjanji tidak akan terlambat datang ke sekolah lagi. Apabila saya terlambat datang ke sekolah lagi saya
                siap diberi sanksi sesuai dengan peraturan sekolah.
            </p>

            <p>Demikian surat pernyataan terlambat ini saya buat dengan penuh penyesalan.</p>
        </div>
    </div>

    <?php
    setlocale(LC_TIME, 'en_US'); //Set the locale to English for month names
    $date = strftime('%d %B %Y');
    $englishMonths = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    $indonesianMonths = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    $date = str_replace($englishMonths, $indonesianMonths, $date);
    ?>

    <p class="waktu">Bogor, <?php echo $date; ?></p>

    <div class="info">
        <div class="card">
            <div class="ortu">
                <p style="margin-bottom:100px">Orang Tua/Wali Peserta Didik,</p>
                
                <p>(...........................)</p>
            </div>
            <br>
            <div class="ttd-left">
                <p style="margin-bottom:100px">Peserta Didik,</p>
                
                <p>( {{ $student['name'] }} )</p>
            </div>
            <br>
            <div class="ttd-right">
                <p style="margin-bottom:100px">Kesiswaan,</p>
                
                <p>(...........................)</p>
            </div>
            <br>
            <div class="ttd-left-left">
                <p style="margin-bottom:100px">Pembimbing Siswa,</p>
                
                @if ($ps)
                    <p>( {{ $ps['name'] ?? 'Nama Tidak Tersedia' }} )</p>
                @else
                    <p>(Nama Tidak Tersedia)</p>
                @endif
            </div>
        </div>
    </div>
    </div>
    </div>

</body>

</html>
