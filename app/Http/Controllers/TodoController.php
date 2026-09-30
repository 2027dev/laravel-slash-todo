<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::orderBy('completed')->orderBy('position')->orderBy('id')->get();

        return view('todos.index', [
            'todos' => $todos,
            'remaining' => $todos->where('completed', false)->count(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
        ]);

        Todo::create([
            'title' => $data['title'],
            'position' => (Todo::max('position') ?? 0) + 1,
        ]);

        return redirect()->route('todos.index');
    }

    public function toggle(Todo $todo)
    {
        $todo->update(['completed' => ! $todo->completed]);

        return redirect()->route('todos.index');
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();

        return redirect()->route('todos.index');
    }
}
