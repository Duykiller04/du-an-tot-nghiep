async function fetchTopSuppliers() {
    const startDate = '01/01/2024'; // Thay đổi theo nhu cầu của bạn
    const endDate = '31/12/2024'; // Thay đổi theo nhu cầu của bạn

    try {
        const response = await fetch(
            `/api/dashboardtopsuppliers?startDate=${encodeURIComponent(startDate)}&endDate=${encodeURIComponent(endDate)}`
        );
        if (!response.ok) {
            const errorText = await response.text();
            throw new Error(`HTTP error! status: ${response.status}, message: ${errorText}`);
        }
        const data = await response.json();
        populateSuppliersTable(data.topSuppliers);
    } catch (error) {
        console.error('Error fetching top suppliers:', error);
    }
}

function populateSuppliersTable(suppliers) {
    const tableBody = document.querySelector('#suppliersTable tbody');
    tableBody.innerHTML = ''; // Xóa dữ liệu cũ

    suppliers.forEach(supplier => {
        const row = document.createElement('tr');
        const totalOrders = supplier.total_orders || 0;

        row.innerHTML = `
            <td>${supplier.supplier_name}</td>
            <td>${new Date(supplier.join_date).toLocaleDateString('vi-VN')}</td>
            <td>${totalOrders}</td>
        `;
        tableBody.appendChild(row);
    });
}

async function fetchTopMedicines() {
    const startDate = '01/01/2024'; // Thay đổi theo nhu cầu của bạn
    const endDate = '31/12/2024'; // Thay đổi theo nhu cầu của bạn

    try {
        const response = await fetch(
            `/api/dashboardtopmedicines?startDate=${encodeURIComponent(startDate)}&endDate=${encodeURIComponent(endDate)}`
        );
        if (!response.ok) {
            const errorText = await response.text();
            throw new Error(`HTTP error! status: ${response.status}, message: ${errorText}`);
        }
        const data = await response.json();
        populateMedicinesTable(data.topMedicines);
    } catch (error) {
        console.error('Error fetching top medicines:', error);
    }
}

function populateMedicinesTable(medicines) {
    const tableBody = document.querySelector('#medicinesTable tbody');
    tableBody.innerHTML = ''; // Xóa dữ liệu cũ

    medicines.forEach(medicine => {
        const row = document.createElement('tr');
        const totalOrders = medicine.total_orders || 0;

        row.innerHTML = `
            <td>${medicine.medicine_name}</td>
             <td>${new Date(medicine.import_date).toLocaleDateString('vi-VN')}</td> <!-- Thêm ngày nhập thuốc -->
            <td>${totalOrders}</td>
           
        `;
        tableBody.appendChild(row);
    });
}

// Gọi cả hai hàm khi trang được tải
window.onload = () => {
    fetchTopSuppliers();
    fetchTopMedicines();
};