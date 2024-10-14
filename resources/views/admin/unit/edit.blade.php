@extends('admin.layouts.master')

@section('title')
    Sửa đơn vị
@endsection

@section('content')
<div class="container-fluid">
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Sửa đơn vị</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Đơn vị</a></li>
                        <li class="breadcrumb-item active">Sửa đơn vị</li>
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
                    <a class="btn btn-primary mb-3" href="{{ route('admin.units.index') }}">Quay lại</a>
                    <form action="{{ route('admin.units.update', $unit->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label" for="unit-name-input">Tên đơn vị</label>
                            <input type="text" name="name" class="form-control" id="unit-name-input" placeholder="Nhập tên đơn vị" value="{{ old('name', $unit->name) }}">
                            @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <div class="mb-3 mb-lg-0">
                                    <label for="" class="form-label">Đơn vị cha</label>
                                    <select name="parent_id" class="form-select" id="">
                                        <option value="0" {{ $unit->parent_id === null ? 'selected' : '' }}>Không</option>
                                        @foreach ($units as $item)
                                            @php($indent = "")
                                            @include('admin.unit.unit_edit_nested', ['unit' => $item])
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="text-end mb-4 mt-4 d-flex justify-content-center">
                            <button type="submit" class="btn btn-success w-sm">Sửa</button>
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
