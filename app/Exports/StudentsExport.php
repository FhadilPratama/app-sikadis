<?php

namespace App\Exports;

use App\Models\PesertaDidik;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StudentsExport implements FromQuery, WithHeadings, WithMapping
{
    protected $rombelId;
    protected $tahunAjarId;

    public function __construct($rombelId = null, $tahunAjarId = null)
    {
        $this->rombelId = $rombelId;
        $this->tahunAjarId = $tahunAjarId;
    }

    public function query()
    {
        $query = PesertaDidik::with(['user', 'anggotaRombel.rombonganBelajar', 'anggotaRombel.tahunAjar']);

        if ($this->tahunAjarId) {
            $query->whereHas('anggotaRombel', function ($q) {
                $q->where('tahun_ajar_id', $this->tahunAjarId);
                if ($this->rombelId) {
                    $q->where('rombongan_belajar_id', $this->rombelId);
                }
            });
        } elseif ($this->rombelId) {
            $query->whereHas('anggotaRombel', function ($q) {
                $q->where('rombongan_belajar_id', $this->rombelId);
            });
        }

        return $query->orderBy('nama');
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Lengkap',
            'Jenis Kelamin',
            'NIS',
            'NISN',
            'Email',
            'Rombongan Belajar',
            'Tahun Ajaran',
            'Status Akun'
        ];
    }

    protected $rowNumber = 0;

    public function map($student): array
    {
        $this->rowNumber++;
        $anggota = $student->anggotaRombel->first(); // Might need to filter by current TA if multiple exist

        return [
            $this->rowNumber,
            $student->nama,
            $student->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan',
            $student->nis,
            $student->nisn,
            $student->user->email,
            $anggota->rombonganBelajar->nama_rombel ?? '-',
            $anggota->tahunAjar->tahun ?? '-',
            $student->user->initial_password ? 'Default: ' . $student->user->initial_password : 'Aktif'
        ];
    }
}
