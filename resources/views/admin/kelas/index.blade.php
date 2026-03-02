@extends('layouts.admin')

@section('title', 'Data Kelas')

@section('content')

{{-- CSS khusus halaman ini --}}
<link rel="stylesheet" href="{{ asset('css/admin/kelas/index.css') }}">

<div class="kelas-index-wrapper">

  {{-- Header & Actions --}}
  <div class="kelas-header">
    <div class="kelas-header-left">
      <div class="kelas-icon">
        <i class="fas fa-chalkboard"></i>
      </div>
      <div class="kelas-header-title">
        <h3>Data Kelas</h3>
        <p>Manajemen tingkat kelas dan jurusan</p>
      </div>
    </div>

    <a href="{{ route('admin.kelas.create') }}" class="btn-add-kelas">
      <i class="fas fa-plus"></i> Tambah Kelas
    </a>
  </div>

  {{-- Alerts --}}
  @if (session('success'))
    <div class="alert-modern alert-success">
      <i class="fas fa-check-circle"></i>
      {{ session('success') }}
    </div>
  @endif

  @if (session('error'))
    <div class="alert-modern alert-error">
      <i class="fas fa-exclamation-circle"></i>
      {{ session('error') }}
    </div>
  @endif

  {{-- Content Card --}}
  <div class="kelas-card">
    <div class="overflow-x-auto">
      <table class="kelas-table">
        <thead>
          <tr>
            <th>No</th>
            <th>Tingkat</th>
            <th>Jurusan</th>
            <th style="text-align:center;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($kelas as $item)
            <tr>
              <td>
                <span class="kelas-no">{{ $loop->iteration }}</span>
              </td>
              <td>
                <span class="badge-tingkat">{{ $item->tingkat }}</span>
              </td>
              <td>
                <span class="kelas-jurusan">{{ $item->jurusan ?? '-' }}</span>
              </td>
              <td>
                <div class="kelas-actions">
                  <a href="{{ route('admin.kelas.edit', $item->id) }}" class="btn-action btn-edit">
                    <i class="fas fa-edit"></i>
                  </a>
                  <form action="{{ route('admin.kelas.destroy', $item->id) }}" method="POST"
                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-action btn-delete">
                      <i class="fas fa-trash"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4">
                <div class="kelas-empty">
                  <div class="kelas-empty-icon">
                    <i class="fas fa-box-open"></i>
                  </div>
                  <h5>Belum ada data kelas</h5>
                  <p>Silahkan tambahkan data kelas baru</p>
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
