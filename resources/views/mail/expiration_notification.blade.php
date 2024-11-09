<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông báo thuốc sắp hết hạn</title>
</head>
<body>
    <h1>Thông báo thuốc sắp hết hạn</h1>
    <p>Chào bạn,</p>
    <p>Dưới đây là danh sách các thuốc sắp hết hạn trong vòng {{ config('app.expiration_notification_days') }} ngày:</p>
    
    <ul>
        @foreach($medicines as $medicine)
            <li>
                <strong>{{ $medicine->name }}</strong> (Hạn sử dụng: {{  \Carbon\Carbon::parse($medicine->expiration_date)->format('d-m-Y') }})
            </li>
        @endforeach
    </ul>

    <p>Vui lòng kiểm tra và thực hiện các hành động cần thiết.</p>
</body>
</html>
