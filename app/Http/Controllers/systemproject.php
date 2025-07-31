<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SystemProjectModel;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Validator;
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

    // public function updateFooterSystem(Request $request)
    // {
    //     // Validate the request
    //     $request->validate([
    //         'footer' => 'required|string|max:255',
    //     ]); 
    //     // Update the footer in the database
    //     $systemProject = SystemProjectModel::first();
    //     if ($systemProject) {
    //         $systemProject->foodter = $request->input('footer');
    //         $systemProject->save(); 
    //         return response()->json(['success' => 'Footer updated successfully']);
    //     } 
    //     return response()->json(['error' => 'System project not found'], 404);
    // } 
    public function updateFooterSystem(Request $request)
    {
        $request->validate([
            'foodter' => 'required|string|max:255',
        ]);

        $systemProject = SystemProjectModel::first();

        if (!$systemProject) {
            // Nếu chưa có, tạo mới (dùng foodter đúng tên trong DB)
            $systemProject = new SystemProjectModel();
            $systemProject->foodter = $request->input('foodter');
            $systemProject->save();

            return response()->json(['success' => 'Footer created successfully']);
        }

        // Nếu đã có, cập nhật
        $systemProject->foodter = $request->input('foodter');
        $systemProject->save();

        return response()->json(['success' => 'Footer updated successfully']);
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
    public function updateLogo(Request $request)
    { 

        // Kiểm tra xem file có tồn tại & hợp lệ không
        if (!$request->hasFile('avatar') || !$request->file('avatar')->isValid()) {
            return response()->json([
                'message' => 'File không hợp lệ hoặc không tồn tại.',
            ], 422);
        }

        $file = $request->file('avatar');
        $filename = 'logo.png';
        $destination = public_path('images');

        // Tạo thư mục nếu chưa tồn tại
        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }

        // Di chuyển file vào thư mục
        $file->move($destination, $filename);

        return response()->json([
            'message' => 'Cập nhật logo thành công',
            'logo_url' => asset("images/{$filename}")
        ]);
    }

}
