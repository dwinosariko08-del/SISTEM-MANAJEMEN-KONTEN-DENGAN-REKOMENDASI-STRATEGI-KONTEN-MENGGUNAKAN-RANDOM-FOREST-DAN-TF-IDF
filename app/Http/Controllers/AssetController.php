<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssetController extends Controller
{
    /**
     * Menampilkan daftar asset
     * - Lapangan: lihat asset miliknya
     * - Leader & Editor: lihat semua asset
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'lapangan') {
            $assets = Asset::where('uploaded_by', $user->id)->latest()->get();
        } else {
            $assets = Asset::latest()->get();
        }

        return view('assets.index', compact('assets'));
    }

    /**
     * Form upload asset (HANYA LAPANGAN)
     */
    public function create()
    {
        return view('assets.create');
    }

    /**
     * Simpan asset ke database (HANYA LAPANGAN)
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_client'   => 'required|string|max:255',
            'jenis_project' => 'required|string|max:255',
            'lokasi'        => 'required|string|max:255',
            'alamat'        => 'nullable|string',
            'gdrive_link'   => 'required|url',
            'keterangan'    => 'nullable|string',
        ]);

        Asset::create([
            'nama_client'   => $request->nama_client,
            'jenis_project' => $request->jenis_project,
            'lokasi'        => $request->lokasi,
            'alamat'        => $request->alamat,
            'gdrive_link'   => $request->gdrive_link,
            'keterangan'    => $request->keterangan,
            'uploaded_by'   => Auth::id(),
        ]);

        return redirect('/assets')->with('success', 'Asset berhasil diupload');
    }
}
