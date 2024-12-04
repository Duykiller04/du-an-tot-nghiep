import './bootstrap';


// Hàm định dạng số với "VND" ở cuối
function formatCurrency(amount) {
    return new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND',
        minimumFractionDigits: 0,
    }).format(amount).replace('VND'); 
}

// Lắng nghe sự kiện
window.Echo.channel('shift.' + shiftId)
    .listen('RevenueUpdated', function (data) {
        console.log('Doanh thu đã được cập nhật:', data.revenueSummary);

        const revenueElement = document.getElementById('total-revenue');
        revenueElement.textContent = formatCurrency(data.revenueSummary);
    });
