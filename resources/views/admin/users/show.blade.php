@extends('admin.layouts.master')
@section('content')
    <h1>CHI TIẾT USER</h1>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-borderless mb-0">
                    <tbody>
                        <tr>
                            <th class="ps-0" scope="row">Full Name:</th>
                            <td class="text-muted">{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th class="ps-0" scope="row">Email:</th>
                            <td class="text-muted">{{ $user->email }}</td>
                        </tr>

                        <tr>
                            <th class="ps-0" scope="row">Password:</th>
                            <td class="text-muted">{{ $user->password }}</td>
                        </tr>

                        <tr>
                            <th class="ps-0" scope="row">Image:</th>
                            <td class="text-muted">
                                <img src="{{ asset('storage/' . $user->image) }}" alt="User Image" width="100">
                            </td>
                        </tr>
                        <tr>
                            <th class="ps-0" scope="row">Phone:</th>
                            <td class="text-muted">{{ $user->phone }}</td>
                        </tr>
                        <tr>
                            <th class="ps-0" scope="row">Birth:</th>
                            <td class="text-muted">{{ date('m/d/Y', strtotime($user->birth)) }}</td>
                        </tr>

                        <tr>
                            <th class="ps-0" scope="row">Address:</th>
                            <td class="text-muted">{{ $user->address }}</td>
                        </tr>
                        <tr>
                            <th class="ps-0" scope="row">Type:</th>
                            <td>{!! $user->type ? '<span class="badge bg-primary">Admin</span>' : '<span class="badge bg-danger">Staff</span>' !!}</td>
                        </tr>
                        <tr>
                            <th class="ps-0" scope="row">Description:</th>
                            <td class="text-muted">{{ $user->description }}</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div><!-- end card body -->
    </div><!-- end card -->
@endsection
