<?php

namespace App\Services\user;


use App\Models\user\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;

class UserService
{
    public function afterUserStored(?User $user, ?string $plainPassword)
    {
        if ($user && !empty($plainPassword)) {
        
            session(['new_user_data' => [
                'name' => $user->name,
                'email' => $user->email,
                'password' => $plainPassword
            ]]);
        }
    
        return redirect()->route('user.showData');
    }


    public function getAll()
    {
        return User::with(['department:id,subject', 'positionRelation:id,subject'])->get();
    }

    public function create(array $data)
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        // Temporarily remove photo from $data to create user first
        $photo = $data['photo'] ?? null;
        unset($data['photo']);

        $user = User::create($data);
        
        // Check if user creation was successful
        if (!$user) {
            throw new \Exception('Failed to create user');
        }

        if ($photo instanceof UploadedFile) {
            $folderName = $user->id . '-' . \Carbon\Carbon::parse($user->created_at)->format('Ymd_His');
            // استخدام اسم ملف بدون أحرف عربية لتجنب مشاكل encoding
            $fileName = 'user_' . $user->id . '_' . time() . '.' . $photo->getClientOriginalExtension();


            if (app()->environment('production')) {
                // Production: store in public_html/profile_pictures manually
                $destination = $_SERVER['DOCUMENT_ROOT'] . "/profile_pictures/user/{$folderName}";
                if (!File::exists($destination)) {
                    File::makeDirectory($destination, 0755, true);
                }
                $photo->move($destination, $fileName);
                $user->photo = "profile_pictures/user/{$folderName}/{$fileName}";
            } else {
                // Local: use Laravel's storage with symbolic link
                $path = $photo->storeAs("public/lexpro/user/{$folderName}", $fileName);
                $user->photo = str_replace('public/', '', $path);
            }
        } else {
            $user->photo = null;
        }

        $user->save();
        return $user;
    }


    public function update($id, $data)
    {
        $user = User::findOrFail($id);

        $photo = $data['photo'] ?? null;
        unset($data['photo']);

        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        // If there's a new photo uploaded
        if ($photo instanceof UploadedFile && $photo->isValid()) {
            // Delete old image if it's not the default
            if ($user->photo && $user->photo !== 'lexpro/defaults/blank2.png') {
                if (app()->environment('production')) {
                    $oldPath = $_SERVER['DOCUMENT_ROOT'] . '/' . $user->photo;
                    if (File::exists($oldPath)) {
                        File::delete($oldPath);
                    }
                } else {
                    Storage::disk('public')->delete($user->photo);
                }
            }

            // Prepare new path
            $folderName = $user->id . '-' . \Carbon\Carbon::parse($user->created_at)->format('Ymd_His');
            // استخدام اسم ملف بدون أحرف عربية لتجنب مشاكل encoding
            $fileName = 'user_' . $user->id . '_' . time() . '.' . $photo->getClientOriginalExtension();


            if (app()->environment('production')) {
                $destination = $_SERVER['DOCUMENT_ROOT'] . "/profile_pictures/user/{$folderName}";
                if (!File::exists($destination)) {
                    File::makeDirectory($destination, 0755, true);
                }
                $photo->move($destination, $fileName);
                $data['photo'] = "profile_pictures/user/{$folderName}/{$fileName}";
            } else {
                $path = $photo->storeAs("public/lexpro/user/{$folderName}", $fileName);
                $data['photo'] = str_replace('public/', '', $path);
            }
        }

        $user->update($data);
        return $user;
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        if ($user->photo && $user->photo !== 'lexpro/defaults/blank2.png') {
            if (app()->environment('production')) {
                $photoPath = $_SERVER['DOCUMENT_ROOT'] . '/' . $user->photo;
                if (File::exists($photoPath)) {
                    File::delete($photoPath);
                }
            } else {
                Storage::disk('public')->delete($user->photo);
            }
        }
        $user->delete();
    }
}
