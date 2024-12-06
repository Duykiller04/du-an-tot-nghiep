@extends('admin.layouts.master')

@section('title')
    Điểm danh
@endsection

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Điểm danh</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item">
                                <a href="javascript: void(0);">Trang chủ</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Điểm danh
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Modal check in --}}
        <div class="modal fade" id="checkInModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="checkInModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" width="700" height="500">
                    <form action="{{ route('admin.attendace.checkin') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="checkInModalLabel">Check in</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <video id="videoCheckIn" width="450" height="338" autoplay></video>
                            <div class="d-flex justify-content-center">
                                <button id="snapCheckIn" type="button" class="btn btn-primary">Chụp ảnh</button>
                            </div>
                            <canvas id="canvasCheckIn" width="450" height="338" class="mt-3"></canvas>
                            <input type="hidden" name="captured_image" id="captured_image_checkin">
                            <input type="hidden" name="shift_id" id="shift_id_checkin">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Check in</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Modal check out --}}
        <div class="modal fade" id="checkOutModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="checkOutModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" width="700" height="500">
                    <form action="{{ route('admin.attendace.checkout') }}" method="POST" enctype="multipart/form-data" id="formCheckOut">
                        @csrf
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="checkOutModalLabel">Check out</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <video id="videoCheckOut" width="450" height="338" autoplay></video>
                            <div class="d-flex justify-content-center">
                                <button id="snapCheckOut" type="button" class="btn btn-primary">Chụp ảnh</button>
                            </div>
                            <canvas id="canvasCheckOut" width="450" height="338" class="mt-3"></canvas>
                            <input type="hidden" name="captured_image" id="captured_image_checkout">
                            <input type="hidden" name="shift_id" id="shift_id_checkout">
                            <div id="reasonField" class="mt-3" style="display: none;">
                                <label for="reasons" class="form-label">Lý do check out lần 2 <span class="text-danger">(*)</span></label>
                                <input type="text" name="reasons" id="reasons" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Check out</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Bảng danh sách ca làm việc -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card" id="shiftList">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Ca làm</th>
                                        <th>Thời gian bắt đầu</th>
                                        <th>Thời gian kết thúc</th>
                                        <th>Trạng thái</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @foreach ($shifts as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->shift->shift_name}}</td>
                                            <td>
                                                <p>{{ \Carbon\Carbon::parse($item->shift->start_time)->format('H:i:s') }}</p>
                                                <p>{{ \Carbon\Carbon::parse($item->shift->start_time)->format('d/m/Y') }}</p>
                                            </td>
                                            <td>
                                                <p>{{ \Carbon\Carbon::parse($item->shift->end_time)->format('H:i:s') }}</p>
                                                <p>{{ \Carbon\Carbon::parse($item->shift->end_time)->format('d/m/Y') }}</p>
                                            </td>
                                            <td>
                                                <span class="badge {{ $getStatusClass($item->shift->status) }}">
                                                    {{ ucfirst($item->shift->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                {{-- @dd($item->shift->attendace->toArray()); --}}
                                                @if ($item->shift->status == 'đang mở')
                                                    @if ( $item->shift->attendace->img_check_in == null && 
                                                    now() >= Carbon\Carbon::parse($item->shift->start_time) && 
                                                    now() <= Carbon\Carbon::parse($item->shift->end_time))
                                                        <button type="button" class="btn btn-primary"
                                                            data-bs-toggle="modal" data-bs-target="#checkInModal"
                                                            data-shift-id="{{ $item->shift->id }}">
                                                            Check in
                                                        </button>
                                                    @elseif ($item->shift->attendace->reasons == null && $item->shift->attendace->img_check_in != null)
                                                        <button type="button" class="btn btn-danger"
                                                            data-bs-toggle="modal" data-bs-target="#checkOutModal"
                                                            data-shift-id="{{ $item->shift->id }}"
                                                            data-reasons="{{ $item->shift->attendace->reasons }}"
                                                            data-img-check-out = "{{ $item->shift->attendace->img_check_out }}"
                                                            >
                                                            Check out
                                                        </button>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('script-libs')
    <script>
        function initializeVideo(videoElement) {
            navigator.mediaDevices.getUserMedia({
                    video: true
                })
                .then(stream => {
                    videoElement.srcObject = stream;
                });
        }

        // Set shift_id when "Check in" button is clicked
        document.querySelectorAll('button[data-bs-target="#checkInModal"]').forEach(button => {
            button.addEventListener('click', function() {
                const shiftId = this.getAttribute('data-shift-id');
                document.getElementById('shift_id_checkin').value = shiftId;
                initializeVideo(document.getElementById('videoCheckIn'));
            });
        });

        // Set shift_id when "Check out" button is clicked
        document.querySelectorAll('button[data-bs-target="#checkOutModal"]').forEach(button => {
            button.addEventListener('click', function() {
                const shiftId = this.getAttribute('data-shift-id');
                const reasons = this.getAttribute('data-reasons');
                const imgCheckOut = this.getAttribute('data-img-check-out');

                document.getElementById('shift_id_checkout').value = shiftId;
                initializeVideo(document.getElementById('videoCheckOut'));

                // Hiển thị trường lý do nếu imgCheckOut là null
                if (imgCheckOut != "") {
                    document.getElementById('reasonField').style.display = 'block';
                } else {
                    document.getElementById('reasonField').style.display = 'none';
                }
            });
        });

        // Capture image for Check in
        document.getElementById('snapCheckIn').addEventListener('click', () => {
            const canvas = document.getElementById('canvasCheckIn');
            const context = canvas.getContext('2d');
            context.drawImage(document.getElementById('videoCheckIn'), 0, 0, 450, 338);
            document.getElementById('captured_image_checkin').value = canvas.toDataURL('image/png');
        });

        // Capture image for Check out
        document.getElementById('snapCheckOut').addEventListener('click', () => {
            const canvas = document.getElementById('canvasCheckOut');
            const context = canvas.getContext('2d');
            context.drawImage(document.getElementById('videoCheckOut'), 0, 0, 450, 338);
            document.getElementById('captured_image_checkout').value = canvas.toDataURL('image/png');
        });

        document.getElementById('formCheckOut').addEventListener('submit', function(event) {
            // Check if the reason field is visible
            const reasonField = document.getElementById('reasonField');
            const reasonsInput = document.getElementById('reasons');
            
            // If the reason field is visible and the reasons input is empty, prevent form submission
            if (reasonField.style.display !== 'none' && reasonsInput.value.trim() === '') {
                event.preventDefault(); // Prevent form submission
                alert('Không được bỏ trống lý do check out lần 2.');
            }
        });

    </script>
@endsection
