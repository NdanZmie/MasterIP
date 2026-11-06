<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TampungProgram;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TampungController extends Controller
{
    /**
     * Display a listing of shared programs & applications in Tampung
     */
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));
        $kategori = trim($request->input('kategori', 'ALL'));
        $sort = trim($request->input('sort', 'terbaru'));

        $query = TampungProgram::query();

        // Search Keyword
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('nama_program', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhere('file_name', 'like', "%{$search}%")
                  ->orWhere('versi', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%")
                  ->orWhere('uploader', 'like', "%{$search}%")
                  ->orWhere('file_extension', 'like', "%{$search}%");
            });
        }

        // Filter Category
        if ($kategori !== '' && $kategori !== 'ALL') {
            $query->where('kategori', $kategori);
        }

        // Sorting
        switch ($sort) {
            case 'populer':
                $query->orderBy('download_count', 'desc')->orderBy('id', 'desc');
                break;
            case 'ukuran':
                $query->orderBy('file_size', 'desc');
                break;
            case 'nama':
                $query->orderBy('nama_program', 'asc');
                break;
            case 'terbaru':
            default:
                $query->orderBy('id', 'desc');
                break;
        }

        // Metrics Summary
        $totalPrograms = TampungProgram::count();
        $totalDownloads = TampungProgram::sum('download_count');
        $rawStorageBytes = TampungProgram::sum('file_size');
        $totalStorageFormatted = $this->formatBytes($rawStorageBytes);
        $latestProgram = TampungProgram::orderBy('id', 'desc')->first();

        // Preset Categories
        $categoriesList = [
            'Aplikasi / Tools',
            'Driver & Hardware',
            'Utilitas EDP',
            'Script & Batch',
            'Sistem Operasi / ISO',
            'Dokumen & Panduan',
            'Lainnya',
        ];

        $programs = $query->paginate(12)->withQueryString();

        return view('pages.tampung', compact(
            'programs',
            'totalPrograms',
            'totalDownloads',
            'totalStorageFormatted',
            'latestProgram',
            'categoriesList',
            'search',
            'kategori',
            'sort'
        ));
    }

    /**
     * Store a newly uploaded program or link in storage
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_program' => 'required|string|max:255',
            'kategori'     => 'required|string|max:100',
            'versi'        => 'nullable|string|max:50',
            'deskripsi'    => 'nullable|string',
            'tipe_sumber'  => 'required|in:upload,link',
            'file'         => 'nullable|file|max:524288', // 512MB max limit
            'external_link'=> 'nullable|url',
        ]);

        $tipeSumber = $request->tipe_sumber;
        $currentUser = session('user_nama') ?: 'EDP';

        $fileName = null;
        $filePath = null;
        $fileSize = 0;
        $fileExt = null;
        $externalLink = null;

        if ($tipeSumber === 'upload') {
            if (!$request->hasFile('file') || !$request->file('file')->isValid()) {
                if ($request->ajax() || $request->expectsJson()) {
                    return response()->json(['success' => false, 'message' => 'File program wajib diunggah.'], 422);
                }
                return back()->with('error', 'File program wajib diunggah.');
            }

            $uploadedFile = $request->file('file');
            $originalName = $uploadedFile->getClientOriginalName();
            $fileExt = strtolower($uploadedFile->getClientOriginalExtension() ?: 'bin');
            $fileSize = $uploadedFile->getSize();

            $cleanBase = Str::slug(pathinfo($originalName, PATHINFO_FILENAME));
            if (empty($cleanBase)) {
                $cleanBase = 'program';
            }
            $safeName = time() . '_' . substr($cleanBase, 0, 50) . '.' . $fileExt;

            // Ensure public storage directory exists
            $storageFolder = storage_path('app/public/tampung');
            if (!file_exists($storageFolder)) {
                mkdir($storageFolder, 0775, true);
            }

            $uploadedFile->move($storageFolder, $safeName);

            $fileName = $originalName;
            $filePath = 'tampung/' . $safeName;

        } else {
            // Tautan Link Eksternal
            $externalLink = trim($request->external_link);
            if (empty($externalLink)) {
                if ($request->ajax() || $request->expectsJson()) {
                    return response()->json(['success' => false, 'message' => 'Tautan / URL program wajib diisi.'], 422);
                }
                return back()->with('error', 'Tautan / URL program wajib diisi.');
            }
            $fileExt = 'link';
        }

        $program = TampungProgram::create([
            'nama_program'   => trim($request->nama_program),
            'kategori'       => trim($request->kategori),
            'versi'          => trim($request->versi ?: ''),
            'deskripsi'      => trim($request->deskripsi ?: ''),
            'tipe_sumber'    => $tipeSumber,
            'file_name'      => $fileName,
            'file_path'      => $filePath,
            'file_size'      => $fileSize,
            'file_extension' => $fileExt,
            'external_link'  => $externalLink,
            'download_count' => 0,
            'uploader'       => $currentUser,
            'catatan'        => trim($request->catatan ?: ''),
        ]);

        if ($request->ajax() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Program '{$program->nama_program}' berhasil ditampung!",
                'data'    => $program,
            ]);
        }

        return redirect()->route('tampung.index')->with('success', "Program '{$program->nama_program}' berhasil ditampung!");
    }

    /**
     * Download program file or redirect to external link
     */
    public function download($id)
    {
        $program = TampungProgram::findOrFail($id);
        $program->increment('download_count');

        if ($program->tipe_sumber === 'link' && !empty($program->external_link)) {
            return redirect()->away($program->external_link);
        }

        // Resolve absolute storage path
        $fullPath = storage_path('app/public/' . $program->file_path);

        if (!file_exists($fullPath)) {
            // Fallback checking in storage/app/
            $altPath = storage_path('app/' . $program->file_path);
            if (file_exists($altPath)) {
                $fullPath = $altPath;
            } else {
                return back()->with('error', "Maaf, file program fisik tidak ditemukan di server ({$program->file_name}).");
            }
        }

        $downloadName = $program->file_name ?: basename($fullPath);

        return response()->download($fullPath, $downloadName);
    }

    /**
     * Update program metadata
     */
    public function update(Request $request, $id)
    {
        $program = TampungProgram::findOrFail($id);

        $request->validate([
            'nama_program' => 'required|string|max:255',
            'kategori'     => 'required|string|max:100',
            'versi'        => 'nullable|string|max:50',
            'deskripsi'    => 'nullable|string',
            'external_link'=> 'nullable|url',
        ]);

        $program->update([
            'nama_program'  => trim($request->nama_program),
            'kategori'      => trim($request->kategori),
            'versi'         => trim($request->versi ?: ''),
            'deskripsi'     => trim($request->deskripsi ?: ''),
            'external_link' => $request->filled('external_link') ? trim($request->external_link) : $program->external_link,
            'catatan'       => trim($request->catatan ?: ''),
        ]);

        if ($request->ajax() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Program '{$program->nama_program}' berhasil diperbarui!",
                'data'    => $program,
            ]);
        }

        return redirect()->route('tampung.index')->with('success', "Program '{$program->nama_program}' berhasil diperbarui!");
    }

    /**
     * Delete program record and remove file from storage
     */
    public function destroy(Request $request, $id)
    {
        $program = TampungProgram::findOrFail($id);

        if ($program->tipe_sumber === 'upload' && !empty($program->file_path)) {
            $path1 = storage_path('app/public/' . $program->file_path);
            $path2 = storage_path('app/' . $program->file_path);
            if (file_exists($path1)) {
                @unlink($path1);
            }
            if (file_exists($path2)) {
                @unlink($path2);
            }
        }

        $nama = $program->nama_program;
        $program->delete();

        if ($request->ajax() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Program '{$nama}' berhasil dihapus dari Tampung!",
            ]);
        }

        return redirect()->route('tampung.index')->with('success', "Program '{$nama}' berhasil dihapus dari Tampung!");
    }

    /**
     * Helper to format bytes into readable units
     */
    private function formatBytes($bytes): string
    {
        $bytes = (float) $bytes;
        if ($bytes <= 0) {
            return '0 MB';
        }
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }
}
