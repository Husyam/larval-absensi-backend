<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    //index
    public function index(Request $request)
    {
        $attendances = Attendance::with('user')
            ->when($request->input('name'), function ($query, $name) {
                $query->whereHas('user', function ($query) use ($name) {
                    $query->where('name', 'like', '%' . $name . '%');
                });
            })->orderBy('id', 'desc')->paginate(10);
        return view('pages.absensi.index', compact('attendances'));
    }

    //create
    public function create()
    {
        // return view('pages.auth.login.auth-login');
    }

    //store
    public function store(Request $request)
    {
        //
    }

    //show
    public function show($id)
    {
        //
    }

    //edit
    public function edit($id)
    {
        //
    }

    //update
    public function update(Request $request, $id)
    {
        //
    }

    //destroy
    public function destroy($id)
    {
        //
    }
}
