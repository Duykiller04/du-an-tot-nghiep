<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{ route('admin.dashboard') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="/theme/admin/assets/images/logo-sm.png" alt="" height="42">
            </span>
            <span class="logo-lg">
                <img src="/theme/admin/assets/images/logo-dark.png" alt="" height="37">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ route('admin.dashboard') }}" class="logo logo-light">
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
                        <i class="bx bxs-capsule"></i> <span data-key="t-multi-level">Sản phẩm</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarMultilevel">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{route('admin.catalogues.index')}}" class="nav-link" data-key="t-level-1.1">Danh mục</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.units.index')}}" class="nav-link" data-key="t-level-1.1">Đơn vị</a>
                            </li>
                            <li class="nav-item">
                                <a href="#Medicine" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="Medicine" data-key="t-level-1.2"> Thuốc
                                </a>
                                <div class="collapse menu-dropdown" id="Medicine">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('admin.medicines.create') }}" class="nav-link" data-key="t-level-2.1">
                                                Thêm mới </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.medicines.index') }}" class="nav-link" data-key="t-level-2.1">
                                                Danh sách </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="#MedicineInstrument" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="MedicineInstrument" data-key="t-level-1.2"> Dụng cụ
                                </a>
                                <div class="collapse menu-dropdown" id="MedicineInstrument">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('admin.medicalInstruments.create') }}" class="nav-link" data-key="t-level-2.1">
                                                Thêm mới </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.medicalInstruments.index') }}" class="nav-link" data-key="t-level-2.1">
                                                Danh sách </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarMultilevel2" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarMultilevel2">
                        <i class="ri-file-list-3-fill"></i> <span data-key="t-multi-level">Đơn thuốc</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarMultilevel2">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="#diseases" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="diseases" data-key="t-level-1.2"> Bệnh
                                </a>
                                <div class="collapse menu-dropdown" id="diseases">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('admin.diseases.create') }}" class="nav-link" data-key="t-level-2.1">
                                                Thêm mới </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.diseases.index') }}" class="nav-link" data-key="t-level-2.1">
                                                Danh sách </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="#cutDosePrescriptions" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="cutDosePrescriptions" data-key="t-level-1.2"> Mẫu đơn thuốc
                                </a>
                                <div class="collapse menu-dropdown" id="cutDosePrescriptions">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('admin.cutDosePrescriptions.create') }}" class="nav-link" data-key="t-level-2.1">
                                                Thêm mới </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.cutDosePrescriptions.index') }}" class="nav-link" data-key="t-level-2.1">
                                                Danh sách </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="#cutDoseOrders" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="cutDoseOrders" data-key="t-level-1.2"> Đơn thuốc cắt liều
                                </a>
                                <div class="collapse menu-dropdown" id="cutDoseOrders">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('admin.cutDoseOrders.create') }}" class="nav-link" data-key="t-level-2.1">
                                                Thêm mới </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.cutDoseOrders.index') }}" class="nav-link" data-key="t-level-2.1">
                                                Danh sách </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="#prescriptions" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="prescriptions" data-key="t-level-1.2"> Đơn thuốc thông thường
                                </a>
                                <div class="collapse menu-dropdown" id="prescriptions">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('admin.prescriptions.create') }}" class="nav-link" data-key="t-level-2.1">
                                                Thêm mới </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.prescriptions.index') }}" class="nav-link" data-key="t-level-2.1">
                                                Danh sách </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarMultilevel3" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarMultilevel3">
                        <i class="ri-store-fill"></i> <span data-key="t-multi-level">Kho</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarMultilevel3">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{route('admin.storage.index')}}" class="nav-link" data-key="t-level-1.1">Kho thuốc</a>
                            </li>
                            <li class="nav-item">
                                <a href="#importorder" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="importorder" data-key="t-level-1.2">Nhập kho thuốc
                                </a>
                                <div class="collapse menu-dropdown" id="importorder">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('admin.importorder.create') }}" class="nav-link" data-key="t-level-2.1">
                                                Thêm mới </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.importorder.index') }}" class="nav-link" data-key="t-level-2.1">
                                                Danh sách </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.inventoryaudit.index')}}" class="nav-link" data-key="t-level-1.1">Kiểm kho</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarMultilevel4" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarMultilevel4">
                        <i class="ri-group-2-fill"></i> <span data-key="t-multi-level">Người dùng và đối tác</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarMultilevel4">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="#users" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="users" data-key="t-level-1.2"> Người dùng
                                </a>
                                <div class="collapse menu-dropdown" id="users">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('admin.users.create') }}" class="nav-link" data-key="t-level-2.1">
                                                Thêm mới </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.users.index') }}" class="nav-link" data-key="t-level-2.1">
                                                Danh sách </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.customers.index')}}" class="nav-link" data-key="t-level-1.1">Khách hàng</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.suppliers.index')}}" class="nav-link" data-key="t-level-1.1">Nhà cung cấp</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('admin.environments.index') }}" >
                        <i class="ri-temp-hot-line"></i> <span data-key="t-apps">Môi trường/Độ ẩm</span>
                    </a>
                   
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarMultilevel5" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarMultilevel5">
                        <i class="ri-group-2-fill"></i> <span data-key="t-multi-level">Ca làm</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarMultilevel5">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="#users" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="users" data-key="t-level-1.2"> Quản lý ca làm
                                </a>
                                <div class="collapse menu-dropdown" id="users">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('admin.shifts.create') }}" class="nav-link" data-key="t-level-2.1">
                                                Thêm mới </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.shifts.index') }}" class="nav-link" data-key="t-level-2.1">
                                                Danh sách </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.attendace.index')}}" class="nav-link" data-key="t-level-1.1">Điểm danh</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('admin.setting.index') }}" role="button"
                        aria-expanded="false" aria-controls="sidebarPages">
                        <i class="ri-notification-3-fill"></i> <span data-key="t-pages">Cấu hình</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('admin.export.form') }}" role="button"
                        aria-expanded="false" aria-controls="sidebarPages">
                        <i class="ri-file-excel-2-fill"></i><span data-key="t-pages">Xuất Excel </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('admin.restore.categories') }}">
                        <i class="bx bxs-trash-alt"></i> <span data-key="t-apps">Thùng rác</span>

                    </a>
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
