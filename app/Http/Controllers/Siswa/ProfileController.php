<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return view('siswa.profile', [
            'user' => $request->user()->load('pesertaDidik'),
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'current_password' => ['nullable', 'required_with:password', 'current_password'],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        // Siswa generally shouldn't change their name/email as it's synced from API
        // But we allow password change
        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
            // Rule: initial_password otomatis dihapus ketika siswa mengganti password
            $user->initial_password = null;
            $user->save();
            return back()->with('success', 'Password berhasil diperbarui.');
        }

        return back()->with('info', 'Tidak ada perubahan yang dilakukan.');
    }
}
