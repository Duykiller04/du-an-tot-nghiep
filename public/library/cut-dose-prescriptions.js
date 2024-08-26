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
document.getElementById("add-medicine").addEventListener("click", function () {
    const medicineContainer = document.getElementById("medicine-container");
    const index = medicineContainer.children.length;
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
    const newRow = `
    <div class="row mb-3 medicine-row">
        <div class="col-md-3">
            <label for="medicine_id" class="form-label">Thuốc</label>
            <select name="medicines[${index}][medicine_id]" class="form-select select2">
                 ${medicineOptions}
            </select>
        </div>

        <div class="col-md-2">
            <label for="unit_id" class="form-label">Đơn vị</label>
            <select name="medicines[${index}][unit_id]" class="form-select select2">
                ${unitOptions}
            </select>
        </div>

        <div class="col-md-2">
            <label for="quantity" class="form-label">Số lượng</label>
            <input type="number" name="medicines[${index}][quantity]" class="form-control">
        </div>

        <div class="col-md-2">
            <label for="current_price" class="form-label">Giá</label>
            <input type="number" name="medicines[${index}][current_price]" class="form-control">
        </div>

        <div class="col-md-2">
            <label for="dosage" class="form-label">Liều lượng</label>
            <input type="text" name="medicines[${index}][dosage]" class="form-control">
        </div>

        <div class="col-md-1 d-flex align-items-end">
            <button type="button" class="btn btn-danger remove-medicine">Xóa</button>
        </div>
    </div>
`;
    medicineContainer.insertAdjacentHTML("beforeend", newRow);
    initializeSelect2();
});
document.addEventListener("click", function (e) {
    if (e.target.classList.contains("remove-medicine")) {
        e.target.closest(".medicine-row").remove();
    }
});
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
                unitsSelect.empty(); // Xóa tất cả tùy chọn hiện tại
                unitsSelect.append('<option value="">Chọn đơn vị</option>');

                // Thêm đơn vị nhỏ nhất vào danh sách
                if (response.smallestUnit) {
                    unitsSelect.append(
                        `<option value="${response.smallestUnitId}">${response.smallestUnitName}</option>`
                    );
                }
                // Thêm các đơn vị lớn hơn vào danh sách
                $.each(response.units, function (id, name) {
                    unitsSelect.append(
                        `<option value="${id}">${name}</option>`
                    ); // Thêm các tùy chọn từ dữ liệu phản hồi
                });

                // Lưu giá gốc vào input để dùng cho tính toán sau này
                // Lưu giá gốc vào input để dùng cho tính toán sau này
                priceInput.data("base-price", response.pricePerLargestUnit);
                priceInput.data(
                    "smallest-price",
                    response.pricePerSmallestUnit
                );
                priceInput.data("smallest-unit-id", response.smallestUnitId);
                priceInput.data("largest-unit-id", response.largestUnitId);
                priceInput.data("unit-proportions", response.proportions); // Lưu tỷ lệ chuyển đổi từ response
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
    var selectedUnitId = $medicineRow.find('select[name$="[unit_id]"]').val(); // Lấy id đơn vị đã chọn
    var quantity = $medicineRow.find('input[name$="[quantity]"]').val(); // Lấy số lượng
    var pricePerLargestUnit = $medicineRow
        .find('input[name$="[current_price]"]')
        .data("base-price"); // Giá theo đơn vị lớn nhất
    var pricePerSmallestUnit = $medicineRow
        .find('input[name$="[current_price]"]')
        .data("smallest-price"); // Giá theo đơn vị bé nhất
    var unitProportions = $medicineRow
        .find('input[name$="[current_price]"]')
        .data("unit-proportions"); // Tỷ lệ chuyển đổi từ response
    var largestUnitId = $medicineRow
        .find('input[name$="[current_price]"]')
        .data("largest-unit-id");
    var smallestUnitId = $medicineRow
        .find('input[name$="[current_price]"]')
        .data("smallest-unit-id"); // ID của đơn vị nhỏ nhất

    var price = 0;

    if (selectedUnitId) {
        if (selectedUnitId == largestUnitId) {
            // Nếu đơn vị chọn là đơn vị lớn nhất
            price = pricePerLargestUnit * quantity;
        } else if (selectedUnitId == smallestUnitId) {
            price = pricePerSmallestUnit * quantity;
        } else {
            var proportion = unitProportions[selectedUnitId] || 1;
            price = pricePerSmallestUnit * proportion * quantity;
        }
        price = Math.round(price);

        // Cập nhật giao diện với giá đã tính
        $medicineRow.find('input[name$="[current_price]"]').val(price); // Cập nhật giá vào ô input
    } else {
        // Nếu không có đơn vị được chọn, giá hiển thị là 0
        $medicineRow.find('input[name$="[current_price]"]').val("0"); // Đặt giá là 0
    }
}
