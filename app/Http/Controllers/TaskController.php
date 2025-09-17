<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Auth::user()->tasks();

        // Filter berdasarkan status
        if ($request->status === 'completed') {
            $query->where('is_completed', true);
        } elseif ($request->status === 'pending') {
            $query->where('is_completed', false);
        }

        // Sort berdasarkan judul tugas
        if ($request->sort === 'asc') {
            $query->orderBy('title', 'asc');
        } elseif ($request->sort === 'desc') {
            $query->orderBy('title', 'desc');
        } else {
            $query->latest(); // default urutan berdasarkan tanggal dibuat
        }

        $tasks = $query->get(); // atau ->paginate(10) jika pakai pagination

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Task::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'is_completed' => $request->has('is_completed'),
        ]);

        return redirect()->route('tasks.index')->with('success', 'Tugas ditambahkan!');
    }

    public function edit(Task $task)
    {
        // pastikan user hanya bisa edit tugasnya sendiri
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }

        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'is_completed' => $request->has('is_completed'),
        ]);

        return redirect()->route('tasks.index')->with('success', 'Tugas diperbarui!');
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);

        // Opsional: pastikan hanya user pemilik yang bisa hapus
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil dihapus.');
    }
}
