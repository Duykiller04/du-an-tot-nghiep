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
                    <div class="card-header border-0">
                        <h5 class="card-title mb-0">Thông tin chung</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="medicine_id" class="form-label">Bệnh (<span class="text-danger">*</span>)</label>
                            <input type="text" class="form-control"
                            id="name_hospital" name="disease_id" value="{{ $cutDosePrescription->disease->disease_name }}"
                            disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="name_hospital">Tên bệnh viện (<span
                                    class="text-danger">*</span>)</label>
                            <input type="text" class="form-control"
                                id="name_hospital" name="name_hospital" value="{{ $cutDosePrescription->name_hospital }}"
                                disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="name_doctor">Tên bác sĩ (<span
                                    class="text-danger">*</span>)</label>
                            <input type="text" class="form-control"
                                id="name_doctor" name="name_doctor" value="{{ $cutDosePrescription->name_doctor }}"
                                disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="age">Tuổi (<span class="text-danger">*</span>)</label>
                            <input type="number" class="form-control" id="age" name="age"
                                value="{{ $cutDosePrescription->age }}" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="phone_doctor">Số điện thoại (<span
                                    class="text-danger">*</span>)</label>
                            <input type="number" class="form-control"
                                id="phone_doctor" name="phone_doctor" value="{{ $cutDosePrescription->phone_doctor }}"
                                disabled>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Cột bên phải -->
            <div class="col-12">
                <div class="card p-4">
                    <div class="card-header p-0 mb-3 border-0">
                        <h5 class="card-title mb-0">Thông tin thuốc và dụng cụ</h5>
                    </div>
                    <table id="example"
                        class="table table-bordered dt-responsive nowrap table-striped align-middle text-center"
                        style="width:100%">

                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Thuốc</th>
                                <th>Đơn vị</th>
                                <th>Số lượng</th>
                                <th>Liều dùng</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $stt = 1;
                            @endphp
                            @foreach ($cutDosePrescription->cutDosePrescriptionDetails as $index => $item)
                                <tr>
                                    <td>{{ $stt++ }}</td>
                                    <td>{{ $item->medicine->name }}</td>
                                    <td>{{ $item->unit->name }}</td>             
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->dosage }}</td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                    <div class="text-end mb-3">
                        <a href="{{ route('admin.cutDosePrescriptions.index') }}"><button type="button" class="btn btn-primary w-sm">Quay
                                lại</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
@endsection
