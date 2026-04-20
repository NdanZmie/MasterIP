<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class LoginController extends Controller
{
    // =====================
    // SHOW LOGIN PAGE
    // =====================
    public function index()
    {
        // Jika sudah login, langsung redirect ke spekpc
        if (session('user_id')) {
            return redirect('/spekpc');
        }

        return view('pages.login');
    }

    // =====================
    // PROSES LOGIN
    // =====================
    public function authenticate(Request $request)
    {
        $request->validate([
            'NIK'      => 'required|string',
            'Password' => 'required|string',
        ], [
            'NIK.required'      => 'NIK wajib diisi.',
            'Password.required' => 'Password wajib diisi.',
        ]);

        $user = User::where('NIK', $request->NIK)->first();

        // Cek user ada & password cocok
        // Catatan: jika password di DB sudah di-hash pakai bcrypt, gunakan Hash::check()
        // Jika plain text, gunakan perbandingan langsung seperti di bawah
        if (!$user || $user->Password !== $request->Password) {
            return back()
                ->withInput(['NIK' => $request->NIK])
                ->with('error', 'NIK atau Password salah. Silakan coba lagi.');
        }

        // Simpan session
        session([
            'user_id'   => $user->id,
            'user_nik'  => $user->NIK,
            'user_nama' => $user->Nama,
        ]);

        return redirect('/spekpc')->with('success', 'Selamat datang, ' . $user->Nama . '!');
    }

    // =====================
    // LOGOUT
    // =====================
    public function logout()
    {
        session()->flush();

        return redirect('/login')->with('success', 'Anda berhasil logout.');
    }
}