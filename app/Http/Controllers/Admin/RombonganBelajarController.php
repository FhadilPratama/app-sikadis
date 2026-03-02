<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RombonganBelajar;
use App\Models\Kelas;
use App\Models\Sekolah;
use App\Models\TahunAjar;
use Illuminate\Http\Request;

class RombonganBelajarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activeTahunAjar = TahunAjar::where('aktif', true)->first();

        if (!$activeTahunAjar) {
            $rombels = collect(); // Kosong jika tidak ada tahun ajar aktif
        } else {
            $rombels = RombonganBelajar::with(['kelas', 'tahunAjar'])
                ->where('tahun_ajar_id', $activeTahunAjar->id)
                ->orderByDesc('id')
                ->get();
        }

        return view('admin.rombonganBelajar.index', compact('rombels', 'activeTahunAjar'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tahunAjarAktif = TahunAjar::where('aktif', true)->first();

        if (!$tahunAjarAktif) {
            return redirect()
                ->route('admin.rombongan-belajar.index')
                ->with('error', 'Tidak ada Tahun Ajar aktif. Aktifkan Tahun Ajar terlebih dahulu.');
        }

        $kelas = Kelas::orderBy('tingkat')->get();

        // Sekolah (Assuming single sekolah for now)
        $sekolah = Sekolah::first();

        return view(
            'admin.rombonganBelajar.create',
            compact('kelas', 'sekolah', 'tahunAjarAktif')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $tahunAjarAktif = TahunAjar::where('aktif', true)->first();

        if (!$tahunAjarAktif) {
            return back()->with('error', 'Tidak ada Tahun Ajar aktif.');
        }

        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'nama_rombel' => 'required|string|max:100',
            'external_rombel_id' => 'nullable|string|max:100|unique:rombongan_belajar,external_rombel_id',
        ]);

        // Cegah duplicate rombel di tahun ajar yang sama
        $exists = RombonganBelajar::where('tahun_ajar_id', $tahunAjarAktif->id)
            ->where('nama_rombel', $request->nama_rombel)
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors([
                    'nama_rombel' => 'Rombel dengan nama tersebut sudah ada di Tahun Ajar aktif.'
                ]);
        }

        RombonganBelajar::create([
            'sekolah_id' => Sekolah::first()->id,
            'kelas_id' => $request->kelas_id,
            'tahun_ajar_id' => $tahunAjarAktif->id,
            'nama_rombel' => $request->nama_rombel,
            'external_rombel_id' => $request->external_rombel_id,
        ]);

        return redirect()
            ->route('admin.rombongan-belajar.index')
            ->with('success', 'Rombongan Belajar berhasil ditambahkan ke Tahun Ajar Aktif.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RombonganBelajar $rombonganBelajar)
    {
        $kelas = Kelas::orderBy('tingkat')->get();

        return view(
            'admin.rombonganBelajar.edit',
            compact('rombonganBelajar', 'kelas')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RombonganBelajar $rombonganBelajar)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'nama_rombel' => 'required|string|max:100',
            'external_rombel_id' => 'nullable|string|max:100|unique:rombongan_belajar,external_rombel_id,' . $rombonganBelajar->id,
        ]);

        // Cegah duplicate rombel di tahun ajar yang sama
        $exists = RombonganBelajar::where('tahun_ajar_id', $rombonganBelajar->tahun_ajar_id)
            ->where('nama_rombel', $request->nama_rombel)
            ->where('id', '!=', $rombonganBelajar->id)
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors([
                    'nama_rombel' => 'Rombel dengan nama tersebut sudah ada di Tahun Ajar ini.'
                ]);
        }

        $rombonganBelajar->update([
            'kelas_id' => $request->kelas_id,
            'nama_rombel' => $request->nama_rombel,
            'external_rombel_id' => $request->external_rombel_id,
        ]);

        return redirect()
            ->route('admin.rombongan-belajar.index')
            ->with('success', 'Rombongan Belajar berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RombonganBelajar $rombonganBelajar)
    {
        $rombonganBelajar->delete();

        return redirect()
            ->route('admin.rombongan-belajar.index')
            ->with('success', 'Rombongan Belajar berhasil dihapus.');
    }
}
