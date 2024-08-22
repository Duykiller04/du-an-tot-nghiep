@extends('admin.layouts.master')

@section('title')
Chi tiết User
@endsection

@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Chi tiết User</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">User</a></li>
                        <li class="breadcrumb-item active">Chi tiết User</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

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
                            <td>
                                @if($user->type == 'Admin')
                                <span class="badge bg-primary">Admin</span>
                                @elseif($user->type == 'Staff')
                                <span class="badge bg-danger">Staff</span>
                                @endif
                            </td>
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
</div>
@endsection

@section('style-libs')
<!-- Plugins css -->
<link href="{{ asset('theme/admin/assets/libs/dropzone/dropzone.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('script-libs')
<!-- ckeditor -->
<script src="{{ asset('theme/admin/assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>

<script>
    ClassicEditor.create(document.querySelector('#symptom'))
        .catch(error => {
            console.error(error);
        });

    ClassicEditor.create(document.querySelector('#treatment_direction'))
        .catch(error => {
            console.error(error);
        });
</script>
@endsection