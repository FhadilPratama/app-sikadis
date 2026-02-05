<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sekolah;
use Illuminate\Http\Request;

class SekolahController extends Controller
{
    public function index()
    {
        $sekolah = Sekolah::first();
        $sekolah = Sekolah::orderBy('nama')->get();
        return view('admin.sekolah.index', compact('sekolah'));
    }

    public function create()
    {
        if (Sekolah::count() >= 1) {
            return redirect()
                ->route('admin.sekolah.index')
                ->with('error', 'Hanya boleh menambahkan satu sekolah.');
        }

        return view('admin.sekolah.create');
    }

    public function store(Request $request)
    {
        if (Sekolah::count() >= 1) {
            return redirect()
                ->route('admin.sekolah.index')
                ->with('error', 'Hanya boleh menambahkan satu sekolah.');
        }

        $validated = $request->validate([
            'npsn' => 'required|unique:sekolah,npsn',
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'jam_masuk' => 'required',
            'batas_terlambat' => 'required|integer|min:0',
        ]);

        Sekolah::create($validated);

        return redirect()
            ->route('admin.sekolah.index')
            ->with('success', 'Data sekolah berhasil disimpan');
    }

    public function edit(Sekolah $sekolah)
    {
        return view('admin.sekolah.edit', compact('sekolah'));
    }

    public function update(Request $request, Sekolah $sekolah)
    {
        $validated = $request->validate([
            'npsn' => 'required|unique:sekolah,npsn,' . $sekolah->id,
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'jam_masuk' => 'required',
            'batas_terlambat' => 'required|integer|min:0',
        ]);

        $sekolah->update($validated);

        return redirect()
            ->route('admin.sekolah.index')
            ->with('success', 'Data sekolah berhasil diperbarui');
    }
}
