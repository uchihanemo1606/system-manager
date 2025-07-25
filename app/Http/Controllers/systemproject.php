<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
