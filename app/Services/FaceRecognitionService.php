<?php

namespace App\Services;

use App\Models\FaceData;
use App\Models\Presensi;
use App\Models\TahunAjar;
use App\Models\AnggotaRombel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class FaceRecognitionService
{
    // Threshold for Euclidean Distance (Lower is stricter)
    protected $threshold = 0.55;

    /**
     * Enroll a face angle for a student
     */
    public function enrollFace($studentId, $angle, array $descriptor, $imageFile)
    {
        // 1. Save Image
        $path = $imageFile->store("faces/{$studentId}/{$angle}", 'public');

        // 2. Save/Update DB
        return FaceData::updateOrCreate(
            [
                'peserta_didik_id' => $studentId,
                'angle' => $angle
            ],
            [
                'descriptor' => $descriptor,
                'image_path' => $path,
            ]
        );
    }

    /**
     * Verify a face descriptor against stored references for a student
     */
    public function verifyFace($studentId, array $inputDescriptor)
    {
        // 1. Get stored faces (all angles)
        $storedFaces = FaceData::where('peserta_didik_id', $studentId)->get();

        if ($storedFaces->isEmpty()) {
            return [
                'match' => false,
                'message' => 'Belum ada data wajah terdaftar. Silakan lakukan enrollment.'
            ];
        }

        $bestDistance = 1.0;
        $matchedAngle = null;

        // 2. Compare against each angle
        foreach ($storedFaces as $face) {
            $storedDescriptor = $face->descriptor;
            if (!is_array($storedDescriptor) || count($storedDescriptor) != 128)
                continue;

            $distance = $this->euclideanDistance($inputDescriptor, $storedDescriptor);

            if ($distance < $bestDistance) {
                $bestDistance = $distance;
                $matchedAngle = $face->angle;
            }
        }

        // 3. Result
        $isMatch = $bestDistance < $this->threshold;

        return [
            'match' => $isMatch,
            'distance' => $bestDistance,
            'angle' => $matchedAngle,
            'message' => $isMatch ? 'Wajah cocok.' : 'Wajah tidak dikenali (Jarak: ' . number_format($bestDistance, 3) . ')'
        ];
    }

    /**
     * Parse Float32Array from request (often comes as object {0: val, 1: val...} or simple array)
     */
    public function parseDescriptor($input)
    {
        if (is_string($input)) {
            $input = json_decode($input, true);
        }
        return array_values($input); // Ensure indexed array
    }

    /**
     * Calculate Euclidean Distance between two 128-D vectors
     */
    private function euclideanDistance(array $a, array $b)
    {
        if (count($a) !== count($b))
            return 1.0; // Error mismatch

        $sum = 0;
        for ($i = 0; $i < count($a); $i++) {
            $diff = $a[$i] - $b[$i];
            $sum += $diff * $diff;
        }
        return sqrt($sum);
    }
}
