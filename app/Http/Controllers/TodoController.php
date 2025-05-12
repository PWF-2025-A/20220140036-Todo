<?php



namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->with('category')
            ->get();

        $todosCompleted = Todo::where('user_id', Auth::id())
            ->where('is_done', true)
            ->count();

        return view('todo.index', compact('todos', 'todosCompleted'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('todo.create', compact('categories'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'category_id' => 'nullable|exists:categories,id',
    ]);

    Todo::create([
        'title' => ucfirst($validated['title']),
        'user_id' => Auth::id(),
        'is_done' => false,
        'category_id' => $validated['category_id'] ?: null, // Kosong disimpan sebagai null
    ]);

    return redirect()->route('todo.index')->with('success', 'Todo created successfully.');
}

    public function edit(Todo $todo)
    {
        if (Auth::id() === $todo->user_id) {
            $categories = Category::all();
            return view('todo.edit', compact('todo', 'categories'));
        }

        return redirect()->route('todo.index')->with('danger', 'You are not authorized to edit this todo!');
    }

    public function update(Request $request, Todo $todo)
    {
        $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'nullable|exists:categories,id', // Membolehkan kategori kosong
        ]);

        // // Jika kategori kosong, set null
        // if (empty($request->category_id)) {
        //     $request->category_id = null;
        // }

        $todo->update([
            'title' => ucfirst($request->title),
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('todo.index')->with('success', 'Todo updated successfully!');
    }

    public function complete(Todo $todo)
    {
        if (Auth::id() === $todo->user_id) {
            $todo->update(['is_done' => true]);
            return redirect()->route('todo.index')->with('success', 'Todo completed successfully!');
        }

        return redirect()->route('todo.index')->with('danger', 'You are not authorized to complete this todo!');
    }

    public function uncomplete(Todo $todo)
    {
        if (Auth::id() === $todo->user_id) {
            $todo->update(['is_done' => false]);
            return redirect()->route('todo.index')->with('success', 'Todo uncompleted successfully!');
        }

        return redirect()->route('todo.index')->with('danger', 'You are not authorized to uncomplete this todo!');
    }

    public function destroy(Todo $todo)
    {
        if (Auth::id() === $todo->user_id) {
            $todo->delete();
            return redirect()->route('todo.index')->with('success', 'Todo deleted successfully!');
        }

        return redirect()->route('todo.index')->with('danger', 'You are not authorized to delete this todo!');
    }

    public function destroyCompleted()
    {
        $todosCompleted = Todo::where('user_id', Auth::id())
            ->where('is_done', true)
            ->get();

        foreach ($todosCompleted as $todo) {
            $todo->delete();
        }

        return redirect()->route('todo.index')->with('success', 'All completed todos deleted successfully!');
    }
}




// namespace App\Http\Controllers;

// use App\Models\Todo;
// use App\Models\Category;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;

// class TodoController extends Controller
// {
//     // Menampilkan daftar Todo milik pengguna yang sedang login
//     public function index()
//     {
//         $todos = Todo::where('user_id', Auth::id())
//             ->orderBy('created_at', 'desc')
//             ->with('category') // load relasi category
//             ->get();

//         $todosCompleted = Todo::where('user_id', Auth::id())
//             ->where('is_done', true)
//             ->count();

//         return view('todo.index', compact('todos', 'todosCompleted'));
//     }

//     // Menampilkan form create Todo dan kirim daftar kategori
//     public function create()
//     {
//         $categories = Category::all();
//         return view('todo.create', compact('categories'));
//     }

//     // Menyimpan Todo baru ke database
//     public function store(Request $request)
//     {
//         $request->validate([
//             'title' => 'required|string|max:255',
//             'category_id' => 'required|exists:categories,id',
//         ]);

//         Todo::create([
//             'title' => ucfirst($request->title),
//             'user_id' => Auth::id(),
//             'category_id' => $request->category_id,
//             'is_done' => false,
//         ]);
        
//         \App\Models\Todo::create($validated);

//         return redirect()->route('todo.index')->with('success', 'Todo created successfully.');
//     }

//     // Menampilkan halaman form untuk mengedit Todo
//     public function edit(Todo $todo)
//     {
//         if (Auth::id() == $todo->user_id) {
//             $categories = Category::all();
//             return view('todo.edit', compact('todo', 'categories'));
//         } else {
//             return redirect()->route('todo.index')->with('danger', 'You are not authorized to edit this todo!');
//         }
//     }

//     // Mengupdate data Todo
//     public function update(Request $request, Todo $todo)
//     {
//         $request->validate([
//             'title' => 'required|max:255',
//             'category_id' => 'required|exists:categories,id',
//         ]);

//         $todo->update([
//             'title' => ucfirst($request->title),
//             'category_id' => $request->category_id,
//         ]);

//         return redirect()->route('todo.index')->with('success', 'Todo updated successfully!');
//     }

//     // Menandai Todo sebagai selesai
//     public function complete(Todo $todo)
//     {
//         if (Auth::id() == $todo->user_id) {
//             $todo->update(['is_done' => true]);
//             return redirect()->route('todo.index')->with('success', 'Todo completed successfully!');
//         } else {
//             return redirect()->route('todo.index')->with('danger', 'You are not authorized to complete this todo!');
//         }
//     }

//     // Mengembalikan Todo ke status "on going"
//     public function uncomplete(Todo $todo)
//     {
//         if (Auth::id() == $todo->user_id) {
//             $todo->update(['is_done' => false]);
//             return redirect()->route('todo.index')->with('success', 'Todo uncompleted successfully!');
//         } else {
//             return redirect()->route('todo.index')->with('danger', 'You are not authorized to uncomplete this todo!');
//         }
//     }

//     // Menghapus Todo
//     public function destroy(Todo $todo)
//     {
//         if (Auth::id() == $todo->user_id) {
//             $todo->delete();
//             return redirect()->route('todo.index')->with('success', 'Todo deleted successfully!');
//         } else {
//             return redirect()->route('todo.index')->with('danger', 'You are not authorized to delete this todo!');
//         }
//     }

//     // Menghapus semua Todo yang sudah selesai
//     public function destroyCompleted()
//     {
//         $todosCompleted = Todo::where('user_id', Auth::id())
//             ->where('is_done', true)
//             ->get();

//         foreach ($todosCompleted as $todo) {
//             $todo->delete();
//         }

//         return redirect()->route('todo.index')->with('success', 'All completed todos deleted successfully!');
//     }
// }
