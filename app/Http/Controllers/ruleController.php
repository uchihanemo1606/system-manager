<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Database\Eloquent\ModelNotFoundException;



class ruleController extends Controller
{
    public function createCategoryRule(Request $request)
    {
        try {
            // Xác thực JWT
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $rules = [
                'name' => 'required|string|max:100',
                'description' => 'nullable|string|max:200',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            $categoryRule = DB::table('category_rules')->insertGetId([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'message' => 'Category rule created successfully.',
            'id' => $categoryRule,
        ], 201);

        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not create category rule. ' . $e->getMessage()], 500);
        }
    }

    public function updateCategoryRule(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }
            $rules = [
            'id' => 'required|integer|exists:category_rules,id',
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:200',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $affected = DB::table('category_rules')
            ->where('id', $request->input('id'))
            ->update([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'updated_at' => now(),
            ]);

        if ($affected === 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'No category rule updated or rule not found.'
            ], 404);
        }

        return response()->json([
            'message' => 'Category rule updated successfully.',
            'id' => $request->input('id'),
        ], 200);

    } catch (TokenExpiredException $e) {
        return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
    } catch (TokenInvalidException $e) {
        return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
    } catch (JWTException $e) {
        return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => 'Could not update category rule. ' . $e->getMessage()], 500);
    }
    }

    public function deleteCategoryRule(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $rules = request() ->query('id');
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $deleted = DB::table('category_rules')
                ->where('id', $request->input('id'))
                ->delete();

            if ($deleted === 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No category rule deleted or rule not found.'
                ], 404);
            }

            return response()->json([
                'message' => 'Category rule deleted successfully.',
                'id' => $request->input('id'),
            ], 200);

        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not delete category rule. ' . $e->getMessage()], 500);
        }
    }

    public function getAllCategoryRules()
    {
        try{
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $categoryRules = DB::table('category_rules')->get();

            return response()->json([
                'message' => 'Category rules retrieved successfully.',
                'data' => $categoryRules,
            ], 200);

        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not retrieve category rules. ' . $e->getMessage()], 500);
        }
    }

    public function getCategoryRuleById(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $rules = request() ->query('id');
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer|exists:category_rules,id',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $categoryRule = DB::table('category_rules')
                ->where('id', $request->input('id'))
                ->first();

            if (!$categoryRule) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Category rule not found.'
                ], 404);
            }

            return response()->json([
                'message' => 'Category rule retrieved successfully.',
                'data' => $categoryRule,
            ], 200);

        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not retrieve category rule by ID. ' . $e->getMessage()], 500);
        }
    }

    public function getCategoryRuleByName(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $rules = request() ->query('name');
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:100|exists:category_rules,name',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $categoryRule = DB::table('category_rules')
                ->where('name', $request->input('name'))
                ->first();

            if (!$categoryRule) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Category rule not found.'
                ], 404);
            }

            return response()->json([
                'message' => 'Category rule retrieved successfully.',
                'data' => $categoryRule,
            ], 200);

        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not retrieve category rule by name. ' . $e->getMessage()], 500);
        }
    }

    public function createRule(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $rules = [
                'name' => 'required|string|max:100',
                'description' => 'nullable|string|max:200',
                'category_rule_id' => 'required|integer|exists:category_rules,id',
                'file_url' => 'string|nullable|max:255',
                'descripton' => 'string|nullable|max:600',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $ruleId = DB::table('rules')->insertGetId([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'category_rule_id' => $request->input('category_rule_id'),
                'username' => $user->username,
                'file_url' => $request->input('file_url', null),
                'date_release' => now(),
                'descripton' => $request->input('description', null),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'message' => 'Rule created successfully.',
                'id' => $ruleId,
            ], 201);

        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not create rule. ' . $e->getMessage()], 500);
        }
    }

    public function updateRule(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $rules = [
                'id' => 'required|integer|exists:rules,id',
                'name' => 'required|string|max:100',
                'description' => 'nullable|string|max:200',
                'category_rule_id' => 'required|integer|exists:category_rules,id',
                'file_url' => 'string|nullable|max:255',
                'descripton' => 'string|nullable|max:600',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $affected = DB::table('rules')
                ->where('id', $request->input('id'))
                ->update([
                    'name' => $request->input('name'),
                    'description' => $request->input('description'),
                    'category_rule_id' => $request->input('category_rule_id'),
                    'file_url' => $request->input('file_url', null),
                    'descripton' => $request->input('descripton', null),
                    'updated_at' => now(),
                ]);

            if ($affected === 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No rule updated or rule not found.'
                ], 404);
            }

            return response()->json([
                'message' => 'Rule updated successfully.',
                'id' => $request->input('id'),
            ], 200);

        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not update rule. ' . $e->getMessage()], 500);
        
        }
    }

    public function deleteRule(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $rules = request() ->query('id');
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $deleted = DB::table('rules')
                ->where('id', $request->input('id'))
                ->delete();

            if ($deleted === 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No rule deleted or rule not found.'
                ], 404);
            }

            return response()->json([
                'message' => 'Rule deleted successfully.',
                'id' => $request->input('id'),
            ], 200);

        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not delete rule. ' . $e->getMessage()], 500);
        }
    }
    public function getAllRules()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $rules = DB::table('rules')->get();

            return response()->json([
                'message' => 'Rules retrieved successfully.',
                'data' => $rules,
            ], 200);

        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not retrieve rules. ' . $e->getMessage()], 500);
        }
    }

    public function createSoftwareRule(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $rules = [
                'software_id' => 'required|integer|exists:category_rules,id',
                'rule_id' => 'required|integer|exits:rules,id',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $softwareRuleId = DB::table('software_rules')->insertGetId([
                'software_id' => $request->input('software_id'),
                'rule_id' => $request->input('rule_id'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'message' => 'Software rule created successfully.',
                'id' => $softwareRuleId,
            ], 201);

        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not create software rule. ' . $e->getMessage()], 500);
        }   
    }

    public function updateSoftwareRule(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $rules = [
                'id' => 'required|integer|exists:software_rules,id',
                'name' => 'required|string|max:100',
                'description' => 'nullable|string|max:200',
                'category_rule_id' => 'required|integer|exists:category_rules,id',
                'file_url' => 'string|nullable|max:255',
                'descripton' => 'string|nullable|max:600',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $affected = DB::table('software_rules')
                ->where('id', $request->input('id'))
                ->update([
                    'name' => $request->input('name'),
                    'description' => $request->input('description'),
                    'category_rule_id' => $request->input('category_rule_id'),
                    'file_url' => $request->input('file_url', null),
                    'descripton' => $request->input('descripton', null),
                    'updated_at' => now(),
                ]);

            if ($affected === 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No software rule updated or rule not found.'
                ], 404);
            }

            return response()->json([
                'message' => 'Software rule updated successfully.',
                'id' => $request->input('id'),
            ], 200);

        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not update software rule. ' . $e->getMessage()], 500);
        }
    }

    public function deleteSoftwareRule(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $rules = request() ->query('id');
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $deleted = DB::table('software_rules')
                ->where('id', $request->input('id'))
                ->delete();

            if ($deleted === 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No software rule deleted or rule not found.'
                ], 404);
            }

            return response()->json([
                'message' => 'Software rule deleted successfully.',
                'id' => $request->input('id'),
            ], 200);

        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not delete software rule. ' . $e->getMessage()], 500);
        }
    }

    public function getAllRulesInSoftware(Request $request)
    {
       try
       {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $rules = DB::table('software_rules')
                ->join('rules', 'software_rules.rule_id', '=', 'rules.id')
                ->select('software_rules.*', 'rules.name as rule_name', 'rules.description as rule_description')
                ->get();

            return response()->json([
                'message' => 'Software rules retrieved successfully.',
                'data' => $rules,
            ], 200);

        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not retrieve software rules. ' . $e->getMessage()], 500);
       } 
    }

    public function getRuleById(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $rules = request() ->query('id');
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer|exists:rules,id',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $rule = DB::table('rules')
                ->where('id', $request->input('id'))
                ->first();

            if (!$rule) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Rule not found.'
                ], 404);
            }

            return response()->json([
                'message' => 'Rule retrieved successfully.',
                'data' => $rule,
            ], 200);

        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not retrieve rule by ID. ' . $e->getMessage()], 500);
        }
    }

    public function getRuleBycategoryId(Request $request)
    {
        try{
            if(!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $rules = request()->query('category_rule_id') ?? $request->input('category_rule_id');

            $validator = Validator::make($request->all(), [
                'category_rule_id' => 'required|integer|exists:category_rules,id',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            $rules = DB::table('rules')
                ->where('category_rule_id', $request->input('category_rule_id'))
                ->get();
            if ($rules->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No rules found for this category.'
                ], 404);
            }
            return response()->json([
                'message' => 'Rules retrieved successfully.',
                'data' => $rules,
            ], 200);
        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not retrieve rules by category ID. ' . $e->getMessage()], 500);
        }
    }

    public function getRuleByName(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Please login to use this function'], 401);
            }

            $rules = request() ->query('name') ?? $request->input('name');
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:100|exists:rules,name',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $rule = DB::table('rules')
                ->where('name', 'like', '%' . $request->input('name') . '%')
                ->first();

            if (!$rule) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Rule not found.'
                ], 404);
            }

            return response()->json([
                'message' => 'Rule retrieved successfully.',
                'data' => $rule,
            ], 200);

        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is absent or could not be parsed.'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not retrieve rule by name. ' . $e->getMessage()], 500);
        }
    }

}
