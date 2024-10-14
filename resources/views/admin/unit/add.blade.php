@extends('admin.layouts.master')

@section('title')
    Thêm đơn vị
@endsection

@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Thêm đơn vị</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Đơn vị</a></li>
                        <li class="breadcrumb-item active">Thêm đơn vị</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card vh-100">
                <div class="card-body">
                    <form action="{{ route('admin.units.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="unit-name-input">Tên đơn vị (<span class="text-danger">*</span>)</label>
                            <input type="text" name="name" class="form-control" id="unit-name-input" placeholder="Nhập tên đơn vị" value="{{ old('name') }}">
                            @error('name')
                            <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <div class="mb-3 mb-lg-0">
                                    <label for="" class="form-label">Đơn vị cha</label>
                                    <select name="parent_id" class="form-select">
                                        <option value="0" {{ old('parent_id') == 0 ? 'selected' : '' }}>Không</option>
                                        @foreach ($units as $item)
                                            @php($indent = "")
                                            @include('admin.unit.unit_nested', ['unit' => $item])
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="text-end mb-4 mt-4">
                            <a class="btn btn-primary" href="{{ route('admin.units.index') }}">Quay lại</a>
                            <button type="submit" class="btn btn-success w-sm">Thêm</button>
                        </div>
                    </form>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->

</div>
<!-- container-fluid -->
@endsection

@section('script-libs')
    <!-- project-create init -->
    <script src="{{ asset('theme/admin/assets/js/pages/project-create.init.js') }}"></script>
@endsection
