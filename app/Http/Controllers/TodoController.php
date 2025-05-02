<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    // Menampilkan daftar Todo milik pengguna yang sedang login
    public function index()
    {
        // Ambil semua Todo berdasarkan user_id dan urutkan berdasarkan waktu pembuatan (desc)
        $todos = Todo::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();

        $todosCompleted = Todo::where('user_id', auth::user()->id)
        ->where('is_done', true)
        ->count();
        return view('todo.index', compact('todos', 'todosCompleted'));
    }

    // Menyimpan Todo baru ke database
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'title' => 'required|string|max:255',  // Pastikan title tidak kosong dan panjangnya tidak lebih dari 255 karakter
        ]);

        // Menambahkan data Todo baru ke database
        Todo::create([
            'title' => ucfirst($request->title),  // Membuat huruf pertama pada title menjadi kapital
            'user_id' => Auth::id(), 
            'is_done' => false, 
        ]);

        // Redirect ke halaman daftar Todo dengan pesan sukses
        return redirect()->route('todo.index')->with('success', 'Todo created successfully.');
    }

    // Menampilkan halaman form untuk membuat Todo baru
    public function create()
    {
        return view('todo.create');
    }

    // Menampilkan halaman form untuk mengedit Todo
    public function edit(Todo $todo)
    {
        // Memeriksa apakah Todo milik pengguna yang sedang login
        if (auth::user()->id == $todo->user_id) {
            return view('todo.edit', compact('todo'));  // Menampilkan form edit jika milik pengguna
        } else {
            // Jika tidak milik pengguna, redirect dengan pesan error
            return redirect()->route('todo.index')->with('danger', 'You are not authorized to edit this todo!');
        }
    }

    // Mengupdate data Todo
    public function update(Request $request, Todo $todo)
    {
        // Validasi input title
        $request->validate([
            'title' => 'required|max:255',
        ]);

        // Update data Todo dengan title baru
        $todo->update([
            'title' => ucfirst($request->title),
        ]);

        // Redirect ke halaman daftar Todo dengan pesan sukses
        return redirect()->route('todo.index')->with('success', 'Todo updated successfully!');
    }

    // Menandai Todo sebagai selesai
    public function complete(Todo $todo)
    {
        if (auth::user()->id == $todo->user_id) {
            $todo->update(['is_done' => true]);  // Menandai Todo sebagai selesai
            return redirect()->route('todo.index')->with('success', 'Todo completed successfully!');
        } else {
            return redirect()->route('todo.index')->with('danger', 'You are not authorized to complete this todo!');
        }
    }

    // Mengembalikan Todo ke status "on going"
    public function uncomplete(Todo $todo)
    {
        if (auth::user()->id == $todo->user_id) {
            $todo->update(['is_done' => false]);  // Mengubah status is_done menjadi false
            return redirect()->route('todo.index')->with('success', 'Todo uncompleted successfully!');
        } else {
            return redirect()->route('todo.index')->with('danger', 'You are not authorized to uncomplete this todo!');
        }
    }

    // Menghapus Todo
    public function destroy(Todo $todo)
    {
        if (auth::user()->id == $todo->user_id) {
            $todo->delete();  // Menghapus Todo dari database
            return redirect()->route('todo.index')->with('success', 'Todo deleted successfully!');
        } else {
            return redirect()->route('todo.index')->with('danger', 'You are not authorized to delete this todo!');
        }
    }

    // Menghapus semua Todo yang sudah selesai
    public function destroyCompleted()
     {
         // get all todos for current user where is_completed is true
         $todosCompleted = Todo::where('user_id', auth::user()->id)
             ->where('is_done', true)
             ->get();
 
         foreach ($todosCompleted as $todo) {
             $todo->delete();
         }
 
         // dd($todosCompleted);
         return redirect()->route('todo.index')->with('success', 'All completed todos deleted successfully!');
     }

    



}
