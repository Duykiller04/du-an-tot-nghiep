@extends('admin.layouts.master')
@section('content')
    <div class="table-responsive">
        <h1>DANH SÁCH USER</h1>
        <a class="btn btn-info" href="{{ route('admin.users.create') }}">Thêm mới</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NAME</th>
                    <th>PHOME</th>
                    <td>ADDRESS</td>
                    <td>BIRTH</td>
                    <th>IMAGE</th>
                    <th>EMAIL</th>
                    <th>TYPE</th>
                    <th>CREATED AT</th>
                    <th>UPDATED AT</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>
                            {{ $item->id }}
                        </td>
                        <td>
                            {{ $item->name }}
                        </td>
                        <td>
                            {{ $item->phone }}
                        </td>
                        <td>
                            {{ $item->address }}
                        </td>
                        <td>{{ date('m/d/Y', strtotime($item->birth)) }}</td>
                        <td>
                            @php
                                $url = $item->image;
                                if (!Str::contains($url, 'http')) {
                                    $url = Storage::url($url);
                                }
                            @endphp
                            <img src="{{ $url }}" alt="" width="100px">
                        </td>
                        <td>
                            {{ $item->email }}
                        </td>
                        <td>{!! $item->type ? '<span class="badge bg-primary">Admin</span>' : '<span class="badge bg-danger">Staff</span>' !!}</td>
                        <td>
                            {{ $item->created_at }}
                        </td>

                        <td>
                            {{ $item->updated_at }}
                        </td>

                        <td>
                            <a class="btn btn-info" href="{{ route('admin.users.show', $item->id) }}">Xem</a>
                            <a class="btn btn-warning" href="{{ route('admin.users.edit', $item->id) }}">Sửa</a>
                            <form action="{{ route('admin.users.destroy', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger " onclick="return confirm('co chắc chắn muốn xóa ko')"
                                    type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $data->Links() }}
    </div>
@endsection
