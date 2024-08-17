@extends('admin.layouts.master')

@section('title')
    Danh sách nhà cung cấp
@endsection

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Danh sách nhà cung cấp</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Danh sách loại bệnh</a></li>
                            <li class="breadcrumb-item active">Danh sách</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <div class="card" id="diseaseList">
                    <div class="card-header border-bottom-dashed">
                        <div class="row g-4 align-items-center">
                            <div class="col-sm">
                                <div>
                                    <h5 class="card-title mb-0">Danh sách nhà cung cấp</h5>
                                </div>
                            </div>
                            <div class="col-sm-auto">
                                <div class="d-flex flex-wrap align-items-start gap-2">
                                    <a href="{{ route('admin.suppliers.create') }}" type="button"
                                        class="btn btn-success add-btn">
                                        <i class="ri-add-line align-bottom me-1"></i> Thêm mới
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <table id="diseaseTable"
                            class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Medicine Code</th>
                                    <th>Name Category</th>
                                    <th>Name Medicine</th>
                                    <th>Image Medicine</th>
                                    <th>Price Sale</th>
                                    <th>Price Import</th>
                                    <th>Expiration Date</th>
                                    <th>Name supplier</th>
                                    <th>Quatity</th>
                                    <th>Is Active</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->medicine_code }}</td>
                                        <td>{{ $item->category->name }}</td>
                                        <td>
                                            @foreach ($item->suppliers as $value)
                                                <p>{{ $value->name }}</p>
                                            @endforeach
                                        </td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            @php
                                                $url = $item->image;
                                                if (!Str::contains($url, 'http')) {
                                                    $url = Storage::url($url);
                                                }
                                            @endphp
                                            @if ($url == '/storage/')
                                                {{ 'Không có ảnh' }}
                                            @else
                                                <img width="30" height="30" src="{{ $url }}" alt="">
                                            @endif
                                        </td>
                                        <td>{{ $item->price_sale }}</td>
                                        <td>{{ $item->price_import }}</td>
                                        <td>{{ $item->expiration_date }}</td>
                                        <td>{{ $item->storage->quantity }}</td>
                                        <td>{!! $item->is_active ? '<span class="badge bg-primary">YES</span>' : '<span class="badge bg-danger">NO</span>' !!}</td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="{{ route('admin.medicines.show', $item->id) }}"
                                                    class="btn btn-primary me-2">Xem</a>
                                                <a href="{{ route('admin.medicines.edit', $item->id) }}"
                                                    class="btn btn-warning me-2">Sửa</a>
                                                <form action="{{ route('admin.medicines.destroy', $item->id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Chắc chắn chưa?')"
                                                        class="btn btn-danger">Xóa</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
@endsection

@section('script-libs')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!--datatable js-->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#diseaseTable').DataTable();
        });
    </script>
@endsection
