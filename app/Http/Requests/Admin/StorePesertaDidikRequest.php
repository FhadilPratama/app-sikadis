<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePesertaDidikRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Admin policy handled in controller/middleware
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'nis' => ['required', 'string', 'max:20', 'unique:peserta_didik,nis'],
            'nisn' => ['required', 'string', 'max:20', 'unique:peserta_didik,nisn'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'email' => ['nullable', 'email', 'unique:users,email'],
            'password' => ['nullable', 'string', 'min:6'],
        ];
    }
}
