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
    const oldMedicine = oldData[index] || {};

    let medicineOptions = '<option value="">Chọn thuốc</option>';
    for (const [id, name] of Object.entries(medicines)) {
        const medicineSelected = oldMedicine.medicine_id == id ? "selected" : "";
        medicineOptions += `<option value="${id}" ${medicineSelected}>${name}</option>`;
    }
    // Tạo các tùy chọn lô từ biến batchs 
    let batchOptions = '<option value="">Chọn lô</option>';
    for (const [id, created_at] of Object.entries(batchs)) {
        const batchSelected = oldMedicine.batch_id  == id ? "selected" : ""; 
      // Chuyển chuỗi created_at thành đối tượng Date
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
        batchOptions += `<option value="${id}" ${batchSelected}>Lô (${formattedDate})</option>`;
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
            <label for="batch_id" class="form-label">Chọn lô</label>
            <select name="medicines[${index}][batch_id]" class="form-select select2">
                ${batchOptions}
            </select>
        </div>

        <div class="col-md-2">
            <label for="quantity" class="form-label">Số lượng</label>
            <input type="number" name="medicines[${index}][quantity]" class="form-control" value="${oldMedicine.quantity || 0}">
        </div>

        <div class="col-md-2">
            <label for="current_price" class="form-label">Giá</label>
            <input type="number" name="medicines[${index}][current_price]" class="form-control" value="${oldMedicine.current_price || 0}">
        </div>

        <div class="col-md-2">
            <label for="dosage" class="form-label">Liều lượng</label>
            <input type="text" name="medicines[${index}][dosage]" class="form-control" value="${oldMedicine.dosage || ''}">
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
// Khi thay đổi đơn vị
$(document).on("change", 'select[name$="[batch_id]"]', function () {
    updatePrice($(this).closest(".medicine-row"));
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
