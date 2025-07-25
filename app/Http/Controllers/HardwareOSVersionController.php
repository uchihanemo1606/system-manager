<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HardwareOSVersion;
use Illuminate\Support\Facades\Log;

class HardwareOSVersionController extends Controller
{
    public function getAll()
    {
        try {
            $items = HardwareOSVersion::all();
            return response()->json(['status' => 'success', 'data' => $items]);
        } catch (\Exception $e) {
            Log::error('Lỗi khi lấy danh sách OS:', ['error' => $e->getMessage()]);
            return response()->json(['status' => 'error', 'message' => 'Lỗi khi lấy danh sách'], 500);
        }
    }
    public function getVersionsByOS(Request $request)
    {
        $osName = $request->query('name');
        if (!$osName) {
            return response()->json(['status' => 'error', 'message' => 'Thiếu tên OS'], 400);
        }

        $versions = HardwareOSVersion::where('OS', $osName)->pluck('OSver');
        return response()->json(['status' => 'success', 'data' => $versions]);
    }

    public function create(Request $request)
    {
        try {
            $validated = $request->validate([
                'OS' => 'required|string|max:100',
                'OSver' => 'required|string|max:100',
            ]);

            $item = HardwareOSVersion::create($validated);
            return response()->json(['status' => 'success', 'data' => $item]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 422);
        } catch (\Exception $e) {
            Log::error('Lỗi khi thêm OS version:', ['error' => $e->getMessage()]);
            return response()->json(['status' => 'error', 'message' => 'Lỗi khi thêm dữ liệu'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $item = HardwareOSVersion::find($id);
            if (!$item) {
                return response()->json(['status' => 'error', 'message' => 'Không tìm thấy bản ghi'], 404);
            }

            $validated = $request->validate([
                'OS' => 'sometimes|string|max:100',
                'OSver' => 'sometimes|string|max:100',
            ]);

            $item->update($validated);

            return response()->json(['status' => 'success', 'data' => $item]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 422);
        } catch (\Exception $e) {
            Log::error('Lỗi khi cập nhật OS version:', ['error' => $e->getMessage()]);
            return response()->json(['status' => 'error', 'message' => 'Lỗi khi cập nhật dữ liệu'], 500);
        }
    }
    public function destroy($id)
    {
        try {
            $item = HardwareOSVersion::find($id);
            if (!$item) {
                return response()->json(['status' => 'error', 'message' => 'Không tìm thấy bản ghi'], 404);
            }

            $item->delete();
            return response()->json(['status' => 'success', 'message' => 'Đã xóa thành công']);
        } catch (\Exception $e) {
            Log::error('Lỗi khi xóa OS version:', ['error' => $e->getMessage()]);
            return response()->json(['status' => 'error', 'message' => 'Lỗi khi xóa bản ghi'], 500);
        }
    }
}
