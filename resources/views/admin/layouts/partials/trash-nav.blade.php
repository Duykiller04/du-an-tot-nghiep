<div class="row">
    <div class="col-lg-12">
        <div class="card">

            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0  me-2">Danh Sách :</h4>
                <div class="flex-shrink-0 ">
                    <ul class="nav justify-content-end nav-tabs-custom rounded card-header-tabs border-bottom-0"
                        role="tablist">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.restore.categories') }}">
                                Categories
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"  href="{{ route('admin.restore.diseases') }}">
                                Diseases
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.restore.suppliers') }}">
                                Suppliers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.restore.users') }}">
                                Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.restore.units') }}">
                                Units
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.restore.medicines') }}">
                                Medicines
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

        </div><!-- end card -->
    </div><!-- end col -->
</div><!-- end row -->