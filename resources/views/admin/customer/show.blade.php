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
                <h4 class="mb-sm-0">Chi tiết Customer</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Customer</a></li>
                        <li class="breadcrumb-item active">Chi tiết Customer</li>
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
                                <td class="text-muted">{{ $customer->name }}</td>
                            </tr>
                            <tr>
                                <th class="ps-0" scope="row">Phone:</th>
                                <td class="text-muted">{{ $customer->phone }}</td>
                            </tr>
                            <tr>
                                <th class="ps-0" scope="row">Address:</th>
                                <td class="text-muted">{{ $customer->address }}</td>
                            </tr>

                            <tr>
                                <th class="ps-0" scope="row">Age:</th>
                                <td class="text-muted">{{ $customer->age }}</td>
                            </tr>
                            <tr>
                                <th class="ps-0" scope="row">weight:</th>
                                <td class="text-muted">{{ $customer->weight }}</td>
                            </tr>
                    </tbody>
                </table>
            </div>
        </div><!-- end card body -->
    </div><!-- end card -->
    
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex gap-2">
                    <a class="btn btn-success" href="{{ route('admin.customers.index') }}" class="btn btn-success mb-3">Quay lại</a>
                </div><!-- end card header -->
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