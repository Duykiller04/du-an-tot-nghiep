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
                    <h4 class="mb-sm-0">Tạo phiếu kiểm kho</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Phiếu kiểm kho</a></li>
                            <li class="breadcrumb-item active">Tạo mới</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card p-3">
                    <div class="card-body">
                        <form action="{{ route('admin.inventoryaudit.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label" for="title">Tiêu đề phiếu kiểm<span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}">
                                @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="storage_id">Kho<span class="text-danger">*</span></label>
                                <select class="form-control @error('storage_id') is-invalid @enderror" id="storage_id" name="storage_id">
                                    <option value="">Chọn kho</option>
                                    @foreach($storages as $storage)
                                        <option value="{{ $storage->id }}" {{ old('storage_id') == $storage->id ? 'selected' : '' }}>{{ $storage->location }}</option>
                                    @endforeach
                                </select>
                                @error('storage_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="check_date">Ngày kiểm<span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('check_date') is-invalid @enderror" id="check_date" name="check_date" value="{{ old('check_date') }}">
                                @error('check_date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="check_by">Người kiểm<span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('check_by') is-invalid @enderror" id="check_by" name="check_by" value="{{ old('check_by') }}">
                                @error('check_by')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="remarks">Ghi chú</label>
                                <input type="text" class="form-control @error('remarks') is-invalid @enderror" id="remarks" name="remarks" value="{{ old('remarks') }}">
                                @error('remarks')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div id="details-container">
                                @for ($i = 0; $i < max(count(old('details', [1])), session('detail_count', 1)); $i++)
                                    <div class="row mb-3 detail-row">
                                        <div class="col-lg-3">
                                            <label class="form-label" for="medicine_id">Loại thuốc<span class="text-danger">*</span></label>
                                            <select class="form-control @error('details.'.$i.'.medicine_id') is-invalid @enderror" name="details[{{ $i }}][medicine_id]">
                                                <option value="">Chọn thuốc</option>
                                                @foreach($medicines as $medicine)
                                                    <option value="{{ $medicine->id }}" {{ old('details.'.$i.'.medicine_id') == $medicine->id ? 'selected' : '' }}>{{ $medicine->medicine_code }}</option>
                                                @endforeach
                                            </select>
                                            @error('details.'.$i.'.medicine_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-lg-2">
                                            <label class="form-label" for="expected_quantity">Số lượng mong muốn<span class="text-danger">*</span></label>
                                            <input type="number" class="form-control @error('details.'.$i.'.expected_quantity') is-invalid @enderror" name="details[{{ $i }}][expected_quantity]" value="{{ old('details.'.$i.'.expected_quantity') }}" >
                                            @error('details.'.$i.'.expected_quantity')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-lg-2">
                                            <label class="form-label" for="actual_quantity">Số lượng thực tế<span class="text-danger">*</span></label>
                                            <input type="number" class="form-control @error('details.'.$i.'.actual_quantity') is-invalid @enderror" name="details[{{ $i }}][actual_quantity]" value="{{ old('details.'.$i.'.actual_quantity') }}" >
                                            @error('details.'.$i.'.actual_quantity')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-lg-2">
                                            <label class="form-label" for="difference">Chênh lệch<span class="text-danger">*</span></label>
                                            <input type="number" class="form-control @error('details.'.$i.'.difference') is-invalid @enderror" name="details[{{ $i }}][difference]" value="{{ old('details.'.$i.'.difference') }}">
                                            @error('details.'.$i.'.difference')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-lg-2">
                                            <label class="form-label" for="remarks">Ghi chú</label>
                                            <input type="text" class="form-control @error('details.'.$i.'.remarks') is-invalid @enderror" name="details[{{ $i }}][remarks]" value="{{ old('details.'.$i.'.remarks') }}">
                                            @error('details.'.$i.'.remarks')
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
                <label class="form-label" for="medicine_id">Loại thuốc</label>
                <select class="form-control" name="details[${index}][medicine_id]">
                    <option value="">Chọn thuốc<span class="text-danger">*</span></option>
                    @foreach($medicines as $medicine)
                        <option value="{{ $medicine->id }}">{{ $medicine->medicine_code}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2">
                <label class="form-label" for="expected_quantity">Số lượng mong muốn<span class="text-danger">*</span></label>
                <input type="number" class="form-control" name="details[${index}][expected_quantity]" >
            </div>
            <div class="col-lg-2">
                <label class="form-label" for="actual_quantity">Số lượng thực tế<span class="text-danger">*</span></label>
                <input type="number" class="form-control" name="details[${index}][actual_quantity]" >
            </div>
            <div class="col-lg-2">
                <label class="form-label" for="difference">Chênh lệch<span class="text-danger">*</span></label>
                <input type="number" class="form-control" name="details[${index}][difference]" >
            </div>
            <div class="col-lg-2">
                <label class="form-label" for="remarks">Ghi chú</label>
                <input type="text" class="form-control" name="details[${index}][remarks]">
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
            alert('Phiếu kiểm kho phải có ít nhất một loại thuốc.');
        }
        });
    }

    document.querySelectorAll('.btn-remove-detail').forEach(addRemoveButtonEvent);
</script>
@endsection
@endsection
