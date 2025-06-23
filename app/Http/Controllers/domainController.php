<?php

namespace App\Http\Controllers;

use App\Models\hardwareAccessDomainModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\DomainModel;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\LogController;
use App\Models\hardwareModel;


class domainController extends Controller
{
    public function createDomain(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['message' => 'Please login to use this function'], 401);
        }

            // Validate the request data
            $request->validate([
                'name' => 'required|string|max:255',
                'createBy' => $user->username,
                'link' => 'required|string|max:255',
                'software_id' => 'required|integer|exists:software,id',
            ]);

            // Create a new domain record
            $domain = new DomainModel();
            $domain->name = $request->input('name');
            $domain->link = $request->input('link', '');
            $domain->software_id = $request->input('software_id',);
            $domain->createBy = $user->username;
            $domain->created_at = now();
            $domain->updated_at = now();

            // Save the domain record
            if ($domain->save()) {
                // Log the creation of the domain
                LogController::createLogAuto([
                    'username' => $user->username,
                    'link_domain' => $domain->link,
                    'message' => " user {$user->username} created domain '{$domain->name}'.",
                    'is_delete' => false
                ]);
                return response()->json(['message' => 'Domain created successfully', 'data' => $domain], 201);
            } else {
                return response()->json(['message' => 'Failed to create domain'], 500);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not create domain. ' . $e->getMessage()], 500);
        }
    }

    public function getAllDomains(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            // Retrieve all domains
            $domains = DomainModel::all();

            return response()->json(['message' => 'Domains retrieved successfully', 'data' => $domains], 200);
        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not retrieve domains. ' . $e->getMessage()], 500);
        }
    }

    public function updateDomain(Request $request)
    {
    try {
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['message' => 'Please login to use this function'], 401);
        }

        // Validate the request data
        $request->validate([
            'id' => 'required|integer|exists:domains,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'link' => 'required|string|max:255',
        ]);

        // Find the domain record
        $domain = DomainModel::find($request->input('id'));
        if (!$domain) {
            return response()->json(['message' => 'Domain not found'], 404);
        }

        // Lưu thông tin cũ
        $oldData = $domain->only(['name', 'link', 'description']);

        // Update the domain record
        $domain->name = $request->input('name');
        $domain->link = $request->input('link', '');
        $domain->description = $request->input('description');
        $domain->updated_at = now();

        // Save the updated domain record
        if ($domain->save()) {
            // Lấy thông tin mới
            $newData = $domain->only(['name', 'link', 'description']);

            // So sánh và tạo chuỗi thay đổi
            $changes = [];
            foreach ($oldData as $key => $oldValue) {
                $newValue = $newData[$key];
                if ($oldValue != $newValue) {
                    $changes[] = "$key: '$oldValue' => '$newValue'";
                }
            }
            $changeString = $changes ? implode(', ', $changes) : 'No changes';

            // Log the update of the domain
            LogController::createLogAuto([
                'username' => $user->username,
                'domain_id' => $domain->id,
                'message' => "User {$user->username} updated domain '{$domain->name}'. Changes: $changeString",
                'is_delete' => false
            ]);
            return response()->json(['message' => 'Domain updated successfully', 'data' => $domain], 200);
        } else {
            return response()->json(['message' => 'Failed to update domain'], 500);
        }
        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not update domain. ' . $e->getMessage()], 500);   
        }
    }


     public function createHardwareDomain(Request $request)
    {
        try{
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }
            $request->validate([
                'hardware_ip' => 'required|string|exists:hardware,ip|max:25',
                'domain_id' => 'required|integer|exists:domain,id',
            ]);
            $hardware_ip = $request->input('hardware_ip');
            $domain_id = $request->input('domain_id');

            // Check if the user has permission to add domains to hardware
            $exists = hardwareAccessDomainModel::where([
            'hardware_ip' => $hardware_ip,
            'domain_id' => $domain_id,
            ])->exists();
            if ($exists) {
                return response()->json(['status' => 'error', 'message' => 'This domain is already assigned to this hardware'], 409);
            }

            $hardwareaccessdomain = hardwareAccessDomainModel::create([
            'hardware_ip' => $hardware_ip,
            'domain_id' => $domain_id,
        ]);

            LogController::createLogAuto([
                'username' => $user->username,
                'hardware_ip' => $hardware_ip,
                'message' => "User {$user->username} added domain with ID {$domain_id} to hardware with IP {$hardware_ip}",
            ]);
            return response()->json([
                'message' => 'Domain added to hardware successfully',
                'hardware in domain' => $hardwareaccessdomain
            ], 200);

        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not add domain to hardware. ' . $e->getMessage()], 500);
        }
    }

    public function getHardwareSoftwareInDomain(Request $request, $domainId)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            // Validate the domain ID
            $domain = DomainModel::find($domainId);
            if (!$domain) {
                return response()->json(['message' => 'Domain not found'], 404);
            }

            // Retrieve hardware associated with the domain
            $hardware = hardwareAccessDomainModel::where('domain_id', $domainId)
                ->with('hardware')
                ->get();

            return response()->json(['message' => 'Hardware retrieved successfully', 'data' => $hardware], 200);
        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not retrieve hardware. ' . $e->getMessage()], 500);
        }
    }

    
    public function getHardwareAndSoftwareInDomain(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $link = $request->query('link', $request->input('link'));
            $name = $request->query('name', $request->input('name'));

            // Lấy domain
             $domainQuery = domainModel::query();
        if ($link) {
            $domainQuery->where('link', $link);
        }
        if ($name) {
            $domainQuery->where('name', $name);
        }
        $domain = $domainQuery->with('software')->first();

        if (!$domain) {
            return response()->json(['message' => 'Domain not found'], 404);
        }

        // Lấy hardware liên kết với domain
            $hardware = hardwareAccessDomainModel::where('domain_id', $domain->id)
                ->with('hardware')
                ->get()
                ->pluck('hardware')
                ->filter();

            // Lấy software liên kết với domain
            $software = $domain->software;

            return response()->json([
                'message' => 'Data retrieved successfully',
                'domain' => $domain,
                'hardware_count' => $hardware->count(),
                'hardware' => $hardware->values(),
            ], 200);
        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not retrieve data. ' . $e->getMessage()], 500);
        }
    }

    public function getdomainbyhardware(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $ip = $request->query('ip');
            if (!$ip) {
                return response()->json(['status' => 'error', 'message' => 'IP is required'], 400);
            }

            // Lấy tất cả hardware_ip gần giống
            $hardwareAccessDomains = hardwareAccessDomainModel::where('hardware_ip', 'like', '%' . $ip . '%')->get();

            if ($hardwareAccessDomains->isEmpty()) {
                return response()->json(['status' => 'error', 'message' => 'No hardware found'], 404);
            }

            // Gom nhóm theo hardware_ip
            $result = [];
            $grouped = $hardwareAccessDomains->groupBy('hardware_ip');
            foreach ($grouped as $hardware_ip => $items) {
                // Lấy domain đầu tiên (nếu có)
                $domainId = $items->first()->domain_id ?? null;
                if ($domainId) {
                    $domain = DomainModel::find($domainId);
                    if ($domain) {
                        $result[] = [
                            'hardware_ip' => $hardware_ip,
                            'domain' => $domain
                        ];
                    }
                }
                // Nếu không có domain thì bỏ qua
            }

            if (empty($result)) {
                return response()->json(['status' => 'error', 'message' => 'No domain found for these hardware IPs'], 404);
            }

            return response()->json([
                'message' => 'Domains by hardware IP retrieved successfully',
                'data' => $result
            ]);
        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not retrieve domains. ' . $e->getMessage()], 500);
        }
    }

}