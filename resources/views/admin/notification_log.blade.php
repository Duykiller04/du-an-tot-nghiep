@extends('admin.layouts.master')

@section('content')
<div class="container">
    <h3 class="my-4">Tất cả thông báo</h3>
    
    <!-- Thông báo thành công hoặc lỗi -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    
    <!-- Form xóa nhiều thông báo -->
    <form action="{{ route('admin.notification_log.deleteMultiple') }}" method="POST">
        @csrf
        @method('DELETE')

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th><input type="checkbox" id="select-all"></th>
                    <th>Nội dung thông báo</th>
                    <th>Thời gian tạo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($notification_log as $notification_log)
                    <tr>
                        <td>
                            <input type="checkbox" name="notification_ids[]" value="{{ $notification_log->id }}">
                        </td>
                        <td> {{ $notification_log->message }}</td>
                        <td>{{ \Carbon\Carbon::parse($notification_log->created_at)->format('H:i d-m-Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Nút xóa nhiều -->
        <button type="submit" class="btn btn-danger">Xóa các thông báo đã chọn</button>
    </form>
</div>

<script>
    // Chọn tất cả checkbox
    document.getElementById('select-all').addEventListener('click', function(event) {
        const checkboxes = document.querySelectorAll('input[name="notification_ids[]"]');
        checkboxes.forEach(checkbox => checkbox.checked = event.target.checked);
    });
</script>
@endsection
