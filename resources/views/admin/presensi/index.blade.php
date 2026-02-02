@extends('layouts.admin')
@section('content')
<h2>Presensi Masuk Siswa</h2>

<select id="siswa">
    <option value="">-- Pilih Siswa --</option>
    @foreach ($siswa as $item)
        <option value="{{ $item->id }}">
            {{ $item->nama }} (NIS: {{ $item->nis ?? '-' }})
        </option>
    @endforeach
</select>

<button onclick="presensiMasuk()">Absen Masuk</button>

<pre id="result" style="margin-top:15px;"></pre>

<script>
function presensiMasuk() {
    const siswaId = document.getElementById('siswa').value;
    if (!siswaId) {
        alert('Pilih siswa dulu');
        return;
    }

    fetch('/api/presensi/masuk', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            peserta_didik_id: siswaId
        })
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById('result').innerText =
            JSON.stringify(data, null, 2);
    })
    .catch(err => {
        document.getElementById('result').innerText = err;
    });
}
</script>
@endsection
