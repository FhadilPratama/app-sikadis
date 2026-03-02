@extends('layouts.admin')

@section('title', 'Data Sekolah')

@section('content')
<div class="sekolah-wrapper">

  {{-- Header --}}
  <div class="sekolah-header">
    <div class="sekolah-title-group">
      <div class="sekolah-icon-box">
        <i class="fas fa-school"></i>
      </div>
      <div class="sekolah-title">
        <h3>Data Sekolah</h3>
        <p>Manajemen informasi sekolah induk</p>
      </div>
    </div>

    @if ($sekolah->count() < 1)
      <a href="{{ route('admin.sekolah.create') }}" class="sekolah-btn-add">
        <i class="fas fa-plus"></i> Tambah Sekolah
      </a>
    @endif
  </div>

  {{-- Alerts --}}
  @if (session('success'))
    <div class="sekolah-alert success">
      <i class="fas fa-check-circle"></i>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  @if (session('error'))
    <div class="sekolah-alert error">
      <i class="fas fa-exclamation-circle"></i>
      <span>{{ session('error') }}</span>
    </div>
  @endif

  {{-- Card --}}
  <div class="sekolah-card">
    <div class="overflow-x-auto">
      <table class="sekolah-table">
        <thead>
          <tr>
            <th>NPSN</th>
            <th>Nama Sekolah</th>
            <th>Alamat</th>
            <th style="text-align:center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($sekolah as $item)
            <tr class="sekolah-row">
              <td>{{ $item->npsn }}</td>
              <td>
                <div class="sekolah-name-wrap">
                  <div class="sekolah-mini-icon">
                    <i class="fas fa-school"></i>
                  </div>
                  <div>
                    <div class="sekolah-name-text">{{ $item->nama }}</div>
                    <div class="sekolah-subtext">Sekolah Induk</div>
                  </div>
                </div>
              </td>
              <td>{{ Str::limit($item->alamat ?? '-', 70) }}</td>
              <td style="text-align:center">
                <a href="{{ route('admin.sekolah.edit', $item->id) }}" class="sekolah-btn-edit">
                  <i class="fas fa-edit"></i> Edit
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4">
                <div class="sekolah-empty">
                  <div class="sekolah-empty-icon">
                    <i class="fas fa-school"></i>
                  </div>
                  <h5>Belum ada data sekolah</h5>
                  <p>Silakan tambahkan data sekolah terlebih dahulu</p>
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
