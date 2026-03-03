<?php

namespace App\Http\Controllers\setting;

use App\Http\Controllers\Controller;
use App\Services\setting\CompanyProfileService;
use App\Http\Requests\setting\CompanyProfileRequest;
use App\Models\setting\CompanyProfile;
use App\Models\setting\Currency;
use Illuminate\Http\Request;
use Exception;

class CompanyProfileController extends Controller
{
    protected $companyProfileService;

    public function __construct(CompanyProfileService $companyProfileService)
    {
        $this->companyProfileService = $companyProfileService;
    }

    public function index()
    {
        $this->authorize('accesssetting', ['view']);
        $companyProfiles = $this->companyProfileService->getAll();
        return view('setting.company_profile.index', compact('companyProfiles'));
    }


    public function create()
    {
        $this->authorize('accesssetting', ['create']);
        $currencies = Currency::select('code')->get();
        return view('setting.company_profile.create', compact('currencies'));
    }

    public function store(CompanyProfileRequest $request)
    {
        try {
            $companyProfile = $this->companyProfileService->create($request->validated());
            return redirect()->route('companyProfiles.show', $companyProfile->id)->with('success', 'Company Profile Created Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function show($id)
    {
        $this->authorize('accesssetting', ['details']);
        $companyProfile = CompanyProfile::findOrFail($id);
        return view('setting.company_profile.show', compact('companyProfile'));
    }



    public function edit($id)
    {
        $this->authorize('accesssetting', ['modify']);
        $this->authorize('accesshr', ['modify']);
        $companyProfile = CompanyProfile::findOrFail($id);
        $currencies = Currency::select('code')->get();
        return view('setting.company_profile.edit', compact('companyProfile', 'currencies'));
    }



    public function update(CompanyProfileRequest $request, $id)
    {
        try {
            cache()->forget('company_profile'); // Clear cache
            $companyProfile = $this->companyProfileService->update($id, $request->validated());
            cache()->forever('company_profile', $companyProfile);
            return redirect()->route('companyProfiles.show', $companyProfile->id)->with('success', 'Company Profile Updated Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function destroy($id)
    {
        try {
            $this->authorize('accesssetting', ['delete']);
            $this->companyProfileService->delete($id);
            return redirect()->route('companyProfiles.index')->with('success', 'Company Profile Deleted Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }
}
