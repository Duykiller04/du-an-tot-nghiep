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
    const newRow = `
    <div class="row mb-3 medicine-row">
        <div class="col-8">
            <label for="medicine_id" class="form-label">Thuốc</label>
            <select name="medicines[${index}][medicine_id]" class="form-select select2">
                 ${medicineOptions}
            </select>
        </div>

       

        <div class="col-2 d-flex align-items-end">
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


$(document).on("change", 'select[name$="[medicine_id]"]', function () {
    var $currentSelect = $(this);
    var medicineId = $currentSelect.val();
    
    // Duyệt qua tất cả các select khác và loại bỏ option trùng
    $('select[name$="[medicine_id]"]').each(function () {
        var $select = $(this);
        
        // Nếu select này không phải là cái đang thay đổi
        if ($select[0] !== $currentSelect[0]) {
            $select.find('option').each(function () {
                var $option = $(this);
                
                // Nếu giá trị của option trùng với medicineId, loại bỏ nó
                if ($option.val() === medicineId) {
                    $option.remove();
                }
            });
        }
    });
});


//render đơn vị theo id thuốc
// $(document).on("change", 'select[name$="[medicine_id]"]', function () {
//     var medicineId = $(this).val();
//     var unitLabelId = $(this)
//     .closest(".medicine-row")
//     .find('label[for="quantity"]')
//     .attr("id");
    
//         $.ajax({
//             url: `/api/get-medicine-detail/${medicineId}`,
//             method: "GET",
//             success: function (response) { 
//                 if (response.unitName) {
//                     $(`#${unitLabelId}`).text(`Số lượng (${response.unitName})`);
//                 } else {
//                     $(`#${unitLabelId}`).text("Số lượng");
//                 }
//             },
//             error: function (xhr) {
//                 console.error("Error:", xhr.responseText);
//             },
//         });
// });


