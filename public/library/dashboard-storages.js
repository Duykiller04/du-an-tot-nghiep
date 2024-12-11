$(document).ready(function() {
        
    // Gọi API để lấy dữ liệu tổng số lượng thuốc và vẽ biểu đồ tròn
    fetch('api/dashboard/storages')
        .then(response => {
            if (!response.ok) {
                throw new Error('Lỗi khi gọi API');
            }
            return response.json();
        })
        .then(data => {
            document.getElementById('totalMedicinesCount').innerText = data.total_medicines_count;

            const labels = data.storages.map(storage => storage.storage_name);
            const medicinesData = data.storages.map(storage => storage.medicines_count);

            const ctx = document.getElementById('myPieChart').getContext('2d');
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        data: medicinesData,
                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                            '#9966FF'
                        ],
                        hoverBackgroundColor: ['#FF6384', '#36A2EB', '#FFCE56',
                            '#4BC0C0', '#9966FF'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `${context.label}: ${context.raw} thuốc`;
                                }
                            }
                        }
                    }
                }
            });
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Đã xảy ra lỗi khi tải dữ liệu.');
        });


});