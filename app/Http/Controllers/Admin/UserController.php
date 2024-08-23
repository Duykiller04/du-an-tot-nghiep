<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        try {
            $data = $request->except('image');

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $data['image'] = $image->store('users', 'public');
            } else {
                $data['image'] = null;
            }

            User::create($data);

            return redirect()->route('admin.users.index')->with('success', 'Thành công');

        } catch (\Exception $exception) {
            return back()->with('error' . $exception->getMessage());
        }
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
        try {
            $model = User::query()->findOrFail($id);

            $data = $request->except('image');

            $currentImgThumb = $model->image;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $data['image'] = $image->store('users', 'public');
            } else {
                $data['image'] = null;
            }

            $model->update($data);

            if (
                $request->hasFile('image')
                && $currentImgThumb
                && Storage::exists($currentImgThumb)
            ) {
                Storage::delete($currentImgThumb);
            }

            return back()->with('success', 'Thành công');

        } catch (\Exception $exception) {
            return back()->with('error' . $exception->getMessage());
        }
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

        return back()->with('success', 'Thành công');
    }
}


// đâye code