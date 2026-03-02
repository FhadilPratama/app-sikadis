<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RombonganBelajar;
use App\Models\TahunAjar;
use App\Services\PresensiService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PresensiGlobalController extends Controller
{
    protected $service;

    public function __construct(PresensiService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user)
            return redirect()->route('login');

        // 1. Determine Date (Default Today)
        $date = $request->date ?? Carbon::today()->format('Y-m-d');

        // 2. Determine Accessible Rombels
        $activeTA = TahunAjar::where('aktif', true)->first();
        if (!$activeTA)
            return back()->with('error', 'Tahun Ajar Aktif belum diset.');

        $rombels = collect([]);

        if ($user->isAdmin()) {
            $rombels = RombonganBelajar::where('tahun_ajar_id', $activeTA->id)->orderBy('nama_rombel')->get();
        } elseif ($user->isWaliKelas()) {
            // Fetch Rombel assigned to this Wali Kelas for Active TA
            $waliKelas = $user->waliKelas->where('tahun_ajar_id', $activeTA->id)->first();
            if ($waliKelas && $waliKelas->rombonganBelajar) {
                $rombels = collect([$waliKelas->rombonganBelajar]);
            }
        }

        if ($rombels->isEmpty()) {
            return view('admin.presensi.harian', [
                'date' => $date,
                'rombels' => [],
                'selectedRombelId' => null,
                'selectedRombel' => null,
                'students' => collect([])
            ])->with('error', 'Anda tidak memiliki akses ke rombel manapun pada tahun ajar ini.');
        }

        $selectedRombelId = $request->rombel_id ?? ($rombels->first()->id ?? null);

        // Ensure selected rombel is in allowed list
        if (!$rombels->contains('id', $selectedRombelId)) {
            $selectedRombelId = $rombels->first()->id;
        }

        $attendanceData = collect([]);
        $selectedRombel = null;

        if ($selectedRombelId) {
            $selectedRombel = $rombels->where('id', $selectedRombelId)->first();
            $attendanceData = $this->service->getRombelDailyAttendance($selectedRombelId, $date);
        }

        return view('admin.presensi.harian', [
            'date' => $date,
            'rombels' => $rombels,
            'selectedRombelId' => $selectedRombelId,
            'selectedRombel' => $selectedRombel,
            'students' => $attendanceData
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'rombel_id' => 'required|exists:rombongan_belajar,id',
            'date' => 'required|date',
            'attendance' => 'array'
        ]);

        // Security Check: Ensure User can edit this Rombel
        $activeTA = TahunAjar::where('aktif', true)->firstOrFail();

        if ($user->isWaliKelas()) {
            $hasAccess = $user->waliKelas()
                ->where('tahun_ajar_id', $activeTA->id)
                ->where('rombongan_belajar_id', $request->rombel_id)
                ->exists();

            if (!$hasAccess) {
                return back()->with('error', 'Anda tidak memiliki hak akses untuk mengubah presensi kelas ini.');
            }
        }

        try {
            $count = $this->service->bulkUpdate(
                $request->rombel_id,
                $request->date,
                $request->attendance ?? [],
                $user->id
            );

            return back()->with('success', "Berhasil menyimpan data presensi untuk {$count} siswa.");
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }
}
