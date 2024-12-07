<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Returns a paginated list of users, with optional search and sorting.
     */
    public function index(Request $request): JsonResponse
    {
        $query = User::query();
        
        // Search by name
        if ($request->has('search') && !empty($request->search)) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        // Sort by name
        if ($request->has('sort') && in_array($request->sort, ['asc', 'desc'])) {
            $query->orderBy('name', $request->sort);
        }
        
        $users = $query->paginate(10);
        
        return response()->json($users, 200);
    }
    
    /**
     * Returns a single user by ID.
     */
    public function show($id): JsonResponse
    {
        // findOrFail will throw ModelNotFoundException if user doesn't exist
        $user = User::findOrFail($id);
        return response()->json($user, 200);
    }
    
    /**
     * Creates a new user.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'ip' => 'nullable|ip',
            'comment' => 'nullable|string'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        $data = $validator->validated();
        $data['password'] = bcrypt($data['password']);
        
        $user = User::create($data);
        
        return response()->json($user, 201);
    }
    
    /**
     * Updates an existing user by ID.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $user = User::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $id,
            'password' => 'sometimes|string|min:6',
            'ip' => 'sometimes|ip',
            'comment' => 'sometimes|string'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        $data = $validator->validated();
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }
        
        $user->update($data);
        
        return response()->json($user, 200);
    }
    
    /**
     * Deletes a user by ID.
     */
    public function destroy($id): JsonResponse
    {
        $user = User::findOrFail($id);
        $user->delete();
        
        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}
