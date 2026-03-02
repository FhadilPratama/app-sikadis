@extends('layouts.admin')

@section('title', 'Data Users')

@section('content')

{{-- CSS LANGSUNG DIPANGGIL DI SINI --}}
<link rel="stylesheet" href="{{ asset('css/admin/users/index.css') }}">

<div class="users-wrapper">

    {{-- HEADER --}}
    <div class="users-header">
        <div class="users-title-group">
            <div class="users-icon-box">
                <i class="fas fa-users"></i>
            </div>
            <div class="users-title">
                <h3>Data Users</h3>
                <p>Manajemen akun pengguna sistem.</p>
            </div>
        </div>

        <a href="{{ route('admin.users.create') }}" class="users-btn-add">
            <i class="fas fa-plus"></i> Tambah User
        </a>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="users-alert success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- CARD --}}
    <div class="users-card">
        <div class="table-responsive">
            <table class="users-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="users-row">
                            <td>
                                <div class="users-name-wrap">
                                    <div class="users-mini-icon">
                                        {{ strtoupper(substr($user->name,0,1)) }}
                                    </div>
                                    <div class="users-name-text">
                                        {{ $user->name }}
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="users-email">
                                    <i class="fas fa-envelope"></i>
                                    {{ $user->email }}
                                </span>
                            </td>

                            <td>
                                <span class="users-badge">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>

                            <td class="text-center">
                                <div class="users-action-group">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" 
                                       class="users-btn-edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <button type="button"
                                        onclick="openDeleteModal({{ $user->id }}, '{{ $user->name }}')"
                                        class="users-btn-delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <div class="users-empty">
                                    <div class="users-empty-icon">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <h5>Tidak ada data user</h5>
                                    <p>Silakan tambahkan user baru.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL DELETE --}}
<div id="deleteModal" class="custom-modal">
    <div class="custom-modal-box danger">
        <div class="modal-icon">
            <i class="fas fa-trash"></i>
        </div>
        <h4>Hapus User?</h4>
        <p id="deleteText"></p>

        <div class="modal-actions">
            <button onclick="closeModal()" class="modal-btn cancel">
                Batal
            </button>

            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="modal-btn confirm danger">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function openDeleteModal(id, nama) {
    document.getElementById('deleteText').innerText =
        "User \"" + nama + "\" akan dihapus permanen.";

    document.getElementById('deleteForm').action =
        "/admin/users/" + id;

    document.getElementById('deleteModal').classList.add('active');
}

function closeModal() {
    document.getElementById('deleteModal').classList.remove('active');
}

window.onclick = function(e) {
    if (e.target.classList.contains('custom-modal')) {
        closeModal();
    }
}
</script>

@endsection