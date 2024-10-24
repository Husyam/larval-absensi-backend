<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view users', only: ['index']),
            new Middleware('permission:edit users', only: ['edit']),
            new Middleware('permission:create users', only: ['create']),
            new Middleware('permission:delete users', only: ['destroy']),
        ];
    }

    public function index (Request $request) {

        // $users = DB::table('users')
        //     ->when(request('search'), function($query) {
        //         $query->where('name', 'like', '%'.request('search').'%')
        //             ->orWhere('email', 'like', '%'.request('search').'%');
        //     })->paginate(10);

        // return view('pages.users.index', compact('users'));

            // Ambil query pencarian dari request
        $search = $request->input('search');

        // Query untuk mendapatkan pengguna dengan pagination
        $users = User::when($search, function($query) use ($search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->latest()->paginate(10);

        // Kembalikan view dengan data pengguna
        return view('pages.users.index', [
            'users' => $users,
            'search' => $search, // Kirim juga query pencarian ke view
        ]);
    }

    public function create () {
        //$permissions = Permission::orderBy('name', 'ASC')->get();
        $roles = Role::orderBy('name', 'ASC')->get();
        return view('pages.users.create', [
            'roles' => $roles,
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'role' => 'required|array', // Pastikan role adalah array
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->position = $request->position;
        $user->department = $request->department;
        $user->password = Hash::make($request->password);
        $user->save();

        // Sync roles
        $user->syncRoles($request->role);

        return redirect()->route('users.index')->with('success', 'User  created successfully');
    }

    public function edit(User $user)
    {
        $roles = Role::orderBy('name', 'ASC')->get();
        $hasRoles = $user->roles->pluck('id');
        return view('pages.users.edit', [
            'user' => $user,
            'roles' => $roles,
            'hasRoles' => $hasRoles,
        ]);
    }


    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:users,name,'.$id,
            'email' => 'required|email|unique:users,email,'.$id,
        ]);

        if ($validator->fails()) {
            return redirect()->route('users.edit', $id)->withInput()->withErrors($validator);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        // Sync roles
        $user->syncRoles($request->role);

        return redirect()->route('users.index')->with('success', 'User  updated successfully');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User  deleted successfully');
    }

}


// $request->validate([
        //     'name' => 'required',
        //     'email' => 'required|email',
        // ]);

        // $user->update([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'phone' => $request->phone,
        //     'role' => $request->role,
        //     'position' => $request->position,
        //     'department' => $request->department,
        // ]);

        // //if password filled
        // if ($request->password) {
        //     $user->update([
        //         'password' => Hash::make($request->password),
        //     ]);
        // }

        // return redirect()->route('users.index')->with('success', 'User updated successfully');
