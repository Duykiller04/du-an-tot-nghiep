$(document).ready(function () {
    // hàm lấy dữ liệu từ API
    function fetchStatistics() {
        $.ajax({
            url: "api/dashboard/store-statistics",
            type: "GET",
            success: function (response) {     
               console.log(response.profit);
               
                                      
                var chart = null;  // Khởi tạo biến chart là null               
                    // Nếu chart đã tồn tại, hủy nó trước khi tạo mới
                    if (chart) {
                        chart.destroy();  // Hủy biểu đồ cũ
                    }
                    const profits = response.profit.map(value => value < 0 ? 0 : value);
                    // Cấu hình biểu đồ
                    var options = {
                        series: [
                            {
                                name: "Doanh thu",
                                data: response.revenues
                            },
                            {
                                name: "Lợi nhuận",
                                data: profits 
                            },
                        ],
                        chart: {
                            type: "bar",
                            height: 350
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: "55%",
                                borderRadius: 5
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            show: true,
                            width: 2,
                            colors: ["transparent"]
                        },
                        xaxis: {
                            categories: response.categories
                        },
                        yaxis: {
                            title: {
                                text: "Biểu đồ"
                            }
                        },
                        fill: {
                            opacity: 1
                        },
                        tooltip: {
                            y: {
                                formatter: function (val) {
                                    return val.toLocaleString("vi-VN") + " VNĐ";
                                }
                            }
                        }
                    };
                    // Render biểu đồ mới
                    chart = new ApexCharts(document.getElementById("statisticsChart"), options);
                    chart.render();
            },
            error: function (xhr) {
                console.error("Error status: " + xhr.status);
                console.error("Response text: " + xhr.responseText);
            },
        });
    }
    fetchStatistics();
});