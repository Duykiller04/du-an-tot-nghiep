$(document).ready(function () {
    // Gọi hàm ban đầu để lấy danh sách thuốc
    fetchTopMedicines();

    // Hàm gọi API để lấy danh sách top thuốc
    function fetchTopMedicines() {
        $.ajax({
            url: "/api/dashboardtopmedicines", // Đường dẫn API
            method: "GET",
            beforeSend: function () {
                $("#medicinesTable tbody").html(
                    "<tr><td colspan='4'>Đang tải dữ liệu...</td></tr>"
                );
            },
            success: function (response) {
                populateMedicinesTable(response.topMedicines);
            },
            error: function (xhr) {
                console.error("Lỗi:", xhr);
                $("#medicinesTable tbody").html(
                    "<tr><td colspan='4'>Đã xảy ra lỗi khi tải dữ liệu.</td></tr>"
                );
            },
        });
    }

    // Hàm để điền dữ liệu vào bảng thuốc
    function populateMedicinesTable(medicines) {
        const tableBody = $("#medicinesTable tbody");
        tableBody.empty(); // Xóa dữ liệu cũ

        if (medicines && medicines.length > 0) {
            medicines.forEach((medicine, index) => {
                const totalOrders = medicine.total_orders || 0;
                const joinDate = medicine.join_date 
                    ? new Date(medicine.join_date).toLocaleDateString("vi-VN") 
                    : "N/A"; // Xử lý trường hợp join_date bị null

                const row = `
                    <tr>
                        <td>${index + 1}</td> <!-- STT -->
                        <td>${medicine.medicine_name}</td>
                        <td>${joinDate}</td> <!-- Ngày nhập thuốc -->
                        <td>${totalOrders}</td>
                    </tr>`;
                tableBody.append(row);
            });
        } else {
            tableBody.html("<tr><td colspan='4'>Không có dữ liệu.</td></tr>");
        }
    }
});
