<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RombonganBelajar;
use App\Models\TahunAjar;
use App\Models\User;
use App\Models\WaliKelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class WaliKelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tahunAjarAktif = TahunAjar::where('aktif', true)->first();

        $query = WaliKelas::with(['user', 'rombonganBelajar.kelas', 'tahunAjar']);

        // Filter Tahun Ajar
        if ($request->has('tahun_ajar_id')) {
            $query->where('tahun_ajar_id', $request->tahun_ajar_id);
        } elseif ($tahunAjarAktif) {
            $query->where('tahun_ajar_id', $tahunAjarAktif->id);
        }

        // Filter Rombel
        if ($request->has('rombongan_belajar_id')) {
            $query->where('rombongan_belajar_id', $request->rombongan_belajar_id);
        }

        $waliKelas = $query->orderByDesc('id')->paginate(10);
        $tahunAjars = TahunAjar::orderByDesc('tahun')->get();
        $rombels = RombonganBelajar::all(); // For filter dropdown

        return view('admin.waliKelas.index', compact('waliKelas', 'tahunAjars', 'rombels', 'tahunAjarAktif'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tahunAjarAktif = TahunAjar::where('aktif', true)->first();

        if (!$tahunAjarAktif) {
            return redirect()
                ->route('admin.wali-kelas.index')
                ->with('error', 'Tidak ada Tahun Ajar aktif. Aktifkan Tahun Ajar terlebih dahulu.');
        }

        // Ambil rombel yang aktif di tahun ajar ini
        // DAN belum punya wali kelas
        $rombels = RombonganBelajar::with('kelas')
            ->where('tahun_ajar_id', $tahunAjarAktif->id)
            ->whereDoesntHave('waliKelas', function ($q) use ($tahunAjarAktif) {
                // Ensure check inside the same academic year
                $q->where('tahun_ajar_id', $tahunAjarAktif->id);
            })
            ->get();

        return view('admin.waliKelas.create', compact('tahunAjarAktif', 'rombels'));
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'rombongan_belajar_id' => [
                'required',
                'exists:rombongan_belajar,id',
                // Validasi: 1 rombel hanya boleh 1 wali kelas di tahun ajar yang sama
                Rule::unique('wali_kelas')->where(function ($query) use ($tahunAjarAktif) {
                    return $query->where('tahun_ajar_id', $tahunAjarAktif->id);
                }),
            ],
        ], [
            'rombongan_belajar_id.unique' => 'Rombongan belajar ini sudah memiliki wali kelas untuk tahun ajar aktif.'
        ]);

        DB::transaction(function () use ($request, $tahunAjarAktif) {
            // 1. Create User
            $password = Str::random(8);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($password),
                'role' => User::ROLE_WALI_KELAS,
                'is_active' => true,
                'initial_password' => $password,
            ]);

            // 2. Create Wali Kelas
            WaliKelas::create([
                'user_id' => $user->id,
                'rombongan_belajar_id' => $request->rombongan_belajar_id,
                'tahun_ajar_id' => $tahunAjarAktif->id,
                'active' => true, // default active
            ]);
        });

        return redirect()
            ->route('admin.wali-kelas.index')
            ->with('success', 'Wali Kelas berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WaliKelas $waliKelas)
    {
        // Load relationships
        $waliKelas->load(['user', 'rombonganBelajar', 'tahunAjar']);

        // Rombels available for THIS tahun ajar
        // Include CURRENT rombel of this wali kelas so it appears in dropdown
        $rombels = RombonganBelajar::with('kelas')
            ->where('tahun_ajar_id', $waliKelas->tahun_ajar_id)
            ->where(function ($query) use ($waliKelas) {
                $query->whereDoesntHave('waliKelas', function ($q) use ($waliKelas) {
                    $q->where('tahun_ajar_id', $waliKelas->tahun_ajar_id);
                })
                    ->orWhere('id', $waliKelas->rombongan_belajar_id);
            })
            ->get();

        return view('admin.waliKelas.edit', compact('waliKelas', 'rombels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WaliKelas $waliKelas)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($waliKelas->user_id),
            ],
            'rombongan_belajar_id' => [
                'required',
                'exists:rombongan_belajar,id',
                // Validasi unique ignore current id
                Rule::unique('wali_kelas')->where(function ($query) use ($waliKelas) {
                    return $query->where('tahun_ajar_id', $waliKelas->tahun_ajar_id);
                })->ignore($waliKelas->id),
            ],
        ], [
            'rombongan_belajar_id.unique' => 'Rombongan belajar ini sudah memiliki wali kelas untuk tahun ajar ini.'
        ]);

        DB::transaction(function () use ($request, $waliKelas) {
            // Update User
            $waliKelas->user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            // Update Wali Kelas
            $waliKelas->update([
                'rombongan_belajar_id' => $request->rombongan_belajar_id,
            ]);
        });

        return redirect()
            ->route('admin.wali-kelas.index')
            ->with('success', 'Data Wali Kelas berhasil diperbarui.');
    }

    /**
     * Reset password
     */
    public function resetPassword(WaliKelas $waliKelas)
    {
        $newPassword = Str::random(8);

        $waliKelas->user->update([
            'password' => Hash::make($newPassword),
            'initial_password' => $newPassword, // Admin requested capability to reset and see it again? 
            // "Reset password (generate ulang)" - prompt suggests showing it.
            // If we update initial_password, admin can see it in table.
        ]);

        return back()->with('success', "Password berhasil direset menjadi: $newPassword");
    }
}
