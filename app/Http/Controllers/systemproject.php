<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SystemProjectModel;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class systemproject extends Controller
{

    public function updateAvatarSystem(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);

        $systemProject = SystemProjectModel::first();
        if ($systemProject) {
            // Upload lên Cloudinary
            $uploadedFileUrl = Cloudinary::upload($request->file('avatar')->getRealPath(), [
                'folder' => 'system_avatars',
                'upload_preset' => env('CLOUDINARY_UPLOAD_PRESET', 'ml_default')
            ])->getSecurePath();

            // Lưu link vào DB
            $systemProject->avatar = $uploadedFileUrl;
            $systemProject->save();

            return response()->json([
                'success' => 'Avatar updated successfully',
                'avatar' => $uploadedFileUrl
            ]);
        }

        return response()->json(['error' => 'System project not found'], 404);
    }

    public function updateFooterSystem(Request $request)
    {
        // Validate the request
        $request->validate([
            'footer' => 'required|string|max:255',
        ]);

        // Update the footer in the database
        $systemProject = SystemProjectModel::first();
        if ($systemProject) {
            $systemProject->foodter = $request->input('footer');
            $systemProject->save();

            return response()->json(['success' => 'Footer updated successfully']);
        }

        return response()->json(['error' => 'System project not found'], 404);
    }


    public function getAvatarSystem()
    {
        // Retrieve the system project
        $systemProject = SystemProjectModel::first();
        if ($systemProject) {
            return response()->json(['avatar' => $systemProject->avatar]);
        }

        return response()->json(['error' => 'System project not found'], 404);
    }

    public function getFooterSystem()
    {
        // Retrieve the system project
        $systemProject = SystemProjectModel::first();
        if ($systemProject) {
            return response()->json(['footer' => $systemProject->foodter]);
        }

        return response()->json(['error' => 'System project not found'], 404);
    }


}
