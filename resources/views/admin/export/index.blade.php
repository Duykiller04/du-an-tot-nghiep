@extends('admin.layouts.master')

@section('title')
    Xuất Bảng Excel
@endsection

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Xuất Bảng Excel</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                        <li class="breadcrumb-item active">Xuất Bảng Excel</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">Danh sách</h5>
                </div>
                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.export') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="selectAll">
                                <label class="form-check-label" for="selectAll">Chọn tất cả</label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="tables[]" value="users"
                                        id="users">
                                    <label class="form-check-label" for="users">Xuất bảng Users</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="tables[]" value="customer"
                                        id="customer">
                                    <label class="form-check-label" for="customer">Xuất Khách hàng</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="tables[]" value="medicine"
                                        id="medicine">
                                    <label class="form-check-label" for="medicine">Xuất bảng Thuốc</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="tables[]" value="batch"
                                        id="batch">
                                    <label class="form-check-label" for="batch">Xuất lô thuốc </label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="tables[]" value="storage"
                                        id="storage">
                                    <label class="form-check-label" for="storage">Xuất Kho thuốc</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="tables[]" value="importorder"
                                        id="importorder">
                                    <label class="form-check-label" for="importorder">Xuất Nhập Kho thuốc</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="tables[]" value="InventoryAudit"
                                        id="InventoryAudit">
                                    <label class="form-check-label" for="InventoryAudit">Xuất Kiểm hàng tồn kho</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="tables[]" value="DiseasesExport"
                                        id="DiseasesExport">
                                    <label class="form-check-label" for="DiseasesExport">Xuất Các loại bệnh</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="tables[]"
                                        value="CutDosePrescription" id="CutDosePrescription">
                                    <label class="form-check-label" for="CutDosePrescription">Xuất Đơn Mẫu</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="tables[]" value="CutDoseOrder"
                                        id="CutDoseOrder">
                                    <label class="form-check-label" for="CutDoseOrder">Xuất Đơn thuốc cắt liều</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="tables[]" value="Prescription"
                                        id="Prescription">
                                    <label class="form-check-label" for="Prescription">Xuất Đơn thuốc thông thường</label>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-4">Xuất Excel</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        // JavaScript để xử lý chọn tất cả checkbox
        document.getElementById('selectAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('input[name="tables[]"]');
            checkboxes.forEach((checkbox) => {
                checkbox.checked = this.checked;
            });
        });
    </script>
@endsection

@section('style-libs')
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection

@section('script-libs')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!--datatable js-->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <script>
        new DataTable("#example", {
            order: [
                [0, 'desc']
            ]
        });
    </script>
@endsection
