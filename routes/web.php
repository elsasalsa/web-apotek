<?php
use App\Http\Controllers\RombelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RayonController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\LateController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('login');
})->name('login');
Route::post('/login-auth', [UserController::class, 'loginAuth'])->name('login.auth');
Route::get('/error-permission', [UserController::class, 'error'])->name('error');

Route::middleware('IsGuest')->group(function() {
    Route::get('/', function () {
        return view('login');
    })->name('login');
    Route::post('/login-auth', [UserController::class, 'loginAuth'])->name('login.auth');
});
Route::middleware('IsLogin')->group(function() {
    // Route::get('/dashboard', function () {
    //     return view('index');
    // });
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('index');

Route::get('/logout', [UserController::class, 'logout'])->name('logout');
Route::middleware('IsAdmin')->group(function() {
    Route::prefix('rombel')->name('rombel.')->group(function() {
        Route::get('/data', [RombelController::class, 'index'])->name('index');
        Route::post('/store', [RombelController::class, 'store'])->name('store');
        Route::get('/create', [RombelController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [RombelController::class, 'edit'])->name('edit');
        Route::patch('/{id}', [RombelController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [RombelController::class, 'destroy'])->name('delete');
    });
    Route::prefix('rayon')->name('rayon.')->group(function() {
        Route::get('/data', [RayonController::class, 'index'])->name('index');
        Route::post('/store', [RayonController::class, 'store'])->name('store');
        Route::get('/create', [RayonController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [RayonController::class, 'edit'])->name('edit');
        Route::patch('/{id}', [RayonController::class, 'update'])->name('update');
        Route::get('input', [RayonController::class, 'input'])->name('input');
        Route::delete('/{id}', [RayonController::class, 'destroy'])->name('delete');
    });
    Route::prefix('user')->name('user.')->group(function() {
        Route::get('/data', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/{id}', [UserController::class, 'edit'])->name('edit');
        Route::patch('/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('delete');
    });
    Route::prefix('student')->name('admin.student.')->group(function() {
        Route::get('/index', [StudentController::class, 'index'])->name('index');
        Route::get('/create', [StudentController::class, 'create'])->name('create');
        Route::post('/store', [StudentController::class, 'store'])->name('store');
        Route::get('/{id}', [StudentController::class, 'edit'])->name('edit');
        Route::patch('/{id}', [StudentController::class, 'update'])->name('update');
        Route::delete('/{id}', [StudentController::class, 'destroy'])->name('delete');
    });
    Route::prefix('late')->name('admin.late.')->group(function() {
        Route::get('/index', [LateController::class, 'index'])->name('index');
        Route::get('/create', [LateController::class, 'create'])->name('create');
        Route::post('/store', [LateController::class, 'store'])->name('store');
        Route::get('/rekap', [LateController::class, 'rekapitulasi'])->name('rekap');
        Route::get('/surat-pernyataan/{id}', [LateController::class, 'unduhPDF'])->name('unduh');
        Route::get('/print/{id}', [LateController::class, 'print'])->name('print');
        Route::get('/detail-keterlambatan/{id}', [LateController::class, 'detailKeterlambatan'])->name('detail');
        Route::get('/export', [LateController::class, 'exportToExcel'])->name('export');
        Route::get('/late/{id}/edit', [LateController::class, 'edit'])->name('edit');
        Route::patch('/{id}', [LateController::class, 'update'])->name('update');
        Route::delete('/{id}', [LateController::class, 'destroy'])->name('delete');
    });
});
Route::middleware('IsPs')->group(function() {
    Route::prefix('/ps/student')->name('ps.student.')->group(function() {
        Route::get('/data', [StudentController::class, 'data'])->name('data');
    });
    Route::prefix('/ps/late')->name('ps.late.')->group(function() {
        Route::get('/data', [LateController::class, 'data'])->name('index');
        Route::get('/rekap-ps', [LateController::class, 'rekapitulasiPs'])->name('rekap');
        Route::get('/surat/{id}', [LateController::class, 'surat'])->name('surat');
        Route::get('/detail/{id}', [LateController::class, 'detail'])->name('detail');
        Route::get('/excel', [LateController::class, 'exportPSToExcel'])->name('export');
        Route::get('/pernyataan/{id}', [LateController::class, 'unduhPS'])->name('unduh');
        Route::get('/print-surat/{id}', [LateController::class, 'printPS'])->name('print');
    });
});
});
