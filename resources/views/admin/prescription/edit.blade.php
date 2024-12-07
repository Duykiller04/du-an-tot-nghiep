@extends('admin.layouts.master')

@section('title')
    Chỉnh sửa đơn thuốc
@endsection

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Sửa đơn thuốc</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Đơn thuốc</a></li>
                            <li class="breadcrumb-item active">Sửa đơn thuốc</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.prescriptions.update', $prescription->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Thông tin khách hàng</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="customer_name" class="form-label">Tên khách hàng <span class="text-danger">(*)</span></label>
                                <input type="text" class="form-control @error('customer_name') is-invalid @enderror"
                                    id="customer_name" name="customer_name" value="{{ old('customer_name', $prescription->customer_name) }}">
                                @error('customer_name')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="age" class="form-label">Tuổi <span class="text-danger">(*)</span></label>
                                <input type="number" class="form-control @error('age') is-invalid @enderror"
                                    id="age" name="age" value="{{ old('age', $prescription->age) }}">
                                @error('age')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Điện thoại</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    id="phone" name="phone" value="{{ old('phone', $prescription->phone) }}">
                                @error('phone')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Địa chỉ</label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror"
                                    id="address" name="address" value="{{ old('address', $prescription->address) }}">
                                @error('address')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email', $prescription->email) }}">
                                @error('email')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="weight" class="form-label">Cân nặng</label>
                                <input type="number" class="form-control @error('weight') is-invalid @enderror"
                                    id="weight" name="weight" value="{{ old('weight', $prescription->weight) }}">
                                @error('weight')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="gender" class="form-label">Giới tính <span class="text-danger">(*)</span></label>
                                <select name="gender" id="gender" class="form-select @error('gender') is-invalid @enderror">
                                    <option value="">Chọn giới tính</option>
                                    <option value="0" {{ old('gender', $prescription->gender) == '0' ? 'selected' : '' }}>Nam</option>
                                    <option value="1" {{ old('gender', $prescription->gender) == '1' ? 'selected' : '' }}>Nữ</option>
                                </select>
                                @error('gender')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Bệnh và ngày bán</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="cutDosePrescription" class="form-label">Đơn thuốc mẫu</label>
                                @foreach ($cutDosePrescription as $item)
                                    <input type="text" class="form-control" value="{{ $item['disease']['disease_name'] }}" readonly>
                                @endforeach
                            </div>
                            <div class="mb-3">
                                <label for="type_sell" class="form-label">Kiểu bán <span class="text-danger">(*)</span></label>
                                <select name="type_sell" id="type_sell" class="form-select @error('type_sell') is-invalid @enderror">
                                    <option value="Bán lẻ" {{ old('type_sell', $prescription->type_sell) == 'Bán lẻ' ? 'selected' : '' }}>Bán lẻ</option>
                                    <option value="Bán giá nhập" {{ old('type_sell', $prescription->type_sell) == 'Bán giá nhập' ? 'selected' : '' }}>Bán giá nhập</option>
                                    <option value="Trả lại nhà cung cấp" {{ old('type_sell', $prescription->type_sell) == 'Trả lại nhà cung cấp' ? 'selected' : '' }}>Trả lại nhà cung cấp</option>
                                    <option value="Xuất" {{ old('type_sell', $prescription->type_sell) == 'Xuất' ? 'selected' : '' }}>Xuất</option>
                                    <option value="Hủy" {{ old('type_sell', $prescription->type_sell) == 'Hủy' ? 'selected' : '' }}>Hủy</option>
                                </select>                                
                                @error('type_sell')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="sale_date" class="form-label">Ngày bán</label>
                                <input type="date" class="form-control" id="sale_date"
                                    value="{{ $prescription->created_at->format('Y-m-d') }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-5">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Trạng thái</h5>
                        </div>
                        <div class="card-body">
                            <label class="form-label">Trạng thái</label>
                            <div class="form-check form-switch form-switch-lg">
                                <input class="form-check-input" type="checkbox" id="customSwitchsizelg" name="status" 
                                    value="1" {{ $prescription->status ? 'checked' : '' }}>
                                <label class="form-check-label" for="status">{{ $prescription->status ? 'Bán' : 'Hủy' }}</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Thông tin thuốc</h5>
                        </div>
                        <div class="card-body">
                            <div id="medicine-container">
                                @foreach ($prescription->prescriptionDetails as $index => $detail)
                                    <div class="row mb-3 medicine-row">
                                        <div class="col-md-2">
                                            <label for="medicine_id_{{ $index }}" class="form-label">Thuốc</label>
                                            <input type="text" class="form-control" value="{{ $detail->medicine->name }}" readonly>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="unit_id_{{ $index }}" class="form-label">Đơn vị</label>
                                            <input type="text" class="form-control" value="{{ $detail->unit->name }}" readonly>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="quantity_{{ $index }}" class="form-label">Số lượng bán</label>
                                            <input type="number" class="form-control" value="{{ $detail->quantity }}" readonly>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="dosage_{{ $index }}" class="form-label">Liều lượng</label>
                                            <input type="text" class="form-control" value="{{ $detail->dosage }}" readonly>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="current_price_{{ $index }}" class="form-label">Thành tiền</label>
                                            <input type="number" class="form-control" value="{{ $detail->current_price }}" readonly>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-2">
                                    <label for="total_price" class="form-label">Tổng tiền</label>
                                    <input type="number" class="form-control" value="{{ old('total_price', $prescription->total) }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 custom-spacing ">
                    <div class="card">
                        <div class="text-end m-3">
                            <a href="{{ route('admin.prescriptions.index') }}">
                                <button type="button" class="btn btn-primary w-sm">Quay lại</button>
                            </a>
                            <button type="submit" class="btn btn-success w-sm">Cập nhật</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('script-libs')
    <script>
        const medicines = @json($medicines);
        const units = @json($units);
    </script>
@endsection
