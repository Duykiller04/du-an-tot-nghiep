$(document).ready(function() {
    $.ajax({
        url: '/api/dashboard/profit', // URL route của bạn
        method: "GET",
        success: function(data) {
            if (data.profit !== undefined) {
                // Định dạng số với dấu phân cách hàng ngàn là dấu phẩy
                var formattedProfit = data.profit.toLocaleString(
                    'en-US'); // Dấu phân cách là dấu phẩy

                // Thêm "VND" vào cuối
                $('#totalReturns').text(formattedProfit + " VND");

                console.log("Tổng lợi nhuận:", formattedProfit + " VND");
            } else {
                console.error("Dữ liệu trả về không hợp lệ!");
            }
        },
        error: function(error) {
            console.error("Có lỗi xảy ra:", error);
        }
    });
});