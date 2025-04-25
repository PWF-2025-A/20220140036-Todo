<?php

namespace App\Http\Controllers;
use App\Models\Todo; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TodoController extends Controller
{
    public function index()
    {   

        $todos = Todo::where('user_id', Auth::id())->orderBy('created_at','desc')->get();
        // $todos = Todo::where('user_id', Auth::id())->get();
        // dd($todos->toArray());
        return view('todo.index', compact('todos'));
    }

    public function store(Request $request)
   {
    $request->validate([
        'title' => 'required|string|max:255',
    ]);

    $todo = Todo::create([
        'title' => ucfirst($request->title),
        'user_id' => Auth::id(),
    ]);

    return redirect()->route('todo.index')->with('success', 'Todo created successfully.');
   }

    public function create()
    {
        return view('todo.create');
    }

    public function edit()
    {
        return view('todo.edit');
    }
}
