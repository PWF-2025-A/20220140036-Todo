<?php

namespace App\Http\Controllers;
use App\Models\Todo; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TodoController extends Controller
{
    public function index()
    {

        // $todos = Todo::all(); 
        
        // // Kirim data todo ke view
        // return view('todo.index', compact('todos'));
       
        // if (Auth::check()) {
        //     dd('User ID: ' . Auth::id());
        // } else {
        //     dd('User belum login!');
        // }
        // // $todos = Todo::all();
        $todos = Todo::where('user_id', Auth::id())->get();
        dd($todos->toArray());
        return view('todo.index', compact('todos'));
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
