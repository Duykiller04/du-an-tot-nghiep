@extends('admin.layouts.master')

@section('title')
    Danh sách môi trường
@endsection

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row mt-3">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Danh sách Môi Trường</h4>
        
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Môi Trường</a></li>
                            <li class="breadcrumb-item active">Danh sách</li>
                        </ol>
                    </div>
                </div>
        
                <!-- Tiêu đề và thông tin nhiệt độ, độ ẩm -->
                <div class="page-title-box text-center mt-4">
                    <h2 class="mb-4">Nhiệt độ và Độ ẩm hiện tại</h2>
                    <div class="d-flex justify-content-center align-items-center gap-4">
                        <div class="d-flex align-items-center">
                            <i class="ri-thermometer-line me-2 text-warning" style="font-size: 24px;"></i>
                            <span class="text-warning" style="font-size: 24px; font-weight: bold;">{{ $weatherData['main']['temp'] }}°C</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="ri-humidity-line me-2 text-primary" style="font-size: 24px;"></i>
                            <span class="text-primary" style="font-size: 24px; font-weight: bold;">{{ $weatherData['main']['humidity'] }}%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- end page title -->

        @if (session('success'))
            <div class="alert alert-success mb-3">
                {{ session('success') }}
            </div>
        @endif
        
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header border-bottom-dashed">
                        <div class="row g-4 align-items-center">
                            <div class="col-sm">
                                <div>
                                    <h5 class="card-title mb-0">Danh sách môi trường</h5>
                                </div>
                            </div>
                            <div class="col-sm-auto">
                                <div class="d-flex flex-wrap align-items-start gap-2">
                                    <a href="{{ route('admin.environments.export') }}" class="btn btn-primary">Xuất Excel</a>
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createEnvironment">Thêm mới môi trường</button>
                                </div>
                            </div>
                        </div>
                    </div>
                     
                    <div class="modal fade" id="createEnvironment" tabindex="-1" aria-labelledby="createEnvironment" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Thêm mới môi trường</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                            {{-- <div class="modal-body">
                                   
                             </div> --}}
                    <div class="modal-body">
                        
                        <form action="{{ route('admin.environments.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="real_temperature">Nhiệt độ trong kho<span class="text-danger">*</span></label>
                                <input type="number" step="0.01" class="form-control" id="real_temperature" name="real_temperature" value="{{ old('real_temperature') }}">
                                @error('real_temperature')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="real_temperature">Nhiệt độ môi trường<span class="text-danger">*</span></label>
                                <input type="number" step="0.01" class="form-control" id="real_temperature" name="temperature" value="{{ $weatherData['main']['temp']}}" readonly>
                            </div>

                            <div class="mb-3">                              
                                <label class="form-label" for="real_humidity">Độ ẩm thực tế<span class="text-danger">*</span></label>
                                <input type="number" step="0.01" class="form-control" id="real_humidity" name="real_humidity" value="{{ old('real_humidity') }}">
                                @error('real_humidity')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="real_temperature">Độ ẩm theo thời tiết<span class="text-danger">*</span></label>
                                <input type="number" step="0.01" class="form-control" id="real_temperature" name="huminity" value="{{ $weatherData['main']['humidity'] }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="storage_id">Chọn kho</label>
                                <select class="form-select" id="storage_id" name="storage_id">
                                    @foreach($storages as $storage)
                                        <option value="{{ $storage->id }}">{{ $storage->name }}</option>
                                    @endforeach
                                </select>
                                @error('storage_id')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-success">Thêm</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @if ($errors->any())
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    var myModal = new bootstrap.Modal(document.getElementById('createEnvironment'));
                    myModal.show();
                });
            </script>
        @endif
        <!-- Modal Sửa Môi Trường -->
                    <div class="modal fade" id="editEnvironment" tabindex="-1" aria-labelledby="editEnvironment" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Chỉnh sửa môi trường</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="POST" id="editEnvironmentForm">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3">
                                            <label class="form-label" for="edit_real_temperature">Nhiệt độ trong kho<span class="text-danger">*</span></label>
                                            <input type="number" step="0.01" class="form-control" id="edit_real_temperature" name="real_temperature">
                                            @error('real_temperature')
                                                <span class="d-block text-danger mt-2">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="edit_real_humidity">Độ ẩm thực tế<span class="text-danger">*</span></label>
                                            <input type="number" step="0.01" class="form-control" id="edit_real_humidity" name="real_humidity">
                                            @error('real_humidity')
                                                <span class="d-block text-danger mt-2">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="edit_storage_id">Chọn kho</label>
                                            <select class="form-select" id="edit_storage_id" name="storage_id">
                                                @foreach($storages as $storage)
                                                    <option value="{{ $storage->id }}">{{ $storage->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('storage_id')
                                                <span class="d-block text-danger mt-2">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-success">Lưu thay đổi</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- @if ($errors->any())
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            var myModal = new bootstrap.Modal(document.getElementById('editEnvironment'));
                            myModal.show();
                        });
                    </script>
                    @endif --}}

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <!-- Hiển thị nhiệt độ và độ ẩm từ API -->
                                    

                                    <table id="environments-table"
                                        class="table table-bordered dt-responsive nowrap table-striped align-middle"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Thời gian</th>
                                                <th>Nhiệt độ môi trường</th>
                                                <th>Nhiệt độ trong kho</th>
                                                <th>Độ ẩm môi trường</th>
                                                <th>Độ ẩm trong kho</th>
                                                <th>Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($environments as $index => $environment)
                                                <tr>
                                                    <td>{{ $index+1 }}</td>
                                                    <td>{{ $environment->time->format('H:i:s d-m-Y') }}</td>
                                                    <td>{{ $environment->temperature }}°C</td>
                                                    <td>{{ $environment->real_temperature }}°C</td>
                                                    <td>{{ $environment->huminity }}%</td>
                                                    <td>{{ $environment->real_humidity }}%</td>
                                                    <td>
                                                        <button type="button" class="btn btn-warning btn-sm editEnvironmentBtn" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#editEnvironment"
                                                        data-id="{{ $environment->id }}"
                                                        data-real_temperature="{{ $environment->real_temperature }}"
                                                        data-real_humidity="{{ $environment->real_humidity }}"
                                                        data-storage_id="{{ $environment->storage_id }}">
                                                        Sửa
                                                        </button>
                                                        <form action="{{ route('admin.environments.destroy', $environment->id) }}" method="POST" class="d-inline-block">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa')">Xóa</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div><!--end col-->
                    </div><!--end row-->
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>
    <!-- container-fluid -->
@endsection

@section('style-libs')
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <!-- Feather Icons CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.css">
@endsection

@section('script-libs')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

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
        $(document).ready(function() {
            $('#environments-table').DataTable({
                responsive: true,
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                buttons: [
                    'copy', 'excel', 'pdf', 'print'
                ],
                language: {
                    "sEmptyTable": "Không có dữ liệu trong bảng",
                    "sInfo": "Hiển thị _START_ đến _END_ của _TOTAL_ mục",
                    "sInfoEmpty": "Hiển thị 0 đến 0 của 0 mục",
                    "sInfoFiltered": "(đã lọc từ _MAX_ mục)",
                    "sLengthMenu": "Hiển thị _MENU_ mục",
                    "sLoadingRecords": "Đang tải...",
                    "sProcessing": "Đang xử lý...",
                    "sSearch": "Tìm kiếm:",
                    "sZeroRecords": "Không tìm thấy kết quả nào",
                    "oPaginate": {
                        "sFirst": "Đầu",
                        "sLast": "Cuối",
                        "sNext": "Kế tiếp",
                        "sPrevious": "Trước"
                    },
                    "oAria": {
                        "sSortAscending": ": Sắp xếp tăng dần",
                        "sSortDescending": ": Sắp xếp giảm dần"
                    }
                },
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Lấy các nút sửa môi trường
            const editButtons = document.querySelectorAll('.editEnvironmentBtn');
            
            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Lấy thông tin từ các thuộc tính data- của nút
                    const id = button.getAttribute('data-id');
                    const realTemperature = button.getAttribute('data-real_temperature');
                    const realHumidity = button.getAttribute('data-real_humidity');
                    const storageId = button.getAttribute('data-storage_id');
                    
                    // Đặt giá trị cho các trường input trong modal
                    document.getElementById('edit_real_temperature').value = realTemperature;
                    document.getElementById('edit_real_humidity').value = realHumidity;
                    document.getElementById('edit_storage_id').value = storageId;
                    
                    // Cập nhật URL form action trong modal
                    const form = document.getElementById('editEnvironmentForm');
                    form.action = `/admin/environments/${id}`;
                });
            });
        });
    </script>
@endsection
