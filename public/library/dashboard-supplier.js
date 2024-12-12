$(document).ready(function () {
    let chartInstance;

    $.ajax({
        url: "api/dashboard/suppliers",
        method: "GET",
        success: function (data) {
            const ctx = document.getElementById("supplierChartCanvas").getContext("2d");
            if (chartInstance) {
                chartInstance.destroy(); // Xóa biểu đồ cũ
            }
            // Chuẩn bị dữ liệu cho biểu đồ
            const labels = data.map(supplier => supplier.supplier_name);
            const percentages = data.map(supplier => supplier.percentage);

            // Gán màu sắc tự động cho các phần
            const colors = labels.map(() =>
                `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(
                    Math.random() * 255
                )}, ${Math.floor(Math.random() * 255)}, 0.7)`
            );

            // Tạo biểu đồ tròn
            chartInstance = new Chart(ctx, {
                type: "pie",
                data: {
                    labels: labels, // Tên các nhà cung cấp
                    datasets: [
                        {
                            data: percentages, // Dữ liệu tỷ lệ phần trăm
                            backgroundColor: colors, // Màu sắc cho mỗi phần
                            borderWidth: 1,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: "top",
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    const label = context.label || "";
                                    const value = context.raw || 0;
                                    return `${label}: ${value.toFixed(2)}%`;
                                },
                            },
                        },
                    },
                },
            });
        },
        error: function (xhr) {
            console.error("Error fetching supplier data:", xhr.responseText);
        },
    });
});


