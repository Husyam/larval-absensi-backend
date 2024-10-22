<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionAbsenController extends Controller
{
    //index
    public function index(Request $request)
    {
        $permission_absen = Permission::with('user')
            ->when($request->input('name'), function ($query, $name) {
                $query->whereHas('user', function ($query) use ($name) {
                    $query->where('name', 'like', "%.$name.%");
                });
            })->orderBy('id', 'desc')->paginate(10);

            return view('pages.permission-absen.index', compact('permission_absen'));
    }

    //create
    public function create()
    {

        return view('pages.permission-absen.index', compact('permission_absen'));
    }

    //store
    public function store(Request $request)
    {
        //
    }

    //show
    //show
    public function show($id)
    {
        $permission_absen = Permission::with('user')->find($id);
        if (!$permission_absen) {
            // Jika tidak ditemukan, redirect atau tampilkan pesan error
            return redirect()->route('permissions-absensi.index')->with('error', 'Permission not found.');
        }
        return view('pages.permission-absen.show', compact('permission_absen'));
    }

    //edit
    public function edit($id)
    {
        $permission_absen = Permission::find($id);
        return view('pages.permission-absen.edit', compact('permission_absen'));
    }

    //update
    public function update(Request $request, $id)
    {
        $permission_absen = Permission::find($id);
        $permission_absen->is_approved = $request->is_approved;
        $permission_absen->save();
        return redirect()->route('permissions-absensi.index')->with('success', 'Permission updated successfully');
    }

    //destroy
    public function destroy($id)
    {
        //
    }
}
