@extends('admin.layouts.master')
@section('content')
<h1>CẬP NHẬT USER</h1>
    <div class="border p-5 rounded bg-light bg-gradient">
        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session()->get('error') }}
            </div>
        @endif

        <form action="{{ route('users.update', $user->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name"
                    value="{{ old('name', $user->name) }}">

                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone"
                    value="{{ old('phone', $user->phone) }}">
                @error('phone')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control   " id="address" name="address"
                    value="{{ old('address', $user->address) }}">
                @error('address')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="birth">Birth Date</label>
                <input type="date" class="form-control " id="birth" name="birth"
                    value="{{ old('birth', $user->birth) }}">
                @error('birth')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" class="form-control" id="image" name="image">
                <img src="{{ \Storage::url($user->image) }}" alt="" width="100px">
                @error('image')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description">{{ old('description', $user->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control " id="email" name="email"
                    value="{{ old('email', $user->email) }}">
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control " id="password" name="password" value=", $user->password">
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="type">Type</label>
                <select class="form-control" id="type" name="type">
                    <option value="1" {{ old('type', $user->type) == '1' ? 'selected' : '' }}>Admin</option>
                    <option value="0" {{ old('type', $user->type) == '0' ? 'selected' : '' }}>Staff</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Eidt User</button>
        </form>
    </div>
@endsection
