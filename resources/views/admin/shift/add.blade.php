@extends('admin.layouts.master')

@section('title')
    Thêm mới ca làm 
@endsection

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Tạo mới ca làm</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Ca làm</a></li>
                            <li class="breadcrumb-item active">Tạo mới</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        @if ($errors->any())
            <div class="alert alert-danger">Đã có lỗi nhập liệu. Vui lòng kiểm tra lại!</div>
        @endif
        <div class="row">
            <div class="col-lg-12">
                <div class="card p-3">
                    <div class="card-body">
                        <form action="{{ route('admin.shifts.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label" for="title">Tên ca làm<span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}">
                                @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="start_time">Giờ bắt đầu<span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control @error('start_time') is-invalid @enderror" id="start_time" name="start_time" value="{{ old('start_time') }}">
                                @error('start_time')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label" for="end_time">Giờ kết thúc<span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control @error('end_time') is-invalid @enderror" id="end_time" name="end_time" value="{{ old('end_time') }}">
                                @error('end_time')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>                 
                            <div class="mb-3">
                                <label class="form-label">Chọn nhân viên<span class="text-danger">*</span></label>
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" id="select_all">
                                    <label class="form-check-label" for="select_all">Chọn tất cả</label>
                                </div>
                                <div id="user-checkboxes">
                                    @foreach ($user as $item)
                                        <div class="form-check">
                                            <input 
                                                type="checkbox" 
                                                class="form-check-input" 
                                                id="user_{{ $item->id }}" 
                                                name="details[]" 
                                                value="{{ $item->id }}" 
                                                {{ in_array($item->id, old('details', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="user_{{ $item->id }}">{{ $item->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('details')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            

                            <div class="text-end mb-4">
                                <a href="{{ route('admin.shifts.index') }}" class="btn btn-warning w-sm">Quay lại</a>
                                <button type="submit" class="btn btn-success w-sm">Lưu</button>
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

@section('js')
    <script>
       document.getElementById('select_all').addEventListener('change', function () {
        let checkboxes = document.querySelectorAll('#user-checkboxes input[type="checkbox"]');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });
    </script>
@endsection
@endsection
