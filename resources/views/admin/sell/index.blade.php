<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bán hàng tại quầy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            background-color: white; 
            max-width: 100%;
            min-height: 95vh;
            max-height: 100%;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            /* backdrop-filter: blur(100px); Hiệu ứng làm mờ */
            /* -webkit-backdrop-filter: blur(8px); Hỗ trợ trình duyệt Webkit */
            
        }
        .row {
            max-height: 85vh; /* Đặt chiều cao tối đa cho khu vực chứa sản phẩm */
            overflow-y: auto; /* Cho phép cuộn dọc khi có quá nhiều sản phẩm */
            scrollbar-width: none; /* Ẩn thanh cuộn trong Firefox */
            -ms-overflow-style: none; /* Ẩn thanh cuộn trong IE/Edge */
        }

        .row::-webkit-scrollbar {
            display: none; /* Ẩn thanh cuộn trong Chrome, Edge và Safari */
        }
        .product-card {
            cursor: pointer;
            transition: transform 0.2s;
        }

        .product-card:hover {
            transform: scale(1.05);
        }

        .cart-item {
            border-bottom: 1px solid #dee2e6;
        }

        .total {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .detail {
            font-size: 1rem;
            color: #495057;
        }
        .custom-tabs .nav-link {
            background-color: #ffffff; /* Màu nền trắng */
            color: #000000; /* Màu chữ đen */
            border: 1px solid #ddd; /* Đường viền */
            transition: all 0.3s ease; /* Hiệu ứng mượt */
        }

        /* Tabs khi hover */
        .custom-tabs .nav-link:hover {
            background-color: #f0f0f0; /* Màu nền khi hover */
            color: #000; /* Màu chữ đen */
        }

        /* Tabs khi active */
        .custom-tabs .nav-link.active {
            background-color: #28a745; /* Màu xanh lá cây */
            color: #fff; /* Màu chữ trắng */
            border-color: #28a745; /* Đường viền xanh lá */
        }
        
    </style>
</head>

<body>
    <div class="container mt-1">
        <div class="row mb-3 bg-white">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <!-- Tabs -->
                <div>
                    <ul class="nav nav-tabs custom-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="tab-ban-hang" data-bs-toggle="tab" data-bs-target="#sale" type="button" role="tab" aria-controls="sale" aria-selected="true">Đơn thông thường</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link " id="tab-cat-lieu" data-bs-toggle="tab" data-bs-target="#sale-cutdose" type="button" role="tab" aria-controls="sale-cutdose" aria-selected="false">Đơn cắt liều</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab-danh-sach" data-bs-toggle="tab" data-bs-target="#list" type="button" role="tab" aria-controls="list" aria-selected="false">Danh sách</button>
                        </li>
                    </ul>
                </div>
                <!-- Nút thoát -->
                <a class="btn btn-warning" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-door-open fs-4"></i>
                </a>
            </div>
        </div>

        <!-- Nội dung Tab -->
        <div class="tab-content" id="myTabContent">
            <!-- Tab Bán hàng -->
            <div class="tab-pane fade show active" id="sale" role="tabpanel" aria-labelledby="tab-ban-hang">
                <div class="row mb-3">
                    <!-- Thanh tìm kiếm -->
                    <div class="col-md-4">
                        <input type="text" id="search" class="form-control" placeholder="Tìm kiếm sản phẩm...">
                    </div>
                    <!-- Lọc danh mục -->
                    <div class="col-md-2">
                        <select id="category-filter" class="form-select">
                            <option value="">Tất cả danh mục</option>
                            <option value="Thuốc bổ">Thuốc bổ</option>
                            <option value="Kháng sinh">Kháng sinh</option>
                            <option value="Vitamin">Vitamin</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <!-- Danh sách sản phẩm -->
                    <div class="col-md-7" style="min-height: 90vh;">
                        <h4 class="mb-3 bg-white">Danh sách sản phẩm</h4>
                        <div class="row" id="product-list">
                            <!-- Sản phẩm sẽ được thêm bằng JavaScript -->
                        </div>
                    </div>

                    <!-- Giỏ hàng -->
                    <div class="col-md-5 bg-light rounded shadow-lg mt-1 mb-1">
                        <h4 class="mb-2 pt-2 text-center">Đơn thuốc</h4>
                        <form id="create-disease-form" method="POST" action="{{ route('admin.prescriptions.store') }}" class="form">
                            @csrf
                            <ul class="list-group mb-3" id="cart">
                                <!-- Sản phẩm trong giỏ hàng sẽ được thêm ở đây -->
                            </ul>
                            <div class="mb-3">
                                <label for="customer-name" class="form-label">Tên khách hàng</label>
                                <input type="text" class="form-control" id="customer-name" name="customer_name" placeholder="Nhập tên khách hàng">
                            </div>
                            <div class="mb-3">
                                <label for="dosage" class="form-label">Liều dùng</label>
                                <textarea class="form-control" id="dosage" name="dosage" rows="3" placeholder="Nhập ghi chú"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="note" class="form-label">Ghi chú</label>
                                <textarea class="form-control" id="note" name="note" rows="3" placeholder="Nhập ghi chú"></textarea>
                            </div>
                            <div class="detail mb-3" id="price-details">
                                <!-- Chi tiết tiền từng loại thuốc -->
                            </div>
                            <div class="d-flex justify-content-between total">
                                <span>Tổng cộng:</span>
                                <span id="total-price">0₫</span>
                                <input type="hidden" name="total_price" value="" id="totalPricePrescription">
                            </div>
                        
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-success w-100 mt-3 mb-2" type="submit" id="checkout-button">Tiền mặt</button>
                            </div>
                        </form>
                        <form action="">
                            <button class="btn btn-primary w-100 mt-3 mb-2" id="checkout-button">QR code</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Tab Cắt liều -->
            <div class="tab-pane fade" id="sale-cutdose" role="tabpanel" aria-labelledby="tab-cat-lieu">
                <div class="row mb-3">
                    <!-- Thanh tìm kiếm -->
                    <div class="col-md-4">
                        <input type="text" id="search" class="form-control" placeholder="Tìm kiếm sản phẩm...">
                    </div>
                    <!-- Lọc danh mục -->
                    <div class="col-md-2">
                        <select id="category-filter" class="form-select">
                            <option value="">Tất cả danh mục</option>
                            <option value="Thuốc bổ">Thuốc bổ</option>
                            <option value="Kháng sinh">Kháng sinh</option>
                            <option value="Vitamin">Vitamin</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <!-- Danh sách sản phẩm -->
                    <div class="col-md-7" style="min-height: 90vh;">
                        <h4 class="mb-3 bg-white">Danh sách sản phẩm</h4>
                        <div class="row" id="product-list-cutdose">
                            <!-- Sản phẩm sẽ được thêm bằng JavaScript -->
                        </div>
                    </div>

                    <!-- Giỏ hàng -->
                    <div class="col-md-5 bg-light rounded shadow-lg mt-1 mb-1">
                        <h4 class="mb-2 pt-2 text-center">Đơn thuốc</h4>
                        <ul class="list-group mb-3" id="dose-cart">
                            <!-- Sản phẩm trong giỏ hàng sẽ được thêm ở đây -->
                        </ul>
                        <form action="" class="form">
                            <div class="mb-3">
                                <label for="customer-name" class="form-label">Tên khách hàng</label>
                                <input type="text" class="form-control" id="customer-name" placeholder="Nhập tên khách hàng">
                            </div>
                            <div class="mb-3">
                                <label for="note" class="form-label">Ghi chú</label>
                                <textarea class="form-control" id="note" rows="3" placeholder="Nhập ghi chú"></textarea>
                            </div>
                            <div class="detail mb-3" id="dose-price-details">
                                <!-- Chi tiết tiền từng loại thuốc -->
                            </div>
                            <div class="d-flex justify-content-between total">
                                <span>Tổng cộng:</span>
                                <span id="dose-total-price">0₫</span>
                            </div>
                        
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-success w-100 mt-3 mb-2" id="checkout-button">Tiền mặt</button>
                                
                            </div>
                        </form>
                        <form action="">
                            <button class="btn btn-primary w-100 mt-3 mb-2" id="checkout-button">QR code</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Tab Danh sách -->
            <div class="tab-pane fade" id="list" role="tabpanel" aria-labelledby="tab-danh-sach">
                <h4>Danh sách</h4>
                <p>Danh sách các mặt hàng sẽ hiển thị tại đây.</p>
                <!-- Nội dung tùy chỉnh của danh sách -->
            </div>
        </div>
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script>

        let products = [];

        $.ajax({
            url: '/api/get-all-product',
            method: 'GET',
            success: function(response) {
                products = response;
                // console.log(products);

                // response.forEach((product, index) => {
                //     console.log(`${index}:`, product);
                // });

                renderProducts();
            }
        })

        const cart = [];

        // Hiển thị danh sách sản phẩm
        function renderProducts(filter = "") {
            const productList = document.getElementById("product-list");
            productList.innerHTML = "";

            const filteredProducts = products.filter(product => 
                product.name.toLowerCase().includes(filter.toLowerCase()) &&
                (!selectedCategory || product.category === selectedCategory)
            );

            filteredProducts.forEach(product => {
                const productCard = document.createElement("div");
                productCard.classList.add("col-sm-3", "sm-3");
                productCard.innerHTML = `
                    <div class="card product-card mb-3" data-id="${product.id}">
                        <img src="${product.img}" class="card-img-top" alt="${product.name}">
                        <div class="card-body text-center">
                            <h6>${product.name}(${product.quantity})</h6>
                            <p >${product.price.toLocaleString()}₫ <small class="text-muted">${product.category}</small></p>
                        </div>
                    </div>
                `;
                productCard.addEventListener("click", () => addToCart(product));
                productList.appendChild(productCard);
            });
        }

        function renderCart() {
            const cartElement = document.getElementById("cart");
            cartElement.innerHTML = "";
            let totalPrice = 0;

            cart.forEach(item => {
                const cartItem = document.createElement("li");
                cartItem.classList.add("list-group-item", "d-flex", "justify-content-between", "align-items-center", "cart-item");

                const batchOptions = item.batches.map((batch, index) => {
                    const isSelected = batch.price_in_smallest_unit === item.price;
                    return `
                        <option value="lot${index + 1}" 
                                data-quantity="${batch.quantity}" 
                                data-expiration-date="${batch.expiration_date}" 
                                data-price="${batch.price_in_smallest_unit}" 
                                ${isSelected ? "selected" : ""}>
                            Lô ${index + 1} (${batch.created_at})
                        </option>
                    `;
                }).join('');

                // Find the selected batch's quantity and expiration date
                const selectedBatch = item.batches.find(batch => batch.price_in_smallest_unit === item.price);

                cartItem.innerHTML = `
                    <div>
                        <span>${item.name}</span>
                        <input type="hidden" name="unit_id[${selectedBatch ? selectedBatch.id : ''}]" value="${item.unit_smallest}">
                        <br>
                        <small id="price-${item.id}">${item.price.toLocaleString()}₫</small>
                        <div class="d-flex align-items-center">
                            <select class="form-select form-select-sm mt-2 lot-select me-2" 
                                    onchange="updateQuantityOnLotChange(${item.id}, this)">
                                ${batchOptions}
                            </select>
                            <small class="me-2">(Tồn: ${selectedBatch ? selectedBatch.quantity : 0})</small>
                            <small class="me-2" id="expiration-date-${item.id}">
                                (HSD: ${selectedBatch ? selectedBatch.expiration_date : "N/A"})
                            </small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <button class="btn btn-sm btn-outline-secondary me-2" onclick="decreaseQuantity(${item.id})">-</button>
                        <input type="number" class="form-control form-control-sm text-center" 
                            value="${item.quantity}" 
                            min="1" 
                            name="quantity[${selectedBatch ? selectedBatch.id : ''}]"
                            onchange="updateQuantity(${item.id}, this.value)" 
                            style="width: 60px;">
                        <button class="btn btn-sm btn-outline-secondary ms-2" onclick="increaseQuantity(${item.id})">+</button>
                    </div>
                    <div>
                        <span>${(item.price * item.quantity).toLocaleString()}₫</span>
                        <button class="btn btn-sm btn-danger ms-3" onclick="removeFromCart(${item.id})">X</button>
                    </div>
                    <!-- Hidden Inputs to store batch details -->
                    <input type="hidden" name="batch_total_price[${selectedBatch ? selectedBatch.id : ''}]" value="${(item.price * item.quantity)}">
                `;

                cartElement.appendChild(cartItem);
                totalPrice += item.price * item.quantity;
            });

            document.getElementById("total-price").innerText = totalPrice.toLocaleString() + "₫";
            document.getElementById("totalPricePrescription").value = totalPrice;
        }


        // Hàm cập nhật số lượng và ngày hết hạn khi người dùng thay đổi lô
        function updateQuantityOnLotChange(itemId, selectElement) {
            const selectedOption = selectElement.selectedOptions[0];
            const newQuantity = selectedOption.getAttribute('data-quantity');
            const newPrice = parseFloat(selectedOption.getAttribute('data-price'));
            const expirationDate = selectedOption.getAttribute('data-expiration-date');

            const cartItem = cart.find(item => item.id === itemId);
            if (cartItem) {
                // Update the cart item's details
                cartItem.price = newPrice;
                cartItem.expiration_date = expirationDate;

                // Update the selected batch stock
                const quantityElement = selectElement.closest('.d-flex').querySelector('small');
                quantityElement.innerText = `(Tồn: ${newQuantity})`;

                // Update the displayed price and expiration date
                document.getElementById(`price-${itemId}`).innerText = newPrice.toLocaleString() + "₫";
                document.getElementById(`expiration-date-${itemId}`).innerText = `(HSD: ${expirationDate})`;

                // Re-render the cart to recalculate totals
                renderCart();
            }
        }

        function updateQuantity(itemId, quantity) {
            if (quantity < 1) {
                alert("Số lượng không thể nhỏ hơn 1.");
                return;
            }

            const cartItem = cart.find(item => item.id === itemId);
            if (cartItem) {
                cartItem.quantity = parseInt(quantity);

                // Cập nhật lại tổng giá trị và hiển thị
                renderCart();
            }
        }

        function updateTotalAmount() {
            // Giả sử mỗi item trong giỏ hàng có các thuộc tính 'price' (giá) và 'quantity' (số lượng)
            let totalAmount = 0;

            cartItems.forEach(item => {
                totalAmount += item.price * item.quantity; // Tính tổng tiền của từng sản phẩm
            });

            // Cập nhật lại hiển thị tổng tiền (giả sử có một phần tử với id 'totalAmount')
            document.getElementById('totalAmount').textContent = `Tổng tiền: ${totalAmount.toFixed(2)} VND`;
            
        }
        
        function addToCart(product) {
            // Lấy danh sách các lô hàng chưa được thêm vào giỏ
            const remainingBatches = product.batches.filter(batch => 
                !cart.some(item => item.id === product.id && item.price === batch.price_in_smallest_unit)
            );

            if (remainingBatches.length === 0) {
                // Nếu không còn lô nào, thông báo cho người dùng
                alert("Hết lô hàng! Không thể thêm sản phẩm này vào giỏ.");
                return;
            }

            // Chọn lô hàng mặc định (lô đầu tiên trong danh sách còn lại)
            const defaultBatch = remainingBatches[0];

            // Thêm sản phẩm vào giỏ với lô hàng mặc định
            cart.push({
                ...product,
                quantity: 1,
                price: defaultBatch.price_in_smallest_unit,
                expiration_date: defaultBatch.expiration_date
            });

            renderCart();
        }


        function increaseQuantity(productId) {
            const product = cart.find(item => item.id === productId);
            if (product) {
                product.quantity++;
                renderCart();
            }
        }

        function decreaseQuantity(productId) {
            const product = cart.find(item => item.id === productId);
            if (product && product.quantity > 1) {
                product.quantity--;
                renderCart();
            } else {
                removeFromCart(productId);
            }
        }

        function removeFromCart(productId) {
            const index = cart.findIndex(item => item.id === productId);
            if (index !== -1) {
                cart.splice(index, 1);
                renderCart();
            }
        }

        let selectedCategory = "";
        document.getElementById("category-filter").addEventListener("change", (e) => {
            selectedCategory = e.target.value;
            renderProducts(document.getElementById("search").value);
        });

        document.getElementById("search").addEventListener("input", (e) => {
            renderProducts(e.target.value);
        });

        renderProducts();


















        
        // Giỏ hàng trong tab cắt liều
        const tabCatLieu = document.getElementById('tab-cat-lieu');
        tabCatLieu.addEventListener('shown.bs.tab', function () {
            renderProducts2();
        });

        function renderProducts2(filter = "") {
            const productList = document.getElementById("product-list-cutdose");
            productList.innerHTML = "";
            
            
            const filteredProducts = products.filter(product => 
                product.name.toLowerCase().includes(filter.toLowerCase()) &&
                (!selectedCategory || product.category === selectedCategory)
            );
            console.log(filteredProducts);
            filteredProducts.forEach(product => {
                const productCard = document.createElement("div");
                productCard.classList.add("col-sm-3", "sm-3");
                productCard.innerHTML = `
                    <div class="card product-card mb-3" data-id="${product.id}">
                        <img src="${product.img}" class="card-img-top" alt="${product.name}"> 
                        <div class="card-body text-center">
                            <h6>${product.name}(${product.quantity})</h6>
                            <p >${product.price.toLocaleString()}₫ <small class="text-muted">${product.category}</small></p>
                            
                        </div>
                    </div>
                `;
                productCard.addEventListener("click", () => addToDoseCart(product));
                productList.appendChild(productCard);
            });
        }

        let doseCart = [];
        // Hiển thị giỏ hàng và chi tiết tiền trong tab cắt liều
        function renderDoseCart() {
            const cartElement = document.getElementById("dose-cart");
            const priceDetails = document.getElementById("dose-price-details");
            cartElement.innerHTML = "";
            priceDetails.innerHTML = "";
            let totalPrice = 0;

            doseCart.forEach(item => {
                const cartItem = document.createElement("li");
                cartItem.classList.add(
                    "list-group-item",
                    "d-flex",
                    "justify-content-between",
                    "align-items-center",
                    "cart-item"
                );
                cartItem.innerHTML = `
                    <div>
                        <div style="width:300px; "><span>${item.name}</span></div>
                        <br>
                        <small>${item.price.toLocaleString()}₫</small>
                        
                        <div class="d-flex align-items-center">
                            <select class="form-select form-select-sm mt-2 lot-select me-2">
                                <option value="lot1">Lô 1</option>
                                <option value="lot2">Lô 2</option>
                            </select>

                            <small class="me-2">(Tồn:1000)</small>
                            <small>(23/10/2025)</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <button class="btn btn-sm btn-outline-secondary me-2" onclick="decreaseDoseQuantity(${item.id})">-</button>
                        <input type="number" class="form-control form-control-sm text-center" value="${item.quantity}" min="1" onchange="updateDoseQuantity(${item.id}, this.value)" style="width: 60px;">
                        <button class="btn btn-sm btn-outline-secondary ms-2" onclick="increaseDoseQuantity(${item.id})">+</button>
                    </div>
                    <div>
                        <span>${(item.price * item.quantity).toLocaleString()}₫</span>
                        <button class="btn btn-sm btn-danger ms-3" onclick="removeFromDoseCart(${item.id})">X</button>
                    </div>
                `;
                cartElement.appendChild(cartItem);
                totalPrice += item.price * item.quantity;

                // Hiển thị chi tiết tiền
                const detailItem = document.createElement("div");
                detailItem.classList.add("row"); // Thêm flexbox cho chi tiết
                detailItem.innerHTML = `
                    <div class="col-4 text-start" ><span>${item.name}</span></div>
                    <div class="col-4 text-center"><span class="text-danger text-start">${item.quantity}</span></div>
                    <div class="col-4 text-end"><span>${(item.price * item.quantity).toLocaleString()}₫</span></div>
                `;
                priceDetails.appendChild(detailItem);
            });

            document.getElementById("dose-total-price").innerText = totalPrice.toLocaleString() + "₫";
        }

        function updateDoseQuantity(itemId, quantity) {
            // Kiểm tra xem số lượng có hợp lệ không (ví dụ: không nhỏ hơn 1)
            if (quantity < 1) {
                alert("Số lượng không thể nhỏ hơn 1.");
                return;
            }

            // Cập nhật số lượng cho item trong giỏ hàng
            const cartItem = doseCart.find(item => item.id === itemId);
            if (cartItem) {
                cartItem.quantity = quantity;
            }

            // Tính lại tổng tiền của giỏ hàng
            updateDoseTotalAmount();

            // Cập nhật lại giao diện nếu cần
            renderDoseCart();
        }

        function updateDoseTotalAmount() {
            let totalAmount = 0;

            doseCart.forEach(item => {
                totalAmount += item.price * item.quantity;
            });

            // Cập nhật lại hiển thị tổng tiền
            document.getElementById('dose-totalAmount').textContent = `Tổng tiền: ${totalAmount.toFixed(2)} VND`;
        }

        function addToDoseCart(product) {
            doseCart.push({ ...product, quantity: 1 });
            renderDoseCart();
        }

        function increaseDoseQuantity(productId) {
            const product = doseCart.find(item => item.id === productId);
            if (product) {
                product.quantity++;
                renderDoseCart();
            }
        }

        function decreaseDoseQuantity(productId) {
            const product = doseCart.find(item => item.id === productId);
            if (product && product.quantity > 1) {
                product.quantity--;
                renderDoseCart();
            } else {
                removeFromDoseCart(productId);
            }
        }

        function removeFromDoseCart(productId) {
            const index = doseCart.findIndex(item => item.id === productId);
            if (index !== -1) {
                doseCart.splice(index, 1);
                renderDoseCart();
            }
        }

        // Xử lý thay đổi bộ lọc danh mục trong tab cắt liều
        let selectedDoseCategory = "";
        document.getElementById("dose-category-filter").addEventListener("change", (e) => {
            selectedDoseCategory = e.target.value;
            renderProductsInDoseTab(document.getElementById("dose-search").value);
        });

        document.getElementById("dose-search").addEventListener("input", (e) => {
            renderProductsInDoseTab(e.target.value);
        });

        renderProductsInDoseTab();

    </script>
</body>

</html>