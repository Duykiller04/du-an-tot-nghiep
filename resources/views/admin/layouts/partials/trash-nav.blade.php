<div class="row" >
    <div class="col-lg-12 ">
        <div class="card" style="overflow: scroll;">

            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0  me-2">Danh Sách :</h4>
                <div class="flex-shrink-0">
                    <ul class="nav justify-content-end nav-tabs-custom rounded card-header-tabs border-bottom-0 "
                        role="tablist">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.restore.categories') }}">
                                Danh mục
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.restore.diseases') }}">
                                Bệnh
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.restore.suppliers') }}">
                                Nhà cung cấp
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.restore.users') }}">
                                Người dùng
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.restore.units') }}">
                                Đơn vị
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.restore.medicines') }}">
                                Thuốc
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.restore.medicalInstruments') }}">
                                Dụng cụ
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.restore.storages') }}">
                                Kho
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.restore.cutDosePrescriptions') }}">
                                Đơn thuốc mẫu
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.restore.importorder') }}">
                                Nhập kho
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link"
                                href="{{ route('admin.restore.cutDoseOrders') }}">
                                Đơn thuốc cắt liều
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link"
                                href="{{ route('admin.restore.prescriptions') }}">
                                Đơn thuốc
                            </a>
                        </li>
                        
                    </ul>
                </div>
            </div>

        </div><!-- end card -->
    </div><!-- end col -->
</div><!-- end row -->
