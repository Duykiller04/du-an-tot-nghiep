@extends('admin.layouts.master')

@section('title')
    Chi tiết đơn thuốc cắt liều
@endsection

@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Chi tiết đơn thuốc</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Đơn thuốc</a></li>
                            <li class="breadcrumb-item active">Chi tiết đơn thuốc</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Cột chính bên trái -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Thông tin chung</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="medicine_id" class="form-label">Bệnh (<span class="text-danger">*</span>)</label>
                            <select name="disease_id" id="disease_id" class="form-select select2" disabled>
                                <option value="">Chọn bệnh</option>
                                @foreach ($diseases as $id => $name)
                                    <option value="{{ $id }}" @if ($cutDosePrescription->id == $id) selected @endif>
                                        {{ $name }}</option>
                                @endforeach
                            </select>
                            @error('disease_id')
                                <span class="d-block text-danger mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="name_hospital">Tên bệnh viện (<span
                                    class="text-danger">*</span>)</label>
                            <input type="text" class="form-control @error('name_hospital') is-invalid @enderror"
                                id="name_hospital" name="name_hospital" value="{{ $cutDosePrescription->name_hospital }}"
                                disabled>
                            @error('name_hospital')
                                <span class="d-block text-danger mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="name_doctor">Tên bác sĩ (<span
                                    class="text-danger">*</span>)</label>
                            <input type="text" class="form-control @error('name_doctor') is-invalid @enderror"
                                id="name_doctor" name="name_doctor" value="{{ $cutDosePrescription->name_doctor }}"
                                disabled>
                            @error('name_doctor')
                                <span class="d-block text-danger mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="age">Tuổi (<span class="text-danger">*</span>)</label>
                            <input type="number" class="form-control" id="age" name="age"
                                value="{{ $cutDosePrescription->age }}" disabled>
                            @error('age')
                                <span class="d-block text-danger mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="phone_doctor">Số điện thoại (<span
                                    class="text-danger">*</span>)</label>
                            <input type="number" class="form-control @error('phone_doctor') is-invalid @enderror"
                                id="phone_doctor" name="phone_doctor" value="{{ $cutDosePrescription->phone_doctor }}"
                                disabled>
                            @error('phone_doctor')
                                <span class="d-block text-danger mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <!-- Cột bên phải -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Thông tin thuốc và dụng cụ</h5>
                    </div>
                    <table id="example"
                        class="table table-bordered dt-responsive nowrap table-striped align-middle text-center"
                        style="width:100%">

                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Thuốc</th>
                                <th>Đơn vị</th>
                                <th>Số lượng</th>
                                <th>Giá hiện tại</th>
                                <th>Liều dùng</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($cutDosePrescription->cutDosePrescriptionDetails as $index => $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->medicine->name }}</td>
                                    <td>{{ $item->unit->name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->current_price }}</td>
                                    <td>{{ $item->dosage }}</td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Nút Lưu bệnh -->
    <div class="text-end mb-3">
        <a href="{{ route('admin.cutDosePrescriptions.index') }}"><button type="button" class="btn btn-primary w-sm">Quay
                lại</button></a>
    </div>
    </div>
@endsection
