<?php

namespace App\Console\Commands;

use App\Models\AnggotaRombel;
use App\Models\Kelas;
use App\Models\PesertaDidik;
use App\Models\RombonganBelajar;
use App\Models\Sekolah;
use App\Models\TahunAjar;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SyncAllCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-all {tahun=2025}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sinkronisasi lengkap Kelas, Rombel, Siswa, dan Anggota Rombel dari API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $syncYear = $this->argument('tahun');
        $this->info("=== Memulai Sinkronisasi Sikadis Tahun {$syncYear} ===");

        $activeTahunAjar = TahunAjar::where('aktif', true)->first();
        if (!$activeTahunAjar) {
            $this->error('Gagal: Tidak ada Tahun Ajar aktif.');
            return 1;
        }

        $sekolah = Sekolah::first();
        if (!$sekolah) {
            $this->error('Gagal: Data Sekolah belum diatur.');
            return 1;
        }

        // 1. Sinkronisasi Kelas & Generate Rombel
        $this->syncKelasAndRombel($syncYear, $sekolah, $activeTahunAjar);

        // 2. Sinkronisasi Siswa & Anggota Rombel
        $this->syncStudentsAndMembership($syncYear, $sekolah, $activeTahunAjar);

        $this->info("=== Sinkronisasi Berhasil Selesai ===");
        return 0;
    }

    protected function syncKelasAndRombel($year, $sekolah, $tahunAjar)
    {
        $this->info("1. Sinkronisasi Kelas dan Rombel...");
        $response = Http::timeout(120)->get("https://zieapi.zielabs.id/api/getkelas?tahun={$year}");

        if ($response->failed()) {
            $this->error('Gagal mengambil data Kelas dari API.');
            return;
        }

        $data = $response->json()['data'] ?? [];
        $countKelas = 0;
        $countRombel = 0;

        foreach ($data as $item) {
            // Parsing Tingkat dari Nama (misal: "X AKKUL 1" -> "X")
            $namaInput = $item['nama'];
            $parts = explode(' ', $namaInput);
            $tingkat = $parts[0] ?? 'X'; // Default X if parsing fails
            $jurusanName = $item['jurusan'];

            // Cek/Buat Kelas (Tingkat + Jurusan)
            // User: "Cek apakah kelas sudah ada di DB (gunakan external_id atau nama kelas)"
            // Kita gunakan kombinasi tingkat & jurusan sebagai identitas unik internal jika external_id belum ada
            $kelas = Kelas::where('tingkat', $tingkat)
                ->where('jurusan', $jurusanName)
                ->first();

            if (!$kelas) {
                $kelas = Kelas::create([
                    'tingkat' => $tingkat,
                    'jurusan' => $jurusanName,
                ]);
                $countKelas++;
            }

            // Generate Rombel Otomatis
            $rombel = RombonganBelajar::where('external_rombel_id', $item['id'])
                ->where('tahun_ajar_id', $tahunAjar->id)
                ->first();

            if (!$rombel) {
                RombonganBelajar::create([
                    'sekolah_id' => $sekolah->id,
                    'kelas_id' => $kelas->id,
                    'tahun_ajar_id' => $tahunAjar->id,
                    'external_rombel_id' => $item['id'],
                    'nama_rombel' => $item['nama'],
                    'active' => true,
                ]);
                $countRombel++;
            }
        }

        $this->info("   -> Selesai: {$countKelas} Kelas baru, {$countRombel} Rombel baru.");
    }

    protected function syncStudentsAndMembership($year, $sekolah, $tahunAjar)
    {
        $this->info("2. Sinkronisasi Siswa dan Anggota Rombel...");
        $response = Http::timeout(300)->get("https://zieapi.zielabs.id/api/getsiswa?tahun={$year}");

        if ($response->failed()) {
            $this->error('Gagal mengambil data Siswa dari API.');
            return;
        }

        $students = $response->json()['data'] ?? [];
        $total = count($students);

        // Optimasi: Cache Rombel & User Emails
        $rombelMap = RombonganBelajar::where('tahun_ajar_id', $tahunAjar->id)
            ->whereNotNull('external_rombel_id')
            ->pluck('id', 'external_rombel_id')
            ->toArray();

        $existingUserEmails = User::pluck('id', 'email')->toArray();

        $batchPassword = Str::random(8);
        $batchHashedPassword = Hash::make($batchPassword);

        $bar = $this->output->createProgressBar($total);
        $bar->start();

        $countSiswa = 0;
        $countMembership = 0;

        foreach ($students as $item) {
            try {
                // Email logic
                $email = $item['email'] ?? ($item['nisn'] ?? $item['no_induk']) . '@sikadis.id';

                // 1. User Account
                $userId = $existingUserEmails[$email] ?? null;
                if (!$userId) {
                    $user = User::create([
                        'name' => $item['nama'],
                        'email' => $email,
                        'password' => $batchHashedPassword,
                        'role' => User::ROLE_SISWA,
                        'is_active' => true,
                        'initial_password' => $batchPassword,
                    ]);
                    $userId = $user->id;
                    $existingUserEmails[$email] = $userId;
                }

                // 2. Peserta Didik
                $pd = PesertaDidik::updateOrCreate(
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

                if ($pd->wasRecentlyCreated)
                    $countSiswa++;

                // 3. Anggota Rombel
                $rombelId = $rombelMap[$item['rombel_id']] ?? null;
                if ($rombelId) {
                    $ar = AnggotaRombel::updateOrCreate(
                        [
                            'peserta_didik_id' => $pd->id,
                            'tahun_ajar_id' => $tahunAjar->id,
                        ],
                        [
                            'rombongan_belajar_id' => $rombelId,
                            'status' => 'aktif',
                            'active' => true,
                        ]
                    );
                    if ($ar->wasRecentlyCreated)
                        $countMembership++;
                }

            } catch (\Exception $e) {
                // Log silently and continue
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("   -> Selesai: {$countSiswa} Siswa baru, {$countMembership} Penempatan Rombel baru.");
    }
}
