<?php

namespace App\Services;

use App\Models\PesertaDidik;
use App\Models\User;
use App\Models\Sekolah;
use App\Models\TahunAjar;
use App\Models\Kelas;
use App\Models\RombonganBelajar;
use App\Models\AnggotaRombel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PesertaDidikService
{
    /**
     * Get filtered list for datatables/pagination
     */
    public function getFiltered($request)
    {
        $activeTahunAjar = TahunAjar::where('aktif', true)->first();
        $selectedTahunAjarId = $request->tahun_ajar_id ?? ($activeTahunAjar->id ?? null);

        $query = PesertaDidik::with([
            'user',
            'anggotaRombel' => function ($q) use ($selectedTahunAjarId) {
                if ($selectedTahunAjarId) {
                    $q->where('tahun_ajar_id', $selectedTahunAjarId)
                        ->with('rombonganBelajar');
                }
            }
        ]);

        // Filter by Rombel
        if ($request->filled('rombel_id')) {
            $query->whereHas('anggotaRombel', function ($q) use ($request, $selectedTahunAjarId) {
                $q->where('rombongan_belajar_id', $request->rombel_id);
                if ($selectedTahunAjarId) {
                    $q->where('tahun_ajar_id', $selectedTahunAjarId);
                }
            });
        }
        // Filter by Tahun Ajar only
        elseif ($selectedTahunAjarId && $request->filled('tahun_ajar_id')) {
            $query->whereHas('anggotaRombel', function ($q) use ($selectedTahunAjarId) {
                $q->where('tahun_ajar_id', $selectedTahunAjarId);
            });
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nis', 'like', "%{$search}%")
                    ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        return [
            'data' => $query->orderBy('nama')->paginate(25),
            'activeTahunAjar' => $activeTahunAjar,
            'selectedTahunAjarId' => $selectedTahunAjarId
        ];
    }

    /**
     * Store new student manually
     */
    public function store(array $data)
    {
        return DB::transaction(function () use ($data) {
            $sekolah = Sekolah::firstOrFail();

            // 1. Create User
            $password = $data['password'] ?? Str::random(8); // Use input or random
            $email = $data['email'] ?? ($data['nisn'] ?? $data['nis']) . '@sikadis.id'; // Auto generate email if empty

            $user = User::create([
                'name' => $data['nama'],
                'email' => $email,
                'password' => Hash::make($password),
                'role' => 'siswa',
                'is_active' => true,
                'initial_password' => $password,
            ]);

            // 2. Create Peserta Didik
            $student = PesertaDidik::create([
                'sekolah_id' => $sekolah->id,
                'user_id' => $user->id,
                'peserta_didik_uuid' => (string) Str::uuid(),
                'nis' => $data['nis'],
                'nisn' => $data['nisn'],
                'nama' => $data['nama'],
                'jenis_kelamin' => $data['jenis_kelamin'],
                'active' => true,
            ]);

            return $student;
        });
    }

    /**
     * Update existing student logic
     */
    public function update(PesertaDidik $student, array $data)
    {
        return DB::transaction(function () use ($student, $data) {
            // Update User Name if changed
            if ($student->user) {
                $userData = ['name' => $data['nama']];
                // Update email/password if provided is optional here
                // For now, simpler is better
                $student->user->update($userData);
            }

            // Update Peserta Didik
            $student->update([
                'nis' => $data['nis'],
                'nisn' => $data['nisn'],
                'nama' => $data['nama'],
                'jenis_kelamin' => $data['jenis_kelamin'],
            ]);

            return $student;
        });
    }

    /**
     * Sync from External API
     */
    public function syncFromApi()
    {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $activeTahunAjar = TahunAjar::where('aktif', true)->first();
        if (!$activeTahunAjar)
            throw new \Exception('Tidak ada Tahun Ajar aktif.');

        $sekolah = Sekolah::first();
        if (!$sekolah)
            throw new \Exception('Data Sekolah belum diatur.');

        $syncYear = '2025'; // Consider making this dynamic later based on TahunAjar

        // 1. SYNC KELAS & ROMBEL (Simplified from existing logic)
        $this->syncRombel($syncYear, $sekolah, $activeTahunAjar);

        // 2. SYNC SISWA
        $resSiswa = Http::timeout(300)->get("https://zieapi.zielabs.id/api/getsiswa?tahun={$syncYear}");
        if ($resSiswa->failed())
            throw new \Exception('Gagal mengambil data siswa dari API.');

        $studentsData = $resSiswa->json()['data'] ?? [];
        $countSync = 0;

        // Prep caching for performance
        $rombelMap = RombonganBelajar::where('tahun_ajar_id', $activeTahunAjar->id)
            ->whereNotNull('external_rombel_id')
            ->pluck('id', 'external_rombel_id')
            ->toArray();

        $existingUserEmails = User::pluck('id', 'email')->toArray();
        $batchPassword = Str::random(8); // Default batch password if new
        $batchHashed = Hash::make($batchPassword);

        foreach ($studentsData as $item) {
            try {
                $email = $item['email'] ?? ($item['nisn'] ?? $item['no_induk']) . '@sikadis.id';

                // Handle User
                $userId = $existingUserEmails[$email] ?? null;
                if (!$userId) {
                    $user = User::create([
                        'name' => $item['nama'],
                        'email' => $email,
                        'password' => $batchHashed,
                        'role' => 'siswa',
                        'is_active' => true,
                        'initial_password' => $batchPassword,
                    ]);
                    $userId = $user->id;
                    $existingUserEmails[$email] = $userId;
                } else {
                    // Update name if changed
                    User::where('id', $userId)->update(['name' => $item['nama']]);
                }

                // Handle Peserta Didik
                $student = PesertaDidik::updateOrCreate(
                    ['peserta_didik_uuid' => $item['peserta_didik_id']],
                    [
                        'sekolah_id' => $sekolah->id,
                        'user_id' => $userId,
                        'nis' => $item['no_induk'],
                        'nisn' => $item['nisn'],
                        'nama' => $item['nama'],
                        'jenis_kelamin' => $item['jenis_kelamin'],
                        'active' => true,
                    ]
                );

                // Handle Anggota Rombel (Enrollment)
                $rombelId = $rombelMap[$item['rombel_id']] ?? null;
                if ($rombelId) {
                    AnggotaRombel::updateOrCreate(
                        [
                            'peserta_didik_id' => $student->id,
                            'tahun_ajar_id' => $activeTahunAjar->id,
                        ],
                        [
                            'rombongan_belajar_id' => $rombelId,
                            'status' => 'aktif',
                            'active' => true,
                        ]
                    );
                }

                $countSync++;
            } catch (\Exception $e) {
                continue;
            }
        }

        return $countSync;
    }

    private function syncRombel($year, $sekolah, $activeTahunAjar)
    {
        $res = Http::timeout(120)->get("https://zieapi.zielabs.id/api/getkelas?tahun={$year}");
        if ($res->successful()) {
            foreach ($res->json()['data'] ?? [] as $item) {
                // Logic to parse tingkat/jurusan
                $parts = explode(' ', $item['nama']);
                $tingkat = $parts[0] ?? 'X';
                $jurusanName = $item['jurusan'];

                $kelas = Kelas::firstOrCreate(
                    ['tingkat' => $tingkat, 'jurusan' => $jurusanName]
                );

                RombonganBelajar::updateOrCreate(
                    ['external_rombel_id' => $item['id'], 'tahun_ajar_id' => $activeTahunAjar->id],
                    [
                        'sekolah_id' => $sekolah->id,
                        'kelas_id' => $kelas->id,
                        'nama_rombel' => $item['nama'],
                        'active' => true,
                    ]
                );
            }
        }
    }
}
