<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HardwareDatabase;
use Illuminate\Support\Facades\Log;

class HardwareDatabaseController extends Controller
{
    // Lấy danh sách database
    public function getAll()
    {
        try {
            $items = HardwareDatabase::all();
            return response()->json(['status' => 'success', 'data' => $items]);
        } catch (\Exception $e) {
            Log::error('Lỗi khi lấy danh sách database:', ['error' => $e->getMessage()]);
            return response()->json(['status' => 'error', 'message' => 'Không thể lấy danh sách'], 500);
        }
    }
    public function getVersionsByDBName(Request $request)
    {
        $dbName = $request->query('name');
        if (!$dbName) {
            return response()->json(['status' => 'error', 'message' => 'Thiếu tên Database'], 400);
        }

        $versions = HardwareDatabase::where('dbname', $dbName)->pluck('dbversion');
        return response()->json(['status' => 'success', 'data' => $versions]);
    }

    // Thêm mới database
    public function create(Request $request)
    {
        try {
            $validated = $request->validate([
                'dbname' => 'required|string|max:100',
                'dbversion' => 'required|string|max:100',
            ]);

            $item = HardwareDatabase::create($validated);
            return response()->json(['status' => 'success', 'data' => $item]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 422);
        } catch (\Exception $e) {
            Log::error('Lỗi khi thêm database:', ['error' => $e->getMessage()]);
            return response()->json(['status' => 'error', 'message' => 'Lỗi khi thêm dữ liệu'], 500);
        }
    }

    // Cập nhật database
    public function update(Request $request, $id)
    {
        try {
            $item = HardwareDatabase::find($id);
            if (!$item) {
                return response()->json(['status' => 'error', 'message' => 'Không tìm thấy bản ghi'], 404);
            }

            $validated = $request->validate([
                'dbname' => 'sometimes|string|max:100',
                'dbversion' => 'sometimes|string|max:100',
            ]);

            $item->update($validated);
            return response()->json(['status' => 'success', 'data' => $item]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 422);
        } catch (\Exception $e) {
            Log::error('Lỗi khi cập nhật database:', ['error' => $e->getMessage()]);
            return response()->json(['status' => 'error', 'message' => 'Lỗi khi cập nhật dữ liệu'], 500);
        }
    }

    // Xóa database
    public function destroy($id)
    {
        try {
            $item = HardwareDatabase::find($id);
            if (!$item) {
                return response()->json(['status' => 'error', 'message' => 'Không tìm thấy bản ghi'], 404);
            }

            $item->delete();
            return response()->json(['status' => 'success', 'message' => 'Đã xóa thành công']);
        } catch (\Exception $e) {
            Log::error('Lỗi khi xóa database:', ['error' => $e->getMessage()]);
            return response()->json(['status' => 'error', 'message' => 'Không thể xóa dữ liệu'], 500);
        }
    }
}
