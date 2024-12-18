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
    const newRow = `
    <div class="row mb-3 medicine-row">
        <div class="col-4">
            <label for="medicine_id" class="form-label">Thuốc</label>
            <select name="medicines[${index}][medicine_id]" class="form-select select2">
                 ${medicineOptions}
            </select>
        </div>

        <div class="col-3">
            <label for="quantity" class="form-label" id="unitLabel-${index}">Số lượng</label>
            <input type="number" name="medicines[${index}][quantity]" class="form-control" value="${oldMedicine.quantity || 0}">
        </div>

        <div class="col-4">
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
    var unitLabelId = $(this)
    .closest(".medicine-row")
    .find('label[for="quantity"]')
    .attr("id");
    
        $.ajax({
            url: `/api/get-medicine-detail/${medicineId}`,
            method: "GET",
            success: function (response) { 
                if (response.unitName) {
                    $(`#${unitLabelId}`).text(`Số lượng (${response.unitName})`);
                } else {
                    $(`#${unitLabelId}`).text("Số lượng");
                }
            },
            error: function (xhr) {
                console.error("Error:", xhr.responseText);
            },
        });
});


