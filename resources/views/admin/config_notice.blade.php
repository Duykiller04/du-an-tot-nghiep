@extends('admin.layouts.master')

@section('title')
    Cấu hình thông báo hết hạn thuốc
@endsection

@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Cấu hình thông báo hết hạn thuốc</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Quản lý thuốc</a></li>
                            <li class="breadcrumb-item active">Cấu hình thông báo</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header border-0">
                        <h5 class="card-title mb-0">Thiết lập thông báo</h5>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.setting.update',$settings->id) }}">
                            @csrf
                             <!-- Nút tổng quát bật/tắt thông báo -->
                             <div class="mb-3 row">
                                <label for="notification_enabled" class="col-sm-3 col-form-label">Bật/Tắt chế độ thông báo</label>
                                <div class="col-sm-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="notification_enabled" name="notification_enabled"
                                               {{ $settings->notification_enabled ? 'checked' : '' }}>
                                        <label class="form-check-label" for="notification_enabled">Có</label>
                                    </div>
                                </div>
                            </div>
                            <!-- Số ngày trước khi hết hạn -->
                            <div class="mb-3 row">
                                <label for="expiration_notification_days" class="col-sm-3 col-form-label">Số ngày thông báo trước khi hết hạn</label>
                                <div class="col-sm-3">
                                    <input type="number" class="form-control" id="expiration_notification_days" name="expiration_notification_days" 
                                           value="{{ $settings->expiration_notification_days }}" required>
                                </div>
                            </div>

                            <!-- Nhận email thông báo -->
                            <div class="mb-3 row">
                                <label for="receive_email_notifications" class="col-sm-3 col-form-label">Nhận email thông báo</label>
                                <div class="col-sm-9">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="receive_email_notifications" name="receive_email_notifications"
                                               {{ $settings->receive_email_notifications ? 'checked' : '' }}>
                                        <label class="form-check-label" for="receive_email_notifications">Có</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Nhận cảnh báo về nhiệt độ bảo quản -->
                            <div class="mb-3 row">
                                <label for="receive_temperature_warnings" class="col-sm-3 col-form-label">Nhận cảnh báo về nhiệt độ bảo quản</label>
                                <div class="col-sm-9">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="receive_temperature_warnings" name="receive_temperature_warnings"
                                               {{ $settings->receive_temperature_warnings ? 'checked' : '' }}>
                                        <label class="form-check-label" for="receive_temperature_warnings">Có</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Nút Lưu -->
                            <div class="mb-3 row">
                                <div class="col-sm-12 text-end">
                                    <button type="submit" class="btn btn-primary">Lưu cấu hình</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('style-libs')
    <!-- Thêm các tệp CSS nếu cần -->
@endsection

@section('script-libs')
    <!-- Thêm các tệp JavaScript nếu cần -->
@endsection

@section('js')
    <!-- Các tệp JavaScript khác -->
@endsection
