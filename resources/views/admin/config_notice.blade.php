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
                        <form method="POST" action="{{ route('admin.setting.update', $settings->id) }}">
                            @csrf
                            @method('PUT')

                            <!-- Nút tổng quát bật/tắt thông báo -->
                            <div class="mb-3 row">
                                <label for="notification_enabled" class="col-sm-3 col-form-label">Bật/Tắt chế độ thông báo</label>
                                <div class="col-sm-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="notification_enabled" name="notification_enabled"
                                               {{ $settings->notification_enabled ? 'checked' : '' }}>

                                        <label class="form-check-label" id="notification_status" for="notification_enabled">
                                                {{ $settings->notification_enabled ? 'Có' : 'Không' }}
                                            </label>
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
                            <!-- Số ngày trước khi hết hạn -->
                            <div class="mb-3 row">
                                <label for="email" class="col-sm-3 col-form-label">email nhận thông báo</label>
                                <div class="col-sm-3">
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="{{ $settings->email }}" required>
                                </div>
                            </div>

                            <!-- Nhận email thông báo -->
                            <div class="mb-3 row">
                                <label for="receive_email_notifications" class="col-sm-3 col-form-label">Nhận email thông báo</label>
                                <div class="col-sm-9">
                                    <!-- Hidden input để gửi giá trị 0 nếu checkbox không được chọn -->
                                    <input type="hidden" id="hidden_email_notifications" name="receive_email_notifications" value="0">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="receive_email_notifications" name="receive_email_notifications"
                                               value="1" {{ $settings->receive_email_notifications ? 'checked' : '' }}>

                                        <label class="form-check-label" id="notification_status" for="notification_enabled">
                                                {{ $settings->receive_email_notifications ? 'Có' : 'Không' }}
                                            </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Nhận cảnh báo về nhiệt độ bảo quản -->
                            {{-- <div class="mb-3 row">
                                <label for="receive_temperature_warnings" class="col-sm-3 col-form-label">Nhận cảnh báo về nhiệt độ bảo quản</label>
                                <div class="col-sm-9">
                                    <!-- Hidden input để gửi giá trị 0 nếu checkbox không được chọn -->
                                    <input type="hidden" id="hidden_temperature_warnings" name="receive_temperature_warnings" value="0">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="receive_temperature_warnings" name="receive_temperature_warnings"
                                               value="1" {{ $settings->temperature_warning ? 'checked' : '' }}>

                                        <label class="form-check-label" id="notification_status" for="notification_enabled">
                                                {{ $settings->temperature_warning ? 'Có' : 'Không' }}
                                            </label>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="card-header border-0">
                                <h5 class="card-title mb-0">Thiết lập ca làm</h5>
                            </div>
                            <!-- Bật mở ca tự động -->
                            <div class="mb-3 row">
                                <label for="auto_open_shift" class="col-sm-3 col-form-label">Mở ca tự động</label>
                                <div class="col-sm-9">
                                    <input type="hidden" id="hidden_auto_open_shift" name="auto_open_shift" value="0">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="auto_open_shift" name="auto_open_shift"
                                            value="1" {{ $settings->auto_open_shift ? 'checked' : '' }}>
                                        <label class="form-check-label" for="auto_open_shift">{{ $settings->auto_open_shift ? 'Có' : 'Không' }}</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Bật đóng ca tự động -->
                            <div class="mb-3 row">
                                <label for="auto_close_shift" class="col-sm-3 col-form-label">Đóng ca tự động</label>
                                <div class="col-sm-9">
                                    <input type="hidden" id="hidden_auto_close_shift" name="auto_close_shift" value="0">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="auto_close_shift" name="auto_close_shift"
                                            value="1" {{ $settings->auto_close_shift ? 'checked' : '' }}>
                                        <label class="form-check-label" for="auto_close_shift">{{ $settings->auto_close_shift ? 'Có' : 'Không' }}</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Số phút sau khi đóng ca -->
                            <div class="mb-3 row">
                                <label for="close_after_minutes" class="col-sm-3 col-form-label">Đóng ca sau bao nhiêu phút</label>
                                <div class="col-sm-3">
                                    <input type="number" class="form-control" id="close_after_minutes" name="close_after_minutes" 
                                        value="{{ $settings->close_after_minutes }}" >
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

@section('js')
    <script>
       document.getElementById('notification_enabled').addEventListener('change', function () {
    const isEnabled = this.checked;

    const expirationInput = document.getElementById('expiration_notification_days');
    const emailCheckbox = document.getElementById('receive_email_notifications');
    const temperatureCheckbox = document.getElementById('receive_temperature_warnings');

    // Disable trường nhập số ngày nếu tắt thông báo, nhưng không disable các checkbox khác
    if (!isEnabled) {
        expirationInput.readonly = true;
        emailCheckbox.checked = false;
        temperatureCheckbox.checked = false;
    } else {
        expirationInput.disabled = false;
    }
});

const checkboxes = ['receive_email_notifications', 'receive_temperature_warnings'];

checkboxes.forEach(id => {
    document.getElementById(id).addEventListener('change', function () {
        // Nếu bất kỳ checkbox nào được bật, tự động bật thông báo
        const notificationEnabled = document.getElementById('notification_enabled');
        if (this.checked) {
            notificationEnabled.checked = true;
            notificationEnabled.dispatchEvent(new Event('change')); // Gọi sự kiện thay đổi để kích hoạt trạng thái mới
        }
    });
});

window.addEventListener('DOMContentLoaded', (event) => {
    const isEnabled = document.getElementById('notification_enabled').checked;
    const expirationInput = document.getElementById('expiration_notification_days');

    if (!isEnabled) {
        expirationInput.disabled = true;
    }
});

    </script>
@endsection
