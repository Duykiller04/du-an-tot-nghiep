@extends('admin.layouts.master')

@section('title')
    Chi tiết người dùng
@endsection

@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Chi tiết người dùng</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Người dùng</a></li>
                            <li class="breadcrumb-item active">Chi tiết người dùng</li>
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
                                <th class="ps-0" scope="row">Tên người dùng:</th>
                                <td class="text-muted">{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th class="ps-0" scope="row">Email:</th>
                                <td class="text-muted">{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th class="ps-0" scope="row">Ảnh:</th>
                                <td class="text-muted">
                                    <img src="{{ asset('storage/' . $user->image) }}" alt="User Image" width="100">
                                </td>
                            </tr>
                            <tr>
                                <th class="ps-0" scope="row">Sô điện thoại:</th>
                                <td class="text-muted">{{ $user->phone }}</td>
                            </tr>
                            <tr>
                                <th class="ps-0" scope="row">Ngày sinh:</th>
                                <td class="text-muted">{{ date('m/d/Y', strtotime($user->birth)) }}</td>
                            </tr>

                            <tr>
                                <th class="ps-0" scope="row">Địa chỉ:</th>
                                <td class="text-muted">{{ $user->address }}</td>
                            </tr>
                            <tr>
                                <th class="ps-0" scope="row">Vai trò:</th>
                                <td>
                                    @if ($user->type == 'admin')
                                        <span class="badge bg-primary">Quản trị viên</span>
                                    @elseif($user->type == 'staff')
                                        <span class="badge bg-danger">Nhân viên</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="ps-0" scope="row">Mô tả:</th>
                                <td class="text-muted">{{ $user->description }}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div><!-- end card body -->
        </div><!-- end card -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="text-end m-3">
                        <a href="{{ route('admin.users.index') }}">
                            <button type="button" class="btn btn-primary w-sm">Quay lại</button>
                        </a>
                    </div>
                </div>
            </div>
            <!--end col-->
        </div>
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
