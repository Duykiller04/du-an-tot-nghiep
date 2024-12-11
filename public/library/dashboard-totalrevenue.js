$(document).ready(function() {
           

    // Gửi yêu cầu API lấy dữ liệu tổng doanh thu
    fetch('api/dashboard/total-revenue')
        .then(response => response.json())
        .then(data => {
            document.querySelector('#totalRevenue').textContent = data.totalRevenue;
        })
        .catch(error => console.error('Lỗi:', error));


});