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

    // Tạo hàng thuốc mới để thêm vào danh sách
    const newRow = `
        <div class="row mb-3 medicine-row">
            <div class="col-4">
                <label for="medicine_id" class="form-label">Thuốc</label>
                <select name="medicines[${medicineIndex}][medicine_id]" class="form-select select2">
                    ${medicineOptions}
                </select>
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
