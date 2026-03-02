@extends('layouts.admin')

@section('title', 'Data Rombongan Belajar')

@section('content')
<link rel="stylesheet" href="{{ asset('css/admin/rombonganBelajar/index.css') }}">

<div class="rombel-wrapper">

  {{-- Header --}}
  <div class="rombel-header">
    <div class="rombel-title-group">
      <div class="rombel-icon-box">
        <i class="fas fa-users"></i>
      </div>
      <div class="rombel-title">
        <h3>Rombongan Belajar</h3>
        <p>Manajemen kelas dan pembagian siswa</p>
      </div>
    </div>

    <div class="rombel-actions">
      @if(isset($activeTahunAjar) && $activeTahunAjar)
        <span class="rombel-year-badge">
          <i class="fas fa-calendar-check"></i> Tahun Ajar: {{ $activeTahunAjar->tahun }}
        </span>
        <a href="{{ route('admin.rombongan-belajar.create') }}" class="rombel-btn-add">
          <i class="fas fa-plus"></i> Tambah Rombel
        </a>
      @else
        <span class="rombel-warning-badge">
          <i class="fas fa-exclamation-circle"></i> Aktifkan Tahun Ajar Terlebih Dahulu
        </span>
      @endif
    </div>
  </div>

  {{-- Alerts --}}
  @if (session('success'))
    <div class="rombel-alert success">
      <i class="fas fa-check-circle"></i>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  @if (session('error'))
    <div class="rombel-alert error">
      <i class="fas fa-exclamation-circle"></i>
      <span>{{ session('error') }}</span>
    </div>
  @endif

  {{-- Card --}}
  <div class="rombel-card">
    <div class="overflow-x-auto">
      <table class="rombel-table">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Rombel</th>
            <th>Jurusan</th>
            <th style="text-align:center">Tahun Ajar</th>
            <th style="text-align:center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($rombels as $rombel)
            <tr class="rombel-row">
              <td>{{ $loop->iteration }}</td>
              <td>
                <div class="rombel-name-wrap">
                  <div class="rombel-mini-icon">
                    <i class="fas fa-users"></i>
                  </div>
                  <div>
                    <div class="rombel-name-text">{{ $rombel->nama_rombel }}</div>
                    @if($rombel->external_rombel_id)
                      <div class="rombel-subtext">EXT: {{ $rombel->external_rombel_id }}</div>
                    @endif
                  </div>
                </div>
              </td>
              <td>
                <span class="rombel-badge kelas">
                  {{ $rombel->kelas->tingkat }} {{ $rombel->kelas->jurusan }}
                </span>
              </td>
              <td style="text-align:center">
                <span class="rombel-badge tahun">
                  {{ $rombel->tahunAjar?->tahun ?? '-' }}
                </span>
              </td>
              <td style="text-align:center">
                <div class="rombel-action-group">
                  <a href="{{ route('admin.rombongan-belajar.anggota.index', $rombel->id) }}"
                     class="rombel-btn-manage" title="Kelola Anggota">
                    <i class="fas fa-users-cog"></i>
                  </a>
                  <a href="{{ route('admin.rombongan-belajar.edit', $rombel->id) }}"
                     class="rombel-btn-edit" title="Edit Data">
                    <i class="fas fa-edit"></i>
                  </a>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5">
                <div class="rombel-empty">
                  <div class="rombel-empty-icon">
                    <i class="fas fa-users-slash"></i>
                  </div>
                  <h5>Tidak ada data rombongan belajar</h5>
                  <p>
                    @if(isset($activeTahunAjar) && $activeTahunAjar)
                      Silakan tambahkan rombel untuk tahun ajar {{ $activeTahunAjar->tahun }}
                    @else
                      Aktifkan tahun ajar terlebih dahulu di menu Tahun Ajaran
                    @endif
                  </p>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>
@endsection
