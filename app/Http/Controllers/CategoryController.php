<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('todos')->where('user_id',Auth::id())->get();
        return view('categories.index', compact('categories'));
    }

    public function create()
{
    $categories = Category::all();
    return view('categories.create', compact('categories'));
}


    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
    ]);

    if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'Anda harus login untuk menambahkan kategori.');
    }

    Category::create([
        'title' => $request->title,
        'user_id' => auth()->id(),
    ]);

    return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan');
}


    public function destroy($id)
    {
        Category::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Kategori berhasil dihapus');
    }
}
