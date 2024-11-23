$(document).ready(function () {
    function fetchRecentOrders() {
        $.ajax({
            url: "api/dashboard/recent-orders",
            method: "GET",
            success: function (data) {
                console.log(data);
                var orderList = $("#recentOrders");
                var stt = 0;
                orderList.empty();
                data.forEach(function (order) {
                    let staffNames = order.shift.users.map(user => user.name).join(", ");
                    orderList.append(`
                <tr>
                            <td>${(stt += 1)}</td>
                            <td>       
                                    <div class="flex-grow-1">${order.customer_name}</div>
                            </td>
                            <td>${order.disease.disease_name}</td>
                            <td>
                                <span class="text-success">${order.total_price} VND</span>
                            </td>
                            <td>${staffNames}</td>
                            <td>${order.shift.shift_name}</td>
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
