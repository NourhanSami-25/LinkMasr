<?php

namespace App\Http\Controllers\utility;

use App\Http\Controllers\Controller;
use App\Models\utility\Todo;
use App\Services\utility\TodoService;
use App\Http\Requests\utility\TodoRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use Exception;


class TodoController extends Controller
{
    protected $todoService;


    public function __construct(TodoService $todoService)
    {
        $this->todoService = $todoService;
    }

    public function getLatestTodos()
    {
        $todos = Todo::with('todoItems')
            ->where('user_id', auth()->id())
            ->orderByRaw("CASE WHEN status = 'pending' THEN 0 ELSE 1 END") // pending first
            ->orderByRaw("FIELD(priority, 'urgent', 'important', 'normal')") // custom priority
            ->latest()
            ->limit(15)
            ->get();

        return response()->json($todos);
    }


    public function index()
    {
        $todos = $this->todoService->getAll()->reverse();
        return view('utility.todo.index', compact('todos'));
    }


    public function create()
    {
        $todos = Todo::select('id', 'subject')->get();
        return view('utility.todo.create', compact('todos'));
    }


    public function store(TodoRequest $request)
    {
        try {
            $todo = $this->todoService->create($request->validated());
            return redirect()->route('todos.index')->with('success', 'Todo List Created Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function show($id)
    {
        $todo = $this->todoService->getItemById($id);
        $todoItems = $todo->todoItems;
        return view('utility.todo.show', compact('todo', 'todoItems'));
    }


    public function edit($id)
    {
        $todo = Todo::findOrFail($id);
        return view('utility.todo.edit', compact('todo'));
    }



    public function update(TodoRequest $request, $id)
    {
        try {
            $todo = $this->todoService->update($id, $request->validated());
            return redirect()->route('todos.index')->with('success', 'Todo List updated successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function destroy($id)
    {
        try {
            $this->todoService->delete($id);
            return redirect()->route('todos.index')->with('success', 'Todo List Deleted Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function toggleTodoStatus($id)
    {
        $todo = Todo::find($id);

        if (!$todo) {
            return response()->json(['message' => 'Todo not found.'], 404);
        }

        $newStatus = $todo->status === 'completed' ? 'pending' : 'completed';
        $todo->update(['status' => $newStatus]);

        return redirect()->back()->with('success', 'Todolist status changed successfully');
    }
}
