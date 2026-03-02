<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PesertaDidik;
use App\Models\RombonganBelajar;
use App\Models\TahunAjar;
use App\Services\PesertaDidikService;
use App\Http\Requests\Admin\StorePesertaDidikRequest;
use App\Http\Requests\Admin\UpdatePesertaDidikRequest;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StudentsExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\Sekolah;

class PesertaDidikController extends Controller
{
    protected $service;

    public function __construct(PesertaDidikService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $this->service->getFiltered($request);

        // Fetch rombels for filter dropdown
        $rombels = RombonganBelajar::where('tahun_ajar_id', $data['selectedTahunAjarId'])
            ->orderBy('nama_rombel')
            ->get();

        $tahunAjars = TahunAjar::orderBy('tahun', 'desc')->get();

        return view('admin.pesertaDidik.index', [
            'students' => $data['data'],
            'activeTahunAjar' => $data['activeTahunAjar'],
            'tahunAjars' => $tahunAjars,
            'rombels' => $rombels,
            'selectedTahunAjarId' => $data['selectedTahunAjarId'],
            'selectedRombelId' => $request->rombel_id
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pesertaDidik.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePesertaDidikRequest $request)
    {
        try {
            $this->service->store($request->validated());
            return redirect()->route('admin.peserta-didik.index')
                ->with('success', 'Data siswa berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambah siswa: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PesertaDidik $pesertaDidik)
    {
        return view('admin.pesertaDidik.edit', compact('pesertaDidik'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePesertaDidikRequest $request, PesertaDidik $pesertaDidik)
    {
        try {
            $this->service->update($pesertaDidik, $request->validated());
            return redirect()->route('admin.peserta-didik.index')
                ->with('success', 'Data siswa berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui siswa: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PesertaDidik $pesertaDidik)
    {
        try {
            if ($pesertaDidik->user) {
                $pesertaDidik->user->delete(); // Soft delete user
            }
            $pesertaDidik->delete();
            return redirect()->route('admin.peserta-didik.index')->with('success', 'Data siswa berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus siswa.');
        }
    }

    /**
     * Sync data with external API
     */
    public function sync()
    {
        try {
            $count = $this->service->syncFromApi();
            return back()->with('success', "Berhasil sinkronisasi otomatis: {$count} Siswa beserta Kelas & Rombel.");
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Export to Excel
     */
    public function exportExcel(Request $request)
    {
        return Excel::download(
            new StudentsExport($request->rombel_id, $request->tahun_ajar_id),
            'data_siswa_' . date('YmdHis') . '.xlsx'
        );
    }

    /**
     * Export to PDF
     */
    public function exportPdf(Request $request)
    {
        // ... (Keep existing export logic or move to service if cleaner, usually Controller is fine for response handling)
        // For brevity reusing logic but ideally this query logic should be in Service too.
        // Copying existing Logic for safety as requested "Controller tipis" but export libraries often need direct response.

        $selectedTahunAjarId = $request->tahun_ajar_id;
        $activeTahunAjar = TahunAjar::where('aktif', true)->first();
        $targetTaId = $selectedTahunAjarId ?: ($activeTahunAjar->id ?? 0);
        $rombelId = $request->rombel_id;

        $query = PesertaDidik::with([
            'user',
            'anggotaRombel' => function ($q) use ($targetTaId) {
                $q->where('tahun_ajar_id', $targetTaId)->with('rombonganBelajar');
            }
        ]);

        if ($rombelId) {
            $query->whereHas('anggotaRombel', function ($q) use ($rombelId, $targetTaId) {
                $q->where('rombongan_belajar_id', $rombelId)
                    ->where('tahun_ajar_id', $targetTaId);
            });
        } elseif ($targetTaId) {
            $query->whereHas('anggotaRombel', function ($q) use ($targetTaId) {
                $q->where('tahun_ajar_id', $targetTaId);
            });
        }

        $students = $query->orderBy('nama')->get();
        $ta = TahunAjar::find($targetTaId);
        $rombel = RombonganBelajar::find($rombelId);
        $sekolah = Sekolah::first();

        $pdf = Pdf::loadView('admin.pesertaDidik.pdf', compact('students', 'ta', 'rombel', 'sekolah'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download('data_siswa_' . date('YmdHis') . '.pdf');
    }

    /**
     * Reset password
     */
    public function resetPassword(PesertaDidik $student)
    {
        $newPassword = Str::random(8);

        $student->user->update([
            'password' => Hash::make($newPassword),
            'initial_password' => $newPassword,
        ]);

        return back()->with('success', "Password untuk {$student->nama} berhasil direset menjadi: $newPassword");
    }
}
