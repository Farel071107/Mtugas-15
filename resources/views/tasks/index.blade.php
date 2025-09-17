@extends('layouts.app')

@section('title', 'Daftar Tugas')

@section('content')

    <h1 class="mb-4">Daftar Tugas</h1>
    <!-- Tombol tambah tugas -->
    <a href="{{ route('tasks.create') }}" class="btn btn-success mb-3">
        <i class="bi bi-plus-circle"></i> Tambah Tugas
    </a>

    @if($tasks->count() > 0)
        <ul class="list-group" id="taskList">
            @foreach($tasks as $task)
                <li
                    class="list-group-item d-flex justify-content-between align-items-center task-item animate__animated"
                    style="transition: background-color 0.3s ease;"
                    data-task-id="{{ $task->id }}">
                    
                    <!-- Bagian kiri: judul & deskripsi -->
                    <div>
                        <strong>{{ $task->title }}</strong>
                        <p class="mb-0 text-muted">{{ $task->description ?? '-' }}</p>
                    </div>

                    <!-- Bagian kanan: status + tombol -->
                    <div class="action-box d-flex align-items-center gap-2 px-3 py-2 rounded">
                        @if($task->is_completed)
                            <span class="badge bg-success badge-hover me-2">
                                <i class="bi bi-check-circle"></i> Selesai
                            </span>
                        @else
                            <span class="badge bg-warning text-dark badge-hover me-2">
                                <i class="bi bi-hourglass-split"></i> Belum
                            </span>
                        @endif

                        <!-- Tombol Edit -->
                        <a href="{{ route('tasks.edit', $task->id) }}" 
                           class="btn btn-sm btn-edit btn-anim">
                           <i class="bi bi-pencil-square"></i> Edit
                        </a>

                        <!-- Tombol Hapus -->
                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-delete btn-anim">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <p>Tidak ada tugas.</p>
    @endif

    <style>
        /* Efek hover list */
        .task-item:hover {
            background-color: #f0f8ff;
        }

        /* Container tombol */
        .action-box {
            background: #f9fafb;
            border: 1px solid #e0e0e0;
            box-shadow: inset 0 1px 2px rgba(0,0,0,0.05);
        }

        /* Animasi tombol Edit & Hapus */
        .btn-anim {
            transition: all 0.25s ease-in-out;
            transform: translateY(0);
        }

        .btn-anim:hover {
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
        }

        .btn-anim:active {
            transform: scale(0.95);
        }

        /* Tombol Edit */
        .btn-edit {
            background: #198754;
            border: none;
            color: white;
        }

        .btn-edit:hover {
            background: #157347;
        }

        /* Tombol Hapus */
        .btn-delete {
            border: 1px solid #dc3545;
            color: #dc3545;
            background: transparent;
        }

        .btn-delete:hover {
            background: #dc3545;
            color: white;
        }

        /* Badge hover */
        .badge-hover:hover {
            opacity: 0.8;
            transition: opacity 0.3s ease;
        }
    </style>

    <!-- Animate.css CDN -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Animasi saat menghapus tugas
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    const listItem = form.closest('.task-item');

                    Swal.fire({
                        title: 'Yakin mau hapus?',
                        text: "Data tidak bisa dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Tambahkan kelas animasi keluar (fadeOut)
                            listItem.classList.remove('animate__fadeIn');
                            listItem.classList.add('animate__fadeOut');

                            // Tunggu animasi selesai (1s)
                            setTimeout(() => {
                                form.submit();
                            }, 1000);
                        }
                    });
                });
            });

            // Animasi masuk saat halaman load (untuk list tugas)
            document.querySelectorAll('.task-item').forEach(item => {
                item.classList.add('animate__fadeIn');
            });

            // SweetAlert Toast untuk tambah tugas (dari session)
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2000,
                    toast: true,
                    position: 'top-end',
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    }
                });
            @endif
        });
    </script>

@endsection
