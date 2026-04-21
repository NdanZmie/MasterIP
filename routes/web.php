<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Datapc;
use App\Http\Controllers\SpekpcController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\NetworkController;
use App\Http\Controllers\DashboardController;  // ← TAMBAH

//
// =======================
// PUBLIC (TIDAK LOGIN)
// =======================
//

// LOGIN
Route::get('/login',  [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post');

// REGISTER
Route::get('/register',  [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.post');

// LOGOUT
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

//
// =======================
// PROTECTED (WAJIB LOGIN)
// =======================
//

Route::middleware('auth.session')->group(function () {

    // ← REDIRECT ROOT KE DASHBOARD
    Route::get('/', fn() => redirect('/dashboard'));

    // ── DASHBOARD ─────────────────────────────
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //
    // DATA
    //
    Route::get('/data', function (Request $request) {
        $search = trim($request->search);
        $data = Datapc::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('ip', 'like', "%{$search}%")
                      ->orWhere('computer_name', 'like', "%{$search}%")
                      ->orWhere('nama', 'like', "%{$search}%")
                      ->orWhere('nik', 'like', "%{$search}%")
                      ->orWhere('departemen', 'like', "%{$search}%")
                      ->orWhere('os', 'like', "%{$search}%")
                      ->orWhere('merk_cpu', 'like', "%{$search}%")
                      ->orWhere('status', 'like', "%{$search}%")
                      ->orWhere('keterangan', 'like', "%{$search}%");
                });
            })
            ->orderBy('no', 'asc')
            ->paginate(10)
            ->withQueryString();
        return view('pages.data_all', [
            'data' => $data,
            'search' => $search
        ]);
    });

    //
    // STATIC
    //
    Route::get('/home', fn() => view('pages.home'));
    Route::get('/clip', fn() => view('pages.clip'));

    //
    // SPEKPC
    //
    Route::get('/spekpc', [SpekpcController::class, 'index'])->name('spekpc');
    Route::post('/spekpc/store', [SpekpcController::class, 'store']);
    Route::post('/spekpc/update/{id}', [SpekpcController::class, 'update']);
    Route::post('/spekpc/delete/{id}', [SpekpcController::class, 'destroy']);
    Route::get('/spekpc/export/excel', [SpekpcController::class, 'exportExcel']);
    Route::get('/spekpc/export/csv',   [SpekpcController::class, 'exportCsv']);

    // ── NETWORK MONITOR ───────────────────────
    Route::get('/network',       [NetworkController::class, 'index'])->name('network');
    Route::post('/network/ping', [NetworkController::class, 'ping'])->name('network.ping');

});