@extends('admin.layouts.master')

@section('title')
    Thêm Môi Trường
@endsection

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Thêm Môi Trường</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Môi Trường</a></li>
                            <li class="breadcrumb-item active">Thêm Môi Trường</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        @if ($errors->any())
             @dd($errors);
            <div class="alert alert-danger">Đã có lỗi nhập liệu. Vui lòng kiểm tra lại!</div>
        @endif

        <form id="create-environment-form" method="POST" action="{{ route('admin.environments.store') }}">
            @csrf
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Thông tin chung</h5>
                        </div>
                        <div class="card-body">
                            {{-- <div class="mb-3">
                                <label class="form-label" for="storage_id">Kho</label>
                                <select class="form-select" id="storage_id" name="storage_id">
                                    @foreach($storages as $storage)
                                        <option value="{{ $storage->id }}">{{ $storage->name }}</option>
                                    @endforeach
                                </select>
                                @error('storage_id')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div> --}}

                            <div class="mb-3">
                                <label class="form-label" for="real_temperature">Nhiệt độ thực tế</label>
                                <input type="number" step="0.01" class="form-control" id="real_temperature" name="real_temperature" value="{{ old('real_temperature') }}">
                                @error('real_temperature')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="real_humidity">Độ ẩm thực tế</label>
                                <input type="number" step="0.01" class="form-control" id="real_humidity" name="real_humidity" value="{{ old('real_humidity') }}">
                                @error('real_humidity')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>

                            <input type="hidden" id="latitude" name="latitude">
                            <input type="hidden" id="longitude" name="longitude">
                            <input type="hidden" id="time" name="time">
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-end mb-3">
                <button type="submit" class="btn btn-success w-sm">Lưu môi trường</button>
            </div>
        </form>
    </div>
@endsection

@section('script-libs')
    <script>
        // Lấy vị trí của người dùng và thời gian hiện tại
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                document.getElementById('latitude').value = position.coords.latitude;
                document.getElementById('longitude').value = position.coords.longitude;
                
                // Thêm thời gian hiện tại
                var now = new Date();
                var year = now.getFullYear();
                var month = (now.getMonth() + 1).toString().padStart(2, '0');
                var day = now.getDate().toString().padStart(2, '0');
                var hours = now.getHours().toString().padStart(2, '0');
                var minutes = now.getMinutes().toString().padStart(2, '0');
                var seconds = now.getSeconds().toString().padStart(2, '0');
                
                var formattedDateTime = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
                document.getElementById('time').value = formattedDateTime;
            }, function (error) {
                console.error('Lỗi khi lấy vị trí: ' + error.message);
            });
        } else {
            alert("Trình duyệt của bạn không hỗ trợ Geolocation.");
        }
    </script>
@endsection