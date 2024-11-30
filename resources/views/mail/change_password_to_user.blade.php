@component('mail::message')
   Ngày: {{ $currentDate }}

    Chào bạn, đây là email thông báo về sự thay đổi tài khoản của bạn!

    Thông tin tài khoản

    Tên người dùng: {{ $user->name }}
    Email: {{ $user->email }}
    Mật khẩu mới: {{ $password }}

    Cảm ơn bạn đã tin tưởng sử dụng hệ thống của chúng tôi! 
    Chúc bạn ngày mới thật tốt lành!
@endcomponent
