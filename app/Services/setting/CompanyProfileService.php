<?php

namespace App\Services\setting;

use Illuminate\Support\Facades\Storage;
use App\Models\setting\CompanyProfile;
use App\Models\common\File;
use Illuminate\Http\UploadedFile;

class CompanyProfileService
{
    public function getAll()
    {
        return CompanyProfile::all();
    }

    public function get()
    {
        return cache()->rememberForever('company_profile', function () {
            return CompanyProfile::where('type', 'main_profile')->first();
        });
    }

    public function create(array $data)
    {
        if (isset($data['pdf_profile']) && $data['pdf_profile']->isValid()) {
            $fileData = $this->prepareFileData($data);
            $path = $this->generateFilePath($fileData);
            $data['pdf_profile'] = $path;
        }

        $logo = $data['logo'] ?? null;
        unset($data['logo']);
        if ($logo instanceof UploadedFile) {
            // Create safe filename without Arabic characters
            $safeName = 'company_logo';
            $fileName = $safeName . '_' . time() . '.' . $logo->getClientOriginalExtension();
            
            if (app()->environment('production')) {
                // Production: store in public_html/profile_pictures manually
                $destination = $_SERVER['DOCUMENT_ROOT'] . "/company_profile";
                if (!File::exists($destination)) {
                    File::makeDirectory($destination, 0755, true);
                }
                $logo->move($destination, $fileName);
                $data['logo'] = "company_profile/{$fileName}";
            } else {
                // Local: use Laravel's storage with symbolic link
                $path = $logo->storeAs("public/lexpro/company_profile", $fileName);
                $data['logo'] = str_replace('public/', '', $path);
            }
        } else {
            $data['logo'] = 'lexpro/defaults/client.png';
        }

        return CompanyProfile::create($data);
    }

    public function update($id, array $data)
    {
        $companyProfile = CompanyProfile::findorfail($id);

        // Handle PDF profile
        if (isset($data['pdf_profile']) && $data['pdf_profile']->isValid()) {

            if (!empty($companyProfile->pdf_profile) && Storage::disk('public')->exists($companyProfile->pdf_profile)) {
                Storage::disk('public')->delete($companyProfile->pdf_profile);
            }

            $fileData = $this->prepareFileData($data);
            $path = $this->generateFilePath($fileData);
            $data['pdf_profile'] = $path;
        } else {
            unset($data['pdf_profile']); // keep existing if not uploading new one
        }

        // Handle Logo upload
        $logo = $data['logo'] ?? null;
        unset($data['logo']);

        if ($logo instanceof UploadedFile) {
            // Create safe filename without Arabic characters
            $safeName = 'company_logo';
            $fileName = $safeName . '_' . time() . '.' . $logo->getClientOriginalExtension();

            if (app()->environment('production')) {
                $destination = $_SERVER['DOCUMENT_ROOT'] . "/company_profile";
                if (!File::exists($destination)) {
                    File::makeDirectory($destination, 0755, true);
                }
                $logo->move($destination, $fileName);
                $data['logo'] = "company_profile/{$fileName}";
            } else {
                $path = $logo->storeAs("public/lexpro/company_profile", $fileName);
                $data['logo'] = str_replace('public/', '', $path);
            }
        }

        // If no new logo provided and model already has one, retain it
        if (!isset($data['logo']) && $companyProfile->logo) {
            $data['logo'] = $companyProfile->logo;
        }

        $companyProfile->update($data);
        return $companyProfile;
    }


    public function delete($id)
    {
        $companyProfile = CompanyProfile::findOrFail($id);
        if (!empty($companyProfile->pdf_profile) && Storage::disk('public')->exists($companyProfile->pdf_profile)) {
            Storage::disk('public')->delete($companyProfile->pdf_profile);
        }
        $companyProfile->delete();
    }


    private function prepareFileData(array $data): array
    {
        $file = $data['pdf_profile'];
        $fileName = $file->getClientOriginalName();
        $modelName = $data['name'];

        return [
            'file' => $file,
            'file_name' => 'PDF_Profile - ' .$fileName,
            'model_name' => $modelName,
            'mime_type' => $file->getClientMimeType(),
        ];
    }

    public function generateFilePath($fileData)
    {
        return $fileData['file']->storeAs('lexpro/' . 'company_profile', $fileData['file_name'], 'public');
    }
}
