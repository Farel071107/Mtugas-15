@extends('layouts.app')

@section('title', 'Edit Tugas')

@section('content')
    <h1 class="mb-4">Edit Tugas</h1>

    <form action="{{ route('tasks.update', $task->id) }}" method="POST" style="max-width: 600px;">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Judul Tugas</label>
            <input
                type="text"
                name="title"
                id="title"
                class="form-control"
                value="{{ old('title', $task->title) }}"
                required
                style="width: 100%; transition: box-shadow 0.3s ease;"
            >
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea
                name="description"
                id="description"
                class="form-control"
                rows="6"
                style="height: 150px; resize: vertical; width: 100%; transition: box-shadow 0.3s ease;"
            >{{ old('description', $task->description) }}</textarea>
        </div>

        <div class="form-check mb-3">
            <input
                type="checkbox"
                name="is_completed"
                id="is_completed"
                class="form-check-input"
                {{ old('is_completed', $task->is_completed) ? 'checked' : '' }}
            >
            <label for="is_completed" class="form-check-label">Selesai</label>
        </div>

        <button type="submit" class="btn btn-success btn-hover me-2">Update</button>
        <a href="{{ route('tasks.index') }}" class="btn btn-outline-danger btn-hover">Batal</a>
    </form>

    <style>
        .btn-hover {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }
        .btn-success.btn-hover:hover {
            background-color: #19692c !important;
            border-color: #19692c !important;
            color: white !important;
        }
        .btn-outline-danger.btn-hover:hover {
            background-color: #b71c1c !important;
            border-color: #b71c1c !important;
            color: white !important;
        }

        .form-control:focus {
            border-color: #19692c;
            box-shadow: 0 0 0 0.25rem rgba(25, 105, 44, 0.25);
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
    </style>
@endsection
