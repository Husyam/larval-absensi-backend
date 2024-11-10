<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{

    public function login(Request $request) {
        $loginData = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Mencari pengguna berdasarkan email
        $user = User::where('email', $loginData['email'])->first();

        // Memeriksa apakah pengguna ada
        if (!$user) {
            return response(['message' => 'Invalid credentials'], 401);
        }

        // Memeriksa apakah password cocok
        if (!Hash::check($loginData['password'], $user->password)) {
            return response(['message' => 'Invalid credentials'], 401);
        }

        // Membuat token untuk pengguna
        $token = $user->createToken('auth_token')->plainTextToken;

        // Mengambil roles pengguna
        $roles = $user->getRoleNames();

        // Mengembalikan respons hanya dengan roles
        return response([
            'user' => $user,
            'token' => $token,
            'roles' => $roles,
        ], 200);
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();

        return response(['message' => 'Logout success'], 200);
    }

    //update image profile & face_embedding
    public function updateProfile(Request $request, User $user)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'face_embedding' => 'required',
        ]);

        $user = $request->user();
        $roles = $user->getRoleNames();
        $image = $request->file('image');
        $face_embedding = $request->face_embedding;

        //save image
        $image->storeAs('public/images', $image->hashName());
        $user->image_url = $image->hashName();
        $user->face_embedding = $face_embedding;
        $user->save();

        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    //get user
    public function getUser (Request $request)
    {
        $user = $request->user();
        $roles = $user->getRoleNames(); // Mendapatkan nama-nama role


        // $user->roles = $roles; get item name from roles
        $user->roles = $roles;


        return response()->json([
            'user' => $user,
        ]);
    }
}
