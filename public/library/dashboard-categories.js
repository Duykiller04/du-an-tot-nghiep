$(document).ready(function() {
           
    $.ajax({
        url: "{{ route('dashboard-categories') }}",
        method: "GET",
        success: function(data) {
            const options = {
                chart: {
                    type: 'donut',
                    height: 230,
                },
                series: data.map(item => item.count),
                labels: data.map(item => item.name),
                colors: ['#5A8DEE', '#f46a6a', '#34c38f', '#f7b84b', '#50a5f1'],
                legend: {
                    show: false
                },
            };
            const chart = new ApexCharts(document.querySelector("#store-visits-source"),
                options);
            chart.render();

            // Tạo phần legend tùy chỉnh
            let legendHTML = '<div class="row justify-content-center">';
            data.forEach((item, index) => {
                if (index % 4 === 0 && index !== 0) {
                    legendHTML += '</div><div class="row justify-content-center">';
                }
                legendHTML += `
                    <div class="col-3 text-center legend-item" data-index="${index}" style="cursor: pointer; font-size: 8px;">
                        <span style="color: ${options.colors[index]}; display: inline-block; width: 10px; height: 10px; border-radius: 50%; background-color: ${options.colors[index]};"></span>
                        ${item.name}
                    </div>
                `;
            });
            legendHTML += '</div>';
            $('#category-legend').html(legendHTML);

            // Sự kiện hover cho legend
            $('.legend-item').on('mouseover', function() {
                const index = $(this).data('index');
                chart.toggleSeries(chart.w.globals.seriesNames[index]);
            }).on('mouseleave', function() {
                const index = $(this).data('index');
                chart.toggleSeries(chart.w.globals.seriesNames[index]);
            });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Có lỗi xảy ra khi lấy dữ liệu:", textStatus, errorThrown);
        }
    });

});