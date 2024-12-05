$(document).ready(function () {
    function fetchRecentOrders() {
        $.ajax({
            url: "api/dashboard/recent-orders",
            method: "GET",
            success: function (data) {
                var orderList = $("#recentOrders");
                var stt = 0;
                orderList.empty();

                 // Sử dụng Intl.NumberFormat để định dạng tiền tệ
                 const currencyFormatter = new Intl.NumberFormat("vi-VN", {
                    style: "currency",
                    currency: "VND",
                });

                data.forEach(function (order) {
                    let formattedPrice = currencyFormatter.format(order.total_price); // Định dạng giá tiền
                    orderList.append(`
                <tr>
                            <td>${(stt += 1)}</td>
                            <td>       
                                    <div class="flex-grow-1">${order.customer_name}</div>
                            </td>
                            <td>${order.disease.disease_name}</td>
                            <td>
                                <span class="text-success">${formattedPrice}</span>
                            </td>
                            <td>${order.seller}</td>
                </tr>
                            `);
                });
            },
            error: function (xhr) {
                console.error("Error: " + xhr.responseText);
            },
        });
    }
    fetchRecentOrders();
});
