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
    $('#dateRangePicker').on('change', function() {
        var dateRangeValue = $(this).val();
        console.log("Khoảng thời gian đã chọn:", dateRangeValue);

        // Tách startDate và endDate từ giá trị của dateRangePicker
        var dates = dateRangeValue.match(
            /(\d{2}\/\d{2}\/\d{4})/g); // Tìm tất cả các ngày trong chuỗi
            var startDate = dates && dates[0] ? dates[0] : null;
            var endDate = dates && dates[1] ? dates[1] : startDate;

        console.log("startDate:", startDate, "endDate:", endDate);

        // Nếu chỉ chọn 1 ngày, tự động gán endDate = startDate
        if (!endDate) {
            endDate = startDate;
        }

        // Gửi yêu cầu AJAX
        $.ajax({
            url: '/api/dashboard/filter',
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            data: {
                startDate: startDate,
                endDate: endDate,
            },
            success: function(response) {
                console.log("Dữ liệu trả về:", response);

                // Hiển thị tổng khách hàng
                $('#totalCustomers').text(response.totalCustomers || 0);

                // Hiển thị tổng đơn hoàng bán
                $('#totalOrders').text(response.totalOrders || 0);

                // Định dạng doanh thu với dấu phân cách và hiển thị 'VND'
                var totalRevenue = response.totalRevenue || 0;
                var formattedRevenue = totalRevenue
                    .toLocaleString(); // Định dạng số với dấu phân cách
                $('#totalRevenue').text(formattedRevenue + " VND");

                // Hiển thị lợi nhuận
                var profit = response.profit || 0; // Đảm bảo lấy giá trị lợi nhuận từ response
                var formattedProfit = profit.toLocaleString(); // Định dạng lợi nhuận
                $('#totalReturns').text(formattedProfit + " VND");
            },
            error: function(xhr, status, error) {
                console.error("Lỗi khi gửi yêu cầu:", error);
                console.error("Trạng thái:", status);
                console.error("Phản hồi từ server:", xhr.responseText);
                alert("Không thể tải dữ liệu. Vui lòng thử lại sau!");
            },
        });

    });

});