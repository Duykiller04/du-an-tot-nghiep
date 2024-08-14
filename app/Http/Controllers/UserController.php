<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    const PATH_UPLOAD = 'users';
    public function index()
    {
        $data = User::query()->latest('id')->paginate(5);

        return view('admin.users.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $userData = [
            'name'        => $request->input('name'),
            'email'       => $request->input('email'),
            'phone'       => $request->input('phone'),
            'address'     => $request->input('address'),
            'birth'       => $request->input('birth'),
            'description' => $request->input('description'),
            'password'    => bcrypt($request->input('password')),
            'type'        => $request->input('type'),
        ];

        $customer = User::create($userData);
        if ($request->hasFile('image')) {
            $customer->image = Storage::put(self::PATH_UPLOAD, $request->file('image'));
            $customer->save();
        }
        return redirect()->route('users.index');
    }
    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $userData = [
            'name'        => $request->input('name'),
            'email'       => $request->input('email'),
            'phone'       => $request->input('phone'),
            'address'     => $request->input('address'),
            'birth'       => $request->input('birth'),
            'description' => $request->input('description'),
            'type'        => $request->input('type'),
        ];

        if ($request->has('password')) {
            $userData['password'] = bcrypt($request->input('password'));
        }

        $customer = User::find($id); // Lấy user cần cập nhật dựa trên $id
        $customer->update($userData); // Cập nhật thông tin user

        if ($request->hasFile('image')) {
            $customer->image = Storage::put(self::PATH_UPLOAD, $request->file('image'));
            $customer->save();
        }

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = User::query()->findOrFail($id);

        $data->delete();

        if ($data->image && Storage::exists($data->image)) {
            Storage::delete($data->image);
        }

        return back();
    }
}
