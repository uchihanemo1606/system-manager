<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SystemProjectModel;

class systemproject extends Controller
{
    public function updateAvatarSystem(Request $request)
    {
        // Validate the request
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:8096',
        ]);

        // Handle the file upload
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/avatars'), $filename);


            return response()->json(['success' => 'Avatar updated successfully', 'filename' => $filename]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
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
