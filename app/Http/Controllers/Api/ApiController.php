<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Schema;
use App\Models\Inheritance;
use Carbon\Carbon;

class ApiController extends Controller
{


    public function checkAuthorizedLogin(Request $request)
    {
        // Normalize CNIC
        $cnic = preg_replace('/[^0-9]/', '', (string) $request->input('cnic'));

        $validator = Validator::make(
            ['cnic' => $cnic],
            ['cnic' => ['required', 'digits:13']],
            [
                'cnic.required' => 'CNIC is required.',
                'cnic.digits'   => 'CNIC must be exactly 13 digits.',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        try {
            // 1. Fetch ALL owner rows for this CNIC
            $owners = DB::table('current_owners')
                ->where('cnic', $cnic)
                ->orderBy('id')
                ->get();

            // 2. Fetch the login request (latest one)
            $loginRequest = DB::table('authorized_login_requests')
                ->where('cnic', $cnic)
                ->orderByDesc('id')
                ->first();

            // 3. If no owners AND no login request → 404
            if ($owners->isEmpty() && ! $loginRequest) {
                return response()->json([
                    'success' => false,
                    'message' => 'No record found for the provided CNIC.',
                ], 404);
            }

            // 4. Collect property_ids and fetch all properties in ONE query
            $propertyIds = $owners->pluck('property_id')
                ->filter()
                ->unique()
                ->values()
                ->all();

            $properties = collect();
            if (! empty($propertyIds)) {
                $properties = DB::table('properties')
                    ->whereIn('id', $propertyIds)
                    ->get()
                    ->keyBy('id');
            }

            // 5. Optional: fetch sector & block names for display
            $sectorIds = $properties->pluck('sector_id')->filter()->unique()->values()->all();
            $blockIds  = $properties->pluck('block_id')->filter()->unique()->values()->all();

            $sectors = collect();
            if (! empty($sectorIds)) {
                $sectors = DB::table('sectors')
                    ->whereIn('id', $sectorIds)
                    ->pluck('name', 'id');
            }

            $blocks = collect();
            if (! empty($blockIds)) {
                $blocks = DB::table('blocks')
                    ->whereIn('id', $blockIds)
                    ->pluck('name', 'id');
            }

            // 6. Build the enriched owners array (owner + its property)
            $ownersWithProperties = $owners->map(function ($owner) use ($properties, $sectors, $blocks) {
                $property = $owner->property_id
                    ? $properties->get($owner->property_id)
                    : null;

                $propertyPayload = null;

                if ($property) {
                    $propertyPayload = [
                        'id'                => $property->id,
                        'application_no'    => $property->application_no ?? null,
                        'application_date'  => $property->application_date ?? null,
                        'plot_no'           => $property->plot_no ?? null,
                        'form_no'           => $property->form_no ?? null,

                        // Sector / Block (IDs + names if available)
                        'sector_id'         => $property->sector_id ?? null,
                        'sector_name'       => $property->sector_id
                            ? ($sectors[$property->sector_id] ?? null)
                            : null,
                        'block_id'          => $property->block_id ?? null,
                        'block_name'        => $property->block_id
                            ? ($blocks[$property->block_id] ?? null)
                            : null,

                        // Area fields
                        'kanal'             => $property->kanal ?? null,
                        'marla'             => $property->marla ?? null,
                        'sqrft'             => $property->sqrft ?? null,
                        'size'              => $property->size ?? null,   // 👈 main "area" string

                        // Property classification
                        'category'          => $property->category ?? null,
                        'ownership_type'    => $property->ownership_type ?? null,
                        'allotment_type'    => $property->allotment_type ?? null,
                        'mode_allottment'   => $property->mode_allottment ?? null,
                        'allotment_date'    => $property->allotment_date ?? null,
                        'transfer_count'    => $property->transfer_count ?? null,

                        // Extra
                        'remarks'           => $property->remarks ?? null,
                        'approved_scheme'   => $property->approved_scheme ?? null,
                        'initial_draft_amount' => $property->initial_draft_amount ?? null,
                        'initial_draft_date'   => $property->initial_draft_date ?? null,
                        'balloting_serial_no'  => $property->balloting_serial_no ?? null,
                    ];
                }

                return [
                    'id'                => $owner->id,
                    'property_id'       => $owner->property_id,
                    'name'              => $owner->applicant_name,
                    'father_name'       => $owner->father_husband_name,
                    'cnic'              => $owner->cnic,
                    'old_nic'           => $owner->old_nic,
                    'address'           => $owner->address_permanent ?: $owner->address_temporary,
                    'address_permanent' => $owner->address_permanent,
                    'address_temporary' => $owner->address_temporary,
                    'is_current'        => true,
                    'created_at'        => $owner->created_at,
                    'property'          => $propertyPayload,
                ];
            })->values();

            // 7. Group by CNIC so the frontend can show ONE owner card with N properties
            $groupedByCnic = $ownersWithProperties
                ->groupBy('cnic')
                ->map(function ($group) {
                    $first = $group->first();

                    return [
                        'id'                => $first['id'],
                        'name'              => $first['name'],
                        'father_name'       => $first['father_name'],
                        'cnic'              => $first['cnic'],
                        'old_nic'           => $first['old_nic'],
                        'address'           => $first['address'],
                        'address_permanent' => $first['address_permanent'],
                        'address_temporary' => $first['address_temporary'],
                        'is_current'        => $first['is_current'],
                        'created_at'        => $first['created_at'],
                        'properties'        => $group
                            ->pluck('property')
                            ->filter()
                            ->values()
                            ->all(),
                        'owner_row_ids'     => $group->pluck('id')->values()->all(),
                        'property_ids'      => $group->pluck('property_id')->filter()->values()->all(),
                    ];
                })
                ->values();

            return response()->json([
                'success'                  => true,
                'message'                  => 'Data fetched successfully.',
                'owners'                   => $groupedByCnic,
                // kept for backward compatibility — flat list with .property attached
                'current_owners'           => $ownersWithProperties,
                'authorized_login_request' => $loginRequest,
            ], 200);

        } catch (\Throwable $e) {
            report($e);
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'error'   => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

  public function storeAuthorizedLoginRequest(Request $request)
{
    // =========================================================
    // 1. LOG EVERYTHING RECEIVED
    // =========================================================

    Log::info('================ AUTHORIZED LOGIN REQUEST START ================');

    Log::info('Authorized Login Request - Incoming Request', [
        'all_data' => $request->all(),
        'headers' => $request->headers->all(),
        'ip' => $request->ip(),
        'method' => $request->method(),
        'url' => $request->fullUrl(),
        'user_agent' => $request->userAgent(),
        'timestamp' => now()->toDateTimeString(),
    ]);

    // =========================================================
    // 2. VALIDATION
    // =========================================================

    $validator = Validator::make($request->all(), [
        'cnic' => 'required|string|max:20',
        'phone_no' => 'required|string|max:11',
        'email' => 'nullable|email|max:255',
        'username' => 'nullable|string|max:255', // Added username

        'device_name' => 'nullable|string|max:255',
        'device_model' => 'nullable|string|max:255',
        'device_brand' => 'nullable|string|max:255',

        'os' => 'nullable|string|max:100',
        'os_version' => 'nullable|string|max:100',

        'ip_address' => 'nullable|string|max:45',
        'app_version' => 'nullable|string|max:50',

        'remarks' => 'nullable|string|max:1000',
    ]);

    if ($validator->fails()) {

        Log::warning('Authorized Login Request - Validation Failed', [
            'request_data' => $request->all(),
            'validation_errors' => $validator->errors()->toArray(),
            'first_error' => $validator->errors()->first(),
        ]);

        Log::info('================ AUTHORIZED LOGIN REQUEST END - VALIDATION ERROR ================');

        return response()->json([
            'success' => false,
            'message' => $validator->errors()->first(),
            'errors' => $validator->errors()
        ], 422);
    }

    Log::info('Authorized Login Request - Validation Passed', [
        'cnic' => $request->cnic,
        'phone_no' => $request->phone_no,
        'email' => $request->email ?? 'Not provided',
        'username' => $request->username ?? 'Not provided',
    ]);

    try {

        // =====================================================
        // 3. CHECK EXISTING PENDING REQUEST
        // =====================================================

        Log::info('Checking for existing pending authorization request', [
            'cnic' => $request->cnic,
        ]);

        $existingRequest = DB::table('authorized_login_requests')
            ->where('cnic', $request->cnic)
            ->where('confirmation_status', 'Pending')
            ->first();

        if ($existingRequest) {

            Log::warning('Existing Pending Authorization Request Found', [
                'cnic' => $request->cnic,
                'existing_request' => (array) $existingRequest,
            ]);

            Log::info('================ AUTHORIZED LOGIN REQUEST END - DUPLICATE ================');

            return response()->json([
                'success' => false,
                'message' => 'A pending authorization request already exists for this CNIC.',
                'data' => $existingRequest
            ], 409);
        }

        Log::info('No existing pending authorization request found', [
            'cnic' => $request->cnic,
        ]);

        // =====================================================
        // 4. CHECK IF EMAIL ALREADY EXISTS IN USERS TABLE
        // =====================================================

        if ($request->has('email') && !empty($request->email)) {
            Log::info('Checking if email already exists in users table', [
                'email' => $request->email,
            ]);

            $existingEmailUser = DB::table('users')
                ->where('email', $request->email)
                ->first();

            if ($existingEmailUser && $existingEmailUser->cnic != $request->cnic) {
                Log::warning('Email already exists for another user', [
                    'email' => $request->email,
                    'existing_user_cnic' => $existingEmailUser->cnic,
                    'requested_cnic' => $request->cnic,
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'This email is already registered with another CNIC.',
                ], 409);
            }

            Log::info('Email check passed', [
                'email' => $request->email,
            ]);
        }

        // =====================================================
        // 5. PROCESS USER TABLE (CREATE OR UPDATE)
        // =====================================================

        Log::info('Checking if user exists in users table', [
            'cnic' => $request->cnic,
        ]);

        // Check if user exists by CNIC
        $existingUser = DB::table('users')
            ->where('cnic', $request->cnic)
            ->first();

        $hashedPassword = bcrypt($request->phone_no);
        $userOperation = '';

        // Determine the name to use: username from request, or fallback to CNIC
        $userName = ($request->has('username') && !empty($request->username))
            ? $request->username
            : $request->cnic;

        if ($existingUser) {
            // =====================================================
            // 5a. UPDATE EXISTING USER
            // =====================================================

            Log::info('User found - Updating existing user record', [
                'cnic' => $request->cnic,
                'existing_user_id' => $existingUser->id,
                'existing_user_data' => (array) $existingUser,
            ]);

            $userUpdateData = [
                'cnic' => $request->cnic,
                'phoneno' => $request->phone_no,
                'password' => $hashedPassword,
                'name' => $userName, // Set name from username or CNIC
                'updated_at' => now(),
            ];

            // Only add email if provided in the request
            if ($request->has('email') && !empty($request->email)) {
                $userUpdateData['email'] = $request->email;
            } else {
                // Keep existing email if user already has one, otherwise leave as is
                if (isset($existingUser->email)) {
                    $userUpdateData['email'] = $existingUser->email;
                }
                // If no existing email, we don't set it (leave NULL)
            }

            Log::info('User update data prepared', [
                'user_update_data' => $userUpdateData,
                'fields_to_update' => [
                    'cnic' => $request->cnic,
                    'phoneno' => $request->phone_no,
                    'email' => $userUpdateData['email'] ?? 'not set (NULL)',
                    'name' => $userUpdateData['name'],
                    'password' => 'hashed (not shown for security)',
                ]
            ]);

            // Update user record
            $userUpdated = DB::table('users')
                ->where('cnic', $request->cnic)
                ->update($userUpdateData);

            Log::info('User record updated successfully', [
                'cnic' => $request->cnic,
                'rows_affected' => $userUpdated,
                'updated_fields' => array_keys($userUpdateData),
                'phone_no_updated' => $request->phone_no,
            ]);

            $userOperation = 'updated';
            $userId = $existingUser->id;
        } else {
            // =====================================================
            // 5b. CREATE NEW USER
            // =====================================================

            Log::info('User not found - Creating new user record', [
                'cnic' => $request->cnic,
            ]);

            $userInsertData = [
                'cnic' => $request->cnic,
                'phoneno' => $request->phone_no,
                'password' => $hashedPassword,
                'name' => $userName, // Set name from username or CNIC
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Only add email if provided - no default email generation
            if ($request->has('email') && !empty($request->email)) {
                $userInsertData['email'] = $request->email;
                Log::info('Email provided, saving to users table', [
                    'cnic' => $request->cnic,
                    'email' => $request->email,
                ]);
            } else {
                Log::info('Email not provided, leaving email as NULL in users table', [
                    'cnic' => $request->cnic,
                ]);
            }

            Log::info('New user data prepared for insert', [
                'user_insert_data' => $userInsertData,
                'fields' => [
                    'cnic' => $request->cnic,
                    'phoneno' => $request->phone_no,
                    'email' => $userInsertData['email'] ?? 'NULL (not provided)',
                    'name' => $userInsertData['name'],
                    'password' => 'hashed (not shown for security)',
                ]
            ]);

            // Insert new user
            $userId = DB::table('users')->insertGetId($userInsertData);

            Log::info('New user created successfully', [
                'new_user_id' => $userId,
                'cnic' => $request->cnic,
                'phone_no' => $request->phone_no,
                'email' => $userInsertData['email'] ?? 'NULL',
                'name' => $userInsertData['name'],
            ]);

            $userOperation = 'created';
        }

        Log::info('User table operation completed', [
            'operation' => $userOperation,
            'user_id' => $userId,
            'cnic' => $request->cnic,
            'phone_no' => $request->phone_no,
            'email' => $request->email ?? 'Not provided',
            'name' => $userName,
        ]);

        // =====================================================
        // 6. PREPARE INSERT DATA FOR AUTHORIZED_LOGIN_REQUESTS
        // =====================================================

        $insertData = [
            'cnic' => $request->cnic,
            'phone_no' => $request->phone_no,

            // SAVE USERNAME IF PROVIDED, OTHERWISE USE CNIC
            'user_name' => $userName,

            // AUTOMATICALLY HASH PHONE_NO AND SAVE AS PASSWORD
            'password' => $hashedPassword,

            'device_name' => $request->device_name,
            'device_model' => $request->device_model,
            'device_brand' => $request->device_brand,

            'os' => $request->os,
            'os_version' => $request->os_version,

            'ip_address' => $request->ip_address,
            'app_version' => $request->app_version,

            'request_datetime' => now(),

            'confirmation_status' => 'Pending',

            'remarks' => $request->remarks,

            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Add email to authorized_login_requests ONLY if provided
        if ($request->has('email') && !empty($request->email)) {
            $insertData['email'] = $request->email;
        }

        Log::info('Authorized Login Request - Data Prepared For Insert', [
            'insert_data' => $insertData,
            'auto_filled' => [
                'user_name' => 'Set from username or CNIC: ' . $userName,
                'password' => 'Auto-filled with hashed phone_no',
                'email' => $request->email ?? 'Not provided (NULL)',
            ],
            'linked_user_id' => $userId,
            'user_operation' => $userOperation,
        ]);

        // =====================================================
        // 7. INSERT INTO AUTHORIZED_LOGIN_REQUESTS DATABASE
        // =====================================================

        Log::info('Attempting to insert authorization request into database', [
            'table' => 'authorized_login_requests',
            'linked_user_id' => $userId,
            'email' => $request->email ?? 'Not provided',
        ]);

        $id = DB::table('authorized_login_requests')
            ->insertGetId($insertData);

        Log::info('Authorization request inserted successfully', [
            'inserted_id' => $id,
            'cnic' => $request->cnic,
            'phone_no' => $request->phone_no,
            'email' => $request->email ?? 'Not provided',
            'linked_user_id' => $userId,
            'user_operation' => $userOperation,
        ]);

        // =====================================================
        // 8. FETCH INSERTED RECORD
        // =====================================================

        Log::info('Fetching newly inserted authorization request', [
            'id' => $id,
        ]);

        $data = DB::table('authorized_login_requests')
            ->where('id', $id)
            ->first();

        Log::info('Newly inserted authorization request fetched', [
            'id' => $id,
            'data' => $data ? (array) $data : null,
            'linked_user_id' => $userId,
        ]);

        // =====================================================
        // 9. FETCH USER RECORD FOR RESPONSE
        // =====================================================

        $userData = DB::table('users')
            ->where('id', $userId)
            ->first();

        Log::info('User record fetched for response', [
            'user_id' => $userId,
            'user_data' => $userData ? (array) $userData : null,
            'phone_no_from_db' => $userData->phoneno ?? null,
        ]);

        // =====================================================
        // 10. FINAL SUCCESS LOG
        // =====================================================

        Log::info('Authorized Login Request - SUCCESS', [
            'authorization_request_id' => $id,
            'user_id' => $userId,
            'user_operation' => $userOperation,
            'cnic' => $request->cnic,
            'phone_no' => $request->phone_no,
            'email' => $request->email ?? 'Not provided',
            'user_name' => $userName,
            'password_hashed' => true,
            'confirmation_status' => 'Pending',
            'final_data' => $data ? (array) $data : null,
            'users_table_updated' => true,
            'user_name_in_users' => $userData->name ?? null,
            'user_email_in_users' => $userData->email ?? null,
            'user_phone_in_users' => $userData->phoneno ?? null,
        ]);

        Log::info('================ AUTHORIZED LOGIN REQUEST END - SUCCESS ================');

        // Remove sensitive data from response
        $responseData = $data ? (array) $data : null;
        if ($responseData && isset($responseData['password'])) {
            unset($responseData['password']); // Don't send password hash in response
        }

        // Add user operation info to response
        $responseData['user_operation'] = $userOperation;
        $responseData['user_id'] = $userId;
        $responseData['user_name'] = $userData->name ?? $userName;
        $responseData['user_email'] = $userData->email ?? null;
        $responseData['user_phone'] = $userData->phoneno ?? $request->phone_no;

        return response()->json([
            'success' => true,
            'message' => 'Authorization request submitted successfully. User record ' . $userOperation . '.',
            'data' => $responseData
        ], 201);
    } catch (\Exception $e) {

        // =====================================================
        // 11. COMPLETE EXCEPTION LOG
        // =====================================================

        Log::error('Authorized Login Request - EXCEPTION OCCURRED', [

            'message' => $e->getMessage(),

            'exception_class' => get_class($e),

            'file' => $e->getFile(),

            'line' => $e->getLine(),

            'code' => $e->getCode(),

            'trace' => $e->getTraceAsString(),

            'request_data' => $request->all(),

            'cnic' => $request->cnic ?? null,

            'phone_no' => $request->phone_no ?? null,

            'email' => $request->email ?? null,

            'username' => $request->username ?? null,

            'timestamp' => now()->toDateTimeString(),
        ]);

        Log::info('================ AUTHORIZED LOGIN REQUEST END - EXCEPTION ================');

        return response()->json([
            'success' => false,
            'message' => 'Something went wrong.',
            'error' => $e->getMessage()
        ], 500);
    }
}
public function login(Request $request)
{
    // =========================================================
    // 1. LOG EVERYTHING RECEIVED
    // =========================================================
    Log::info('================ LOGIN REQUEST START ================');

    Log::info('Login Request - Incoming Request', [
        'all_data'   => $request->all(),
        'ip'         => $request->ip(),
        'method'     => $request->method(),
        'url'        => $request->fullUrl(),
        'user_agent' => $request->userAgent(),
        'timestamp'  => now()->toDateTimeString(),
    ]);

    // =========================================================
    // 2. VALIDATION
    // =========================================================
    $validator = Validator::make($request->all(), [
        'user_name' => 'required|string',  // CNIC
        'password'  => 'required|string',
    ]);

    if ($validator->fails()) {
        Log::warning('Login Request - Validation Failed', [
            'validation_errors' => $validator->errors()->toArray(),
        ]);

        return response()->json([
            'success' => false,
            'message' => $validator->errors()->first(),
        ], 422);
    }

    try {
        $cnic = $request->user_name;

        // =====================================================
        // 3. CHECK APPROVED USER IN AUTHORIZED_LOGIN_REQUESTS
        // =====================================================
        $authorizedUser = DB::table('authorized_login_requests')
            ->where('cnic', $cnic)
            ->orderByDesc('id')
            ->first();

        if (! $authorizedUser) {
            Log::warning('User not found in authorized_login_requests', ['cnic' => $cnic]);

            return response()->json([
                'success' => false,
                'message' => 'User not authorized. Please contact admin for registration.',
            ], 403);
        }

        if ($authorizedUser->confirmation_status !== 'Approved') {
            $status  = $authorizedUser->confirmation_status;
            $message = $status === 'Pending'
                ? 'Your account is pending admin approval. Please wait for confirmation.'
                : 'Your account has been rejected. Please contact admin for assistance.';

            return response()->json([
                'success' => false,
                'message' => $message,
                'status'  => $status,
            ], 403);
        }

        // =====================================================
        // 4. FIND USER IN USERS TABLE BY CNIC
        // =====================================================
        $user = DB::table('users')->where('cnic', $cnic)->first();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'User account not set up. Please contact admin.',
            ], 404);
        }

        // =====================================================
        // 5. VERIFY PASSWORD
        // =====================================================
        $passwordMatches = Hash::check($request->password, $user->password);

        if (! $passwordMatches) {
            Log::warning('Password verification failed', [
                'cnic'    => $cnic,
                'user_id' => $user->id,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Invalid CNIC or password',
            ], 401);
        }

        // =====================================================
        // 6. FETCH CURRENT_OWNERS + JOINED PROPERTIES
        //    (replaces the old inheritances lookup)
        // =====================================================

        // 6a. All owner rows for this CNIC
        $owners = DB::table('current_owners')
            ->where('cnic', $user->cnic)
            ->orderBy('id')
            ->get();

        // 6b. Fetch all related properties in one shot
        $propertyIds = $owners->pluck('property_id')
            ->filter()
            ->unique()
            ->values()
            ->all();

        $propertiesById = collect();
        if (! empty($propertyIds)) {
            $propertiesById = DB::table('properties')
                ->whereIn('id', $propertyIds)
                ->get()
                ->keyBy('id');
        }

        // 6c. Build grouped owner + properties payload
        $ownersPayload = $owners->map(function ($owner) use ($propertiesById) {
            $property = $owner->property_id
                ? $propertiesById->get($owner->property_id)
                : null;

            $propertyPayload = null;
            if ($property) {
                $propertyPayload = [
                    'id'               => $property->id,
                    'application_no'   => $property->application_no ?? null,
                    'application_date' => $property->application_date ?? null,
                    'plot_no'          => $property->plot_no ?? null,
                    'form_no'          => $property->form_no ?? null,
                    'sector_id'        => $property->sector_id ?? null,
                    'block_id'         => $property->block_id ?? null,
                    'kanal'            => $property->kanal ?? null,
                    'marla'            => $property->marla ?? null,
                    'sqrft'            => $property->sqrft ?? null,
                    'size'             => $property->size ?? null,
                    'category'         => $property->category ?? null,
                    'ownership_type'   => $property->ownership_type ?? null,
                    'allotment_type'   => $property->allotment_type ?? null,
                    'mode_allottment'  => $property->mode_allottment ?? null,
                    'allotment_date'   => $property->allotment_date ?? null,
                    'transfer_count'   => $property->transfer_count ?? null,
                    'remarks'          => $property->remarks ?? null,
                    'approved_scheme'  => $property->approved_scheme ?? null,
                ];
            }

            return [
                'id'                => $owner->id,
                'property_id'       => $owner->property_id,
                'name'              => $owner->applicant_name,
                'father_name'       => $owner->father_husband_name,
                'cnic'              => $owner->cnic,
                'old_nic'           => $owner->old_nic,
                'address'           => $owner->address_permanent ?: $owner->address_temporary,
                'address_permanent' => $owner->address_permanent,
                'address_temporary' => $owner->address_temporary,
                'is_current'        => true,
                'created_at'        => $owner->created_at,
                'property'          => $propertyPayload,
            ];
        })->values();

        // Group by CNIC so frontend gets one owner + N properties
        $ownersGrouped = $ownersPayload
            ->groupBy('cnic')
            ->map(function ($group) {
                $first = $group->first();

                return [
                    'id'                => $first['id'],
                    'name'              => $first['name'],
                    'father_name'       => $first['father_name'],
                    'cnic'              => $first['cnic'],
                    'old_nic'           => $first['old_nic'],
                    'address'           => $first['address'],
                    'address_permanent' => $first['address_permanent'],
                    'address_temporary' => $first['address_temporary'],
                    'is_current'        => $first['is_current'],
                    'created_at'        => $first['created_at'],
                    'properties'        => $group->pluck('property')->filter()->values()->all(),
                    'property_ids'      => $group->pluck('property_id')->filter()->values()->all(),
                ];
            })
            ->values();

        // Primary owner = first grouped entry
        $primaryOwner = $ownersGrouped->first();

        // Flat list of all properties across all owner rows (for convenience)
        $allProperties = $ownersPayload->pluck('property')->filter()->values()->all();

        // =====================================================
        // 7. GET AUTHORIZED LOGIN REQUEST DATA
        // =====================================================
        $authRequest = DB::table('authorized_login_requests')
            ->where('cnic', $user->cnic)
            ->where('confirmation_status', 'Approved')
            ->orderByDesc('id')
            ->first();

        // =====================================================
        // 8. PREPARE RESPONSE
        // =====================================================
        $responseData = [
            'success' => true,
            'message' => 'Login successful',
            'user'    => [
                'id'                  => $user->id,
                'name'                => $user->name,
                'email'               => $user->email,
                'cnic'                => $user->cnic,
                'phone_no'            => $user->phoneno ?? null,
                'profile_pic'         => $user->profile_pic ?? null,
                'confirmation_status' => $authorizedUser->confirmation_status,
                'device_name'         => $authRequest->device_name  ?? $authorizedUser->device_name  ?? null,
                'device_model'        => $authRequest->device_model ?? $authorizedUser->device_model ?? null,
                'device_brand'        => $authRequest->device_brand ?? $authorizedUser->device_brand ?? null,
                'os'                  => $authRequest->os           ?? $authorizedUser->os           ?? null,
                'os_version'          => $authRequest->os_version   ?? $authorizedUser->os_version   ?? null,
                'app_version'         => $authRequest->app_version  ?? $authorizedUser->app_version  ?? null,
            ],
            'authorized_data' => [
                'id'                  => $authorizedUser->id,
                'confirmation_status' => $authorizedUser->confirmation_status,
                'confirmed_at'        => $authorizedUser->confirmed_at ?? null,
                'phone_no'            => $authorizedUser->phone_no ?? null,
                'email'               => $authorizedUser->email ?? null,
                'forced_password'     => $authorizedUser->forced_password ?? null,
            ],
            // 👇 NEW: current_owners replaces inheritance
            'current_owner'  => $primaryOwner,   // one grouped owner (with .properties)
            'current_owners' => $ownersPayload,  // flat list for backward compat
            'properties'     => $allProperties,  // flat property list
        ];

        Log::info('Login successful - Response prepared', [
            'cnic'              => $cnic,
            'user_id'           => $user->id,
            'owners_count'      => $ownersPayload->count(),
            'properties_count'  => count($allProperties),
            'forced_password'   => $authorizedUser->forced_password ?? null,
        ]);

        return response()->json($responseData, 200);

    } catch (\Throwable $e) {
        Log::error('Login Request - EXCEPTION', [
            'message'   => $e->getMessage(),
            'file'      => $e->getFile(),
            'line'      => $e->getLine(),
            'trace'     => $e->getTraceAsString(),
            'cnic'      => $request->user_name ?? null,
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Something went wrong. Please try again.',
        ], 500);
    }
}
    public function addProfilePicture(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'cnic' => 'required|string|max:20',
                'profile_pic' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Check whether CNIC exists
            $record = DB::table('authorized_login_requests')
                ->where('cnic', $request->cnic)
                ->first();

            if (!$record) {
                return response()->json([
                    'success' => false,
                    'message' => 'No authorized login request found for this CNIC.'
                ], 404);
            }

            // Upload profile picture
            $file = $request->file('profile_pic');

            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            $file->move(
                public_path('profile_pictures'),
                $fileName
            );

            // Store path in database
            $profilePicPath = 'profile_pictures/' . $fileName;

            DB::table('authorized_login_requests')
                ->where('cnic', $request->cnic)
                ->update([
                    'profile_pic' => $profilePicPath,
                    'updated_at' => now()
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Profile picture uploaded successfully.',
                'data' => [
                    'cnic' => $request->cnic,
                    'profile_pic' => $profilePicPath,
                    'profile_pic_url' => asset($profilePicPath)
                ]
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while uploading profile picture.',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    public function getPropertiesByCnic(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'cnic' => 'required|string|max:20',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors'  => $validator->errors(),
                ], 422);
            }

            $cleanCnic = preg_replace('/[^0-9]/', '', $request->cnic);

            // =========================================================
            // 1. current_owners rows for this CNIC
            // =========================================================
            $ownerRows = DB::table('current_owners')
                ->where('cnic', $cleanCnic)
                ->get();

            if ($ownerRows->isEmpty()) {
                $ownerRows = DB::table('current_owners')
                    ->where('old_nic', $cleanCnic)
                    ->get();
            }

            if ($ownerRows->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No records found for this CNIC.',
                    'data'    => [],
                ], 404);
            }

            // =========================================================
            // 2. Fetch properties by their IDs
            // =========================================================
            $propertyIds = $ownerRows->pluck('property_id')
                ->filter()
                ->unique()
                ->values()
                ->all();

            if (empty($propertyIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No property_id found for this CNIC.',
                    'data'    => [],
                ], 404);
            }

            $properties = DB::table('properties')
                ->whereIn('id', $propertyIds)
                ->get()
                ->keyBy('id');

            if ($properties->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No matching properties found.',
                    'data'    => [],
                ], 404);
            }

            // =========================================================
            // 3. Co-owners for these properties
            // =========================================================
            $allOwnersByProperty = DB::table('current_owners')
                ->whereIn('property_id', $propertyIds)
                ->get()
                ->groupBy('property_id');

            // =========================================================
            // 4. Fetch attachments for all properties in ONE query
            // =========================================================
            $attachmentsByProperty = collect();
            if (Schema::hasTable('attchements')) {
                $attachmentsByProperty = DB::table('attchements')
                    ->whereIn('property_id', $propertyIds)
                    ->get()
                    ->groupBy('property_id');
            }

            // =========================================================
            // 5. Build enriched payload
            // =========================================================
            $enrichedProperties = $ownerRows
                ->map(function ($ownerRow) use (
                    $properties,
                    $allOwnersByProperty,
                    $attachmentsByProperty
                ) {
                    $property = $ownerRow->property_id
                        ? $properties->get($ownerRow->property_id)
                        : null;

                    if (! $property) {
                        return null;
                    }

                    // ---------- Documents ----------
                    $documents = [];

                    // 5a. Try property_documents table first
                    if (Schema::hasTable('property_documents')) {
                        try {
                            $propertyDocs = DB::table('property_documents')
                                ->where('property_id', $property->id)
                                ->select('document_type', 'file_path')
                                ->get();

                            foreach ($propertyDocs as $doc) {
                                if (! empty($doc->file_path)) {
                                    $documents[] = [
                                        'document_type' => $doc->document_type,
                                        'file_path'     => $doc->file_path,
                                        'source'        => 'property_documents',
                                    ];
                                }
                            }
                        } catch (\Throwable $e) {
                            Log::warning('property_documents lookup failed', [
                                'property_id' => $property->id,
                                'error'       => $e->getMessage(),
                            ]);
                        }
                    }

                    // 5b. Attachments from `attchements` table — map each
                    //     non-null file column to its human label
                    $attachments = $attachmentsByProperty->get($property->id, collect());

                    // Column → display label map
                    $fileColumns = [
                        'property_document'        => 'Property Document',
                        'noting_file'              => 'Noting File',
                        'cnic_front'               => 'CNIC Front',
                        'complete_file'            => 'Complete File',
                        'transfer_order'           => 'Transfer Order',
                        'alternate_allotment'      => 'Alternate Allotment',
                        'adjacent_area_allotment'  => 'Adjacent Area Allotment',
                        'allotment_order'          => 'Allotment Order',
                        'decision_courts'          => 'Decision (Courts)',
                        'decision_allotment_committee' => 'Decision (Allotment Committee)',
                        'decision_mda_board'       => 'Decision (MDA Board)',
                        'decision_revising_authority' => 'Decision (Revising Authority)',
                    ];

                    foreach ($attachments as $row) {
                        foreach ($fileColumns as $column => $label) {
                            if (! empty($row->{$column})) {
                                $documents[] = [
                                    'document_type' => $column,
                                    'display_name'  => $label,
                                    'file_path'     => $row->{$column},
                                    'source'        => 'attchements',
                                    'attachment_id' => $row->id,
                                ];
                            }
                        }
                    }

                    // ---------- Co-owners ----------
                    $ownersForThisProperty = $allOwnersByProperty
                        ->get($property->id, collect())
                        ->map(function ($o) {
                            return [
                                'cnic'             => (string) $o->cnic,
                                'name'             => $o->applicant_name,
                                'father_name'      => $o->father_husband_name,
                                'share_percentage' => null,
                                'old_nic'          => $o->old_nic,
                                'owner_row_id'     => $o->id,
                            ];
                        })
                        ->values()
                        ->all();

                    return [
                        'property'      => $property,
                        'documents'     => $documents,
                        'owners'        => $ownersForThisProperty,
                        'current_owner' => [
                            'id'          => $ownerRow->id,
                            'name'        => $ownerRow->applicant_name,
                            'father_name' => $ownerRow->father_husband_name,
                            'cnic'        => $ownerRow->cnic,
                            'old_nic'     => $ownerRow->old_nic,
                            'address'     => $ownerRow->address_permanent
                                ?: $ownerRow->address_temporary,
                        ],
                    ];
                })
                ->filter()
                ->values();

            return response()->json([
                'success'       => true,
                'message'       => 'Property details fetched successfully.',
                'cnic'          => (string) $cleanCnic,
                'total_records' => (string) $enrichedProperties->count(),
                'data'          => $enrichedProperties,
            ], 200);

        } catch (\Throwable $e) {
            Log::error('getPropertiesByCnic EXCEPTION', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'error'   => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }


  public function resetPassword(Request $request)
    {
        // =========================================================
        // 1. LOG REQUEST START
        // =========================================================

        Log::info('================ RESET PASSWORD REQUEST START ================');

        Log::info('Reset Password - Incoming Request', [
            'all_data' => $request->all(),
            'headers' => $request->headers->all(),
            'ip' => $request->ip(),
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'user_agent' => $request->userAgent(),
            'timestamp' => now()->toDateTimeString(),
        ]);

        try {
            // =========================================================
            // 2. VALIDATION
            // =========================================================

            Log::info('Reset Password - Starting validation');

            $validator = Validator::make($request->all(), [
                'cnic' => 'required|string|max:20',
                'phone_no' => 'required|string|max:11',
                'new_password' => 'required|string|min:6|max:255'
            ]);

            if ($validator->fails()) {
                Log::warning('Reset Password - Validation Failed', [
                    'request_data' => $request->all(),
                    'validation_errors' => $validator->errors()->toArray(),
                    'first_error' => $validator->errors()->first(),
                    'timestamp' => now()->toDateTimeString(),
                ]);

                Log::info('================ RESET PASSWORD REQUEST END - VALIDATION ERROR ================');

                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first(),
                    'errors' => $validator->errors()
                ], 422);
            }

            Log::info('Reset Password - Validation Passed', [
                'cnic' => $request->cnic,
                'phone_no' => $request->phone_no,
                'new_password_length' => strlen($request->new_password),
                'timestamp' => now()->toDateTimeString(),
            ]);

            // =========================================================
            // 3. CHECK AUTHORIZED LOGIN ACCESS
            // =========================================================

            Log::info('Reset Password - Checking authorized login access', [
                'cnic' => $request->cnic,
                'phone_no' => $request->phone_no,
            ]);

            // First check if user has approved login access
            $loginRequest = DB::table('authorized_login_requests')
                ->where('cnic', $request->cnic)
                ->where('confirmation_status', 'Approved')
                ->first();

            Log::info('Reset Password - Authorized login request search result', [
                'cnic' => $request->cnic,
                'found' => $loginRequest ? true : false,
                'login_request_data' => $loginRequest ? (array) $loginRequest : null,
                'confirmation_status' => $loginRequest->confirmation_status ?? null,
            ]);

            if (!$loginRequest) {
                Log::warning('Reset Password - User not authorized', [
                    'cnic' => $request->cnic,
                    'phone_no' => $request->phone_no,
                    'reason' => 'No approved login request found',
                    'timestamp' => now()->toDateTimeString(),
                ]);

                Log::info('================ RESET PASSWORD REQUEST END - NOT AUTHORIZED ================');

                return response()->json([
                    'success' => false,
                    'message' => 'You do not have authorized login access. Please contact admin.'
                ], 403);
            }

            Log::info('Reset Password - User has authorized login access', [
                'cnic' => $request->cnic,
                'login_request_id' => $loginRequest->id,
                'confirmation_status' => $loginRequest->confirmation_status,
                'approved_at' => $loginRequest->updated_at ?? null,
            ]);

            // =========================================================
            // 4. CHECK USER IN USERS TABLE
            // =========================================================

            Log::info('Reset Password - Searching for user in users table', [
                'cnic' => $request->cnic,
                'phone_no' => $request->phone_no,
            ]);

            // Check if user exists in users table
            $user = DB::table('users')
                ->where('cnic', $request->cnic)
                ->first();

            Log::info('Reset Password - User search result from users table', [
                'cnic' => $request->cnic,
                'found' => $user ? true : false,
                'user_data' => $user ? (array) $user : null,
                'user_id' => $user->id ?? null,
                'user_name' => $user->name ?? null,
                'user_email' => $user->email ?? null,
                'user_phone' => $user->phoneno ?? null,
                'has_password' => $user->password ? true : false,
            ]);

            if (!$user) {
                Log::warning('Reset Password - User not found in users table', [
                    'cnic' => $request->cnic,
                    'phone_no' => $request->phone_no,
                    'login_request_id' => $loginRequest->id,
                    'timestamp' => now()->toDateTimeString(),
                ]);

                Log::info('================ RESET PASSWORD REQUEST END - USER NOT FOUND ================');

                return response()->json([
                    'success' => false,
                    'message' => 'User account not found in system. Please contact admin.'
                ], 404);
            }

            Log::info('Reset Password - User found in users table', [
                'cnic' => $request->cnic,
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'phone_no_in_db' => $user->phoneno ?? null,
            ]);

            // =========================================================
            // 5. VERIFY PHONE NUMBER (Enhanced Security Check)
            // =========================================================

            Log::info('Reset Password - Verifying phone number', [
                'cnic' => $request->cnic,
                'provided_phone' => $request->phone_no,
                'stored_phone' => $user->phoneno ?? null,
            ]);

            // Check if phone number matches
            if ($user->phoneno && $user->phoneno !== $request->phone_no) {
                Log::warning('Reset Password - Phone number mismatch', [
                    'cnic' => $request->cnic,
                    'provided_phone' => $request->phone_no,
                    'stored_phone' => $user->phoneno,
                    'user_id' => $user->id,
                    'timestamp' => now()->toDateTimeString(),
                ]);

                Log::info('================ RESET PASSWORD REQUEST END - PHONE MISMATCH ================');

                return response()->json([
                    'success' => false,
                    'message' => 'Phone number does not match our records. Please use the registered phone number.'
                ], 400);
            }

            Log::info('Reset Password - Phone number verified successfully', [
                'cnic' => $request->cnic,
                'phone_no' => $request->phone_no,
                'user_id' => $user->id,
            ]);

            // =========================================================
            // 6. CHECK IF NEW PASSWORD IS SAME AS OLD PASSWORD
            // =========================================================

            Log::info('Reset Password - Checking if new password is different from old password', [
                'cnic' => $request->cnic,
                'user_id' => $user->id,
            ]);

            // Check if new password is same as old password
            if (Hash::check($request->new_password, $user->password)) {
                Log::warning('Reset Password - New password is same as old password', [
                    'cnic' => $request->cnic,
                    'user_id' => $user->id,
                    'timestamp' => now()->toDateTimeString(),
                ]);

                Log::info('================ RESET PASSWORD REQUEST END - SAME PASSWORD ================');

                return response()->json([
                    'success' => false,
                    'message' => 'New password cannot be the same as the old password.'
                ], 400);
            }

            Log::info('Reset Password - New password is different from old password', [
                'cnic' => $request->cnic,
                'user_id' => $user->id,
            ]);

            // =========================================================
            // 7. UPDATE PASSWORD IN USERS TABLE
            // =========================================================

            Log::info('Reset Password - Updating password in users table', [
                'cnic' => $request->cnic,
                'user_id' => $user->id,
                'user_name' => $user->name,
                'new_password_length' => strlen($request->new_password),
                'old_password_hash' => $user->password ? 'present' : 'null',
                'timestamp' => now()->toDateTimeString(),
            ]);

            // Hash the new password
            $hashedPassword = Hash::make($request->new_password);

            Log::info('Reset Password - New password hashed successfully', [
                'cnic' => $request->cnic,
                'user_id' => $user->id,
                'hashed_password_length' => strlen($hashedPassword),
                'hash_type' => 'bcrypt',
            ]);

            // Update password in users table
            $updated = DB::table('users')
                ->where('cnic', $request->cnic)
                ->update([
                    'password' => $hashedPassword,
                    'updated_at' => now()
                ]);

            Log::info('Reset Password - Users table update result', [
                'cnic' => $request->cnic,
                'user_id' => $user->id,
                'rows_affected' => $updated,
                'updated_fields' => ['password', 'updated_at'],
                'update_success' => $updated > 0,
            ]);

            if (!$updated) {
                Log::error('Reset Password - Failed to update password in users table', [
                    'cnic' => $request->cnic,
                    'user_id' => $user->id,
                    'rows_affected' => $updated,
                    'timestamp' => now()->toDateTimeString(),
                ]);

                Log::info('================ RESET PASSWORD REQUEST END - UPDATE FAILED ================');

                return response()->json([
                    'success' => false,
                    'message' => 'Failed to reset password. Please try again.'
                ], 500);
            }

            // =========================================================
            // 8. UPDATE PASSWORD IN AUTHORIZED_LOGIN_REQUESTS TABLE
            // =========================================================

            Log::info('Reset Password - Updating password in authorized_login_requests table', [
                'cnic' => $request->cnic,
                'login_request_id' => $loginRequest->id,
                'user_id' => $user->id,
            ]);

            // Prepare update data for authorized_login_requests
            $updateData = [
                'password' => $hashedPassword,
                'updated_at' => now()
            ];

            // Set forced_password to 1 if it's not already 1
            if ($loginRequest->forced_password != 1) {
                $updateData['forced_password'] = 1;
                Log::info('Reset Password - Setting forced_password to 1', [
                    'cnic' => $request->cnic,
                    'login_request_id' => $loginRequest->id,
                    'current_forced_password' => $loginRequest->forced_password ?? null,
                ]);
            } else {
                Log::info('Reset Password - forced_password already 1, no update needed', [
                    'cnic' => $request->cnic,
                    'login_request_id' => $loginRequest->id,
                ]);
            }

            // Update password in authorized_login_requests table to keep in sync
            $updatedAuth = DB::table('authorized_login_requests')
                ->where('cnic', $request->cnic)
                ->where('confirmation_status', 'Approved')
                ->update($updateData);

            Log::info('Reset Password - Authorized_login_requests table update result', [
                'cnic' => $request->cnic,
                'login_request_id' => $loginRequest->id,
                'rows_affected' => $updatedAuth,
                'update_success' => $updatedAuth > 0,
                'forced_password_set' => $loginRequest->forced_password != 1,
                'forced_password_current_value' => $loginRequest->forced_password ?? null,
            ]);

            // =========================================================
            // 9. LOG SUCCESS AND RETURN RESPONSE
            // =========================================================

            Log::info('Reset Password - Successful', [
                'cnic' => $request->cnic,
                'phone_no' => $request->phone_no,
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'login_request_id' => $loginRequest->id,
                'password_updated' => true,
                'users_table_updated' => $updated > 0,
                'auth_table_updated' => $updatedAuth > 0,
                'forced_password_status' => $loginRequest->forced_password != 1 ? 'set_to_1' : 'already_1',
                'timestamp' => now()->toDateTimeString(),
            ]);

            Log::info('================ RESET PASSWORD REQUEST END - SUCCESS ================');

            return response()->json([
                'success' => true,
                'message' => 'Password reset successfully. Please login with your new password.',
                'data' => [
                    'user_id' => $user->id,
                    'cnic' => $request->cnic,
                    'phone_no' => $request->phone_no,
                ]
            ], 200);
        } catch (\Exception $e) {
            // =========================================================
            // 10. COMPLETE EXCEPTION LOG
            // =========================================================

            Log::error('Reset Password - EXCEPTION OCCURRED', [
                'message' => $e->getMessage(),
                'exception_class' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'code' => $e->getCode(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all(),
                'cnic' => $request->cnic ?? null,
                'phone_no' => $request->phone_no ?? null,
                'new_password_length' => isset($request->new_password) ? strlen($request->new_password) : null,
                'timestamp' => now()->toDateTimeString(),
            ]);

            Log::info('================ RESET PASSWORD REQUEST END - EXCEPTION ================');

            return response()->json([
                'success' => false,
                'message' => 'Failed to reset password. Please try again later.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function getUserDetails(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'cnic' => 'required|string|max:20',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first()
                ], 422);
            }

            // Get user from inheritances table
            $user = DB::table('inheritances')
                ->where('cnic', $request->cnic)
                ->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            // Get authorized login request status
            $loginRequest = DB::table('authorized_login_requests')
                ->where('cnic', $request->cnic)
                ->where('confirmation_status', 'Approved')
                ->first();

            return response()->json([
                'success' => true,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'father_name' => $user->father_name,
                    'cnic' => $user->cnic,
                    'phone_no' => $loginRequest ? $loginRequest->phone_no : null,
                    'address' => $user->address,
                    'area' => $user->area,
                    'is_current' => $user->is_current,
                    'confirmation_status' => $loginRequest ? 'Approved' : null
                ]
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error in getUserDetails', [
                'message' => $e->getMessage(),
                'cnic' => $request->cnic ?? null
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }


    public function updateUserEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cnic' => 'required|string',
            'email' => 'required|email|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            // Check if login request exists for this CNIC
            $loginRequest = DB::table('authorized_login_requests')
                ->where('cnic', $request->cnic)
                ->first();

            if (!$loginRequest) {
                return response()->json([
                    'success' => false,
                    'message' => 'No login request found for this CNIC'
                ], 404);
            }

            // Check if request is approved
            if ($loginRequest->confirmation_status !== 'Approved') {
                return response()->json([
                    'success' => false,
                    'message' => 'Login request is not approved yet'
                ], 403);
            }

            // Update email in authorized_login_requests table
            $updated = DB::table('authorized_login_requests')
                ->where('cnic', $request->cnic)
                ->update([
                    'email' => $request->email,
                    'updated_at' => now()
                ]);

            if ($updated) {
                return response()->json([
                    'success' => true,
                    'message' => 'Email updated successfully',
                    'data' => [
                        'cnic' => $request->cnic,
                        'email' => $request->email
                    ]
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update email'
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

public function getTownById($id)
{
    try {
        $town = DB::table('towns')->where('id', $id)->first();

        if (!$town) {
            return response()->json([
                'success' => false,
                'message' => 'Town not found.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Town fetched successfully.',
            'data' => $town
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Something went wrong while fetching town.',
            'error' => $e->getMessage()
        ], 500);
    }
}

}
