function initializeSelect2() {
    $(".select2").select2({
        width: "100%",
    });
}
initializeSelect2();

document.getElementById("add-medicine").addEventListener("click", function () {
    const medicineContainer = document.getElementById("medicine-container");
    const index = medicineContainer.children.length; // Đếm số hàng hiện có để xác định chỉ số mới

    // Option thuốc
    let medicineOptions = '<option value="">Chọn thuốc</option>';
    for (const [id, name] of Object.entries(medicines)) {
        medicineOptions += `<option value="${id}">${name}</option>`;
    }

    // Option đơn vị
    let unitOptions = '<option value="">Chọn đơn vị</option>';
    for (const [id, name] of Object.entries(units)) {
        unitOptions += `<option value="${id}">${name}</option>`;
    }

    const newRow = `
    <div class="row mb-3 medicine-row">
        <div class="col-md-2">
            <label for="medicine_id" class="form-label">Thuốc</label>
            <select name="medicines[${index}][medicine_id]" class="form-select select2">
                ${medicineOptions}
            </select>
            <div class="text-danger" id="error-medicine-${index}"></div>
        </div>

        <div class="col-md-2">
            <label for="unit_id" class="form-label">Đơn vị</label>
            <select name="medicines[${index}][unit_id]" class="form-select select2">
                ${unitOptions}
            </select>
            <div class="text-danger" id="error-unit-${index}"></div>
        </div>

        <div class="col-md-1">
            <label for="quantity_storage" class="form-label">Tồn kho</label>
            <input type="number" name="medicines[${index}][quantity_storage]" class="form-control" disabled>
        </div>

        <div class="col-md-2">
            <label for="quantity" class="form-label">Số lượng bán</label>
            <input type="number" name="medicines[${index}][quantity]" class="form-control" min="1" value="1">
            <div class="text-danger" id="error-quantity-${index}"></div>
        </div>

        <div class="col-md-2">
            <label for="dosage" class="form-label">Liều lượng</label>
            <input type="text" name="medicines[${index}][dosage]" class="form-control">
            <div class="text-danger" id="error-dosage-${index}"></div>
        </div>

        <div class="col-md-2">
            <label for="current_price" class="form-label">Thành tiền</label>
            <input type="number" name="medicines[${index}][current_price]" class="form-control">
            <div class="text-danger" id="error-price-${index}"></div>
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
        updateTotalPrice();
    }
});

let largest_price; // Giá theo đơn vị lớn nhất

// Thay đổi thuốc
$(document).on("change", 'select[name$="[medicine_id]"]', function () {
    const $medicineRow = $(this).closest(".medicine-row");
    const unitsSelect = $medicineRow.find('select[name$="[unit_id]"]');
    const priceInput = $medicineRow.find('input[name$="[current_price]"]');
    const quantityStorageInput = $medicineRow.find('input[name$="[quantity_storage]"]');
    const quantityInput = $medicineRow.find('input[name$="[quantity]"]');

    // Reset kho và số lượng bán
    quantityStorageInput.val('');
    quantityInput.val('');
    priceInput.val('');

    var medicineId = $(this).val();
    if (medicineId) {
        $.ajax({
            url: `/api/cut-dose-order/${medicineId}`,
            method: "GET",
            success: function (response) {
                unitsSelect.empty(); // Xoá các option hiện tại
                unitsSelect.append('<option value="">Chọn đơn vị</option>');

                // Thêm option đơn vị
                $.each(response.units, function (index, unit) {
                    unitsSelect.append(
                        `<option value="${unit.id}">${unit.name}</option>`
                    );
                });

                // Lưu giá gốc để tính toán sau
                priceInput.data("new_prices", response.newPrices);

                // Lưu số lượng theo đơn vị để tính toán sau
                priceInput.data("new_quantity", response.quantity);

                largest_price = response.price_sale; // Giá lớn nhất
            },
            error: function (xhr) {
                console.error("Error:", xhr.responseText);
            },
        });
    } else {
        unitsSelect.empty();
        unitsSelect.append('<option value="">Chọn đơn vị</option>');
    }
    updateTotalPrice();
});

// Khi thay đổi đơn vị
$(document).on("change", 'select[name$="[unit_id]"]', function () {
    const $medicineRow = $(this).closest(".medicine-row");
    const selectedUnitIndex = $(this).prop("selectedIndex") - 1;

    const priceInput = $medicineRow.find('input[name$="[current_price]"]');
    const newPrices = priceInput.data("new_prices");
    const quantityStorageInput = $medicineRow.find('input[name$="[quantity_storage]"]');
    const newQuantities = priceInput.data("new_quantity"); // nhận số lượng mới từ response

    // Cập nhật số lượng tồn dựa trên đơn vị đã chọn
    if (newQuantities && selectedUnitIndex >= 0) {
        const stockQuantity = newQuantities[selectedUnitIndex];
        quantityStorageInput.val(stockQuantity); // Đặt số lượng hàng tồn kho

        // Đặt lại số lượng dựa trên tồn kho
        if (stockQuantity > 0) {
            $medicineRow.find('input[name$="[quantity]"]').val(1); // Đặt lại thành 1 nếu số lượng bán > 0
        } else {
            $medicineRow.find('input[name$="[quantity]"]').val(0); // Đặt lại thành 0 nếu số lượng bán = 0
        }

        $medicineRow.find('input[name$="[quantity]"]').attr("max", stockQuantity); // Đặt giá trị tối đa cho số lượng đầu vào
    } else {
        quantityStorageInput.val(''); // Xóa nếu không chọn đơn vị
    }

    updatePrice($medicineRow); // Cập nhật giá
    updateTotalPrice();
});

// Khi thay đổi số lượng bán
$(document).on("input", 'input[name$="[quantity]"]', function () {
    const $medicineRow = $(this).closest(".medicine-row");
    const stockQuantity = $medicineRow.find('input[name$="[quantity_storage]"]').val();

    // Áp dụng giới hạn số lượng tối thiểu và tối đa
    const inputQuantity = $(this).val();
    if (inputQuantity < 1) {
        $(this).val(1); // Đặt lại thành 1 nếu nhỏ hơn 1
    } else if (parseInt(inputQuantity) > parseInt(stockQuantity)) {
        $(this).val(stockQuantity); // Đặt lại số lượng hàng tồn kho nếu vượt quá
    }

    updatePrice($medicineRow);
    updateTotalPrice();
});

function updatePrice($medicineRow) {
    const selectedUnitId = $medicineRow.find('select[name$="[unit_id]"]').prop("selectedIndex") - 1;
    const quantity = $medicineRow.find('input[name$="[quantity]"]').val();

    const priceInput = $medicineRow.find('input[name$="[current_price]"]');
    const newPrices = priceInput.data("new_prices");

    const unitPrice = newPrices[selectedUnitId] || 0; // Kiểm tra giá trị của newPrices
    let price = unitPrice * quantity;
    price = parseFloat(price).toFixed(2); // Làm tròn đến 2 chữ số thập phân

    $medicineRow.find('input[name$="[current_price]"]').val(price);

    updateTotalPrice();
}


//Tính tổng tiền
function updateTotalPrice() {
    let totalPrice = 0;

    $('.medicine-row').each(function () {
        const currentPrice = $(this).find('input[name$="[current_price]"]').val();
        totalPrice += parseFloat(currentPrice) || 0;
    });

    // Cập nhật input
    $('input[name="total_price"]').val(totalPrice.toFixed(2));
}

// Thêm sự kiện input cho input thành tiền
// Không cho nhập số âm vào input thành tiền và xử lý trường hợp xóa trắng
$(document).on("input", 'input[name$="[current_price]"]', function () {
    const value = parseFloat($(this).val());
    if (isNaN(value) || value < 0) {
        $(this).val(0); // Đặt lại giá trị thành 0 nếu nhập số âm hoặc xóa trắng
    }
    updateTotalPrice(); // Cập nhật tổng tiền
});



