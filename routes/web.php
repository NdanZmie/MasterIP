<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Datapc;
use App\Http\Controllers\SpekpcController; // ✅ WAJIB

//
// =======================
// DATA (tetap)
// =======================
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
// =======================
// STATIC PAGES
// =======================
//
Route::get('/home', fn() => view('pages.home'));
Route::get('/logout', fn() => view('pages.home'));
Route::get('/clip', fn() => view('pages.clip'));

//
// =======================
// SPEKPC (CONTROLLER)
// =======================
//
Route::get('/spekpc/export/excel', [SpekpcController::class, 'exportExcel']);
Route::get('/spekpc/export/csv', [SpekpcController::class, 'exportCsv']);





Route::get('/spekpc', [SpekpcController::class, 'index']);
Route::post('/spekpc/store', [SpekpcController::class, 'store']);
Route::put('/spekpc/update/{id}', [SpekpcController::class, 'update']);
Route::delete('/spekpc/delete/{id}', [SpekpcController::class, 'destroy']);