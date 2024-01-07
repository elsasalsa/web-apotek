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
    .unduh {
        margin: -30px 70px;
        float:right;
        clear: right;
    }
    
</style>

<body>
    <div class="unduh" >
        <a class="btn btn-danger" href="{{ route("admin.late.unduh", ['id' => $student['id']]) }}">Unduh .PDF</a>
    </div>

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
                <p class="right">(....................)</p>
            </tr>
        </table>
        
    </div>
</div>

    

    
</body>
</html>
