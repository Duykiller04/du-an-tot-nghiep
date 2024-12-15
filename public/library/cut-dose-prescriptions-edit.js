function initializeSelect2() {
    $(".select2").select2({
        width: "100%", // Hoặc bất kỳ cấu hình nào bạn cần
    });
}
initializeSelect2();
let medicineIndex = document.querySelectorAll(".medicine-row").length;

document.getElementById("add-medicine").addEventListener("click", function () {
    const medicineListContainer = document.getElementById(
        "medicine-list-container"
    );

    // Kiểm tra xem phần tử medicineListContainer có tồn tại không
    if (!medicineListContainer) {
        console.error(
            "Phần tử với id 'medicine-list-container' không tồn tại."
        );
        return;
    }

    // Tạo các tùy chọn thuốc từ biến medicines
    let medicineOptions = '<option value="">Chọn thuốc</option>';
    for (const [id, name] of Object.entries(medicines)) {
        medicineOptions += `<option value="${id}">${name}</option>`;
    }

    // Tạo các tùy chọn đơn vị từ biến units
    let batchOptions = '<option value="">Chọn lô</option>';
    for (const [id, created_at] of Object.entries(batchs)) {
        const date = new Date(created_at); 

        // Định dạng ngày, tháng, năm
        const day = String(date.getDate()).padStart(2, '0'); // Ngày (2 chữ số)
        const month = String(date.getMonth() + 1).padStart(2, '0'); // Tháng (2 chữ số)
        const year = date.getFullYear(); // Năm
    
        // Định dạng giờ, phút, giây
        const hours = String(date.getHours()).padStart(2, '0'); // Giờ (2 chữ số)
        const minutes = String(date.getMinutes()).padStart(2, '0'); // Phút (2 chữ số)
        const seconds = String(date.getSeconds()).padStart(2, '0'); // Giây (2 chữ số)
    
        // Gộp lại thành định dạng đầy đủ
        const formattedDate = `${day}/${month}/${year} ${hours}:${minutes}:${seconds}`;
        batchOptions += `<option value="${id}">Lô (${formattedDate})</option>`;
    }

    // Tạo hàng thuốc mới để thêm vào danh sách
    const newRow = `
        <div class="row mb-3 medicine-row">
            <div class="col-md-3">
                <label for="medicine_id" class="form-label">Thuốc</label>
                <select name="medicines[${medicineIndex}][medicine_id]" class="form-select select2">
                    ${medicineOptions}
                </select>
            </div>

            <div class="col-md-2">
                <label for="batch_id" class="form-label">Lô</label>
                <select name="medicines[${medicineIndex}][batch_id]" class="form-select select2">
                    ${batchOptions}
                </select>
            </div>

            <div class="col-md-2">
                <label for="quantity" class="form-label">Số lượng</label>
                <input type="number" name="medicines[${medicineIndex}][quantity]" class="form-control" value="0">
            </div>

            <div class="col-md-2">
                <label for="current_price" class="form-label">Giá</label>
                <input type="number" name="medicines[${medicineIndex}][current_price]" class="form-control" value="0">
            </div>

            <div class="col-md-2">
                <label for="dosage" class="form-label">Liều lượng</label>
                <input type="text" name="medicines[${medicineIndex}][dosage]" class="form-control">
            </div>

            <div class="col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-danger remove-medicine">Xóa</button>
            </div>
        </div>
    `;
    medicineListContainer.insertAdjacentHTML("beforeend", newRow);
    initializeSelect2();

    // Tăng chỉ số toàn cục cho thuốc mới để tránh bị trùng lặp
    medicineIndex++;
});

document.addEventListener("click", function (e) {
    if (e.target.classList.contains("remove-medicine")) {
        e.target.closest(".medicine-row").remove();
    }
});

$(document).on("click", ".delete-medicine", function () {
    var medicineId = $(this).data("id");

    // Thêm input hidden để lưu ID của thuốc sẽ bị xóa
    $("form").append(
        '<input type="hidden" name="delete_medicines[]" value="' +
            medicineId +
            '">'
    );
    // Ẩn thuốc khỏi giao diện
    $("#medicine-" + medicineId).remove();
});
//render đơn vị theo id thuốc
$(document).on("change", 'select[name$="[medicine_id]"]', function () {
    var medicineId = $(this).val();
    const batchsSelect = $(this)
        .closest(".medicine-row")
        .find('select[name$="[batch_id]"]');
    const priceInput = $(this)
        .closest(".medicine-row")
        .find('input[name$="[current_price]"]');
    
    if (medicineId) {
        $.ajax({
            url: `/api/get-batchs/${medicineId}`,
            method: "GET",
            success: function (response) {              
                batchsSelect.empty(); // Xóa tất cả tùy chọn hiện tại
                batchsSelect.append('<option value="">Chọn lô</option>');
                
                //  Thêm các lô vào danh sách
                $.each(response.batchs, function (index, batch) {
                    
                    const date = new Date(batch.created_at); 

                    // Định dạng ngày theo định dạng 'd/m/Y'
                    const day = String(date.getDate()).padStart(2, '0'); // Ngày (2 chữ số)
                    const month = String(date.getMonth() + 1).padStart(2, '0'); // Tháng (2 chữ số)
                    const year = date.getFullYear(); // Năm
                    // Định dạng giờ, phút, giây
                    const hours = String(date.getHours()).padStart(2, '0'); // Giờ (2 chữ số)
                    const minutes = String(date.getMinutes()).padStart(2, '0'); // Phút (2 chữ số)
                    const seconds = String(date.getSeconds()).padStart(2, '0'); // Giây (2 chữ số)
                    priceInput.data("smallest_price", batch.price_in_smallest_unit);
                    const formattedDate = `${day}/${month}/${year} ${hours}:${minutes}:${seconds}`;
                    batchsSelect.append(
                        `<option value="${batch.id}">Lô ${formattedDate}</option>`
                    );
                });                

            },
            error: function (xhr) {
                console.error("Error:", xhr.responseText);
            },
        });
    } else {
        batchsSelect.empty();
        batchsSelect.append('<option value="">Chọn lô</option>');
    }
});
$(document).on("change", 'select[name$="[batch_id]"]', function () {
    console.log(123);
    
    const $medicineRow = $(this).closest(".medicine-row");

    // Kiểm tra xem new_prices đã có dữ liệu chưa
    const priceInput = $medicineRow.find('input[name$="[current_price]"]');
    const smallest_price = priceInput.data("smallest_price");

    if (!smallest_price) {
        // Nếu chưa có new_prices, thực hiện gọi API để lấy lại
        const medicineId = $medicineRow
            .find('select[name$="[medicine_id]"]')
            .val();

        if (medicineId) {
            $.ajax({
                url: `/api/get-batchs/${medicineId}`,
                method: "GET",
                success: function (response) {
                    $.each(response.batchs, function (index, batch) {
                        const date = new Date(batch.created_at); 
    
                        // Định dạng ngày theo định dạng 'd/m/Y'
                        const day = String(date.getDate()).padStart(2, '0'); // Ngày (2 chữ số)
                        const month = String(date.getMonth() + 1).padStart(2, '0'); // Tháng (2 chữ số)
                        const year = date.getFullYear(); // Năm
                        const formattedDate = `${day}/${month}/${year}`;
                        priceInput.data("smallest_price", batch.price_in_smallest_unit);
                        batchsSelect.append(
                            `<option value="${batch.id}">Lô ${formattedDate}</option>`
                        );
                    });    
                    
                    updatePrice($medicineRow);
                },
                error: function (xhr) {
                    console.error(
                        "Error fetching new prices:",
                        xhr.responseText
                    );
                },
            });
        }
    } else {
        // Nếu đã có new_prices, chỉ cần tính toán lại giá
        updatePrice($medicineRow);
    }
});
// Khi thay đổi số lượng
$(document).on("input", 'input[name$="[quantity]"]', function () {
    updatePrice($(this).closest(".medicine-row"));
});

function updatePrice($medicineRow) {
    var quantity = $medicineRow.find('input[name$="[quantity]"]').val();

    // Lấy new_prices từ data của priceInput
    var priceInput = $medicineRow.find('input[name$="[current_price]"]');
    var smallest_price = priceInput.data("smallest_price");
    var price = smallest_price * quantity;
    price = parseFloat(price).toFixed(2); // Làm tròn giá trị sau 2 số thập phân

    $medicineRow.find('input[name$="[current_price]"]').val(price);
}
