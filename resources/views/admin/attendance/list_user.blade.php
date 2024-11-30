@extends('admin.layouts.master')

@section('title')
    Thời gian làm việc của nhân viên
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Thời gian làm việc của nhân viên</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item">
                                <a href="javascript: void(0);">Trang chủ</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Thời gian làm việc của nhân viên
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bảng danh sách ca làm việc -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card" id="shiftList">
                    <div class="card-body">
                        <h3 class="text-center mb-4">Thống kê điểm danh nhân viên {{ isset($userId) ? $arrUsers->where('id', $userId)->first()->name : '' }}: tháng {{ $month }}/{{ $year }}</h3>

                        <form action="{{ route('admin.attendace.list.user') }}" method="GET" class="mb-4">
                            <div class="row">
                                <div class="col-md-2">
                                    <select name="user_id" class="form-control">
                                        <option value="">Chọn nhân viên</option>
                                        @foreach ($arrUsers as $item)
                                            <option value="{{ $item->id }}" {{ isset($userId) && $item->id == $userId ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>                                    
                                </div>
                                <div class="col-md-4">
                                    <select name="month" class="form-control">
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}" {{ $i == $month ? 'selected' : '' }}>
                                                Tháng {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select name="year" class="form-control">
                                        @for ($i = now()->year - 5; $i <= now()->year; $i++)
                                            <option value="{{ $i }}" {{ $i == $year ? 'selected' : '' }}>
                                                Năm {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary">Lọc</button>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>Ngày</th>
                                        <th>Nhân viên</th>
                                        <th>Ca làm</th>
                                        <th>Check-in</th>
                                        <th>Thời gian check-in</th>
                                        <th>Check-out</th>
                                        <th>Thời gian check-out</th>
                                        <th class="text-danger">Lý do check-out lần 2</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($attendances as $attendance)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($attendance->created_at)->format('d/m/Y') }}</td>
                                            <td>{{ $attendance->user->name }}</td>
                                            <td>{{ $attendance->shift_id }}</td>
                                            <td>
                                                <a
                                                data-fancybox
                                                data-src="{{ asset($attendance->img_check_in) }}"
                                                data-caption="Ảnh check-in"
                                                >
                                                    <img src="{{ asset($attendance->img_check_in) }}" width="200" height="150" alt="" />
                                                </a>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($attendance->created_at)->format('d/m/Y H:i:s') }}</td>
                                            <td>
                                                <a
                                                data-fancybox
                                                data-src="{{ asset($attendance->img_check_out) }}"
                                                data-caption="Ảnh check-out"
                                                >
                                                    <img src="{{ asset($attendance->img_check_out) }}" width="200" height="150" alt="" />
                                                </a>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($attendance->time_out)->format('d/m/Y H:i:s') }}</td>
                                            <td class="text-danger">{{ $attendance->reasons }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">Không có dữ liệu</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            <nav>
                                <ul class="pagination justify-content-center">
                                    @if ($attendances->onFirstPage())
                                        <li class="page-item disabled"><span class="page-link">« Trước</span></li>
                                    @else
                                        <li class="page-item"><a class="page-link" href="{{ $attendances->previousPageUrl() }}">« Trước</a></li>
                                    @endif
                        
                                    @foreach ($attendances->onEachSide(1)->getUrlRange(1, $attendances->lastPage()) as $page => $url)
                                        @if ($page == $attendances->currentPage())
                                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                        @else
                                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                        @endif
                                    @endforeach
                        
                                    @if ($attendances->hasMorePages())
                                        <li class="page-item"><a class="page-link" href="{{ $attendances->nextPageUrl() }}">Tiếp »</a></li>
                                    @else
                                        <li class="page-item disabled"><span class="page-link">Tiếp »</span></li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection


