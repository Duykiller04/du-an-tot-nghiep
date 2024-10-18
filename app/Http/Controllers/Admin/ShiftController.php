<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use App\Models\ShiftUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = User::where('type', 'staff')->get();
        //$user = User::all();
        //dd($user);
        return view('admin.shift.add',['user'=>$user]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'start_time' => 'required|date|after_or_equal:today',
            'end_time' => 'required|date|after:start_time',
            'details.*.user_id' => 'required|exists:users,id',
        ]);

        // Check for validation errors
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $shift = Shift::create([
            'shift_name' => $request->title, 
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => 'Kế hoạch', 
            'revenue_summary' => 0, 
        ]);

        foreach ($request->details as $detail) {
            ShiftUser::create([
                'users_id' => $detail['user_id'], 
                'shift_id' => $shift->id,
            ]);
        }

        return redirect()->route('admin.shifts.index')->with('success', 'Tạo ca làm thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
