$(document).ready(function () {
    // hàm lấy dữ liệu từ API
    function fetchStatistics(type = "day") {
        $.ajax({
            url: "api/dashboard/store-statistics",
            type: "GET",
            data: { type: type },
            success: function (response) {                
                const currencyFormatter = new Intl.NumberFormat("vi-VN", {
                    style: "currency",
                    currency: "VND",
                });
                let formattedPrice = currencyFormatter.format(response.totalRevenue); // Định dạng giá tiền
                $("#totalStoreOrders").text(response.totalOrders);
                $("#totalRevenueOrders").text(formattedPrice);
            },
            error: function (xhr) {
                console.error("Error status: " + xhr.status);
                console.error("Response text: " + xhr.responseText);
            },
        });
    }
   
    $(".btn-timeFrame").on("click", function () {
        var type = $(this).data("type");
        // Xóa lớp selected khỏi tất cả các button
        $(".btn-timeFrame").removeClass("selected");

        // Thêm lớp selected vào button được nhấp
        $(this).addClass("selected");
        fetchStatistics(type);
    }); 
    fetchStatistics();
});