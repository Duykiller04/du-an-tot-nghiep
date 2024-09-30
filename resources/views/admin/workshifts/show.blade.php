@extends('admin.layouts.master')

@section('title')
    Chi tiết Ca Làm
@endsection

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Chi tiết Ca Làm</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.workshifts.index') }}">Danh sách ca làm</a></li>
                            <li class="breadcrumb-item active">Chi tiết</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Thông tin chi tiết ca làm</h5>
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <th scope="row">ID:</th>
                            <td>{{ $workshift->id }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Tên Ca Làm:</th>
                            <td>{{ $workshift->name }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Tên Nhân Viên:</th>
                            <td>{{ $workshift->user ? $workshift->user->name : 'Không có' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">KPI:</th>
                            <td>{{ $workshift->target }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Trạng Thái KPI:</th>
                            <td>{{ $workshift->is_applied ? 'Có' : 'Không' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Thời Gian Bắt Đầu:</th>
                            <td>{{ $workshift->start_time }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Thời Gian Kết Thúc:</th>
                            <td>{{ $workshift->end_time }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Ngày Tạo:</th>
                            <td>{{ $workshift->created_at }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Ngày Sửa:</th>
                            <td>{{ $workshift->updated_at }}</td>
                        </tr>
                    </tbody>
                </table>

                <a href="{{ route('admin.workshifts.edit', $workshift->id) }}" class="btn btn-warning">Sửa</a>
                <form action="{{ route('admin.workshifts.destroy', $workshift->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa không')" type="submit">Xóa</button>
                </form>
            </div>
        </div>
    </div>
    <!-- container-fluid -->
@endsection
