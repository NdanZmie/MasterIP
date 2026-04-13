<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Datapc;
use Illuminate\Http\Request;

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
        ->orderBy('no', 'asc') // 🔥 biar urut rapi
        ->paginate(10)
        ->withQueryString();

    return view('pages.data_all', [
        'data' => $data,
        'search' => $search
    ]);
});



Route::get('/home', function () {
    return view('pages.home');
});

Route::get('/logout', function () {
    return view('pages.home');
});