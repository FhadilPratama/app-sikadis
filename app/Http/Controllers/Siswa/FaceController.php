<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\FaceData;
use App\Services\FaceRecognitionService;
use App\Services\PresensiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FaceController extends Controller
{
    protected $faceService;
    protected $presensiService;

    public function __construct(FaceRecognitionService $faceService, PresensiService $presensiService)
    {
        $this->faceService = $faceService;
        $this->presensiService = $presensiService;
    }

    /**
     * Halaman Utama Presensi (Face Recognition Interface)
     */
    public function index()
    {
        $user = Auth::user();
        $student = $user->pesertaDidik;

        if (!$student)
            return redirect()->route('dashboard');

        // Cek apakah sudah absen hari ini
        // (Logic ini bisa dipindah ke Service untuk clean code, tapi di sini oke untuk UX)
        // ... (Cek via PresensiService kalau ada methode-nya, atau query manual)
        // For brevity: assume PresensiService handles the "ClockIn" check inside.

        // Cek Enrollment
        $enrolledCount = FaceData::where('peserta_didik_id', $student->id)->count();
        $isEnrolled = $enrolledCount >= 3; // Front, Left, Right

        return view('siswa.presensi.face_v2', [
            'student' => $student,
            'isEnrolled' => $isEnrolled
        ]);
    }

    /**
     * Proses Enrollment (Pendaftaran Wajah)
     */
    public function enroll(Request $request)
    {
        $request->validate([
            'angle' => 'required|in:front,left,right',
            'descriptor' => 'required', // JSON array
            'image' => 'required|image|max:2048' // Snapshot
        ]);

        $user = Auth::user();
        $student = $user->pesertaDidik;

        try {
            $descriptor = $this->faceService->parseDescriptor($request->descriptor);

            $this->faceService->enrollFace(
                $student->id,
                $request->angle,
                $descriptor,
                $request->file('image')
            );

            return response()->json(['status' => 'success', 'message' => "Wajah {$request->angle} berhasil didaftarkan."]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Proses Presensi (Verifikasi Wajah)
     */
    public function verify(Request $request)
    {
        $request->validate([
            'descriptor' => 'required',
            'image' => 'required|image', // Snapshot bukti
            'lat' => 'nullable',
            'long' => 'nullable'
        ]);

        $user = Auth::user();
        $student = $user->pesertaDidik;

        try {
            // 1. Verify Face
            $descriptor = $this->faceService->parseDescriptor($request->descriptor);
            $verification = $this->faceService->verifyFace($student->id, $descriptor);

            if (!$verification['match']) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Wajah tidak dikenali. Silakan coba lagi. (' . number_format($verification['distance'], 2) . ')'
                ], 422);
            }

            // 2. Record Attendance
            $presensi = $this->presensiService->clockIn(
                $student->id,
                $request->lat,
                $request->long,
                // $request->file('image') // Pass image if Service supports it
            );

            return response()->json([
                'status' => 'success',
                'message' => 'Presensi Berhasil!',
                'redirect' => route('siswa.dashboard') // or history
            ]);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Gagal Absen: ' . $e->getMessage()], 500);
        }
    }
}
