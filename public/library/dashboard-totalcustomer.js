$(document).ready(function() {

    // Gửi yêu cầu AJAX để lấy dữ liệu tổng số khách hàng
    flatpickr("#dateRangePicker", {
        mode: "range", // Chọn khoảng thời gian
        dateFormat: "Y-m-d",
        locale: "vi" // Ngôn ngữ Tiếng Việt (tùy chọn)
    });

    // Khi nhấn vào icon, cũng mở DatePicker
    document.getElementById('icon-calendar').addEventListener('click', function() {
        document.getElementById('dateRangePicker').focus(); // Kích hoạt input
    });
    $.ajax({
        url: "{{ route('dashboard-customers') }}",
        method: 'GET',
        success: function(response) {
            $('#totalCustomers').text(response.totalCustomers);
        },
        error: function() {
            alert('Lỗi khi lấy dữ liệu khách hàng');
        }
    });

    // Khởi tạo Date Range Picker
    flatpickr("#dateRangePicker", {
        mode: "range",
        dateFormat: "d/m/Y",
        locale: "vn",
        monthSelectorType: "static",
        onClose: function(selectedDates, dateStr, instance) {
            document.getElementById('dateRangePicker').value = dateStr;
        }
    });
});