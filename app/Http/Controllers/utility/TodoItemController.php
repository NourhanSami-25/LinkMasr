<?php

namespace App\Http\Controllers\utility;

use App\Http\Controllers\Controller;
use App\Services\utility\TodoItemService;
use App\Http\Requests\utility\TodoItemRequest;
use Illuminate\Http\Request;
use App\Models\utility\TodoItem;
use Exception;


class TodoItemController extends Controller
{
    protected $todoItemService;

    public function __construct(TodoItemService $todoItemService)
    {
        $this->todoItemService = $todoItemService;
    }


    public function store(TodoItemRequest $request)
    {

        try {
            $todoItem = $this->todoItemService->create($request->validated());
            return redirect()->back()->with('success', 'Todo Item Created Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function update(TodoItemRequest $request, $id)
    {
        try {
            $todoItem = $this->todoItemService->update($id, $request->validated());
            return redirect()->back()->with('success', 'Todo Item updated successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function destroy($id)
    {
        $this->todoItemService->delete($id);

        return redirect()->back()
            ->with('success', 'Todo item deleted successfully.');
    }

    public function toggleStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,completed'
        ]);

        $item = TodoItem::findOrFail($id);
        $item->status = $request->status;
        $item->save();

        return response()->json(['message' => 'Status updated successfully.']);
    }
}
