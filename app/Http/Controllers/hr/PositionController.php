<?php

namespace App\Http\Controllers\hr;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\hr\Position;
use App\Services\hr\PositionService;
use App\Http\Requests\hr\PositionRequest;
use Exception;

class PositionController extends Controller
{
    protected $positionService;

    public function __construct(PositionService $positionService)
    {
        $this->positionService = $positionService;
    }

    public function index()
    {
        $this->authorize('accesshr', ['view']);
        $positions = $this->positionService->getAll();
        return view('hr.position.index', compact('positions'));
    }


    public function create()
    {
        $this->authorize('accesshr', ['create']);
        return view('hr.position.create');
    }


    public function store(PositionRequest $request)
    {
        try {
            $position = $this->positionService->create($request->validated());
            return redirect()->route('positions.index')->with('success', 'Position Created Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function show($id)
    {
        $this->authorize('accesshr', ['details']);
    }



    public function edit($id)
    {
        $this->authorize('accesshr', ['modify']);
        $position = Position::findOrFail($id);
        return view('hr.position.edit', compact('position'));
    }



    public function update(PositionRequest $request, $id)
    {
        try {
            $position = $this->positionService->update($id, $request->validated());
            return redirect()->route('positions.index')->with('success', 'Position updated successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function destroy($id)
    {
        try {
            $this->authorize('accesshr', ['delete']);
            $this->positionService->delete($id);
            return redirect()->route('positions.index')->with('success', 'Position Deleted Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }
}
