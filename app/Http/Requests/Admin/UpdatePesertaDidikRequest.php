<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePesertaDidikRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $studentId = $this->route('peserta_didik') ? $this->route('peserta_didik')->id : null;

        return [
            'nama' => ['required', 'string', 'max:255'],
            'nis' => ['required', 'string', 'max:20', Rule::unique('peserta_didik', 'nis')->ignore($studentId)],
            'nisn' => ['required', 'string', 'max:20', Rule::unique('peserta_didik', 'nisn')->ignore($studentId)],
            'jenis_kelamin' => ['required', 'in:L,P'],
        ];
    }
}
