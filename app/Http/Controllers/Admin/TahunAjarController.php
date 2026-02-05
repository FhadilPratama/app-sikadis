<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TahunAjar;
use Illuminate\Http\Request;

class TahunAjarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tahunAjar = TahunAjar::orderByDesc('id')->get();
        $hasActive = TahunAjar::where('aktif', true)->exists();

        return view('admin.tahunAjar.index', compact('tahunAjar', 'hasActive'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tahunAjar.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required|string|max:20|unique:tahun_ajar,tahun',
            'aktif' => 'nullable',
        ]);

        $isAktif = $request->has('aktif');

        // 🔒 Enforce hanya 1 Tahun Ajar aktif
        if ($isAktif) {
            TahunAjar::where('aktif', true)->update([
                'aktif' => false
            ]);
        }

        TahunAjar::create([
            'tahun' => $request->tahun,
            'aktif' => $isAktif,
        ]);

        return redirect()
            ->route('admin.tahun-ajar.index')
            ->with('success', 'Tahun ajaran berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TahunAjar $tahunAjar)
    {
        return view('admin.tahunAjar.edit', compact('tahunAjar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TahunAjar $tahunAjar)
    {
        $request->validate([
            'tahun' => 'required|string|max:20|unique:tahun_ajar,tahun,' . $tahunAjar->id,
            'aktif' => 'nullable',
        ]);

        $isAktif = $request->has('aktif');

        // 🔒 Enforce hanya 1 Tahun Ajar aktif
        if ($isAktif) {
            TahunAjar::where('id', '!=', $tahunAjar->id)
                ->where('aktif', true)
                ->update([
                    'aktif' => false
                ]);
        }

        $tahunAjar->update([
            'tahun' => $request->tahun,
            'aktif' => $isAktif,
        ]);

        return redirect()
            ->route('admin.tahun-ajar.index')
            ->with('success', 'Tahun ajaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     * (Opsional – aktifkan jika dibutuhkan)
     */
    public function destroy(TahunAjar $tahunAjar)
    {
        // Optional safety: cegah hapus Tahun Ajar aktif
        if ($tahunAjar->aktif) {
            return redirect()
                ->route('admin.tahun-ajar.index')
                ->with('error', 'Tidak dapat menghapus Tahun Ajar yang sedang aktif.');
        }

        $tahunAjar->delete();

        return redirect()
            ->route('admin.tahun-ajar.index')
            ->with('success', 'Tahun ajaran berhasil dihapus.');
    }
}
