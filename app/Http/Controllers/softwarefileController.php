<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\softwareFileModel;

class softwarefileController extends Controller
{
    public function createSoftwarefile(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

           $validated = $request->validate([
            'software_id' => 'required|string|exists:hardware,ip|max:25',
            'file_name' => 'required|string|max:255',
            'file_path' => 'required|string|max:10000',
            'description' => 'nullable|string|max:10000',
        ]);

        $exists = softwareFileModel::where([
            'software_id' => $validated['software_id'],
            'file_name' => $validated['file_name'],
            'file_path' => $validated['file_path'],
        ])->exists();

        if ($exists) {
            return response()->json([
                'status' => 'error',
                'message' => 'file already exists for this software.'
            ], 409);
        }
       $softwareFile = softwareFileModel::create([
            'software_id' => $validated['software_id'],
            'username' => $user->username,
            'file_name' => $validated['file_name'],
            'file_path' => $validated['file_path'],
            'description' => $validated['description'] ?? null,
        ]);
        return response()->json([
            'message' => 'Software file created successfully.',
            'data' => $softwareFile,
        ], 201);
        } catch (TokenExpiredException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token has expired.'
            ], 401);
        } catch (TokenInvalidException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token is invalid.'
            ], 401);
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token is absent or could not be parsed.'
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Could not create hardware permission. ' . $e->getMessage()
            ], 500);
        }

    }

    public function updateSoftwareFile(Request $request)
    {
         try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $softwareFileid = $request->query('id');
            $validated = $request->validate([
                'software_id' => 'required|string|exists:hardware,ip|max:25',
                'file_name' => 'required|string|max:255',
                'file_path' => 'required|string|max:10000',
                'description' => 'nullable|string|max:10000',
            ]);
            $softwareFile = softwareFileModel::findOrFail($softwareFileid);

            if(!$softwareFile) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Software file not found.'
                ], 404);
            }

            $softwareFile->update($validated);
            return response()->json([
                'message' => 'Software file updated successfully.',
                'data' => $softwareFile,
            ], 200);
        }catch (TokenExpiredException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token has expired.'
            ], 401);
        } catch (TokenInvalidException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token is invalid.'
            ], 401);
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token is absent or could not be parsed.'
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Could not create hardware permission. ' . $e->getMessage()
            ], 500);
        }

    }

    public function deleteSoftwareFile(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $softwareFileid = $request->query('id');
            $softwareFile = softwareFileModel::findOrFail($softwareFileid);

            if(!$softwareFile) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Software file not found.'
                ], 404);
            }

            $softwareFile->delete();
            return response()->json([
                'message' => 'Software file deleted successfully.',
            ], 200);
        } catch (TokenExpiredException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token has expired.'
            ], 401);
        } catch (TokenInvalidException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token is invalid.'
            ], 401);
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token is absent or could not be parsed.'
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Could not delete software file. ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAllSoftwareFile(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $softwareFiles = softwareFileModel::with('software')->get();
            return response()->json([
                'message' => 'Software files retrieved successfully.',
                'data' => $softwareFiles,
            ], 200);
        } catch (TokenExpiredException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token has expired.'
            ], 401);
        } catch (TokenInvalidException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token is invalid.'
            ], 401);
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token is absent or could not be parsed.'
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Could not retrieve software files. ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAllSoftwareFileBySoftwareId(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $softwareId = $request->query('software_id');
            $softwareFiles = softwareFileModel::where('software_id', $softwareId)->with('software')->get();

            if ($softwareFiles->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No software files found for this software.'
                ], 404);
            }

            return response()->json([
                'message' => 'Software files retrieved successfully.',
                'data' => $softwareFiles,
            ], 200);
        } catch (TokenExpiredException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token has expired.'
            ], 401);
        } catch (TokenInvalidException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token is invalid.'
            ], 401);
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token is absent or could not be parsed.'
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Could not retrieve software files. ' . $e->getMessage()
            ], 500);
        }
    }

}
