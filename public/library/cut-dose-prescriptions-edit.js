// ClassicEditor.create(document.querySelector('#dosage'))
//     .catch(error => {
//         console.error(error);
//     });

function initializeSelect2() {
    $(".select2").select2({
        width: "100%", // Hoặc bất kỳ cấu hình nào bạn cần
    });
}
initializeSelect2();
// Tạo biến để theo dõi chỉ số toàn cục cho các thuốc mới thêm
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
    let unitOptions = '<option value="">Chọn đơn vị</option>';
    for (const [id, name] of Object.entries(units)) {
        unitOptions += `<option value="${id}">${name}</option>`;
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
                <label for="unit_id" class="form-label">Đơn vị</label>
                <select name="medicines[${medicineIndex}][unit_id]" class="form-select select2">
                    ${unitOptions}
                </select>
            </div>

            <div class="col-md-2">
                <label for="quantity" class="form-label">Số lượng</label>
                <input type="number" name="medicines[${medicineIndex}][quantity]" class="form-control">
            </div>

            <div class="col-md-2">
                <label for="current_price" class="form-label">Giá</label>
                <input type="number" name="medicines[${medicineIndex}][current_price]" class="form-control">
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
let largest_price; //Giá theo đơn vị lớn nhất

//render đơn vị theo id thuốc
$(document).on("change", 'select[name$="[medicine_id]"]', function () {
    var medicineId = $(this).val();
    const unitsSelect = $(this)
        .closest(".medicine-row")
        .find('select[name$="[unit_id]"]');
    const priceInput = $(this)
        .closest(".medicine-row")
        .find('input[name$="[current_price]"]');

    if (medicineId) {
        $.ajax({
            url: `/api/get-units/${medicineId}`,
            method: "GET",
            success: function (response) {
                console.log(response);

                unitsSelect.empty(); // Xóa tất cả tùy chọn hiện tại
                unitsSelect.append('<option value="">Chọn đơn vị</option>');

                // Thêm các đơn vị vào danh sách
                $.each(response.units, function (index, unit) {
                    unitsSelect.append(
                        `<option value="${unit.id}">${unit.name}</option>`
                    );
                });

                // Lưu giá gốc vào input để dùng cho tính toán sau này
                priceInput.data("new_prices", response.newPrices);

                largest_price = response.price_sale; // Lưu giá bán lớn nhất
            },
            error: function (xhr) {
                console.error("Error:", xhr.responseText);
            },
        });
    } else {
        unitsSelect.empty();
        unitSelect.append('<option value="">Chọn đơn vị</option>');
    }
});
// Khi thay đổi đơn vị
$(document).on("change", 'select[name$="[unit_id]"]', function () {
    updatePrice($(this).closest(".medicine-row"));
});

// Khi thay đổi số lượng
$(document).on("input", 'input[name$="[quantity]"]', function () {
    updatePrice($(this).closest(".medicine-row"));
});

function updatePrice($medicineRow) {
    var selectedUnitId = $medicineRow.find('select[name$="[unit_id]"]').prop("selectedIndex") - 1;

    var quantity = $medicineRow.find('input[name$="[quantity]"]').val();

    // Lấy new_prices từ data của priceInput
    var priceInput = $medicineRow.find('input[name$="[current_price]"]');
    var new_prices = priceInput.data("new_prices");

    var gia_ban = new_prices[selectedUnitId] || 0; // Kiểm tra giá trị của new_prices
    console.log(new_prices);

    if (gia_ban === 0) {
        var gia_ban = largest_price;
    }
    var price = gia_ban * quantity;
    price = parseFloat(price).toFixed(2); // Làm tròn giá trị sau 2 số thập phân

    $medicineRow.find('input[name$="[current_price]"]').val(price);
}
