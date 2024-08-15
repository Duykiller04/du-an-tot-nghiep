@extends('admin.layouts.master')

@section('title')
    Danh sách loại bệnh
@endsection

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Danh sách các loại bệnh</h4>

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
                                    <h5 class="card-title mb-0">Danh sách bệnh</h5>
                                </div>
                            </div>
                            <div class="col-sm-auto">
                                <div class="d-flex flex-wrap align-items-start gap-2">
                                    <a href="{{ route('admin.diseases.create') }}" type="button" class="btn btn-success add-btn">
                                        <i class="ri-add-line align-bottom me-1"></i> Thêm
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <table id="diseaseTable" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên bệnh</th>
                                    <th>Ảnh</th>
                                    <th>Ngày ghi nhận</th>
                                    <th>Mức độ nguy hiểm</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($diseases as $disease)
                                    <tr>
                                        <td>{{ $disease->id }}</td>
                                        <td>{{ $disease->disease_name }}</td>
                                        <td>
                                            @php
                                                $url = $disease->feature_img;
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
                                        <td>{{ \Carbon\Carbon::parse($disease->verify_date)->format('H:m:s d/m/Y') }}</td>
                                        <td>
                                            @if ($disease->danger_level === 'low')
                                                <span class="badge bg-success text-white">Thấp</span>
                                            @elseif ($disease->danger_level === 'medium')
                                                <span class="badge bg-warning text-white">Trung bình</span>
                                            @else
                                                <span class="badge bg-danger text-white">Cao</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown d-inline-block">
                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ri-more-fill align-middle"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <div href="#"
                                                            class="dropdown-item btn btn-warning">
                                                            <a class="btn btn-warning"
                                                                href="{{ route('admin.diseases.edit', $disease->id) }}">Sửa</a>
                                                            </div>
                                                       
                                                    </li>
                                                    
                                                    <li>
                                                        <a class="dropdown-item remove-item-btn">
                                                        <form action="{{ route('admin.diseases.destroy', $disease->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa bệnh này?')">Xóa</button>
                                                        </form>
                                                        </a>
                                                    </li>
                                                </ul>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
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
