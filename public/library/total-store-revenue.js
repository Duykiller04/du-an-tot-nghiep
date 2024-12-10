$(document).ready(function () {
    let chartInstance; // Biến lưu biểu đồ
    function updateChart(data) {
        const ctx = document.getElementById('statisticsChart').getContext('2d');

        if (chartInstance) {
            chartInstance.destroy(); // Xóa biểu đồ cũ
        }

        chartInstance = new Chart(ctx, {
            type: 'bar', // Loại biểu đồ
            data: {
                labels: ['Thống kê'], // Nhãn trục X
                datasets: [
                    {
                        label: 'Tổng đơn hàng',
                        data: [data.totalOrders], // Số lượng đơn hàng
                        backgroundColor: 'rgba(54, 162, 235, 0.6)', // Màu sắc
                    },
                    {
                        label: 'Doanh thu (VND)',
                        data: [data.totalRevenue], // Doanh thu
                        backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top', // Vị trí chú thích
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true, // Bắt đầu từ 0
                    },
                },
            },
        });
    }

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
                updateChart(response);
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