<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Services\IzinService;
use App\Models\IzinKehadiran;
use App\Models\TahunAjar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IzinController extends Controller
{
    protected $service;

    public function __construct(IzinService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $user = Auth::user();
        $student = $user->pesertaDidik;

        $history = IzinKehadiran::whereHas('anggotaRombel', function ($q) use ($student) {
            $q->where('peserta_didik_id', $student->id);
        })
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('siswa.izin.index', compact('history'));
    }

    public function create()
    {
        return view('siswa.izin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date|after_or_equal:today', // Or allow past dates? Usually allow reasonable past.
            'jenis' => 'required|in:sakit,izin',
            'keterangan' => 'required|string|max:255',
            'bukti' => 'nullable|image|max:2048' // Optional for Izin sometimes, mandatory for Sakit usually
        ]);

        try {
            $user = Auth::user();
            $this->service->createRequest(
                $user->pesertaDidik->id,
                $request->tanggal,
                $request->jenis,
                $request->keterangan,
                $request->file('bukti')
            );

            return redirect()->route('siswa.izin.index')->with('success', 'Pengajuan berhasil dikirim.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengajukan: ' . $e->getMessage())->withInput();
        }
    }
}
