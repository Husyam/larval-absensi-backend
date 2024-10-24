<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PermissionController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view permissions', only: ['index']),
            new Middleware('permission:edit permissions', only: ['edit']),
            new Middleware('permission:create permissions', only: ['create']),
            new Middleware('permission:delete permissions', only: ['destroy']),
        ];
    }


    //index
    public function index()
    {
        $permissions = DB::table('permissions')
            ->when(request('search'), function($query) {
                $query->where('name', 'like', '%'.request('search').'%');
            })->paginate(10);

        return view('pages.permissions.index', compact('permissions'));
    }

    //create
    public function create()
    {
        return view('pages.permissions.create');
    }

    //store
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions|min:3',
        ]);

        if ($validator->passes()) {
            Permission::create(['name' => $request->name]);

            return redirect()->route('permissions.index')->with('success', 'Permission created successfully');
        } else {
            return redirect()->route('permissions.create')->withInput()->withErrors($validator);
        }
    }

    //show
    public function show($id)
    {
        //
    }

    //edit
    public function edit($id)
    {
        $permissions = Permission::find($id);
        return view('pages.permissions.edit',[
            'permission' => $permissions
        ]);
    }

    //update
    public function update(Request $request, $id)
    {
        $permissions = Permission::find($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions|min:3',
        ]);

        if ($validator->passes()) {
            // $permissions = Permission::find($id);
            $permissions->name = $request->name;
            $permissions->save();

            return redirect()->route('permissions.index')->with('success', 'Permission updated successfully');
        } else {
            return redirect()->route('permissions.edit', $id)->withInput()->withErrors($validator);
        }
    }

    //destroy
    public function destroy($id)
    {
        $permissions = Permission::find($id);
        $permissions->delete();

        return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully');
    }

}
