<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RombonganBelajar;
use App\Models\AnggotaRombel;
use App\Services\AnggotaRombelService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AnggotaRombelController extends Controller
{
    protected $service;

    public function __construct(AnggotaRombelService $service)
    {
        $this->service = $service;
    }

    /**
     * Show members of a specific rombel
     */
    public function index(RombonganBelajar $rombonganBelajar)
    {
        $members = $this->service->getRombelMembers($rombonganBelajar);
        $unenrolledStudents = $this->service->getUnenrolledStudents();

        return view('admin.rombonganBelajar.anggota', [
            'rombel' => $rombonganBelajar,
            'members' => $members,
            'unenrolledStudents' => $unenrolledStudents
        ]);
    }

    /**
     * Add student to rombel
     */
    public function store(Request $request, RombonganBelajar $rombonganBelajar)
    {
        $request->validate([
            'peserta_didik_id' => 'required|exists:peserta_didik,id',
        ]);

        try {
            $this->service->enrollStudent($request->peserta_didik_id, $rombonganBelajar->id);
            return back()->with('success', 'Siswa berhasil ditambahkan ke rombel.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors());
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan siswa: ' . $e->getMessage());
        }
    }

    /**
     * Remove member from rombel
     */
    public function destroy(AnggotaRombel $anggotaRombel)
    {
        try {
            $this->service->removeMember($anggotaRombel);
            return back()->with('success', 'Siswa berhasil dikeluarkan dari rombel.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors());
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus siswa: ' . $e->getMessage());
        }
    }
}
