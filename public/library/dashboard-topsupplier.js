$(document).ready(function () {
    // Xử lý sự kiện khi chọn loại thời gian
    $("#timeFilter").on("change", function () {
        let type = $(this).val(); // Lấy giá trị type từ dropdown
        fetchTopSuppliers(type); // Gọi hàm fetchTopSuppliers
    });

    // Hàm gọi API để lấy danh sách top nhà cung cấp
    function fetchTopSuppliers(type) {
        $.ajax({
            url: "api/dashboardtopsuppliers", // Đường dẫn API
            method: "GET", // Sử dụng GET
            data: { type: type }, // Gửi type lên server
            beforeSend: function () {
                $("#supplierList").html("<p>Đang tải dữ liệu...</p>");
            },
            success: function (response) {
                if (response.topSuppliers && response.topSuppliers.length > 0) {
                    let html = "";
                    response.topSuppliers.forEach((supplier, index) => {
                        html += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${supplier.supplier_name}</td>
                                <td>${new Date(supplier.join_date).toLocaleDateString("vi-VN")}</td>
                                <td>${supplier.total_orders}</td>
                            </tr>`;
                    });
                    $("#supplierList").html(html);
                } else {
                    $("#supplierList").html("<p>Không có dữ liệu.</p>");
                }
            },
            error: function (xhr, status, error) {
                console.error("Lỗi:", error);
                $("#supplierList").html(
                    "<p>Đã xảy ra lỗi khi tải dữ liệu.</p>"
                );
            },
        });
    }

    // Gọi hàm ban đầu với loại thời gian mặc định (today)
    fetchTopSuppliers("today");
});