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
                    <a class="nav-link menu-link
                     {{ Request::is('admin') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}" role="button"
                        aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Trang chủ</span>
                    </a>
                </li> <!-- end Dashboard Menu -->

                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::is('admin/catalogues*') || Request::is('admin/units*') || Request::is('admin/medicines*') || Request::is('admin/medicalInstruments*') ? 'active' : '' }}" href="#sidebarMultilevel" data-bs-toggle="collapse" role="button"
                        aria-expanded="{{ Request::is('admin/catalogues*') || Request::is('admin/units*') || Request::is('admin/medicines*') || Request::is('admin/medicalInstruments*') ? 'true' : 'false' }}" aria-controls="sidebarMultilevel">
                        <i class="bx bxs-capsule"></i> <span data-key="t-multi-level">Sản phẩm</span>
                    </a>
                    <div class="collapse menu-dropdown  {{ Request::is('admin/catalogues*') || Request::is('admin/units*') || Request::is('admin/medicines*') || Request::is('admin/medicalInstruments*') ? 'show' : '' }}" id="sidebarMultilevel">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.catalogues.index') }}" class="nav-link {{ Request::is('admin/catalogues*') ? 'active' : '' }}"
                                    data-key="t-level-1.1">Danh mục</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.units.index') }}" class="nav-link {{ Request::is('admin/units*') ? 'active' : '' }}" data-key="t-level-1.1">Đơn
                                    vị</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.medicines.index') }}" class="nav-link  {{ Request::is('admin/medicines*') ? 'active' : '' }}" data-key="t-level-1.1">
                                    Thuốc
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.medicalInstruments.index') }}" class="nav-link {{ Request::is('admin/medicalInstruments*') ? 'active' : '' }}" data-key="t-level-1.1">
                                    Dụng cụ
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::is('admin/diseases*') || Request::is('admin/cutDosePrescriptions*') || Request::is('admin/cutDoseOrders*') || Request::is('admin/prescriptions*') ? 'active' : '' }}" href="#sidebarMultilevel2" data-bs-toggle="collapse"
                        role="button" aria-expanded="false" aria-controls="sidebarMultilevel2">
                        <i class="ri-file-list-3-fill"></i> <span data-key="t-multi-level">Đơn thuốc</span>
                    </a>
                    <div class="collapse menu-dropdown {{ Request::is('admin/diseases*') || Request::is('admin/cutDosePrescriptions*') || Request::is('admin/cutDoseOrders*') || Request::is('admin/prescriptions*') ? 'show' : '' }}" id="sidebarMultilevel2">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.diseases.index') }}" class="nav-link {{ Request::is('admin/diseases*') ? 'active' : '' }}" data-key="t-level-1.1">
                                    Bệnh
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.cutDosePrescriptions.index') }}" class="nav-link {{ Request::is('admin/cutDosePrescriptions*') ? 'active' : '' }}" data-key="t-level-1.1">
                                    Mẫu đơn thuốc
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.cutDoseOrders.index') }}" class="nav-link {{ Request::is('admin/cutDoseOrders*') ? 'active' : '' }}" data-key="t-level-1.1">
                                    Đơn thuốc cắt liều
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.prescriptions.index') }}" class="nav-link {{ Request::is('admin/prescriptions*') ? 'active' : '' }}" data-key="t-level-1.1">
                                    Đơn thuốc thông thường
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::is('admin/storage*') || Request::is('admin/importorder*') || Request::is('admin/inventoryaudit*') ? 'active' : '' }}   " href="#sidebarMultilevel3" data-bs-toggle="collapse"
                        role="button" aria-expanded="false" aria-controls="sidebarMultilevel3">
                        <i class="ri-store-fill"></i> <span data-key="t-multi-level">Kho</span>
                    </a>
                    <div class="collapse menu-dropdown {{ Request::is('admin/storage*') || Request::is('admin/importorder*') || Request::is('admin/inventoryaudit*') ? 'show' : '' }}" id="sidebarMultilevel3">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.storage.index') }}" class="nav-link {{ Request::is('admin/storage*') ? 'active' : '' }}"
                                    data-key="t-level-1.1">Kho thuốc</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.importorder.index') }}" class="nav-link {{ Request::is('admin/importorder*') ? 'active' : '' }}" data-key="t-level-1.1">
                                    Nhập kho thuốc
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.inventoryaudit.index') }}" class="nav-link {{ Request::is('admin/inventoryaudit*') ? 'active' : '' }}"
                                    data-key="t-level-1.1">Kiểm kho</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::is('admin/users*') || Request::is('admin/customers*') || Request::is('admin/suppliers*') ? 'active' : '' }}" href="#sidebarMultilevel4" data-bs-toggle="collapse"
                        role="button" aria-expanded="false" aria-controls="sidebarMultilevel4">
                        <i class="ri-group-2-fill"></i> <span data-key="t-multi-level">Người dùng và đối tác</span>
                    </a>
                    <div class="collapse menu-dropdown {{ Request::is('admin/users*') || Request::is('admin/customers*') || Request::is('admin/suppliers*') ? 'show' : '' }}" id="sidebarMultilevel4">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.users.index') }}" class="nav-link {{ Request::is('admin/users*') ? 'active' : '' }}"
                                    data-key="t-level-1.1">Người dùng</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.customers.index') }}" class="nav-link {{ Request::is('admin/customers*') ? 'active' : '' }}"
                                    data-key="t-level-1.1">Khách hàng</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.suppliers.index') }}" class="nav-link {{ Request::is('admin/suppliers*') ? 'active' : '' }}"
                                    data-key="t-level-1.1">Nhà cung cấp</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::is('admin/environments*') ? 'active' : '' }}" href="{{ route('admin.environments.index') }}">
                        <i class="ri-temp-hot-line"></i> <span data-key="t-apps">Môi trường/Độ ẩm</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::is('admin/shifts*') || Request::is('admin/attendace*') || Request::is('admin/list-attendace*') ? 'active' : '' }}" href="#sidebarMultilevel5" data-bs-toggle="collapse"
                        role="button" aria-expanded="false" aria-controls="sidebarMultilevel5">
                        <i class="ri-group-2-fill"></i> <span data-key="t-multi-level">Ca làm</span>
                    </a>
                    <div class="collapse menu-dropdown {{ Request::is('admin/shifts*') || Request::is('admin/attendace*') || Request::is('admin/list-attendace*') ? 'show' : '' }}" id="sidebarMultilevel5">
                        <ul class="nav nav-sm flex-column">
                            @if (Auth::user()->isAdmin())
                                <li class="nav-item">
                                    <a href="{{ route('admin.shifts.index') }}" class="nav-link {{ Request::is('admin/shifts*') ? 'active' : '' }}"
                                    data-key="t-level-1.1">Quản lý ca làm</a>
                                </li>
                            @endif
                            @if (!Auth::user()->isAdmin())
                                <li class="nav-item">
                                    <a href="{{ route('admin.attendace.index') }}" class="nav-link {{ Request::is('admin/attendace*') ? 'active' : '' }}"
                                        data-key="t-level-1.1">Điểm danh</a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a href="{{ (Auth::user()->type == 'admin') ? route('admin.attendace.list.user') : route('admin.attendace.list') }}" class="nav-link {{ Request::is('admin/list-attendace*') ? 'active' : '' }}"
                                    data-key="t-level-1.1">{{ (Auth::user()->type == 'admin') ? 'Giờ làm việc của nhân viên' : 'Giờ làm việc' }}</a>
                            </li>
                        </ul>
                    </div>
                </li>
                @if (Auth::user()->isAdmin())
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ Request::is('admin/setting*') ? 'active' : '' }}" href="{{ route('admin.setting.index') }}" role="button"
                            aria-expanded="false" aria-controls="sidebarPages">
                            <i class="ri-notification-3-fill"></i> <span data-key="t-pages">Cấu hình</span>
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::is('admin/export*') ? 'active' : '' }}" href="{{ route('admin.export.form') }}" role="button"
                        aria-expanded="false" aria-controls="sidebarPages">
                        <i class="ri-file-excel-2-fill"></i><span data-key="t-pages">Xuất Excel </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::is('admin/restore*') ? 'active' : '' }}" href="{{ route('admin.restore.categories') }}">
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
