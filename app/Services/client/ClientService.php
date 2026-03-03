<?php

namespace App\Services\client;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Auth;
use App\Models\client\Client;
use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;

class ClientService
{
    public function getAll()
    {
        return Client::all();
    }

    public function create(array $data)
    {
        $data['created_by'] = Auth::id();
        $data['user_id'] = Auth::id(); // Add user_id for foreign key constraint

        // Temporarily remove photo from $data to create client first
        $photo = $data['photo'] ?? null;
        unset($data['photo']);

        $client = Client::create($data);

        if ($photo instanceof UploadedFile) {
            $folderName = $client->id . '-' . \Carbon\Carbon::parse($client->created_at)->format('Ymd_His');
            // استخدام اسم ملف بدون أحرف عربية لتجنب مشاكل encoding
            $fileName = 'client_' . $client->id . '_' . time() . '.' . $photo->getClientOriginalExtension();


            if (app()->environment('production')) {
                // Production: store in public_html/profile_pictures manually
                $destination = public_path("profile_pictures/client/{$folderName}");
                if (!File::exists($destination)) {
                    File::makeDirectory($destination, 0755, true);
                }
                $photo->move($destination, $fileName);
                $client->photo = "profile_pictures/client/{$folderName}/{$fileName}";
            } else {
                // Local: use Laravel's storage with symbolic link
                $path = $photo->storeAs("public/lexpro/client/{$folderName}", $fileName);
                $client->photo = str_replace('public/', '', $path);
            }
        } else {
            $client->photo = '';
        }

        $client->save();
        return $client;
    }



    public function getItemById($id)
    {
        return Client::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $client = Client::findOrFail($id);

        $photo = $data['photo'] ?? null;
        unset($data['photo']);

        // If there's a new photo uploaded
        if ($photo instanceof UploadedFile && $photo->isValid()) {
            // Delete old image if it's not the default
            if ($client->photo) {
                if (app()->environment('production')) {
                    $oldPath = public_path($client->photo);
                    if (File::exists($oldPath)) {
                        File::delete($oldPath);
                    }
                } else {
                    Storage::disk('public')->delete($client->photo);
                }
            }

            // Prepare new path
            $folderName = $client->id . '-' . \Carbon\Carbon::parse($client->created_at)->format('Ymd_His');
            // استخدام اسم ملف بدون أحرف عربية لتجنب مشاكل encoding
            $fileName = 'client_' . $client->id . '_' . time() . '.' . $photo->getClientOriginalExtension();


            if (app()->environment('production')) {
                $destination = public_path("profile_pictures/client/{$folderName}");
                if (!File::exists($destination)) {
                    File::makeDirectory($destination, 0755, true);
                }
                $photo->move($destination, $fileName);
                $data['photo'] = "profile_pictures/client/{$folderName}/{$fileName}";
            } else {
                $path = $photo->storeAs("public/lexpro/client/{$folderName}", $fileName);
                $data['photo'] = str_replace('public/', '', $path);
            }
        }

        $client->update($data);
        return $client;
    }

    public function delete($id)
    {
        $client = Client::findOrFail($id);

        if ($client->photo) {
            if (app()->environment('production')) {
                $photoPath = public_path($client->photo);
                if (File::exists($photoPath)) {
                    File::delete($photoPath);
                }
            } else {
                Storage::disk('public')->delete($client->photo);
            }
        }
        $client->delete();
    }
}
