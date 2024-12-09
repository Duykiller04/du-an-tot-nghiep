$(document).ready(function() {
           

    fetch('api/dashboard/total-orders') // Đảm bảo endpoint này trả về tổng số đơn thuốc
        .then(response => response.json())
        .then(data => {
            const totalOrders = data.totalCount;
            // console.log('Tổng số đơn thuốc:', totalOrders);
            const counter = document.querySelector('.counter-value');
            counter.textContent = totalOrders;

            counter.setAttribute('data-target', totalOrders);
        })
        .catch(error => console.error('Lỗi khi tải dữ liệu:', error));



});