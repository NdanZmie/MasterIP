<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    // =====================
    // SHOW REGISTER PAGE
    // =====================
    public function index()
    {
        // Jika sudah login, langsung redirect ke spekpc
        if (session('user_id')) {
            return redirect('/spekpc');
        }

        return view('pages.register');
    }

    // =====================
    // PROSES REGISTER
    // =====================
    public function store(Request $request)
    {
        $request->validate([
            'NIK'      => 'required|string|unique:user,NIK',
            'Nama'     => 'required|string|min:2|max:100',
            'Password' => 'required|string|min:4',
        ], [
            'NIK.required'      => 'NIK wajib diisi.',
            'NIK.unique'        => 'NIK ini sudah terdaftar. Gunakan NIK lain.',
            'Nama.required'     => 'Nama lengkap wajib diisi.',
            'Nama.min'          => 'Nama minimal 2 karakter.',
            'Password.required' => 'Password wajib diisi.',
            'Password.min'      => 'Password minimal 4 karakter.',
        ]);

        // Simpan user baru
        // Catatan: jika ingin hash password, tambahkan:
        //   'Password' => Hash::make($request->Password)
        // dan tambahkan: use Illuminate\Support\Facades\Hash;
        User::create([
            'NIK'      => trim($request->NIK),
            'Nama'     => trim($request->Nama),
            'Password' => $request->Password, // plain text, ganti dengan Hash::make() jika perlu
        ]);

        return redirect()->route('login')
            ->with('success', 'Akun berhasil dibuat! Silakan login dengan NIK dan password Anda.');
    }
}