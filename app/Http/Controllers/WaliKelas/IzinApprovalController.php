<?php

namespace App\Http\Controllers\WaliKelas;

use App\Http\Controllers\Controller;
use App\Services\IzinService;
use App\Models\IzinKehadiran;
use App\Models\TahunAjar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IzinApprovalController extends Controller
{
    protected $service;

    public function __construct(IzinService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $user = Auth::user();
        $activeTA = TahunAjar::where('aktif', true)->first();

        // Get Rombel ID for this Wali Kelas
        $waliKelas = $user->waliKelas->where('tahun_ajar_id', $activeTA->id)->first();

        if (!$waliKelas) {
            return view('wali_kelas.izin.index', ['requests' => collect([])])
                ->with('error', 'Anda tidak memiliki kelas aktif.');
        }

        $requests = IzinKehadiran::with(['anggotaRombel.pesertaDidik'])
            ->whereHas('anggotaRombel', function ($q) use ($waliKelas) {
                $q->where('rombongan_belajar_id', $waliKelas->rombongan_belajar_id);
            })
            ->where('status', 'pending')
            ->orderBy('tanggal', 'asc')
            ->get();

        return view('wali_kelas.izin.index', compact('requests', 'waliKelas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'action' => 'required|in:approve,reject'
        ]);

        try {
            if ($request->action == 'approve') {
                $this->service->approveRequest($id, Auth::id());
                $msg = 'Pengajuan disetujui.';
            } else {
                $this->service->rejectRequest($id);
                $msg = 'Pengajuan ditolak.';
            }
            return back()->with('success', $msg);
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
