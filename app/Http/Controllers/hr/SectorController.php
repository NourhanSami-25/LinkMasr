<?php

namespace App\Http\Controllers\hr;

use App\Http\Controllers\Controller;
use App\Models\hr\Sector;
use App\Models\user\User;
use App\Services\hr\SectorService;
use App\Http\Requests\hr\SectorRequest;
use Exception;


class SectorController extends Controller
{
    protected $sectorService;

    public function __construct(SectorService $sectorService)
    {
        $this->sectorService = $sectorService;
    }

    public function index()
    {
        $this->authorize('accesshr', ['view']);
        $sectors = $this->sectorService->getAll()->reverse();
        return view('hr.sector.index', compact('sectors'));
    }


    public function create()
    {
        $this->authorize('accesshr', ['create']);
        $users = User::select('id', 'name')->where('status', 'active')->get();
        return view('hr.sector.create', compact('users'));
    }


    public function store(SectorRequest $request)
    {
        try {
            $sector = $this->sectorService->create($request->validated());
            return redirect()->route('sectors.index')->with('success', 'Sector Created Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function show($id)
    {
        $this->authorize('accesshr', ['details']);
        $sector = Sector::findOrFail($id);
        return view('hr.sector.show', compact('sector'));
    }



    public function edit($id)
    {
        $this->authorize('accesshr', ['modify']);
        $sector = Sector::findOrFail($id);
        $users = User::select('id', 'name')->where('status', 'active')->get();
        return view('hr.sector.edit', compact('sector', 'users'));
    }



    public function update(SectorRequest $request, $id)
    {
        try {
            $sector = $this->sectorService->update($id, $request->validated());
            return redirect()->route('sectors.index')->with('success', 'Sector updated successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function destroy($id)
    {
        try {
            $this->authorize('accesshr', ['delete']);
            $this->sectorService->delete($id);
            return redirect()->route('sectors.index')->with('success', 'Sector Deleted Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }
}
