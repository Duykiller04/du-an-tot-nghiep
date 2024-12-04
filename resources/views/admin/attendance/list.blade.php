@extends('admin.layouts.master')

@section('title')
    Thời gian làm việc
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Thời gian làm việc</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item">
                                <a href="javascript: void(0);">Trang chủ</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Thời gian làm việc
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
                        <h3 class="text-center mb-4">Thống kê điểm danh tháng {{ $month }}/{{ $year }}</h3>

                        <form action="{{ route('admin.attendace.list') }}" method="GET" class="mb-4">
                            <div class="row">
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
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary">Lọc</button>
                                </div>
                            </div>
                        </form>
                        <div class="d-flex mb-3">
                            <span class="badge text-bg-dark p-3">
                                Số buổi không đi làm: {{ $missedDays }}
                            </span>
                            <span class="badge text-bg-secondary ms-3 p-3">
                                Số buổi đi muộn: {{ $lateCount }}
                            </span>
                            <span class="badge text-bg-warning ms-3 p-3">
                                Số buổi về sớm: {{ $earlyCount }}
                            </span>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle">
                                <thead>
                                    <tr>
                                        <td>STT</td>
                                        <th class="text-info">Ngày</th>
                                        <th class="text-info">Ca làm</th>
                                        <th class="text-info">Thời gian bắt đầu</th>
                                        <th class="text-info">Thời gian kết thúc ca</th>
                                        <th>Check-in</th>
                                        <th>Thời gian check-in</th>
                                        <th>Check-out</th>
                                        <th>Thời gian check-out</th>
                                        <th>Thời gian check-out lần 2</th>
                                        <th class="text-danger">Lý do check-out lần 2</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($attendances as $attendance)
                                        <tr>
                                            <td><strong>{{ $loop->iteration + ($attendances->currentPage() - 1) * $attendances->perPage() }}</strong></td>
                                            <td class="text-info">{{ \Carbon\Carbon::parse($attendance->created_at)->format('d/m/Y') }}</td>
                                            <td class="text-info">{{ $attendance->shift->shift_name }}</td>
                                            <td class="text-info">
                                                <p>{{ \Carbon\Carbon::parse($attendance->shift->start_time)->format('H:i:s') }}</p>
                                                <p>{{ \Carbon\Carbon::parse($attendance->shift->start_time)->format('d/m/Y') }}</p>
                                            </td>
                                            <td class="text-info">
                                                <p>{{ \Carbon\Carbon::parse($attendance->shift->end_time)->format('H:i:s') }}</p>
                                                <p>{{ \Carbon\Carbon::parse($attendance->shift->end_time)->format('d/m/Y') }}</p>
                                            </td>
                                            <td>
                                                @if ($attendance->img_check_in)
                                                    <a
                                                    data-fancybox
                                                    data-src="{{ asset($attendance->img_check_in) }}"
                                                    data-caption="Ảnh check-out"
                                                    >
                                                        <img src="{{ asset($attendance->img_check_in) }}" width="100" height="80" alt="" />
                                                    </a>
                                                @else
                                                    <img src="{{ asset('theme/admin/assets/images/no-img-avatar.png') }}" width="100" height="80" alt="No image" />
                                                @endif
                                            </td>
                                            <td>
                                                @if ($attendance->time_in)
                                                    <p>{{\Carbon\Carbon::parse($attendance->time_in)->format('H:i:s')}}</p>
                                                    <p>{{\Carbon\Carbon::parse($attendance->time_in)->format('d/m/Y')}}</p>
                                                @else
                                                    <p>N/A</p>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($attendance->img_check_out)
                                                    <a
                                                    data-fancybox
                                                    data-src="{{ asset($attendance->img_check_out) }}"
                                                    data-caption="Ảnh check-out"
                                                    >
                                                        <img src="{{ asset($attendance->img_check_out) }}" width="100" height="80" alt="" />
                                                    </a>
                                                @else
                                                    <img src="{{ asset('theme/admin/assets/images/no-img-avatar.png') }}" width="100" height="80" alt="No image" />
                                                @endif
                                            </td>
                                            <td>
                                                @if ($attendance->time_out)
                                                    <p>{{\Carbon\Carbon::parse($attendance->time_out)->format('H:i:s')}}</p>
                                                    <p>{{\Carbon\Carbon::parse($attendance->time_out)->format('d/m/Y')}}</p>
                                                @else
                                                    <p>N/A</p>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($attendance->time_out_2)
                                                    <p>{{\Carbon\Carbon::parse($attendance->time_out_2)->format('H:i:s')}}</p>
                                                    <p>{{\Carbon\Carbon::parse($attendance->time_out_2)->format('d/m/Y')}}</p>
                                                @else
                                                    <p>N/A</p>
                                                @endif
                                            </td>
                                            <td class="text-danger">{{ $attendance->reasons }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">Không có dữ liệu</td>
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

