<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bán hàng tại quầy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('/theme/client/assets/css/custom.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    @if (Session::has('error') || Session::has('success'))
        @include('admin.layouts.partials.notification')
    @endif

    <div class="container mt-1">
        <div class="row mb-3 bg-white">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <!-- Tabs -->
                <div>
                    <ul class="nav nav-tabs custom-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="tab-ban-hang" data-bs-toggle="tab"
                                data-bs-target="#sale" type="button" role="tab" aria-controls="sale"
                                aria-selected="true">Đơn thông thường</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link " id="tab-cat-lieu" data-bs-toggle="tab"
                                data-bs-target="#sale-cutdose" type="button" role="tab"
                                aria-controls="sale-cutdose" aria-selected="false">Đơn cắt liều</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab-danh-sach" data-bs-toggle="tab" data-bs-target="#list"
                                type="button" role="tab" aria-controls="list" aria-selected="false">Danh
                                sách</button>
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
                        <input type="text" id="search1" class="form-control" placeholder="Tìm kiếm sản phẩm...">
                    </div>
                    <!-- Lọc danh mục -->
                    <div class="col-md-2">
                        <select id="category-filter1" class="form-select">
                            <option value="">Tất cả danh mục</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->name }}">{{ $category->name }}</option>
                            @endforeach
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
                        <form id="create-disease-form" method="POST" action="{{ route('admin.prescriptions.store') }}"
                            class="form">
                            @csrf
                            <div class="mb-3 mt-3">
                                <label for="cutDosePrescription" class="form-label">Đơn thuốc mẫu</label>
                                <select name="cutDosePrescription" id="cutDosePrescription" class="form-select select2 @error('cutDosePrescription') is-invalid @enderror">
                                    <option value="">Chọn mẫu đơn thuốc</option>
                                    @foreach ($cutDosePrescription as $prescription)
                                        <option value="{{ $prescription['id'] }}" {{ old('cutDosePrescription') == $prescription['id'] ? 'selected' : '' }}>
                                            {{ $prescription['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <ul class="list-group mb-3" id="cart">
                                <!-- Sản phẩm trong giỏ hàng sẽ được thêm ở đây -->
                            </ul>
                            <div class="mb-3">
                                <label for="customer-name" class="form-label">Tên khách hàng</label>
                                <input type="text" class="form-control" id="customer-name" name="customer_name"
                                    placeholder="Nhập tên khách hàng">
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
                                <button class="btn btn-success w-100 mt-3 mb-2" type="submit"
                                    id="checkout-button">Tiền mặt</button>
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
                        <input type="text" id="search2" class="form-control"
                            placeholder="Tìm kiếm sản phẩm...">
                    </div>
                    <!-- Lọc danh mục -->
                    <div class="col-md-2">
                        <select id="category-filter2" class="form-select">
                            <option value="">Tất cả danh mục</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->name }}">{{ $category->name }}</option>
                            @endforeach
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
                        <form id="create-disease-form" method="POST"
                            action="{{ route('admin.cutDoseOrders.store') }}" class="form">
                            @csrf
                            <ul class="list-group mb-3" id="dose-cart">
                                <!-- Sản phẩm trong giỏ hàng sẽ được thêm ở đây -->
                            </ul>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="customer-name-dose" class="form-label">Tên khách hàng <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="customer-name-dose" name="customer_name"
                                        placeholder="Nhập tên khách hàng" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="age-dose" class="form-label">Tuổi <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="age-dose" name="age"
                                        placeholder="Nhập tuổi" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="phone-dose" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="phone-dose" name="phone"
                                        placeholder="Nhập số điện thoại" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="address-dose" class="form-label">Địa chỉ <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="address-dose" name="address"
                                        placeholder="Nhập Địa chỉ" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="weight-dose" class="form-label">Cân nặng <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="weight-dose" name="weight"
                                        placeholder="Nhập cân nặng" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email-dose" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email-dose" name="email"
                                        placeholder="Nhập email" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="gender-dose" class="form-label">Giới tính <span class="text-danger">*</span></label><br>
                                    <div class="form-check form-check-inline ms-2">
                                        <input class="form-check-input" type="radio" name="gender" id="gender-dose-male" value="0" required>
                                        <label class="form-check-label" for="gender-dose-male">Nam</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="gender-dose-female" value="1" required>
                                        <label class="form-check-label" for="gender-dose-female">Nữ</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="disisease" class="form-label">Chọn bệnh <span class="text-danger">*</span></label>
                                    <select class="form-select" id="disisease" name="disisease" required>
                                        <option value="">Chọn bệnh</option>
                                        @foreach ($disisease as $item)
                                            <option value="{{ $item->id }}">{{ $item->disease_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="dosage" class="form-label">Liều dùng</label>
                                <textarea class="form-control" id="dosage" name="dosage" rows="3" placeholder="Nhập ghi chú"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="note-dose" class="form-label">Ghi chú</label>
                                <textarea class="form-control" id="note-dose" name="note" rows="3" placeholder="Nhập ghi chú"></textarea>
                            </div>
                            <div class="detail mb-3" id="dose-price-details">
                                <!-- Chi tiết tiền từng loại thuốc -->
                            </div>
                            <div class="d-flex justify-content-between total">
                                <span>Tổng cộng:</span>
                                <span id="dose-total-price">0₫</span>
                                <input type="hidden" name="total_price" value="" id="totalPriceDose">
                            </div>

                            <div class="d-flex justify-content-between">
                                <button class="btn btn-success w-100 mt-3 mb-2" type="submit"
                                    id="checkout-button">Tiền mặt</button>
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
                <h4 class="mb-3">Danh sách đơn hàng hôm nay</h4>
                <table class="table table-bordered table-hover" id="invoice-table">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Tên khách hàng</th>
                            <th>Tổng tiền</th>
                            <th>Thời gian tạo</th>
                            <th>Loại đơn thuốc</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dữ liệu từ API sẽ được thêm ở đây -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script>
        //Sửa chữa
        $('#cutDosePrescription').on('change', function () {
            var prescriptionId = $(this).val(); // Lấy ID đơn thuốc mẫu được chọn
            var selectedPrescription = @json($cutDosePrescription);

            var medicineIds = []; // Mảng để lưu ID của thuốc trong đơn thuốc mẫu
            
            // Lấy danh sách `medicineIds` từ đơn thuốc mẫu
            selectedPrescription.forEach(function (prescription) {
                if (prescription.id == prescriptionId) {
                    prescription.cut_dose_prescription_details.forEach(function (detail) {
                        medicineIds.push(detail.medicine_id); // Lưu ID thuốc
                    });
                }
            });

            // Clear giỏ hàng và thêm lại các thuốc từ đơn thuốc mẫu
            updateCartWithSelectedPrescription(medicineIds);
        });

        function updateCartWithSelectedPrescription(medicineIds) {
            // 1. Tạo một giỏ hàng mới (newCart)
            let newCart = [];

            medicineIds.forEach(medicineId => {
                let product = products.find(product => product.id === medicineId);

                if (!product) {
                    console.warn(`Không tìm thấy thông tin thuốc với ID: ${medicineId}`);
                    return;
                }

                // Kiểm tra xem thuốc có chứa lô hàng (batches)
                if (!product.batches || product.batches.length === 0) {
                    console.error(`Thuốc với ID ${medicineId} không có thông tin lô.`);
                    return;
                }

                // Chỉ lấy lô đầu tiên trong danh sách `batches`
                let firstBatch = product.batches[0];
                

                // Thêm thuốc vào giỏ hàng mới với lô đầu tiên
                newCart.push({
                    id: product.id,
                    name: product.name,
                    price: firstBatch.price_in_smallest_unit,
                    quantity: 1, // Số lượng mặc định là 1
                    expiration_date: firstBatch.expiration_date,
                    batches: product.batches, // Thêm thông tin tất cả lô (nếu cần sau này xử lý)
                    donvi: product.unit_smallest
                });
            });

            // 2. Gán giỏ hàng mới vào biến `cart`
            cart = newCart;

            // 3. Cập nhật lại giao diện
            renderCart();
        }

        let products = [];
        let productsDose = [];
        $.ajax({
            url: '/api/get-all-product',
            method: 'GET',
            success: function(response) {
                products = response;
                productsDose = response;
                renderProducts();
                renderProducts2();
            }
        })

        let cart = [];

        // Hiển thị danh sách sản phẩm
        function renderProducts(filter = "") {
            let productList = document.getElementById("product-list");
            productList.innerHTML = "";

            let filteredProducts = products.filter(product =>
                product.name.toLowerCase().includes(filter.toLowerCase()) &&
                (!selectedCategory || product.category === selectedCategory)
            );

            filteredProducts.forEach(product => {
                let productCard = document.createElement("div");
                productCard.classList.add("col-sm-3", "sm-3");
                productCard.innerHTML = `
                    <div class="card product-card mb-3" data-id="${product.id}">
                        <img src="${product.img}" class="card-img-top" alt="${product.name}">
                        <div class="card-body text-center">
                            <h6>${product.name}</h6>
                            <small class="text-muted">${product.category}</small>
                            <p class="text-success">(Tồn: ${product.quantity})</p>
                            <h5 class="text-danger">${product.price.toLocaleString()}₫ </h5>
                        </div>
                    </div>
                `;
                productCard.addEventListener("click", () => addToCart(product));
                productList.appendChild(productCard);
            });
        }

        function renderCart() {
            let cartElement = document.getElementById("cart");
            cartElement.innerHTML = "";
            let totalPrice = 0;
            
            cart.forEach(item => {
                let cartItem = document.createElement("li");
                cartItem.classList.add("list-group-item", "d-flex", "justify-content-between", "align-items-center",
                    "cart-item");

                let batchOptions = item.batches.map((batch, index) => {
                    let isSelected = batch.price_in_smallest_unit === item.price;
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
                let selectedBatch = item.batches.find(batch => batch.price_in_smallest_unit === item.price);
                
                cartItem.innerHTML = `
                    <div>
                        <h6>${item.name}</h6>
                        <input type="hidden" name="unit_id[${selectedBatch ? selectedBatch.id : ''}]" value="${item.unit_smallest || cart[0].donvi}">
                        
                        <div class="d-flex flex-column">
                            <h5 class="m-0 p-0 text-danger" id="price-${item.id}">${item.price.toLocaleString()}₫</h5>
                            <small class="text-success mt-2 mb-2">(Tồn: ${selectedBatch ? selectedBatch.quantity : 0})</small>
                            <small id="expiration-date-${item.id}">
                                (HSD: ${selectedBatch ? selectedBatch.expiration_date : "N/A"})
                            </small>
                        </div>

                        <div class="d-flex align-items-center">
                            <select class="form-select form-select-sm mt-2 lot-select me-2" 
                                    data-item-id="${item.id}"
                                    onchange="updateQuantityOnLotChange(${item.id}, this)">
                                ${batchOptions}
                            </select>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <button class="btn btn-sm btn-outline-secondary me-2" 
                            onclick="decreaseQuantity(${item.id}, ${item.price})">-</button>
                        <input type="number" class="form-control form-control-sm text-center" 
                            value="${item.quantity}" 
                            min="1" 
                            name="quantity[${selectedBatch ? selectedBatch.id : ''}]"
                            onchange="updateQuantity(${item.id}, ${item.price}, this.value)" 
                            style="width: 60px;">
                        <button class="btn btn-sm btn-outline-secondary ms-2" 
                            onclick="increaseQuantity(${item.id}, ${item.price})">+</button>
                    </div>

                    <div>
                        <span>${(item.price * item.quantity).toLocaleString()}₫</span>
                        <button class="btn btn-sm btn-danger ms-3" onclick="removeFromCart(${item.id}, ${item.price})">X</button>
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


       
        function updateQuantityOnLotChange(itemId, selectElement) {
            let selectedOption = selectElement.selectedOptions[0];
            let newQuantity = selectedOption.getAttribute('data-quantity');
            let newPrice = parseFloat(selectedOption.getAttribute('data-price'));
            let expirationDate = selectedOption.getAttribute('data-expiration-date');

            let cartItem = cart.find(item => item.id === itemId);
            if (!cartItem) {
                console.error(`Không tìm thấy sản phẩm với ID: ${itemId}`);
                return;
            }

            // Update the cart item's details
            cartItem.price = newPrice;
            cartItem.expiration_date = expirationDate;

            // Update the selected batch stock
            let container = selectElement.closest('.d-flex');
            if (container) {
                let quantityElement = container.querySelector('small');
                if (quantityElement) {
                    quantityElement.innerText = `(Tồn: ${newQuantity})`;
                }
            }

            // Update the displayed price and expiration date
            let priceElement = document.getElementById(`price-${itemId}`);
            if (priceElement) {
                priceElement.innerText = newPrice.toLocaleString() + "₫";
            }

            let expirationElement = document.getElementById(`expiration-date-${itemId}`);
            if (expirationElement) {
                expirationElement.innerText = `(HSD: ${expirationDate})`;
            }

            // Re-render the cart to recalculate totals
            renderCart();
        }

        function updateQuantity(itemId, price, quantity) {
            let cartItem = cart.find(item => item.id === itemId && item.price === price);
            if (cartItem) {
                // Lấy số tồn kho của lô hàng hiện tại
                let stock = cartItem.batches.find(batch => batch.price_in_smallest_unit === price)?.quantity || 0;

                if (quantity < 1) {
                    alert("Số lượng không thể nhỏ hơn 1.");
                    cartItem.quantity = 1;
                } else if (quantity > stock) {
                    alert("Số lượng không được vượt quá tồn kho!");
                    cartItem.quantity = stock;
                } else {
                    cartItem.quantity = parseInt(quantity);
                }
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
            let remainingBatches = product.batches.filter(batch =>
                !cart.some(item => item.id === product.id && item.price === batch.price_in_smallest_unit)
            );

            if (remainingBatches.length === 0) {
                // Nếu không còn lô nào, thông báo cho người dùng
                alert("Hết lô hàng! Không thể thêm sản phẩm này vào giỏ.");
                return;
            }

            // Chọn lô hàng mặc định (lô đầu tiên trong danh sách còn lại)
            let defaultBatch = remainingBatches[0];

            // Thêm sản phẩm vào giỏ với lô hàng mặc định
            cart.push({
                ...product,
                quantity: 1,
                price: defaultBatch.price_in_smallest_unit,
                expiration_date: defaultBatch.expiration_date
            });

            renderCart();
        }
        function getSelectedPrice(itemId) {
            // Lấy giá trị (price) của batch hiện tại được chọn từ dropdown
            let selectElement = document.querySelector(`.lot-select[data-item-id="${itemId}"]`);
            if (selectElement) {
                let selectedOption = selectElement.selectedOptions[0];
                return parseFloat(selectedOption.getAttribute('data-price'));
            }
            return null;
        }


        function increaseQuantity(itemId, price) {
            let cartItem = cart.find(item => item.id === itemId && item.price === price);
            if (cartItem) {
                // Lấy số tồn kho của lô hàng hiện tại
                let stock = cartItem.batches.find(batch => batch.price_in_smallest_unit === price)?.quantity || 0;

                if (cartItem.quantity < stock) {
                    cartItem.quantity++;
                } else {
                    alert("Số lượng không được vượt quá tồn kho!");
                }
                renderCart();
            }
        }

        function decreaseQuantity(itemId, price) {
            // Tìm item trong giỏ hàng dựa trên id sản phẩm và price của lô hàng
            let cartItem = cart.find(item => item.id === itemId && item.price === price);
            if (cartItem) {
                if (cartItem.quantity > 1) {
                    cartItem.quantity--;
                } else {
                    removeFromCart(itemId, price); // Xóa sản phẩm nếu số lượng giảm về 0
                }
                renderCart();
            }
        }

        function removeFromCart(itemId, price) {
            let index = cart.findIndex(item => item.id === itemId && item.price === price);
            if (index !== -1) {
                cart.splice(index, 1);
                renderCart();
            }
        }


        let selectedCategory = "";
        document.getElementById("category-filter1").addEventListener("change", (e) => {
            selectedCategory = e.target.value;
            renderProducts(document.getElementById("search1").value);
        });

        document.getElementById("search1").addEventListener("input", (e) => {
            renderProducts(e.target.value);
        });

        renderProducts();

        // Giỏ hàng trong tab cắt liều
        let tabCatLieu = document.getElementById('tab-cat-lieu');
        tabCatLieu.addEventListener('shown.bs.tab', function() {
            renderProducts2();
        });

        let doseCart = [];

        function renderProducts2(filter = "") {
            let productList = document.getElementById("product-list-cutdose");
            productList.innerHTML = "";

            let filteredProducts = productsDose.filter(productsDose =>
                productsDose.name.toLowerCase().includes(filter.toLowerCase()) &&
                (!selectedDoseCategory || productsDose.category === selectedDoseCategory)
            );
            console.log(filteredProducts);

            filteredProducts.forEach(productsDose => {
                let productCard = document.createElement("div");
                productCard.classList.add("col-sm-3", "sm-3");
                productCard.innerHTML = `
                    <div class="card product-card mb-3" data-id="${productsDose.id}">
                        <img src="${productsDose.img}" class="card-img-top" alt="${productsDose.name}">
                        <div class="card-body text-center">
                            <h6>${productsDose.name}</h6>
                            <small class="text-muted">${productsDose.category}</small>
                            <p class="text-success">(Tồn: ${productsDose.quantity})</p>
                            <h5 class="text-danger">${productsDose.price.toLocaleString()}₫</h5>
                        </div>
                    </div>
                `;
                productCard.addEventListener("click", () => addDoseToCart(productsDose));
                productList.appendChild(productCard);
            });
        }

        function renderDoseCart() {
            let cartElement = document.getElementById("dose-cart");
            cartElement.innerHTML = "";
            let totalPrice = 0;

            doseCart.forEach(item => {
                let cartItem = document.createElement("li");
                cartItem.classList.add("list-group-item", "d-flex", "justify-content-between", "align-items-center",
                    "cart-item");

                let batchOptions = item.batches.map((batch, index) => {
                    let isSelected = batch.price_in_smallest_unit === item.price;
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
                let selectedBatch = item.batches.find(batch => batch.price_in_smallest_unit === item.price);

                cartItem.innerHTML = `
                    <div>
                        <h6>${item.name}</h6>
                        <input type="hidden" name="unit_id[${selectedBatch ? selectedBatch.id : ''}]" value="${item.unit_smallest}">

                        <div class="d-flex flex-column">
                            <h5 class="m-0 p-0 text-danger" id="price-${item.id}">${item.price.toLocaleString()}₫</h5>
                            <small class="mt-2 mb-2 text-success">(Tồn: ${selectedBatch ? selectedBatch.quantity : 0})</small>
                            <small id="expiration-date-${item.id}">
                                (HSD: ${selectedBatch ? selectedBatch.expiration_date : "N/A"})
                            </small>
                        </div>

                        <div class="d-flex align-items-center">
                             <select class="form-select form-select-sm mt-2 lot-select me-2" 
                                    data-item-id="${item.id}"
                                    onchange="updateQuantityDoseOnLotChange(${item.id}, this)">
                                ${batchOptions}
                            </select>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-center">
                        <button class="btn btn-sm btn-outline-secondary me-2" 
                            onclick="decreaseDoseQuantity(${item.id}, ${item.price})">-</button>
                        <input type="number" class="form-control form-control-sm text-center" 
                            value="${item.quantity}" 
                            min="1" 
                            name="quantity[${selectedBatch ? selectedBatch.id : ''}]"
                            onchange="updateDoseQuantity(${item.id}, ${item.price}, this.value)" 
                            style="width: 60px;">
                        <button class="btn btn-sm btn-outline-secondary ms-2" 
                            onclick="increaseDoseQuantity(${item.id}, ${item.price})">+</button>
                    </div>


                    <div>
                        <span>${(item.price * item.quantity).toLocaleString()}₫</span>
                        <button class="btn btn-sm btn-danger ms-3" onclick="removeDoseFromCart(${item.id}, ${item.price})">X</button>
                    </div>
                    <!-- Hidden Inputs to store batch details -->
                    <input type="hidden" name="batch_total_price[${selectedBatch ? selectedBatch.id : ''}]" value="${(item.price * item.quantity)}">
                `;

                cartElement.appendChild(cartItem);
                totalPrice += item.price * item.quantity;
            });

            document.getElementById("dose-total-price").innerText = totalPrice.toLocaleString() + "₫";
            document.getElementById("totalPriceDose").value = totalPrice;
        }


        // Hàm cập nhật số lượng và ngày hết hạn khi người dùng thay đổi lô
        function updateQuantityDoseOnLotChange(itemId, selectElement) {
            let selectedOption = selectElement.selectedOptions[0];
            let newQuantity = selectedOption.getAttribute('data-quantity');
            let newPrice = parseFloat(selectedOption.getAttribute('data-price'));
            let expirationDate = selectedOption.getAttribute('data-expiration-date');

            let cartItem = doseCart.find(item => item.id === itemId);
            if (!cartItem) {
                console.error(`Không tìm thấy sản phẩm với ID: ${itemId}`);
                return;
            }

            // Update the cart item's details
            cartItem.price = newPrice;
            cartItem.expiration_date = expirationDate;

            // Update the selected batch stock
            let container = selectElement.closest('.d-flex');
            if (container) {
                let quantityElement = container.querySelector('small');
                if (quantityElement) {
                    quantityElement.innerText = `(Tồn: ${newQuantity})`;
                }
            }

            // Update the displayed price and expiration date
            let priceElement = document.getElementById(`price-${itemId}`);
            if (priceElement) {
                priceElement.innerText = newPrice.toLocaleString() + "₫";
            }

            let expirationElement = document.getElementById(`expiration-date-${itemId}`);
            if (expirationElement) {
                expirationElement.innerText = `(HSD: ${expirationDate})`;
            }

            // Re-render the cart to recalculate totals
            renderDoseCart();
        }
        
       
        function updateDoseQuantity(itemId, price, quantity) {
            
            let cartItem = doseCart.find(item => item.id === itemId && item.price === price);
            if (cartItem) {
                // Lấy số tồn kho của lô hàng hiện tại
                let stock = cartItem.batches.find(batch => batch.price_in_smallest_unit === price)?.quantity || 0;

                if (quantity < 1) {
                    alert("Số lượng không thể nhỏ hơn 1.");
                    cartItem.quantity = 1;
                } else if (quantity > stock) {
                    alert("Số lượng không được vượt quá tồn kho!");
                    cartItem.quantity = stock;
                } else {
                    cartItem.quantity = parseInt(quantity);
                }
                renderDoseCart();
            }
        }
        
        function updateDoseTotalAmount() {
            // Giả sử mỗi item trong giỏ hàng có các thuộc tính 'price' (giá) và 'quantity' (số lượng)
            let totalAmount = 0;

            cartItems.forEach(item => {
                totalAmount += item.price * item.quantity; // Tính tổng tiền của từng sản phẩm
            });

            // Cập nhật lại hiển thị tổng tiền (giả sử có một phần tử với id 'totalAmount')
            document.getElementById('totalAmount').textContent = `Tổng tiền: ${totalAmount.toFixed(2)} VND`;

        }

        function addDoseToCart(productsDose) {
            // Lấy danh sách các lô hàng chưa được thêm vào giỏ
            let remainingBatches = productsDose.batches.filter(batch =>
                !doseCart.some(item => item.id === productsDose.id && item.price === batch.price_in_smallest_unit)
            );

            if (remainingBatches.length === 0) {
                // Nếu không còn lô nào, thông báo cho người dùng
                alert("Hết lô hàng! Không thể thêm sản phẩm này vào giỏ.");
                return;
            }

            // Chọn lô hàng mặc định (lô đầu tiên trong danh sách còn lại)
            let defaultBatch = remainingBatches[0];

            // Thêm sản phẩm vào giỏ với lô hàng mặc định
            doseCart.push({
                ...productsDose,
                quantity: 1,
                price: defaultBatch.price_in_smallest_unit,
                expiration_date: defaultBatch.expiration_date
            });

            renderDoseCart();
        }


        function increaseDoseQuantity(itemId, price) {
            let cartItem = doseCart.find(item => item.id === itemId && item.price === price);
            if (cartItem) {
                // Lấy số tồn kho của lô hàng hiện tại
                let stock = cartItem.batches.find(batch => batch.price_in_smallest_unit === price)?.quantity || 0;
                if (cartItem.quantity < stock) {
                    cartItem.quantity++;
                } else {
                    alert("Số lượng không được vượt quá tồn kho!");
                }
                renderDoseCart();
            }
        }

        function decreaseDoseQuantity(itemId, price) {
            let cartItem = doseCart.find(item => item.id === itemId && item.price === price);
            if (cartItem) {
                if (cartItem.quantity > 1) {
                    cartItem.quantity--;
                } else {
                    removeDoseFromCart(itemId, price); // Xóa sản phẩm nếu số lượng giảm về 0
                }
                renderDoseCart();
            }
        }

        function removeDoseFromCart(itemId, price) {
            let index = doseCart.findIndex(item => item.id === itemId && item.price === price);
            if (index !== -1) {
                doseCart.splice(index, 1);
                renderDoseCart();
            }
        }

        let selectedDoseCategory = "";
        document.getElementById("category-filter2").addEventListener("change", (e) => {
            selectedDoseCategory = e.target.value;
            renderProducts2(document.getElementById("search2").value);
        });

        document.getElementById("search2").addEventListener("input", (e) => {
            renderProducts2(e.target.value);
        });

        renderProducts2();
        ///////
        document.addEventListener('DOMContentLoaded', function () {
        // Hàm gọi API và render dữ liệu
        function fetchInvoices() {
            fetch('/api/invoices/today', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Không thể lấy dữ liệu từ API');
                    }
                    return response.json();
                })
                .then(data => {
                    renderInvoices(data);
                })
                .catch(error => {
                    console.error('Lỗi khi gọi API:', error);
                });
        }

        // Hàm render dữ liệu vào bảng
        function renderInvoices(invoices) {
            const tableBody = document.querySelector('#invoice-table tbody');
            tableBody.innerHTML = ''; // Xóa dữ liệu cũ

            if (invoices.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="5" class="text-center">Không có đơn hàng nào trong hôm nay</td></tr>`;
                return;
            }

            invoices.forEach((invoice, index) => {
                const row = `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${invoice.customer_name || 'N/A'}</td>
                        <td>${invoice.total_price ? invoice.total_price.toLocaleString() + '₫' : '0₫'}</td>
                        <td>${formatDate(invoice.created_at)}</td>
                        <td>${invoice.type || ''}</td>
                    </tr>
                `;
                tableBody.insertAdjacentHTML('beforeend', row);
            });
        }

        // Hàm format ngày giờ
        function formatDate(dateString) {
            const date = new Date(dateString);
            const day = date.getDate().toString().padStart(2, '0');
            const month = (date.getMonth() + 1).toString().padStart(2, '0');
            const year = date.getFullYear();
            const hours = date.getHours().toString().padStart(2, '0');
            const minutes = date.getMinutes().toString().padStart(2, '0');
            const seconds = date.getSeconds().toString().padStart(2, '0');

            return `${hours}:${minutes}:${seconds} ${day}-${month}-${year}`;
        }

        // Gọi fetchInvoices khi chuyển sang tab "Danh sách"
        const tabDanhSach = document.getElementById('tab-danh-sach');
        tabDanhSach.addEventListener('click', fetchInvoices);
    });

    </script>
</body>

</html>
