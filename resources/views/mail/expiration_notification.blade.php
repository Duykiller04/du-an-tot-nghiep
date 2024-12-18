<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông báo thuốc sắp hết hạn</title>
</head>
<body>
    <h1>Thông báo thuốc sắp hết hạn</h1>
    <p>Chào bạn,</p>
    <p>Dưới đây là danh sách các thuốc sắp hết hạn :</p>
    
    <ul>
        @foreach($medicines as $medicine)
            <li>
               Thuốc <strong>{{ $medicine['medicine_name'] }}</strong> lô nhập ngày <strong>{{ $medicine['batch_name'] }}</strong> (Hạn sử dụng: {{  $medicine['expiration_date'] }})
            </li>
        @endforeach
    </ul>

    <p>Vui lòng kiểm tra và thực hiện các hành động cần thiết.</p>
</body>
</html>
