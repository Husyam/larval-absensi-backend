<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view roles', only: ['index']),
            new Middleware('permission:edit roles', only: ['edit']),
            new Middleware('permission:create roles', only: ['create']),
            new Middleware('permission:delete roles', only: ['destroy']),
        ];
    }

    public function index()
    {
        $roles = Role::orderBy('name', 'ASC')->paginate(10);
        return view('pages.roles.index', ['roles' => $roles]);
    }

    public function create()
    {
        $permissions = Permission::orderBy('name', 'ASC')->get();
        return view('pages.roles.create',
            ['permissions' => $permissions
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles|min:3',
        ]);

        if ($validator->passes()) {
            // dd($request->permission);
            $role = Role::create(['name' => $request->name]);

            if (!empty($request->permission)) {
               foreach ($request->permission as $name) {
                   $role->givePermissionTo($name);
               }
            }

            return redirect()->route('roles.index')->with('success', 'Roles created successfully');
        } else {
            return redirect()->route('roles.create')->withInput()->withErrors($validator);
        }
    }

    //edit
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $hasPermission = $role->permissions->pluck('name');
        $permissions = Permission::orderBy('name', 'ASC')->get();
        // dd($hasPermission);
        return view('pages.roles.edit',[
            'permissions' => $permissions,
            'hasPermission' => $hasPermission,
            'role' => $role,
        ]);
    }

    //update
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name,'.$id.'id',
        ]);

        if ($validator->passes()) {
            $role->name = $request->name;
            $role->save();

            if (!empty($request->permission)) {
               $role->syncPermissions($request->permission);
            } else{
                $role->syncPermissions([]);
            }

            return redirect()->route('roles.index')->with('success', 'Roles update successfully');
        } else {
            return redirect()->route('roles.create', $id)->withInput()->withErrors($validator);
        }
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->route('roles.index')->with('error', 'Roles deleted successfully');
    }
}