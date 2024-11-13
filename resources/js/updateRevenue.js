import './bootstrap';



window.Echo.channel('shift.' + shiftId)
    .listen('RevenueUpdated', function(data) {
        console.log('Doanh thu đã được cập nhật:', data.revenueSummary);
        document.getElementById('total-revenue').textContent = data.revenueSummary;
    });
