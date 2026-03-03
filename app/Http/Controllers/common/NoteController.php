<?php

namespace App\Http\Controllers\common;

use App\Http\Controllers\Controller;
use App\Http\Requests\common\NoteRequest;
use App\Services\common\NoteService;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    protected $noteService;

    public function __construct(NoteService $noteService)
    {
        $this->noteService = $noteService;
    }

    public function store(NoteRequest $request)
    {
        $this->noteService->create($request->validated());
        return redirect()->back()->with('success', 'Note created successfully');
    }

    public function update(Request $request, $id)
    {
        $this->noteService->update($id, $request->only(['content']));
        return redirect()->back()->with('success', 'Note updated successfully');
    }

    public function destroy($id)
    {
        $this->noteService->delete($id);
        return redirect()->back()->with('success', 'Note Deleted Successfully');
    }
}
