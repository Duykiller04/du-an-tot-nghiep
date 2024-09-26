<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="index.html" class="logo logo-dark">
            <span class="logo-sm">
                <img src="/theme/admin/assets/images/logo-sm.png" alt="" height="42">
            </span>
            <span class="logo-lg">
                <img src="/theme/admin/assets/images/logo-dark.png" alt="" height="37">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="index.html" class="logo logo-light">
            <span class="logo-sm">
                <img src="/theme/admin/assets/images/logo-sm.png" alt="" height="42">
            </span>
            <span class="logo-lg">
                <img src="/theme/admin/assets/images/logo-light.png" alt="" height="37">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>

                
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('admin.dashboard') }}" role="button"
                        aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Trang chủ</span>
                    </a>
                </li> <!-- end Dashboard Menu -->

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarMultilevel" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarMultilevel">
                        <i class="ri-share-line"></i> <span data-key="t-multi-level">Multi Level</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarMultilevel">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                {{-- <a href="{{route('customer.index')}}" class="nav-link" data-key="t-level-1.1">Customers</a> --}}
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarAccount" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarAccount" data-key="t-level-1.2"> Level
                                    1.2
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarAccount">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="#" class="nav-link" data-key="t-level-2.1">
                                                Level 2.1 </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#sidebarCrm" class="nav-link" data-bs-toggle="collapse"
                                                role="button" aria-expanded="false" aria-controls="sidebarCrm"
                                                data-key="t-level-2.2"> Level 2.2
                                            </a>
                                            <div class="collapse menu-dropdown" id="sidebarCrm">
                                                <ul class="nav nav-sm flex-column">
                                                    <li class="nav-item">
                                                        <a href="#" class="nav-link" data-key="t-level-3.1"> Level
                                                            3.1
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#" class="nav-link" data-key="t-level-3.2"> Level
                                                            3.2
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#units" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="units">
                        <i class="bx bxs-shapes"></i> <span data-key="t-apps">Đơn vị tính</span>
                    </a>
                    <div class="collapse menu-dropdown" id="units">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.units.create') }}" class="nav-link" role="button"
                                    aria-expanded="false" aria-controls="sidebarEcommerce" data-key="t-ecommerce">
                                    Thêm mới
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin.units.index') }}" class="nav-link" role="button"
                                    aria-expanded="false" aria-controls="sidebarInvoices" data-key="t-invoices">
                                    Danh sách
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarProduct" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarProduct">
                        <i class="bx bxs-virus"></i> <span data-key="t-apps">Các loại bệnh</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarProduct">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.diseases.create') }}" class="nav-link" role="button"
                                    aria-expanded="false" aria-controls="sidebarEcommerce" data-key="t-ecommerce">
                                    Thêm mới
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin.diseases.index') }}" class="nav-link" role="button"
                                    aria-expanded="false" aria-controls="sidebarInvoices" data-key="t-invoices">
                                    Danh sách
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarCatalogue" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarCatalogue">
                        <i class="bx bx-category"></i> <span data-key="t-apps">Danh mục</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarCatalogue">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.catalogues.create') }}" class="nav-link" role="button"
                                    aria-expanded="false" aria-controls="sidebarEcommerce" data-key="t-ecommerce">
                                    Thêm mới
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin.catalogues.index') }}" class="nav-link" role="button"
                                    aria-expanded="false" aria-controls="sidebarInvoices" data-key="t-invoices">
                                    Danh sách
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('admin.inventoryaudit.index') }}" role="button"
                        aria-expanded="false" aria-controls="sidebarPages">
                        <i class="ri-pages-line"></i> <span data-key="t-pages">Kiểm kho</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#enviroment" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="enviroment">
                        <i class="ri-layout-3-line"></i> <span data-key="t-apps">Môi trường/Độ ẩm</span>
                    </a>
                    <div class="collapse menu-dropdown" id="enviroment">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.environments.create') }}" class="nav-link" role="button"
                                    aria-expanded="false" aria-controls="sidebarEcommerce" data-key="t-ecommerce">
                                    Thêm mới
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin.environments.index') }}" class="nav-link" role="button"
                                    aria-expanded="false" aria-controls="sidebarInvoices" data-key="t-invoices">
                                    Danh sách
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#user" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="user">
                        <i class="ri-folder-user-fill"></i> <span data-key="t-apps">Người dùng</span>
                    </a>
                    <div class="collapse menu-dropdown" id="user">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.users.create') }}" class="nav-link" role="button"
                                    aria-expanded="false" aria-controls="sidebarEcommerce" data-key="t-ecommerce">
                                    Thêm mới
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin.users.index') }}" class="nav-link" role="button"
                                    aria-expanded="false" aria-controls="sidebarInvoices" data-key="t-invoices">
                                    Danh sách
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#customer" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="customer">
                        <i class="ri-group-2-fill"></i> <span data-key="t-apps">Khách hàng</span>
                    </a>
                    <div class="collapse menu-dropdown" id="customer">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.customers.create') }}" class="nav-link" role="button"
                                    aria-expanded="false" aria-controls="sidebarEcommerce" data-key="t-ecommerce">
                                    Thêm mới
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin.customers.index') }}" class="nav-link" role="button"
                                    aria-expanded="false" aria-controls="sidebarInvoices" data-key="t-invoices">
                                    Danh sách
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#suppliers" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="suppliers">
                        <i class="ri-building-4-fill"></i> <span data-key="t-apps">Nhà cung cấp</span>
                    </a>
                    <div class="collapse menu-dropdown" id="suppliers">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.suppliers.create') }}" class="nav-link" role="button"
                                    aria-expanded="false" aria-controls="sidebarEcommerce" data-key="t-ecommerce">
                                    Thêm mới
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin.suppliers.index') }}" class="nav-link" role="button"
                                    aria-expanded="false" aria-controls="sidebarInvoices" data-key="t-invoices">
                                    Danh sách
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>



                {{-- ---------------------------------------------------------------------------------------------------------------- --}}

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#medicalInstrument" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="medicalInstrument">
                        <i class="bx bx-injection"></i> <span data-key="t-apps">Dụng cụ</span>
                    </a>
                    <div class="collapse menu-dropdown" id="medicalInstrument">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.medicalInstruments.create') }}" class="nav-link"
                                    role="button" aria-expanded="false" aria-controls="sidebarEcommerce"
                                    data-key="t-ecommerce">
                                    Thêm mới
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin.medicalInstruments.index') }}" class="nav-link"
                                    role="button" aria-expanded="false" aria-controls="sidebarInvoices"
                                    data-key="t-invoices">
                                    Danh sách
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>



                <li class="nav-item">
                    <a class="nav-link menu-link" href="#medicine" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="medicine">
                        <i class="bx bxs-capsule"></i> <span data-key="t-apps">Thuốc</span>
                    </a>
                    <div class="collapse menu-dropdown" id="medicine">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.medicines.create') }}" class="nav-link" role="button"
                                    aria-expanded="false" aria-controls="sidebarEcommerce" data-key="t-ecommerce">
                                    Thêm mới
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin.medicines.index') }}" class="nav-link" role="button"
                                    aria-expanded="false" aria-controls="sidebarInvoices" data-key="t-invoices">
                                    Danh sách
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#cutdosepre" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="cutdosepre">
                        <i class="bx bx-notepad"></i> <span data-key="t-apps">Đơn thuốc mẫu</span>
                    </a>
                    <div class="collapse menu-dropdown" id="cutdosepre">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.cutDosePrescriptions.create') }}" class="nav-link"
                                    role="button" aria-expanded="false" aria-controls="sidebarEcommerce"
                                    data-key="t-ecommerce">
                                    Thêm mới
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin.cutDosePrescriptions.index') }}" class="nav-link"
                                    role="button" aria-expanded="false" aria-controls="sidebarInvoices"
                                    data-key="t-invoices">
                                    Danh sách
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#cutdoseorder" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="cutdoseorder">
                        <i class="bx bx-receipt"></i> <span data-key="t-apps">Thuốc cắt liều</span>
                    </a>
                    <div class="collapse menu-dropdown" id="cutdoseorder">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.cutDoseOrders.create') }}" class="nav-link" role="button"
                                    aria-expanded="false" aria-controls="sidebarEcommerce" data-key="t-ecommerce">
                                    Thêm mới
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin.cutDoseOrders.index') }}" class="nav-link" role="button"
                                    aria-expanded="false" aria-controls="sidebarInvoices" data-key="t-invoices">
                                    Danh sách
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#storage" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="storage">
                        <i class="ri-store-2-fill"></i> <span data-key="t-apps"> Kho thuốc</span>
                    </a>
                    <div class="collapse menu-dropdown" id="storage">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.storage.create') }}" class="nav-link" role="button"
                                    aria-expanded="false" aria-controls="sidebarEcommerce" data-key="t-ecommerce">
                                    Thêm mới
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin.storage.index') }}" class="nav-link" role="button"
                                    aria-expanded="false" aria-controls="sidebarInvoices" data-key="t-invoices">
                                    Danh sách
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#importorder" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="importorder">
                        <i class="ri-store-2-fill"></i> <span data-key="t-apps"> Nhập kho thuốc</span>
                    </a>
                    <div class="collapse menu-dropdown" id="importorder">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.importorder.create') }}" class="nav-link" role="button"
                                    aria-expanded="false" aria-controls="sidebarEcommerce" data-key="t-ecommerce">
                                    Thêm mới
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin.importorder.index') }}" class="nav-link" role="button"
                                    aria-expanded="false" aria-controls="sidebarInvoices" data-key="t-invoices">
                                    Danh sách
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
        </li>
        </ul>
    </div>
    <!-- Sidebar -->
</div>

<div class="sidebar-background"></div>
</div>
