<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //get all users 
    public function index()
    {
        try {
            $users = User::select('id', 'username', 'email')->get();
            return response()->json($users, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error fetching users'], 500);
        }
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|string|max:255|unique:users',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);

            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Revoke any existing tokens that might exist
            $user->tokens()->delete();

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'User registered successfully',
                'user' => $user->only(['id', 'username', 'email']),
                'token' => $token
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Registration failed'
            ], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string|email',
                'username' => 'required|string',
                'password' => 'required|string'
            ]);

            $user = User::where('email', $request->email)
                ->where('username', $request->username)
                ->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'message' => 'Invalid credentials'
                ], 401);
            }

            // Revoke any existing tokens
            $user->tokens()->delete();

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'user' => $user->only(['id', 'username', 'email']),
                'token' => $token
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Login failed'
            ], 500);
        }
    }

    public function me(Request $request)
    {
        try {
            if (!Auth::check()) {
                return response()->json([
                    'message' => 'Unauthenticated'
                ], 401);
            }

            $user = $request->user();
            return response()->json([
                'user' => $user->only(['id', 'username', 'email'])
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch user data'
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            // Check if user is updating their own profile
            if ($request->user()->id != $id) {
                return response()->json([
                    'message' => 'Unauthorized to update this profile'
                ], 403);
            }

            $data = $request->validate([
                'username' => 'sometimes|string|max:255|unique:users,username,' . $user->id,
                'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
                'password' => 'sometimes|string|min:8',
            ]);

            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }

            // Revoke all tokens before update
            $user->tokens()->delete();

            $user->update($data);

            // Create new token
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Profile updated successfully',
                'user' => $user->only(['id', 'username', 'email']),
                'token' => $token
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Update failed'
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            // Revoke all tokens
            $request->user()->tokens()->delete();

            return response()->json([
                'message' => 'Successfully logged out'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Logout failed'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);

            // Check if user is deleting their own profile
            if (auth()->user()->id != $id) {
                return response()->json([
                    'message' => 'Unauthorized to delete this account'
                ], 403);
            }

            // Delete all tokens before deleting user
            $user->tokens()->delete();
            $user->delete();

            return response()->json([
                'message' => 'Account deleted successfully'
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Delete failed'
            ], 500);
        }
    }
}
