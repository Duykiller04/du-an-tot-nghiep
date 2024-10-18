@extends('admin.layouts.master')

@section('title')
    Tạo phiếu kiểm kho
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

                            <div id="details-container">
                                @for ($i = 0; $i < max(count(old('details', [1])), session('detail_count', 1)); $i++)
                                    <div class="row mb-3 detail-row">
                                        <div class="col-lg-3">
                                            <label class="form-label" for="user_id">Chọn nhân viên<span class="text-danger">*</span></label>
                                            <select class="form-control @error('details.' . $i . '.user_id') is-invalid @enderror" name="details[{{ $i }}][user_id]">
                                                <option value="">Chọn nhân viên<span class="text-danger">*</span></option>
                                                @if ($user->isNotEmpty())
                                                    @foreach ($user as $item)
                                                        <option value="{{ $item->id }}" {{ old('details.' . $i . '.user_id') == $item->id ? 'selected' : '' }}>
                                                            {{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                @else
                                                    <option value="">Không có nhân viên nào</option>
                                                @endif
                                            </select>
                                            @error('details.' . $i . '.user_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-lg-1 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger btn-remove-detail">Xóa</button>
                                        </div>
                                    </div>
                                @endfor
                            </div>

                            <div>
                                <button id="btn-add-detail" type="button" class="btn btn-primary">Thêm chi tiết +</button>
                            </div>

                            <div class="text-end mb-4">
                                <a href="{{ route('admin.inventoryaudit.index') }}" class="btn btn-warning w-sm">Quay lại</a>
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
        var detailCount = {{ max(count(old('details', [1])), session('detail_count', 1)) }};
        var users = @json($user); // Chuyển đổi collection $user thành JSON

        document.getElementById('btn-add-detail').addEventListener('click', function() {
            if (detailCount >= 5) {
                alert('Chỉ được phép thêm tối đa 5 chi tiết.');
                return;
            }

            var newDetail = createDetailElement(detailCount);
            document.getElementById('details-container').appendChild(newDetail);
            addRemoveButtonEvent(newDetail.querySelector('.btn-remove-detail'));
            detailCount++;
        });

        function createDetailElement(index) {
            var newDetail = document.createElement('div');
            newDetail.className = 'row mb-3 detail-row';
            newDetail.innerHTML = `
                <div class="col-lg-3">
                    <select class="form-control" name="details[${index}][user_id]">
                        <option value="">Chọn nhân viên<span class="text-danger">*</span></option>
                        ${users.length > 0 ? users.map(user => `<option value="${user.id}">${user.name}</option>`).join('') : '<option value="">Không có nhân viên nào</option>'}
                    </select>
                </div>
                <div class="col-lg-1 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-remove-detail">Xóa</button>
                </div>
            `;
            return newDetail;
        }

        function addRemoveButtonEvent(button) {
            button.addEventListener('click', function() {
                if (detailCount > 1) {
                    this.closest('.detail-row').remove();
                    detailCount--;
                } else {
                    alert('Phiếu kiểm kho phải có ít nhất một nhân viên.');
                }
            });
        }

        document.querySelectorAll('.btn-remove-detail').forEach(addRemoveButtonEvent);
    </script>
@endsection
@endsection
